<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', [ShopController::class, 'index']);
Route::get('/detail/{id}', [ShopController::class, 'detail']);
Route::get('/thanks', [ShopController::class, 'thanks']);
Route::post('/done', [ShopController::class, 'done']);
Route::get('/search_shop',[ShopController::class, 'search_shop']);

Route::group(['middleware' => ['auth','verified']], function () {
    Route::post('/reserve', [ShopController::class, 'reservation']);
    Route::delete('/reserve/cancel', [ShopController::class, 'destroy']);
    Route::post('/favorite/{id}', [ShopController::class, 'favorite']);
    Route::get('/mypage', [ShopController::class, 'mypage']);
});

//ユーザー登録後にメール認証を促すページに遷移
Route::get('/email/verify', function () {
    return view('auth.verify_email');
})->middleware('auth')->name('verification.notice');

//認証リンクをクリックしたときに生成されるリクエストを処理
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');


//認証メールの再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', '認証メールを再送信しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');