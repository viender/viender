<div id="navbar-mobile" class="navbar-fixed navbar-mobile">
    <nav class="navbar-mobile">
        <div class="nav-wrapper">
            <div class="row navbar-mobile-header">
                <div class="col s3">

                </div>
                <div class="col s6">
                    <div class="logo">
                       <h1><a href="/">Viender</a></h1>
                    </div>
                </div>
                <div class="col s3">
                    <search-or-ask-panel-trigger-open>
                        <i id="ask-menu" class="fa fa-search-plus" aria-hidden="true"></i>
                        <span> Ask</span>
                    </search-or-ask-panel-trigger-open>
                </div>
            </div>
            <div class="row navbar-mobile-menus">
                @if (Auth::guest())
                    {{-- <div class="navbar-mobile-menus-button col s6"><a href="{{ url('/login') }}">Login</a></div>
                    <div class="navbar-mobile-menus-button col s6"><a href="{{ url('/register') }}">Register</a></div> --}}
                @else
                    <div class="col s3">
                        <a
                            id="read-menu"
                            @click="$store.commit('navigation/SET_ACTIVE_MENU', {activeMenu: 1})"
                            :class="$store.state.navigation.activeMenu === 1 ? 'active' : ''"
                            class="navbar-mobile-menus-button {{ Route::currentRouteName() == 'web.viender.socialite.pages.read' ? 'active' : '' }}"
                            href={{ route('web.viender.socialite.pages.read') }}>
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="col s3">
                        <a
                            id="answer-menu"
                            @click="$store.commit('navigation/SET_ACTIVE_MENU', {activeMenu: 2})"
                            :class="$store.state.navigation.activeMenu === 2 ? 'active' : ''"
                            class="navbar-mobile-menus-button {{ Route::currentRouteName() == 'web.viender.socialite.pages.answer' ? 'active' : '' }}"
                            href={{ route('web.viender.socialite.pages.answer') }}>
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="notification-menu-button col s3">
                        @if(\Auth::user())
                            @if(Route::currentRouteName() !== 'web.viender.notification.notification.index' && \Auth::user()->notifications()->count() > 0)
                                <div
                                    class="notification-count"
                                    v-html="$store.state.navigation.notificationCount"
                                    v-cloak="true"
                                    v-if="$store.state.navigation.showNotificationCount && $store.state.navigation.notificationCount"></div>
                            @endif
                        @endif
                        <a
                            id="notification-menu"
                            @click="$store.commit('navigation/SET_ACTIVE_MENU', {activeMenu: 3})"
                            :class="$store.state.navigation.activeMenu === 3 ? 'active' : ''"
                            class="navbar-mobile-menus-button {{ Route::currentRouteName() == 'web.viender.notification.notification.index' ? 'active' : '' }}"
                            href={{ route('web.viender.notification.notification.index') }}>
                            <i class="fa fa-bell" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="col s3">
                        <a
                            id="profile-menu"
                            @click="$store.commit('navigation/SET_ACTIVE_MENU', {activeMenu: 4})"
                            :class="$store.state.navigation.activeMenu === 4 ? 'active' : ''"
                            class="navbar-mobile-menus-button {{ Route::currentRouteName() == 'web.viender.profile.pages.profile' ? 'active' : '' }}"
                            href={{ route('web.viender.profile.pages.profile', \Auth::user()->username) }}>
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</div>

<search-or-ask-panel></search-or-ask-panel>
<create-question-overlay></create-question-overlay>
