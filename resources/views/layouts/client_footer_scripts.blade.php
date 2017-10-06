
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.submenu_1').click(function() {
            $('ul.dp_menu_1').toggle('slow');
            $('ul.dp_menu_2').hide('slow');
            $('.icon_f1').toggleClass('fa-chevron-right');
            $('.icon_f1').addClass('fa-chevron-down');
            $('.icon_f2').removeClass('fa-chevron-down').addClass('fa-chevron-right');
            $(this).addClass('active');
            $('.submenu_2').removeClass('active');
        });

        $('.submenu_2').click(function() {
            $('ul.dp_menu_2').toggle('slow');
            $('ul.dp_menu_1').hide('slow');
            $('.icon_f2').toggleClass('fa-chevron-down');
            $('.icon_f1').removeClass('fa-chevron-down').addClass('fa-chevron-right');
            $(this).addClass('active');
            $('.submenu_1').removeClass('active');
        });
    });

    $(document).ready(function() {
        jQuery('.toggle_menu_slide').click(function () {
            jQuery("body").addClass('open_menu');
        });
        jQuery(document).on('click', '.remove_menu', function () {
            jQuery("body").removeClass('open_menu');
        });
        jQuery(document).ready(function(){
            var tz = jstz.determine(); // Determines the time zone of the browser client
            var timezone = tz.name(); //'Asia/Kolhata' for Indian Time.
            var val = jQuery("#user_timezone").val();
            var _token = "{{ csrf_token() }}";
            if(val == "") {
                jQuery.ajax({
                    url:"{{ url('user/set-timezone') }}",
                    type:"POST",
                    data:{'timezone':timezone, '_token': _token},
                    success:function() {
                        jQuery("#user_timezone").val(timezone);
                    }
                })

            }

        });
    });

</script>
@yield('scripts')