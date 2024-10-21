<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\StripeController;
use App\Models\Reservation;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;




Route::get('/', [ShopController::class, 'index']);
Route::get('/detail/{id}', [ShopController::class, 'detail']);

Route::get('/search_shop',[ShopController::class, 'search_shop']);

Route::post('/done', [ReservationController::class, 'done']);


Route::group(['middleware' => ['auth','verified']], function () {
    Route::get('/mypage', [ShopController::class, 'mypage']);
    Route::get('/mypage/detail/{id}', [ShopController::class, 'detail']);
    Route::post('/favorite/{id}', [ShopController::class, 'favorite']);
    Route::get('/thanks', [ShopController::class, 'thanks']);
    
    Route::post('/reserve', [ReservationController::class, 'reserve']);
    Route::get('/reserve/change', [ReservationController::class, 'change']);
    Route::post('/reserve/change/confirm', [ReservationController::class, 'change_confirm']);
    Route::patch('/reserve/change/update', [ReservationController::class, 'update']);
    Route::delete('/reserve/cancel', [ReservationController::class, 'destroy']);

    
});

//管理者用ルート
Route::group(['middleware' => ['auth', 'can:admin']], function () {
    Route::get('/admin-page', [AdminController::class, 'index']);
    Route::post('/admin-email/confirm', [AdminController::class, 'admin_email_confirm']);
    Route::post('/admin-email/send', [AdminController::class, 'admin_email_send']);

});

//店舗代表者用ルート
Route::group(['middleware' => ['auth', 'can:owner']], function () {
    Route::get('/owner-page', [OwnerController::class, 'index']);

    Route::get('/before_day', [OwnerController::class, 'before_day']);
    Route::get('/next_day', [OwnerController::class, 'next_day']);
    Route::get('/calendar', [OwnerController::class, 'calendar']);

    Route::get('/myshop/detail/{id}', [ShopController::class, 'detail']);
    Route::post('shop/register/confirm',[OwnerController::class,'create']);
    Route::post('shop/register/done', [OwnerController::class, 'store']);
    Route::get('shop/edit/{id}', [OwnerController::class, 'edit']);
    Route::post('shop/edit/{id}/confirm', [OwnerController::class, 'update_confirm']);
    Route::patch('shop/edit/{id}/update', [OwnerController::class, 'update']);

    Route::get('/owner-email/index', [OwnerController::class, 'owner_email_index']);
    Route::post('/owner-email/confirm', [OwnerController::class, 'owner_email_confirm']);
    Route::post('/owner-email/send', [OwnerController::class, 'owner_email_send']);
});

//一般用ルート
Route::group(['middleware' => ['auth', 'can:general']], function () {
    Route::get('/checkout', function () {
        return view('payment.checkout');
    });
    Route::get('success', function () {
        return view('payment.checkout_success');
    })->name('success');
    Route::get('cancel', function () {
        return view('payment.checkout_cancel');
    })->name('cancel');
    Route::get('/checkout-payment', [StripeController::class,'checkout'])->name('checkout.session'); // Stripeフォームへ遷移する処理

    Route::get('/qr', [ReservationController::class, 'qr']);
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

