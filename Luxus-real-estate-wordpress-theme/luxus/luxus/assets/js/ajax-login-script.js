(function($){
    "use strict";
    jQuery(document).ready(function () {

        $(document).on('click','.sl-ajax-login',function(){

            $('#sl-login-model').hide();
            $('#sl-login-model-content').hide();
            
            $('#sl-login-model').fadeIn(500);
            $('#sl-login-model-content').fadeIn(500);

            return false;

        });

        $(document).on( "click","#sl-login-model-content .close", function() {
            $('#sl-login-model').hide();
            $('#sl-login-model-content').hide();
        });
        
        // Perform AJAX login on form submit
        $('form#login').on('submit', function(e){
            $('form#login p.status').show().text(ajax_login_object.loadingmessage);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_login_object.ajaxurl,
                data: { 
                    'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                    'username': $('form#login #username').val(), 
                    'password': $('form#login #password').val(), 
                    'security': $('form#login #security').val() },
                success:function(data){
                    $('form#login p.status').text(data.message);
                    if (data.loggedin == true){
                        document.location.href = ajax_login_object.redirecturl;
                    }
                }
                
            });
            e.preventDefault();
        });

    });
})(jQuery);