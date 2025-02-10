<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ShopController extends Controller
{
    // 店舗一覧
    public function index()
    {
        // **ランダムシードをセッションに保存（なければ新しく作成）**
        $randomSeed = session('random_seed', rand());
        session(['random_seed' => $randomSeed]); // シードをセッションに保存

        // 基本となるクエリを作成
        $query = Shop::with('area', 'genre');
        // 評価の平均点を計算
        $query->leftJoin('reservations', 'shops.id', '=', 'reservations.shop_id')
        ->leftJoin('reviews', 'reservations.id', '=', 'reviews.reservation_id')
        ->selectRaw('shops.*, COALESCE(ROUND(AVG(reviews.star), 2), -1) as avg_star')
        ->groupBy('shops.id');

        $shops = $query->orderByRaw("RAND($randomSeed)")->get();

        $areas = Area::all();
        $genres = Genre::all();

        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
            $favorites=Favorite::all();

            return view('index',['areas' => $areas,'genres' => $genres, 'shops' => $shops,'user_id'=>$user_id,'favorites'=>$favorites]);
        }else{
            return view('index', ['areas' => $areas, 'genres' => $genres, 'shops' => $shops]);
        }
    }

    // ユーザー登録後に遷移するページ
    public function thanks()
    {
        return view('thanks');
    }

    // 店舗詳細＆予約フォーム
    public function detail($id)
    {
        // 詳しくみるボタンを押されたカードのidを探す
        $shop_detail = Shop::find($id);
        //遷移元URLの取得
        $prevUrl = $_SERVER['HTTP_REFERER'];
        //現在のパスの取得
        $currentUrl = $_SERVER['REQUEST_URI'];

        // カレンダーの昨日以前を非表示にするため「今日」を定義
        $today = Carbon::now()->format('Y-m-d');

        //レビュー表示
        $reviews = Review::whereHas('reservation', function($query) use ($id){$query->where("shop_id","=",$id);})->latest()->get();

        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
            return view('detail', ['user_id'=> $user_id,'shop_detail' => $shop_detail,'today' => $today, 'prevUrl'=> $prevUrl, 'currentUrl'=> $currentUrl, 'reviews'=> $reviews]);
        }else{
            return view('detail', ['shop_detail' => $shop_detail, 'today' => $today, 'prevUrl' => $prevUrl, 'currentUrl' => $currentUrl, 'reviews' => $reviews]);
        }
    }

    // お気に入り
    public function favorite(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $shop_id = $request->all();
        unset($shop_id['_token']);
        $favorite_registered = Favorite::where("user_id", "=", $user_id)->where("shop_id", "=", $shop_id["shop_id"])->first();
        if($favorite_registered)
        {
            $favorite_registered->delete();
        }else{
        Favorite::create([
            'user_id' => $user->id,
            'shop_id' => $shop_id['shop_id']
        ]);
        }

        // **リダイレクト時にランダムシードを維持**
        return redirect()->route('index');
    }


    //店舗検索
    public function search_shop(Request $request)
    {
        // 並び順の取得（デフォルトはランダム）
        $order = $request->input('sort', 'random');

        // **ランダムが選択された場合は、新しいシードを生成**
        if ($order === 'random') {
            session(['random_seed' => rand()]);
        }


        // 基本となるクエリを作成
        $query = Shop::with('area', 'genre')
        ->AreaSearch($request->area_id)
        ->GenreSearch($request->genre_id)
        ->KeywordSearch($request->keyword);

        // 評価の平均点を計算
        $query->leftJoin('reservations', 'shops.id', '=', 'reservations.shop_id')
        ->leftJoin('reviews', 'reservations.id', '=', 'reviews.reservation_id')
        ->selectRaw('shops.*, COALESCE(ROUND(AVG(reviews.star), 2), -1) as avg_star')
        ->groupBy('shops.id');

        // `order` によって並び替えを変更
        if ($order === 'asc') {
            $query->orderByRaw('avg_star = -1 ASC')  // 評価なしを後ろに表示
            ->orderBy('avg_star', 'asc'); // 低評価順
        } elseif ($order === 'desc') {
            $query->orderByRaw('avg_star = -1 ASC')  // 評価なしを後ろに表示
            ->orderBy('avg_star', 'desc'); // 高評価順
        } else {
            $randomSeed = session('random_seed', rand());
            $query->orderByRaw("RAND($randomSeed)");
        }

        // 最終的にクエリを実行してデータを取得
        $shops = $query->get();

        $areas = Area::all();
        $genres = Genre::all();

        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
            $favorites = Favorite::all();
            return view('index', ['areas' => $areas, 'genres' => $genres, 'shops' => $shops, 'user_id' => $user_id, 'favorites' => $favorites]);
        } else {
            return view('index', ['areas' => $areas, 'genres' => $genres, 'shops' => $shops]);
        }
    }

    // マイページ１（予約状況）
    public function mypage()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y-m-d');
        $reservation_details = Reservation::with('shop')->where("user_id", "=", "$user_id")->where("date",">=","$today")->where("visit_status","=","0")->oldest('date')->oldest('time')->get();
        $favorites = Favorite::where("user_id","=","$user_id")->get();

        if($user->role=='general'){
            if($user->stripe_id){
                $member_status="プレミアム会員";
            }else{
                $member_status = "一般会員";
            }
        }else{
            $member_status="";
        }
        return view('mypage',['reservation_details'=> $reservation_details,'user_id' => $user_id,'favorites' => $favorites, 'member_status'=>$member_status]);
    }

    // マイページ２（予約履歴）
    public function history()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y-m-d');
        $reservation_details = Reservation::with('shop')->where("user_id", "=", "$user_id")->where("date","<=","$today")->where("visit_status","=", "1")->latest('date')->latest('time')->get();

        $favorites = Favorite::where("user_id", "=", "$user_id")->get();

        $reviewed_reservations = Review::with('reservation:id')->pluck('reservation_id')->toArray();

        if ($user->role == 'general') {
            if ($user->stripe_id) {
                $member_status = "プレミアム会員";
            } else {
                $member_status = "一般会員";
            }
        } else {
            $member_status = "";
        }
        return view('mypage_history', ['reservation_details' => $reservation_details, 'user_id' => $user_id, 'favorites' => $favorites, 'member_status' => $member_status, 'reviewed_reservations' => $reviewed_reservations]);
    }


    //レビュー作成
    public function review_make(Request $request)
    {
        //遷移元URLの取得
        $prevUrl = $_SERVER['HTTP_REFERER'];
        $old_reservation_id = old('reservation_id');
        $review_content = $request->session()->get("form_input");
        if ($review_content) { //確認画面から内容修正する場合
            $reservation_items = Reservation::find($review_content['reservation_id']);
            $reservation_record = [];
            $reservation_record['id'] = $reservation_items->id;
            $reservation_record['shop_name'] = $reservation_items->shop->name;
            $reservation_record['shop_id'] = $reservation_items->shop_id;
            
        }elseif($old_reservation_id){
            $reservation_items = Reservation::find($old_reservation_id);
            $reservation_record = [];
            $reservation_record['id'] = $reservation_items->id;
            $reservation_record['shop_name'] = $reservation_items->shop->name;
            $reservation_record['shop_id'] = $reservation_items->shop_id;
        }else{
            $reservation_items = Reservation::find($request->id);
            $reservation_record = [];
            $reservation_record['id'] = $reservation_items->id;
            $reservation_record['shop_name'] = $reservation_items->shop->name;
            $reservation_record['shop_id'] = $reservation_items->shop_id;
        }
        $request->session()->forget('form_input');
        return view('review_make', compact('reservation_record','prevUrl'));
    }

    //レビュー確認
    public function review_confirm(ReviewRequest $request)
    {
        $review_content = $request->only(['reservation_id','shop_id','shop_name','star','comment']);
        $request->session()->put("form_input", $review_content);

        $image_exist = $request->file('image');

        if ($image_exist) {
            // 拡張子取得
            $extension = $request->file("image")->getClientOriginalExtension();
            // 一時的にtmpフォルダに保存する
            $tmp_image = $request->file('image')->storeAs('tmp', $request->user()->id . '-' . $request->shop_id . '.' . $extension, 'public');
            //画像名
            $image_name = $request->user()->id . '-' . $request->shop_id . '.' . $extension;
            //確認viewで使えるパスの文字列定義
            $tmp_image_path = '/storage/'. $tmp_image;
            //画像確定パスの文字列
            $image_path = '/storage/review_image/' . $image_name;
        } else {
            // 画像をアップロードしない場合は何もセットしない
            $image_path = '';
            $tmp_image_path ='';
            $image_name='';
        }
        return view('review_confirm', compact('review_content', 'image_name', 'tmp_image_path','image_path'));
    }

    //レビュー投稿
    public function review_send(Request $request)
    {
        // 戻るボタンをクリックされた場合
        if ($request->input('back') == 'back') {
            if($request->image_name){
                Storage::disk('public')->delete('tmp/' . $request->image_name);
            }
        return redirect('/mypage/review/make')
        ->withInput();
        }
        $review_confirm = $request->only(['reservation_id', 'star', 'comment', 'image']);

        // 一時保存のtmpから本番の格納場所へ移動
        Storage::disk('public')->move('tmp/' . $request->image_name, 'review_image/' . $request->image_name);


        Review::create($review_confirm);
        $request->session()->forget('form_input');
        return redirect ('/mypage/history');
    }

    //レビュー編集
    public function review_edit(Request $request)
    {
        //遷移元URLの取得
        $prevUrl = $_SERVER['HTTP_REFERER'];
        $old_reservation_id = old('reservation_id');
        $review_content = $request->session()->get("form_input");
        if ($review_content) { //確認画面から内容修正する場合
            $reservation_items = Reservation::find($review_content['reservation_id']);
            $reservation_record = [];
            $reservation_record['id'] = $reservation_items->id;
            $reservation_record['shop_name'] = $reservation_items->shop->name;
            $reservation_record['shop_id'] = $reservation_items->shop_id;
        } elseif ($old_reservation_id) {
            $reservation_items = Reservation::find($old_reservation_id);
            $reservation_record = [];
            $reservation_record['id'] = $reservation_items->id;
            $reservation_record['shop_name'] = $reservation_items->shop->name;
            $reservation_record['shop_id'] = $reservation_items->shop_id;
        } else {
            $reservation_items = Reservation::find($request->id);
            $reservation_record = [];
            $reservation_record['id'] = $reservation_items->id;
            $reservation_record['shop_name'] = $reservation_items->shop->name;
            $reservation_record['shop_id'] = $reservation_items->shop_id;
        }
        $request->session()->forget('form_input');

        $current_review = Review::where("reservation_id","=", $request->id)->first();

        return view('review_edit', compact('reservation_record', 'prevUrl', 'current_review'));
    }

    //レビュー編集確認
    public function review_edit_confirm(ReviewRequest $request)
    {
        $review_content = $request->only(['reservation_id', 'shop_id', 'shop_name', 'star', 'comment']);

        $request->session()->put("form_input", $review_content);

        $image_exist = $request->file('image');

        if ($image_exist) {
            // 拡張子取得
            $extension = $request->file("image")->getClientOriginalExtension();
            // 一時的にtmpフォルダに保存する
            $tmp_image = $request->file('image')->storeAs('tmp', $request->user()->id . '-' . $request->shop_id . '.' . $extension, 'public');
            //画像名
            $image_name = $request->user()->id . '-' . $request->shop_id . '.' . $extension;
            //確認viewで使えるパスの文字列定義
            $tmp_image_path = '/storage/tmp/' . $image_name;
            //画像確定パスの文字列
            $image_path = '/storage/review_image/' . $image_name;
        } else {
            // 画像をアップロードしない場合は何もセットしない
            $image_path_array = Review::where("reservation_id","=", $request->reservation_id)->pluck("image");
            $image_path = $image_path_array[0];

            $image_name = '';
            $tmp_image_path_array =Review::where("reservation_id", "=", $request->reservation_id)->pluck("image");
            $tmp_image_path = $tmp_image_path_array[0];
        }
        return view('review_edit_confirm', compact('review_content', 'image_name', 'tmp_image_path', 'image_path'));
    }

    //レビュー編集確定
    public function review_update(Request $request)
    {
        // 戻るボタンをクリックされた場合
        if ($request->input('back') == 'back') {
            if ($request->image_name) {
                Storage::disk('public')->delete('tmp/'. $request->image_name);
            }
            return redirect('/review/edit')
            ->withInput();
        }

        // 一時保存のtmpから本番の格納場所へ移動
        Storage::disk('public')->move('tmp/' . $request->image_name, 'review_image/' . $request->image_name);

        $review_confirm = $request->only(['reservation_id', 'star', 'comment', 'image']);
        Review::where("reservation_id","=",$request->reservation_id)->update($review_confirm);
        $request->session()->forget('form_input');
        return redirect()->route('detail', ['id' => $request->shop_id]);
    }

    // レビュー削除
    public function review_destroy(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect()->route('detail', ['id' => $request->shop_id]);
    }
}
