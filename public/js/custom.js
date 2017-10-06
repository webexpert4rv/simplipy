$(document).ready(function(){
   jQuery('.menu_icon').click(function() {
        jQuery("body").addClass('Open_menu');
    });
    jQuery(document).on('click','.remove_menu',function(){
      jQuery("body").removeClass('Open_menu');
    });
});



