<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Favorite;
use Carbon\Carbon;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    // 予約操作
    public function reserve(ReservationRequest $request)
    {
        $user = Auth::user();
        $reservation_details = $request->all();
        unset($reservation_details['_token']);
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

    // 予約変更入力
    public function change()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $today = Carbon::now()->format('Y-m-d');
        $reservation_details = Reservation::with('shop')->where("user_id", "=", "$user_id")->get();
        $favorites = Favorite::where("user_id", "=", "$user_id")->get();

        return view('change_reservation', ['reservation_details' => $reservation_details, 'user_id' => $user_id, 'today' => $today, 'favorites' => $favorites]);
    }

    // 変更内容確認
    public function change_confirm(Request $request)
    {
        $before_details=$request->only(['name', 'before_date', 'before_time', 'before_number']);
        $after_details=$request->only(['id','name','after_date','after_time','after_number']);
        return view('change_reservation_confirm',['before_details'=>$before_details,'after_details'=> $after_details]);
    }

    // 変更実行
    public function update(Request $request)
    {
        $update_item = $request->only(['date', 'time', 'number']);
        unset($update_item['_token']);
        Reservation::find($request->id)->update($update_item);
        return redirect('/mypage')->with('message', '予約内容を変更しました');
    }


    // 予約キャンセル
    public function destroy(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect('/mypage')->with('message', '予約を取り消しました');
    }

    public function qr(Request $request)
    {
        $reservation_id = $request->only('id');
        
        return view('qr', ['reservation_id' => $reservation_id]);
    }
}