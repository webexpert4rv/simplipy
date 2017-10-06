<!-- Scripts -->

<!-- jQuery -->
<script src="{{ asset('js/admin_dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('js/admin_dist/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('js/admin_dist/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('js/admin_dist/nprogress.js') }}"></script>
<!-- Chart.js -->
<script src="{{ asset('js/admin_dist/Chart.min.js') }}"></script>

<!-- gauge.js -->
<script src="{{ asset('js/admin_dist/gauge.min.js') }}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset('js/admin_dist/bootstrap-progressbar.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('js/admin_dist/icheck.min.js') }}"></script>

<!-- Skycons -->
<script src="{{ asset('js/admin_dist/skycons.js') }}"></script>
<!-- Flot -->
<script src="{{ asset('js/admin_dist/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('js/admin_dist/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('js/admin_dist/flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('js/admin_dist/flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('js/admin_dist/flot/jquery.flot.resize.js') }}"></script>
<!-- Flot plugins -->
<script src="{{ asset('js/admin_dist/flot/jquery.flot.orderBars.js') }}"></script>
<script src="{{ asset('js/admin_dist/flot/jquery.flot.spline.min.js') }}"></script>
<script src="{{ asset('js/admin_dist/flot/curvedLines.js') }}"></script>
<!-- DateJS -->
<script src="{{ asset('js/admin_dist/date.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('js/admin_dist/jquery.vmap.js') }}"></script>
<script src="{{ asset('js/admin_dist/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('js/admin_dist/jquery.vmap.sampledata.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('js/admin_dist/moment.min.js') }}"></script>
<script src="{{ asset('js/admin_dist/moment.min.js') }}"></script>
<script src="{{ asset('js/admin_dist/daterangepicker.js') }}"></script>

<script src="{{ asset('js/admin_dist/pnotify.js') }}"></script>
<script src="{{ asset('js/admin_dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('js/admin_dist/pnotify.nonblock.js') }}"></script>


<!-- Custom Theme Scripts -->
<script src="{{ asset('js/admin_dist/custom.min.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

<script>
    $(document).ready(function () {
        $('textarea').ckeditor();
        var val = $("#success_notif").val();
        console.log('sdda'+val);
        if(typeof  val != "undefined") {

            new PNotify({
                title: 'Success',
                text: val,
                type: 'success',
                styling: 'bootstrap3'
            });
        }

        var error = $("#error_notif").val();
        console.log('sd'+error);
        if(typeof  error != "undefined") {
            new PNotify({
                title: 'Oh No!',
                text: error,
                type: 'error',
                styling: 'bootstrap3'
            });
        }
    })


</script>
@yield('scripts')