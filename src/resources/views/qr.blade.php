<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR</title>
</head>

<body>
    <a class="detail-block__back-button--button" href="/mypage">＜</a>
    {!! QrCode::generate( $reservation_id['id'] ); !!}
</body>

</html>