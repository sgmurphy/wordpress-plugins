<?php

namespace SolidWP\Mail\Admin;

/**
 * Class Notice
 *
 * Handles the display and dismissal of admin notices for the Solid Mail plugin.
 *
 * @package SolidWP\Mail\Admin
 */
class Notice {

	/**
	 * Meta key to store the dismissed state of the new ownership notice.
	 *
	 * @var string
	 */
	private string $new_ownership_flag = 'solid_mail_notice_new_ownership_dismissed';

	/**
	 * Meta key to store the dismissed state of the migration error notice.
	 *
	 * @var string
	 */
	private string $migration_error_flag = 'solid_mail_notice_migration_error_dismissed';


	/**
	 * Handles the AJAX request to dismiss the admin notice.
	 *
	 * @return void
	 */
	public function dismiss_notice() {
		$nonce = sanitize_text_field( $_POST['_wpnonce'] ?? '' );

		// Verify nonce and return an error if verification fails
		if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'dismiss_solid_mail_notice' ) ) {
			wp_send_json_error();
		}

		$flag = sanitize_text_field( $_POST['flag'] ?? '' );

		// make sure the flag is allowed before saving.
		if ( ! empty( $flag ) && in_array( $flag, [ $this->new_ownership_flag, $this->migration_error_flag ], true ) ) {
			update_user_meta( get_current_user_id(), $flag, true );
			wp_send_json_success();
		}

		wp_send_json_error();
	}

	/**
	 * Displays the admin notice informing users about the new ownership.
	 *
	 * Checks if the notice has been dismissed by the current user. If not,
	 * it outputs the HTML for the notice and a script to handle its dismissal
	 * via AJAX.
	 *
	 * @return void
	 */
	public function display_notice_new_ownership() {
		// only admin should see this.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		// Check if the user has dismissed the notice
		if ( get_user_meta( get_current_user_id(), $this->new_ownership_flag, true ) ) {
			return;
		}

		$nonce = wp_create_nonce( 'dismiss_solid_mail_notice' );
		?>
        <div class="notice notice-info is-dismissible solid-mail-notice">
            <p><?php esc_html_e( 'WP SMTP is now Solid Mail and is being maintained and supported by the team from SolidWP.', 'LION' ); ?>
                <a href="https://go.solidwp.com/wp-smtp-is-now-solid-mail"
                   target="_blank"><?php esc_html_e( 'Learn more.', 'LION' ); ?></a>
            </p>
        </div>
        <script type="text/javascript">
            ( function ( $ ) {
                $( document ).on( 'click', '.solid-mail-notice .notice-dismiss', function () {
                    $.post( ajaxurl, {
                        action: 'dismiss_solid_mail_notice',
                        _wpnonce: '<?php echo $nonce; ?>',
                        flag: '<?php echo $this->new_ownership_flag ?>'
                    } );
                } );
            } )( jQuery );
        </script>
		<?php
	}

	/**
	 * Displays the admin notice if there's a migration error.
	 *
	 * Checks if the migration error notice has been dismissed by the current user. If not,
	 * it outputs the HTML for the notice and a script to handle its dismissal via AJAX.
	 *
	 * @return void
	 */
	public function display_notice_migration_error() {
		// Only admin should see this.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Get the stored migration error message.
		$migration_error = get_option( 'solid_mail_migration_error', '' );

		// Check if the user has dismissed the notice or if there is no error.
		if ( empty( $migration_error ) || get_user_meta( get_current_user_id(), $this->migration_error_flag, true ) ) {
			return;
		}

		$nonce = wp_create_nonce( 'dismiss_solid_mail_notice' );
		?>
        <div class="notice notice-error is-dismissible solid-mail-migration-error-notice">
            <p><?php esc_html_e( 'There was an error during the migration process: ', 'LION' ); ?>
				<?php echo esc_html( $migration_error ); ?></p>
        </div>
        <script type="text/javascript">
            ( function ( $ ) {
                $( document ).on( 'click', '.solid-mail-migration-error-notice .notice-dismiss', function () {
                    $.post( ajaxurl, {
                        action: 'dismiss_solid_mail_notice',
                        _wpnonce: '<?php echo $nonce; ?>',
                        flag: '<?php echo $this->migration_error_flag; ?>'
                    } );
                } );
            } )( jQuery );
        </script>
		<?php
	}
}