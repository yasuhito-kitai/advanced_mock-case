<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $shop = Shop::where('user_id','=',$user_id)->first();
        $shop_id = $shop->id;
        $areas = Area::all();
        $genres = Genre::all();

        //表示する今日の日付を取得
        $format_date = Carbon::today()->format('Y-m-d');

        //表示されている日付の勤怠レコードを取得
        $item_records = Reservation::with('user')->where('shop_id','=',$shop_id)->where("date", "=", $format_date)->oldest('time')->get();

        $shop=Shop::where("user_id", "=", $user_id)->first();
        
        if(!$shop)
        {
            return view('owner_page',['user_id' => $user_id, 'areas' => $areas, 'genres' => $genres,'shop'=>$shop]);//初回登録時
        }else{
            return view('owner_page', ['shop' => $shop, 'display_date' => $format_date,'item_records'=> $item_records]);//登録後
        }
    }

    public function create(Request $request)
    {
        $shop_detail = $request->all();
        $area_name = Area::find($shop_detail["area_id"])->name;
        $genre_name = Genre::find($shop_detail["genre_id"])->name;
        $image_exist = $request->file('image');
        
        if ($image_exist) {
        // 拡張子取得
        $extension = $request->file("image")->getClientOriginalExtension();
        // 一時的にtmpフォルダに保存する
        $tmp_image = $request->file('image')->storeAs('tmp', $request->user()->id . '.' .$extension, 'public');
        // DB登録用の文字列定義
        $image_name = $request->user()->id . '.' . $extension ;

        } else {
        // 画像をアップロードしない場合は「NOW PRINTING」画像がセットされる
        $image_name = '/img/noimage.jpg';
        }

        return view('register_shop_confirm',['shop_detail'=>$shop_detail, 'area_name'=>$area_name, 'genre_name' => $genre_name, 'image_name'=>$image_name]);

    }

    public function store(Request $request)
    {

        // 戻るボタンをクリックされた場合
        if ($request->input('back') == 'back') {
            return redirect('/owner-page')
            ->withInput();
        }

        $shop_detail = $request->all();

        if ($request->image !== '/img/noimage.jpg') {
        // 一時保存のtmpから本番の格納場所へ移動
            Storage::move('public/tmp/'. $shop_detail['image'], 'public/'. $shop_detail['image']);
        
        Shop::create([
            'user_id' => $shop_detail['user_id'],
            'name' => $shop_detail['name'],
            'area_id' => $shop_detail['area_id'],
            'genre_id' => $shop_detail['genre_id'],
            'overview' => $shop_detail['overview'],
            'image' => '/storage/'.$shop_detail['image']
            ]);
        }

        else{
            Shop::create([
                'user_id' => $shop_detail['user_id'],
                'name' => $shop_detail['name'],
                'area_id' => $shop_detail['area_id'],
                'genre_id' => $shop_detail['genre_id'],
                'overview' => $shop_detail['overview'],
                'image' => $shop_detail['image']
            ]);
        }
        return redirect('/');

    }


    public function edit($id)
    {
        // 詳しくみるボタンを押されたカードのidを探す
        $shop_detail = Shop::find($id);
        //遷移元URLの取得
        $prevUrl = $_SERVER['HTTP_REFERER'];
        //現在のパスの取得
        $currentUrl = $_SERVER['REQUEST_URI'];

        $areas = Area::all();
        $genres = Genre::all();
        $shops = Shop::all();
            $user = Auth::user();
            $user_id = $user->id;

        return view('edit_shop', ['shop_detail' => $shop_detail, 'prevUrl' => $prevUrl, 'currentUrl' => $currentUrl,'areas' => $areas, 'genres' => $genres, 'shops' => $shops, 'user_id' => $user_id]);

    }

    // 店舗情報更新確認
    public function update_confirm(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->id;
        
        $after_details = $request->all();
        $area_name = Area::find($after_details["area_id"])->name;
        $genre_name = Genre::find($after_details["genre_id"])->name;

        $image_exist = $request->file('image');
        if ($image_exist) {
            // 拡張子取得
            $extension = $request->file("image")->getClientOriginalExtension();
            // 一時的にtmpフォルダに保存する
            $tmp_image = $request->file('image')->storeAs('tmp', $request->user()->id . '.' . $extension, 'public');
            // DB登録用の文字列定義
            $image_path = '/storage/' . $tmp_image;
            //確認画面からDBへ送るための変数を定義
            $image_name= $request->user()->id . '.' . $extension;

            return view('edit_shop_confirm', ['after_details' => $after_details, 'area_name' => $area_name, 'genre_name' => $genre_name, 'image_name'=> $image_name ,'image_path' => $image_path]);

        }else{
            $image_path= Shop::where("user_id", "=", $user_id)->first();
            $image_name = '';
            return view('edit_shop_confirm', ['after_details' => $after_details, 'area_name'=> $area_name, 'genre_name'=> $genre_name, 'image_name' => $image_name, 'image_path' => $image_path->image]);
        }
    }

    public function update(Request $request)
    {
        $update_item = $request->only(['name', 'area_id', 'genre_id','overview']);
        $image_name = $request->only('image_name');

        if($request->image !== '/img/noimage.jpg'){
            // 一時保存のtmpから本番の格納場所へ移動
            Storage::move('public/tmp/' . $image_name['image_name'], 'public/' . $image_name['image_name']);
            unset($update_item['_token']);
            Shop::find($request->id)->update($update_item);
            Shop::find($request->id)->update(['image'=>'/storage/'.$image_name['image_name']]);
        }else{
            unset($update_item['_token']);
            Shop::find($request->id)->update($update_item);
        }


        return redirect('/owner-page')->with('message', '店舗情報を更新しました');
    }






    






    // カレンダーで日付選択
    public function calendar(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $shop = Shop::where('user_id', '=', $user_id)->first();
        $shop_id = $shop->id;
        $select_date = $request->all();

        //表示されている日付の勤怠レコードを取得
        $item_records = Reservation::where('shop_id', '=', $shop_id)->where("date", "=", "$select_date[select_date]")->paginate(5);

        return view('owner_page', ['display_date' => $select_date["select_date"], 'item_records' => $item_records]);
    }


    public function before_day(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $shop = Shop::where('user_id', '=', $user_id)->first();
        $shop_id = $shop->id;
        //表示されている日付－１日
        $display_date_string = $request->all();
        $display_date_carbon = Carbon::parse($display_date_string["display_date"]);
        $before_day_raw = $display_date_carbon->subDay();
        $before_day = $before_day_raw->format('Y-m-d');

        //表示されている日付の勤怠レコードを取得
        $item_records = Reservation::where('user_id', '=', $shop_id)->where("date", "=", "$before_day")->paginate(5);

        return view('owner_page', ['display_date' => $before_day, 'item_records' => $item_records]);
    }


    public function next_day(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $shop = Shop::where('user_id', '=', $user_id)->first();
        $shop_id = $shop->id;
        //表示されている日付＋１日
        $display_date_string = $request->all();
        $display_date_carbon = Carbon::parse($display_date_string["display_date"]);
        $next_day_raw = $display_date_carbon->addDay();
        $next_day = $next_day_raw->format('Y-m-d');

        //表示されている日付の勤怠レコードを取得
        $item_records = Reservation::where('user_id', '=', $shop_id)->where("date", "=", "$next_day")->paginate(5);

        return view('owner_page', ['display_date' => $next_day, 'item_records' => $item_records]);
    }
}
