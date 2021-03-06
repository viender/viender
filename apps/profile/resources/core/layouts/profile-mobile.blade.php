@extends('viender::layouts.app')

@section('content')
<div class="">
	<div class="row profile-header">
		<div class="col s12 profile-avatar">
			<img src="{{ Storage::url($user->avatar_large_url) }}" alt="">
		</div>
	</div>

	<div class="row profile-userDetail">
		<div class="col s12">
            <div class="profile-userDetail__container">
    			<span class="profile-userDetail__name">{{ $user->fullName() }}</span>
                <i class="fa fa-ellipsis-h profile-userDetail__menu" aria-hidden="true" @click="$refs.profileMenu.open()"></i>
            </div>

			@if(\Auth::user() ? $followed = \Auth::user()->followedUsers()->where([
	            'followable_id'   => $user->id,
	        ])->exists() && \Auth::user() ? \Auth::user()->id != $user->id : false : false)
	        	<div class="followButton" v-if="notMounted">
	        		<button class="btn followed">Unfollow</button>
	        	</div>
	        @elseif(\Auth::user() ? \Auth::user()->id != $user->id : false)
	        	<div class="followButton" v-if="notMounted">
	        		<button class="btn">Follow</button>
	        	</div>
	        @endif

			@if(\Auth::user() ? \Auth::user()->id != $user->id : false)
				<follow-button
					followee_id="{{ $user->id }}"
					url="{{ route('api.viender.follow.users.followings.store', \Auth::user()) }}"
					followed="{{ $followed }}"
					@mounted="hideBeforeMountedPreloaders()">
				</follow-button>
			@endif
		</div>
	</div>

	<div class="row">
		@include('viender.profile.layouts::profileNav-mobile', ['currentMenu' => $currentMenu, 'obj' => $user])
	</div>

	<div class="row">
		<div class="col s12 profile-content">
			@yield('profile-content')
		</div>
	</div>

    <profile-menu ref="profileMenu" update-profile-url="{{ route('web.viender.profile.update') }}"></profile-menu>
</div>
@endsection

@section('head-styles')
<link rel="stylesheet" href={{ mix('css/viender/profile/profile/app-mobile.css') }}>
@endsection

@section('scripts')
<script>
    window.$loadScript({
        d: document,
        tag: 'script',
        id: 'app-script',
        url: "{{ mix('js/viender/profile/profile/app-mobile.js') }}",
        onload: function() {
            window.$appScriptLoaded = true;
            window.$runApp();
        }
    });
</script>
@endsection
