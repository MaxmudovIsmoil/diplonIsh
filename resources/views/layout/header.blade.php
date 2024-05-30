<!-- END: Head-->
<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
        </div>

        <ul class="nav navbar-nav align-items-center ml-auto">
{{--            <li class="nav-item dropdown dropdown-language">--}}
{{--                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    @if(App::isLocale('ru'))--}}
{{--                        <i class="flag-icon flag-icon-ru"></i><span class="selected-language">Russian</span>--}}
{{--                    @elseif(App::isLocale('en'))--}}
{{--                        <i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span>--}}
{{--                    @else--}}
{{--                        <i class="flag-icon flag-icon-uz"></i><span class="selected-language">Uzbek</span>--}}
{{--                    @endif--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">--}}
{{--                    <a class="dropdown-item @if(App::isLocale('ru')) active @endif" href="{{ route('locale', ['ru']) }}" data-language="ru">--}}
{{--                        <i class="flag-icon flag-icon-ru"></i> Russian--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item @if(App::isLocale('en')) active @endif" href="{{ route('locale', ['en']) }}" data-language="en">--}}
{{--                        <i class="flag-icon flag-icon-us"></i> English--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item @if(App::isLocale('uz')) active @endif" href="{{ route('locale', ['uz']) }}" data-language="ru">--}}
{{--                        <i class="flag-icon flag-icon-uz"></i> Uzbek--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item d-none d-lg-block">
                <a class="nav-link nav-link-style1" id="theme-toggle">
                    <i id="theme-icon" class="ficon fas fa-sun"></i>
                </a>
            </li>
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{ auth()->user()->name }}</span>
                        <span class="user-status">{{ auth()->user()->username }}</span></div><span class="avatar">
                        <img class="round" src="{{ auth()->user()->photo }}"
                             alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="" id="js_profile_btn">
                        <i class="mr-50" data-feather="user"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="mr-50" data-feather="power"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- END: Header-->


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="width: 30px;" />
                    <h2 class="brand-text" style="font-size: 14px; padding-left: 5px;">{{ config('app.name') }}</h2>
                </a></li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if(Auth::user()->rule === 1) {{-- Admin --}}
{{--                <li class="nav-item @if (Request::segment(2) === 'user') active @endif">--}}
{{--                    <a class="d-flex align-items-center" href="">--}}
{{--                        <i data-feather="user"></i> Teachers--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-item @if (Request::segment(2) === 'user') active @endif">
                    <a class="d-flex align-items-center" href="{{ route('admin.user.index') }}">
                        <i data-feather="users"></i> Users
                    </a>
                </li>
                <li class="nav-item @if (Request::segment(2) === 'course') active @endif">
                    <a class="d-flex align-items-center" href="{{ route('admin.course.index') }}">
                        <i data-feather="grid"></i> Kurslar
                    </a>
                </li>
            @else {{-- Student --}}
                @foreach(\App\Models\Course::get()->toArray() as $course)
                    <li class="nav-item @if (Request::segment(2) == $course['id']) active @endif">
                        <a class="d-flex align-items-center" href="{{ route('course.index', $course['id']) }}">
                            <i data-feather="list"></i> {{ $course['name'] }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
