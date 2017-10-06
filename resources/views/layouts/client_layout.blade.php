<!DOCTYPE html>
<html>
@include('layouts.client_head')
<body class="dashboard_page">
<section class="dash_column clearfix">
    <div class="container-fluid">
        <div class="row">
@include('layouts.client_header')
        </div>
    </div>
    <div class="dash_left_column clearfix">
        <div class="page_head clearfix">
            <div class="toggle_menu_slide"><i class="fa fa-bars" aria-hidden="true"></i></div>
            <a href="{{ url("home") }}" class="logo_h"><img src="{{ asset('images/Logo.png') }}"></a>
            <div class="logout-btn"><a title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> log out</a></div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    @yield('content')
    </div>
    <input type="hidden" id="user_timezone" value="{{ \Session::get('user_timezone')  }}"/>
</section>

@include('layouts.client_footer_scripts')
</body>
</html>