<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('admin.layouts.admin_header')

<body class="nav-md after_login">
<div class="container body">
    <div class="main_container">
        @if(session('success'))
            <input type="hidden" value="{{ session('success') }}" id="success_notif">
        @endif

        @if(session('error'))
                <input type="hidden" value="{{ session('error') }}" id="error_notif">
            @elseif(count($errors) > 0)
                @php  $html = "<ul>"; @endphp
                @foreach ($errors->all() as $error)
                   @php $html .="<li>".$error."</li>"; @endphp
                @endforeach
                @php  $html .= "</ul>"; @endphp
                    <input type="hidden" value="{!! $html !!}" id="error_notif">
        @endif
        @if(!\Auth::user())
        @include('admin.layouts.admin_sidebar')
        @else
            @include('admin.layouts.user_sidebar')
            @endif
        @yield('content')

    <!-- footer content -->
        <footer>
            <div class="pull-right">
                &copy; {{ date('Y') }} Simplify
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="mymodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
            </div>
           {{-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>--}}

        </div>
    </div>
</div>

@include('admin.layouts.admin_footer')
</body>
</html>