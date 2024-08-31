<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Number;
use App\Models\Time;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // 店舗一覧
    public function index()
    {
        $shop_all = Shop::all();
        $favorites=Favorite::all();
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
            return view('index',['shop_all' => $shop_all,'user_id'=>$user_id,'favorites'=>$favorites]);
        }else{
            return view('index', ['shop_all' => $shop_all]);
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

        // カレンダーが昨日以前を非表示にするため「今日」を定義
        $today = Carbon::now()->format('Y-m-d');
        // 店舗の詳細、人数、時間をビューに渡す。カレンダーのminには「今日」を渡す。戻るボタンの分岐のために遷移元URLも送る。
        return view('detail', ['shop_detail' => $shop_detail,'today' => $today, 'prevUrl'=> $prevUrl]);
    }

    // お気に入り
    public function favorite(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $shop_id = $request->all();
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



    // 予約操作
    public function reservation(Request $request)
    {
        $user = Auth::user();
        $reservation_details = $request->all();
        Reservation::create([
            'user_id' => $user->id,
            'shop_id' => $reservation_details['shop_id'],
            'date' =>$reservation_details['date'],
            'time' => $reservation_details['time'],
            'number' => $reservation_details['number']
        ]);
        // 予約完了後は完了お知らせページへ遷移
        return view('done');
    }

    // 予約完了
    public function done()
    {
        return redirect()->back();
    }

    // 予約キャンセル
    public function destroy(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect('/mypage')->with('message', '予約を取り消しました');
    }

    // マイページ
    public function mypage(Request $request)
    {
        $reservation_details = Reservation::with('shop')->get();
        $user = Auth::user();
        $user_id = $user->id;
        $favorites = Favorite::where("user_id","=","$user_id")->get();

        return view('mypage',['reservation_details'=> $reservation_details,'user_id' => $user_id,'favorites' => $favorites]);
    }
}
