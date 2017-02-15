(function($) {
    $(function() {
 
        // Check to make sure the input box exists
        if( 0 < $('#datepicker').length ) {
            $('#datepicker').datepicker();
        } // end if
 
    });
}(jQuery));		


 // Advertisement Upload JS
		function renderMediaUploader( $ ) {
			'use strict';
			
			var file_frame, image_data, json;
			
			if( undefined !== file_frame) {
				file_frame.open();
				return;
			}
			
			file_frame = wp.media.frames.file_frame = wp.media({
				frame: 'post',
				state: 'insert',
				multiple: false
			});
			
			file_frame.on( 'insert', function() {
				json = file_frame.state().get( 'selection' ).first().toJSON();
				
				if( 0 > $.trim( json.url.length ) ) {
					return;
				}
				
				$( '#lwr-ad-image-container' )
					.children( 'img' )
						.attr( 'src', json.url )
						.attr( 'alt', json.caption )
						.attr( 'title', json.title )
										.show()
					.parent()
					.removeClass( 'hidden' );
					
				$( '#lwr-ad-image-container' )
					.prev()
					.hide();
					
				$( '#lwr-ad-image-container' )
					.next()
					.show();
					
				// Store the image's information into the meta data fields
				$( '#ad-thumbnail-src' ).val( json.url );
				$( '#ad-thumbnail-title' ).val( json.title );
				$( '#ad-thumbnail-alt' ).val( json.title );
										
			});
			
			file_frame.open();
		}
		
		(function( $ ) {
			'use strict';
			
			$(function() {
				$( '#upload_ad_button' ).on( 'click', function( evt ) {
					evt.preventDefault();
					renderMediaUploader( $ );
				});
				
				$( '#remove-ad-image' ).on( 'click', function( evt ) {
					evt.preventDefault();
					resetUploadForm( $ );
				});
				
				renderFeaturedImage($);
			});
		
		})( jQuery );
		
		function resetUploadForm( $ ) {
			'use strict';
			
			$( '#lwr-ad-image-container' ).children( 'img' ).hide();				
			$( '#lwr-ad-image-container' ).prev().show();			
			$( '#lwr-ad-image-container' ).next().hide().addClass('hidden');			
			$( '#lwr-ad-image-meta' ).children().val('');
			
		}
		
		function renderFeaturedImage( $ ) {
			if( '' !== $.trim ( $( '#ad-thumbnail-src' ).val() ) ) {
				$( '#lwr-ad-image-container' ).removeClass( 'hidden' );
				
				$( '#upload_ad_button' ).parent().hide();
				$( '#remove-ad-image' ).parent().removeClass('hidden' );
			}
		}
			
		
 
