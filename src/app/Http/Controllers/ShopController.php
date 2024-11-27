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


class ShopController extends Controller
{
    // 店舗一覧
    public function index()
    {
        $areas = Area::all();
        $genres = Genre::all();
        $shops = Shop::all();
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

        // カレンダーが昨日以前を非表示にするため「今日」を定義
        $today = Carbon::now()->format('Y-m-d');

        if (Auth::check()) {
        $user = Auth::user();
        $user_id = $user->id;
        
        return view('detail', ['user_id'=> $user_id,'shop_detail' => $shop_detail,'today' => $today, 'prevUrl'=> $prevUrl, 'currentUrl'=> $currentUrl]);
        }else{
            return view('detail', [ 'shop_detail' => $shop_detail, 'today' => $today, 'prevUrl' => $prevUrl, 'currentUrl' => $currentUrl]);

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

        return back();
    }


    //店舗検索
    public function search_shop(Request $request)
    {
        $shops = Shop::with('area','genre')->AreaSearch($request->area_id)->GenreSearch($request->genre_id)->KeywordSearch($request->keyword)->get();
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

        if ($user->role == 'general') {
            if ($user->stripe_id) {
                $member_status = "プレミアム会員";
            } else {
                $member_status = "一般会員";
            }
        } else {
            $member_status = "";
        }
        return view('mypage_history', ['reservation_details' => $reservation_details, 'user_id' => $user_id, 'favorites' => $favorites, 'member_status' => $member_status]);
    }


//レビュー作成
    public function review_make(Request $request)
    {
        //遷移元URLの取得
        $prevUrl = $_SERVER['HTTP_REFERER'];

        $review_content = $request->session()->get("form_input");

        if ($review_content) { //確認画面から内容修正する場合
            $reservation_items = Reservation::find($review_content['reservation_id']);
            $reservation_record = [];
            $reservation_record['id'] = $reservation_items->id;
            $reservation_record['user_id'] = $reservation_items->user_id;
            $reservation_record['shop_name'] = $reservation_items->shop->name;
            $reservation_record['shop_id'] = $reservation_items->shop_id;
            $request->session()->forget('form_input');
        } else {
            $reservation_items = Reservation::find($request->id);

            $reservation_record = [];
            $reservation_record['id'] = $reservation_items->id;
            $reservation_record['user_id'] = $reservation_items->user_id;
            $reservation_record['shop_name'] = $reservation_items->shop->name;
            $reservation_record['shop_id'] = $reservation_items->shop_id;
        }


        return view('review_make', compact('reservation_record','prevUrl'));
        
    }

    //レビュー確認
    public function review_confirm(ReviewRequest $request)
    {
        $review_content = $request->only(['user_id','shop_id','reservation_id','shop_name','star','comment']);
        $request->session()->put("form_input", $review_content);
        return view('review_confirm', compact('review_content'));
    }

    //レビュー投稿
    public function review_send(Request $request)
    {
        // 戻るボタンをクリックされた場合
        if ($request->input('back') == 'back') {

        return redirect('/mypage/review/make')
        ->withInput();
        }

        $review_confirm = $request->only(['user_id','shop_id', 'reservation_id', 'star', 'comment']);
        Review::create($review_confirm);
        return redirect ('/mypage');
    }
}
