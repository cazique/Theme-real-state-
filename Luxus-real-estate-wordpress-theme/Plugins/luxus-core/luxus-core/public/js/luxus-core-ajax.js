
(function($){
    $(document).ready(function () {

        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": true,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }

    	// Save Searches
        $("#save-search").on("click", function(){

            if($("#search_name").val() == '') {

                $(".err_msg").html("This Field Is Required.")

            }else{

                var searchData =  $('form.name-your-search, form.properties-search-form').serialize();

                $.ajax({
                    type: 'POST', // Adding Post method
                    url: save_searches_object.ajaxurl, // Including ajax file url
                    data: {
                        "action": "luxus_save_search_action", //Action Function
                        "formData":searchData // Searched Data
                    }, // Sending data searchTitle to luxus_save_search_action function.

                    success: function(data){ // Show returned data using the function.
                        $('#saveSearchesModel').hide();
                        $('.modal-backdrop').hide();
                    }
                });

            }

        });

        // Delete Searches
        $(".delete-search").on("click", function(){

            var formid = $(this).closest(".save-search-form").attr("id");

            // Get Delete Button ID
            var del_id = $(this).attr("id");

            // On Click Confirm Button
            $(".confirm-delete-search").on("click", function(){

                $.ajax({
                    type: 'POST', // Adding Post method
                    url: delete_searches_object.ajaxurl, // Including ajax file url
                    data: {
                        "action": "luxus_delete_search_action", //Action Function
                        "del_id": del_id // delete search id
                    }, // Sending data searchTitle to luxus_delete_search_action function.

                    success: function(data){ // Show returned data using the function.
                        $('#confirm-delete-model').hide();
                        $('.modal-backdrop').hide();
                        $('#' + formid).hide();
                    }
                });
                  
            });

        });
         
    });
})(jQuery);

// Test Save Searchess
function save_search(){
    
    jQuery(function($){
        $('#sl-login-model').hide();
        $('#sl-login-model-content').hide();
        
        $('#sl-login-model').fadeIn(500);
        $('#sl-login-model-content').fadeIn(500);

        return false;
    });
}

// Bookmark / Heart Property
function save_heart(property_id){

    jQuery(function($){

        let attr_login = $("#heartbtn"+property_id).attr('data-userLogin');
        let attr_heart = $("#heartbtn"+property_id).attr('data-heartValue');

        // If User Login
        if ( attr_login == 'Yes' ) {

            if( attr_heart == 'No' ){

                $("#heartbtn"+property_id).css('background','#00bbff');
                $("#heartbtn"+property_id+" .sl-icon").css('color','#ffffff');
                $("#heartbtn"+property_id).attr('data-heartValue','Yes');
                toastr.info('Marked as favorite');
            }
            else{
                
                $("#heartbtn"+property_id).css('background','rgba(255, 255, 255, 0.9)');
                $("#heartbtn"+property_id+" .sl-icon").css('color','#00bbff');
                $("#heartbtn"+property_id).attr('data-heartValue','No');
                $("#heartbtn"+property_id).removeClass("already-selected");
                toastr.info('Removed from favorite');
            }

            $.ajax({
                type: 'POST', // Adding Post method
                url: heart_property_object.ajaxurl, // Including ajax file url
                data: {
                    "action": "luxus_heart_property_action", //Action Function
                    "property_id": property_id // Property ID
                },
            });

        } else {

            $('#sl-login-model').hide();
            $('#sl-login-model-content').hide();
            
            $('#sl-login-model').fadeIn(500);
            $('#sl-login-model-content').fadeIn(500);

            return false;
        }

    });
}

// Compare Property
function save_compare(property_id){

    jQuery(function($){

        $(".compaire-popup").css('visibility','visible');    
        $(".compaire-popup").css('opacity','1');    
        $(".compaire-popup").fadeIn(500);

        $.ajax({
            type: 'POST', // Adding Post method
            url: compare_property_object.ajaxurl, // Including ajax file url
            data: {
                "action": "luxus_compare_property_action", //Action Function
                "property_id": property_id // Property ID
            },

            success:function(response) {

                if (response == 'already_added') {

                    toastr.info('Already added to compair list.');

                } else if (response == 'full') {

                    $('#compare_icons').html(3);
                    toastr.info('Only 3 properties can be compair.');

                } else {

                    $("#comparebtn"+property_id).css('background','#00bbff');
                    $("#comparebtn"+property_id+" .sl-icon").css('color','#ffffff');
                    $('#compare_icons').html(response);
                    toastr.info('Property added to compair list.');

                }
            }
        })
    });
}

// Privent Post data confirm
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}