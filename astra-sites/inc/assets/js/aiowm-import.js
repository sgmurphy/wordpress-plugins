(function($){

	AstraSitesAIOWMImport = {

		/**
		 * Init
		 */
		init: function() {
			this._bind();
		},

		/**
		 * Binds events for the Astra Sites.
		 *
		 * @since x.x.x
		 *
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
            if ( ! AstraSitesAIOWMImportVars.import_url ) {
                return;
            }

			$("#ai1wm-import-url").click();
            $('#ai1wmle-import-url').val(AstraSitesAIOWMImportVars.import_url);
            var inputElement = document.getElementById('ai1wmle-import-url');
            var event = new Event('input', {
                bubbles: true,
                cancelable: true,
              });
              
              // Triggering the event on the input element
            inputElement.dispatchEvent(event);
            setTimeout(function() {
                var importBtn = $( '#ai1wmle-import-file' );
                if ( importBtn ) {
                    importBtn.click();
                }
            }, 1000);
		},

		/**
		 * Close Getting Started Notice
		 *
		 * @param  {object} event
		 * @return void
		 */
		_auto_close_notice: function() {

			if( $( '.astra-sites-getting-started-btn' ).length ) {
				$.ajax({
					url: AstraSitesAIOWMImportVars.ajaxurl,
					type: 'POST',
					data: {
						'action' : 'astra-sites-getting-started-notice',
						'_ajax_nonce' : AstraSitesAIOWMImportVars._ajax_nonce,
					},
				})
				.done(function (result) {
				});
			}

		},

		/**
		 * Activate Theme
		 *
		 * @since x.x.x
		 */
		_activateTheme: function( event, response ) {
			event.preventDefault();

			$('#astra-theme-activation-nag a').addClass('processing');

			if( response ) {
				$('#astra-theme-activation-nag a').text( AstraSitesAIOWMImportVars.installed );
			} else {
				$('#astra-theme-activation-nag a').text( AstraSitesAIOWMImportVars.activating );
			}

			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				$.ajax({
					url: AstraSitesAIOWMImportVars.ajaxurl,
					type: 'POST',
					data: {
						'action' : 'astra-sites-activate-theme',
						'_ajax_nonce' : AstraSitesAIOWMImportVars._ajax_nonce,
					},
				})
				.done(function (result) {
					if( result.success ) {
						$('.astra-sites-theme-action-link').parent().html( AstraSitesAIOWMImportVars.activated + ' 🎉' );
					}

				});

			}, 3000 );

		},

		/**
		 * Install and activate
		 *
		 * @since x.x.x
		 *
		 * @param  {object} event Current event.
		 * @return void
		 */
		_install_and_activate: function(event ) {
			event.preventDefault();
			var theme_slug = $(this).data('theme-slug') || '';
			var btn = $( event.target );

			if ( btn.hasClass( 'processing' ) ) {
				return;
			}

			btn.text( AstraSitesAIOWMImportVars.installing ).addClass('processing');

			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( event );
			}

			wp.updates.installTheme( {
				slug: theme_slug
			});
		}

	};

	/**
	 * Initialize
	 */
	$(function(){
		AstraSitesAIOWMImport.init();
	});

})(jQuery);