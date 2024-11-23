<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR</title>
    <link rel="stylesheet" href="{{ asset('css/qr.css') }}">
</head>

<body>
    <div class="qr-group">
        <div class="title">
            <p class="title__text">来店照合QRコード</p>
        </div>

        <div class="content">
            {!! QrCode::generate( $reservation_id['id'] ); !!}
        </div>

        <div class=back__button>
            <a class="detail-block__back-button--button" href="/mypage">戻る</a>
        </div>
    </div>
</body>

</html>