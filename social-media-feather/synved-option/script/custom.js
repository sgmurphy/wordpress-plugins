// Synved WP Options
// Custom jquery code
// Version: 1.0
//
// Copyright (c) 2011 Synved Ltd.
// All rights reserved

var synvedOptionmediaUploadInput = null;

var SynvedOption = {

	performRequest: function( action, params ) {
		if ( params == undefined || params == null ) {
			params = {};
		}

		jQuery.ajax(
			SynvedOptionVars.ajaxurl,
			{
				type: 'POST',
				data: {
					action: 'synved_option',
					synvedSecurity: SynvedOptionVars.synvedSecurity,
					synvedAction: action,
					synvedParams: params,
				},
				success: function( response ) {
					SynvedOption.actionStarted( action, params, response, this );
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					SynvedOption.actionFailed( action, params, errorThrown, this );
				},
			},
		);
	},

	actionStarted: function( action, params, response, request ) {

	},

	actionFailed: function( action, params, error, request ) {

	},

	handleOverlay: function( markup ) {

	},
};

jQuery( document ).ready( function() {
	jQuery( '#sharethis_terms_notice' ).on( 'click', '.notice-dismiss', function( event ) {
		jQuery.post( ajaxurl, { action: 'feather_hide_terms', nonce: SynvedOptionVars.synvedSecurity, } );
	} );

	jQuery( '.synved-option-upload-button' ).click( function() {
		var formfield = jQuery( this ).prevAll( 'input[type="text"]' );
		var type = jQuery( this ).prevAll( 'input[type="hidden"]' ).attr( 'value' );
		synvedOptionmediaUploadInput = formfield;
		tb_show( '', 'media-upload.php?type=' + type + '&amp;TB_iframe=true' );
		return false;
	} );

	var oldSendToEditor = null;

	if ( window.send_to_editor ) {
		oldSendToEditor = window.send_to_editor;
	}

	window.send_to_editor = function( html ) {
		if ( oldSendToEditor != null ) {
			oldSendToEditor( html );
		}

		imgurl = jQuery( 'img', html ).attr( 'src' );
		jQuery( synvedOptionmediaUploadInput ).val( imgurl );
		tb_remove();
	};

	jQuery( '.synved-option-color-input-picker' ).each( function() {
		var it = jQuery( this );
		var input = it.prev( 'input.color-input' );
		it.farbtastic( input );

		it.stop().css( { opacity: 0, display: 'none' } );

		input.focus( function() {
			jQuery( it ).stop().css( { display: 'block' } ).animate( { opacity: 1 } );
		} )
			.blur( function() {
				jQuery( it ).stop().animate( { opacity: 0 } ).css( { display: 'none' } );
			} );
	} );

	jQuery( '.synved-option-tag-selector' ).suggest( ajaxurl + '?action=ajax-tag-search&tax=post_tag', {
		multiple: true,
		multipleSep: ',',
	} );

	jQuery( '.synved-option-reset-button' ).click( function( e ) {
		var jthis = jQuery( this );
		var input = jthis.parentsUntil( 'tr' ).find( 'input, textarea' );

		if ( input.size() > 0 ) {
			var placeholder = input.attr( 'placeholder' );

			if ( placeholder != null ) {
				input.val( placeholder );
			}
		}

		e.preventDefault();

		return false;
	} );
} );

( function( $, wp ) {

	$( document ).ready( function() {
		// Close review us.
		$( 'body' ).on( 'click', '#close-review-us', function() {
			wp.ajax.post( 'smf_ajax_hide_review', {
				nonce: SynvedOptionVars.synvedSecurity,
			} ).always( function( results ) {
				$( '.smf-review-us' ).fadeOut();
			} );
		} );
	} );

	/**
	 * Handles "disable all features" switch button
	 * @type {{init: synved_switcher.init}}
	 */
	synved_switcher = {
		init: function( state ) {
			var checkbox = $( "#synved-disable" );

			if ( state ) {
				checkbox.prop( 'checked', 'checked' );
			} else {
				checkbox.removeProp( 'checked' );
			}

			$( "#synved-slider" ).on(
				"click",
				function( e ) {
					checkbox = $( "#synved-disable" );
					if ( checkbox[0].checked ) {
						if ( confirm( 'This will decline ShareThis Terms of Service, please confirm.' ) ) {
							window.location.href = SynvedOptionVars.termsURLDisagree;
						} else {
							var int = setInterval(
								function() {
									if ( ! checkbox[0].checked ) {
										checkbox[0].checked = true;
										clearInterval( int );
									}
								},
								10,
							);
						}
					} else {
						window.location.href = SynvedOptionVars.termsURLAgree;
					}
				},
			);
		},
	};
} )( window.jQuery, window.wp );
