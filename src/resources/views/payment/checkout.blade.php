@extends('layouts.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
@stop

@section('content')
<div class="container">
    プレミアム会員は限定クーポンの受取りやさらに便利な機能が使えるようになる500円（買い切り）の有料サービスです。
    <form action="{{ route('checkout.session') }}" method="GET" id="stripe-form">
        @csrf
        <button type="submit" id="card-button" class="btn btn-primary mt-5">
            プレミアム会員になる
        </button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@stop