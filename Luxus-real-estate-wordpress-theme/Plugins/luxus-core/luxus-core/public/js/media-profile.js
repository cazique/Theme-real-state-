// Profile Image

jQuery( document ).ready( function( $ ) {

    var profile_img_uploader;

    $('#upload_profile_image').on("click", function(event){

        event.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (profile_img_uploader) {
            profile_img_uploader.open();
            return;
        }

        //Extend the wp.media object
        profile_img_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false // Select multiple files Off
        });

        //Grabe Attachment URL and ID
        profile_img_uploader.on('select', function() {

            // Get attachment data on selection
            attachment = profile_img_uploader.state().get('selection').first().toJSON();

            // attachment.url set to image preview background
            $( '#profile-image-preview-wrapper' ).css( 'background-image', 'url("' + attachment.url + '")');
            // attachment.id set value to upload image button
            $( '#profile_image_id' ).val( attachment.id );

            // Attachment Values
            $( '#user_img_url' ).val( attachment.url );
            $( '#user_img_id' ).val( attachment.id );
            $( '#user_img_width' ).val( attachment.width );
            $( '#user_img_height' ).val( attachment.height );
            $( '#user_img_thumbnail' ).val( attachment.sizes.thumbnail.url );
            $( '#user_img_alt' ).val( attachment.alt_text );
            $( '#user_img_title' ).val( attachment.title );
            $( '#user_img_description' ).val( attachment.description );

        });

        //Open the uploader dialog
        profile_img_uploader.open();

    });

});


// Profile Thumbnail
jQuery( document ).ready( function( $ ) {

    var profile_thumb_uploader;

    $('#upload_profile_thumbnail').on("click", function(event){

        event.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (profile_thumb_uploader) {
            profile_thumb_uploader.open();
            return;
        }

        //Extend the wp.media object
        profile_thumb_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false // Select multiple files Off
        });

        //Grabe Attachment URL and ID
        profile_thumb_uploader.on('select', function() {

            // Get attachment data on selection
            attachment = profile_thumb_uploader.state().get('selection').first().toJSON();

            // attachment.url set to image preview background
            $( '#profile-thumbnail-preview-wrapper' ).css( 'background-image', 'url("' + attachment.url + '")');
            // attachment.id set value to upload image button
            $( '#profile_thumbnail_id' ).val( attachment.id );

            // Attachment Values
            $( '#user_cover_url' ).val( attachment.url );
            $( '#user_cover_id' ).val( attachment.id );
            $( '#user_cover_width' ).val( attachment.width );
            $( '#user_cover_height' ).val( attachment.height );
            $( '#user_cover_thumbnail' ).val( attachment.sizes.thumbnail.url );
            $( '#user_cover_alt' ).val( attachment.alt_text );
            $( '#user_cover_title' ).val( attachment.title );
            $( '#user_cover_description' ).val( attachment.description );

        });

        //Open the uploader dialog
        profile_thumb_uploader.open();

    });

});