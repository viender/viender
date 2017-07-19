@extends('viender::layouts.app')

@section('content')
<div class="" style="padding-top: 5px;">
    <div class="row">
        <div class="col s3">

        </div>
        <div class="col s6">
            <h5>Top stories for you</h5>
            <answer :answer="{{ json_encode($transformedAnswer) }}"></answer>
        </div>
        <div class="col s3">

        </div>
    </div>
</div>
@endsection

@section('head-styles')
<link rel="stylesheet" href={{ mix('css/viender/socialite/read/app.css') }}>
@endsection

@section('scripts')
<script src={{ mix('js/viender/socialite/read/app.js') }} async defer></script>
@endsection