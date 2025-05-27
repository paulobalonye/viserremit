@php
    $class = request()->routeIs('home') ? 'header--primary' : 'header--secondary';
@endphp
<header class="header-fixed {{ $class }}">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            @if ($class == 'header--primary')
                <a class="logo logo-dark" href="{{ route('home') }}">
                    <img alt="{{ gs('site_name') }}" class="img-fluid logo__is" src="{{ siteLogo('dark') }}" />
                </a>
            @endif
            <a class="logo logo-light" href="{{ route('home') }}">
                <img alt="{{ gs('site_name') }}" class="img-fluid logo__is" src="{{ siteLogo() }}" />
            </a>
            <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse"
                type="button">
                <span class="menu-toggle"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0 align-items-lg-center mb-2">
                    <li class="nav-item">
                        <a class="primary-menu__link" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    @foreach ($pages as $k => $data)
                        <li class="nav-item">
                            <a class="primary-menu__link" href="{{ route('pages', $data->slug) }}">
                                {{ __($data->name) }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="primary-menu__link" href="{{ route('blog') }}">@lang('Blog')</a>
                    </li>
                    <li class="nav-item">
                        <a class="primary-menu__link" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                    @include($activeTemplate . 'partials.language')
                    @guest
                        <li class="nav-item pt-lg-0 pb-lg-0 pt-10 pb-10">
                            <a class="btn btn--md btn--base fixed-width" href="{{ route('user.login') }}">
                                @lang('Login')
                            </a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item pt-lg-0 pb-lg-0 pt-10 pb-10">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <a class="btn btn--md btn--base" href="{{ route('user.home') }}"> @lang('Dashboard')</a>
                                <a class="btn btn--md btn--custom" href="{{ route('user.logout') }}">
                                    @lang('Logout')
                                </a>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
