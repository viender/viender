@extends('layouts.app')

@section('content')
<div class="" style="padding-top: 5px;">
	<div class="row">
		<div class="col s3">

		</div>
		<div class="col s6">
			{{ \Auth::user()->name }}
		</div>
		<div class="col s3">
			
		</div>
	</div>
</div>
@endsection

@section('head-styles')
<link rel="stylesheet" href={{ mix('css/viender/socialite/answer/app.css') }}>
@endsection

@section('head-scripts')
<script src={{ mix('js/viender/socialite/answer/app.js') }} async="1"></script>
@endsection