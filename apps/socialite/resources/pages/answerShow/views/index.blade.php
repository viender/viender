@extends('layouts.app')

@section('content')
hello
@endsection

@section('head-styles')
<link rel="stylesheet" href={{ mix('css/viender/socialite/answerShow/app.css') }}>
@endsection

@section('scripts')
<script src={{ mix('js/viender/socialite/answerShow/app.js') }} async="1"></script>
@endsection