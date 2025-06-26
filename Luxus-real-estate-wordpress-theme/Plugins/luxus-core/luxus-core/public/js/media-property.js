
// Property Images
jQuery( document ).ready( function( $ ) {

    var property_images;

    $('#upload_property_images').on("click", function(e){

        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if( property_images ) {

            property_images.open();
            return;
        }

        // Extend the wp.media object
        property_images = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: 'add'
        });

        /**
         *When multiple images are selected, get the multiple attachment objects
         *and convert them into a usable array of attachments
         */
        property_images.on( 'select', function(){

            var attachments = property_images.state().get('selection').map( 

            function( attachment ) {

                attachment.toJSON();
                return attachment;

            });

            // loop through the array and do things with each attachment
           var i;

           for (i = 0; i < attachments.length; ++i) {

                //sample function 1: add image preview
                $('#property_images').append(
                    '<div class="property_images_preview"><span class="removebtn">X</span><img src="' + attachments[i].attributes.url + '" ><input id="property_images_ids' + attachments[i].id + '" type="hidden" name="property_images_ids[]"  value="' + attachments[i].id + '"></div>'
                    );
            }

        });

        property_images.open();

    });

    $(document).on("click", ".removebtn", function() {
       $(this).parent().remove(); 
    });

});

// Property Thumbnail
jQuery( document ).ready( function( $ ) {
    var property_thumb_uploader;
    
    $('#upload_property_thumbnail').on("click", function(event){
        event.preventDefault();
        // If the uploader object has already been created, reopen the dialog
        if (property_thumb_uploader) {
            property_thumb_uploader.open();
            return;
        }

        // Extend the wp.media object
        property_thumb_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true // Select multiple files Off
        });

        // Grabe Attachment URL and ID
        property_thumb_uploader.on('select', function() {

            // Get attachment data on selection
            attachment = property_thumb_uploader.state().get('selection').first().toJSON();

            // attachment.url set to image preview background
            $( '#property-thumbnail-preview-wrapper' ).css( 'background-image', 'url("' + attachment.url + '")');
            // attachment.id set value to upload image button
            $( '#property_thumbnail_id' ).val( attachment.id );
        });

        // Open the uploader dialog
        property_thumb_uploader.open();

    });
});

// Property 360 Image
jQuery( document ).ready( function( $ ) {
    var property_three_uploader;

    $('#upload_property_three').on("click", function(event){
        event.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (property_three_uploader) {
            property_three_uploader.open();
            return;
        }

        // Extend the wp.media object
        property_three_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true // Select multiple files Off
        });

        // Grabe Attachment URL and ID
        property_three_uploader.on('select', function() {

            // Get attachment data on selection
            attachment = property_three_uploader.state().get('selection').first().toJSON();

            // Attachment Values
            $( '#property-three-preview-wrapper' ).css( 'background-image', 'url("' + attachment.url + '")');
            $( '#property_three_url' ).val( attachment.url );
            $( '#property_three_id' ).val( attachment.id );
            $( '#property_three_width' ).val( attachment.width );
            $( '#property_three_height' ).val( attachment.height );
            $( '#property_three_thumbnail' ).val( attachment.sizes.thumbnail.url );
            $( '#property_three_alt' ).val( attachment.alt_text );
            $( '#property_three_title' ).val( attachment.title );
            $( '#property_three_description' ).val( attachment.description );
        });

        // Open the uploader dialog
        property_three_uploader.open();

    });
});