@extends('viender::layouts.app')

@section('content')
<div class="">
	<div class="row profile-header">
		<div class="col s3 profile-avatar left-column">
			<img src="{{ $user->avatar_url }}" alt="">
		</div>
	</div>

	<div class="row profile-nav">
		<div class="col s8 offset-s3">
			@include('viender.profile.layouts::profileNav', ['currentMenu' => 0])
		</div>
	</div>

	<div class="row">
		<div class="col s3 left-column">
			<div class="profile-content__userDetail">
				<span>{{ $user->fullName() }}</span>
			</div>
		</div>

		<div class="col s6">
			<div class="profile-content">
			<feed-list :feed-urls="{ answers: '{{ route('api.viender.socialite.users.answers.index', $user->username) }}' }"></feed-list>
			<answer-show-modal></answer-show-modal>
			</div>
		</div>

		<div class="col s3">
		</div>
	</div>
</div>
@endsection

@section('head-styles')
<link rel="stylesheet" href={{ mix('css/viender/profile/profile/app.css') }}>
@endsection

@section('head-scripts')
<script src={{ mix('js/viender/profile/profile/app.js') }} async="1"></script>
@endsection
