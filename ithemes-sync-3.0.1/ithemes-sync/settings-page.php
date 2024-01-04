<?php

/*
Code to render and manage the settings page for Project Sync.
Written by Chris Jean for iThemes.com
Version 1.1.1

Version History
	1.0.0 - 2013-10-02 - Chris Jean
		Initial version
	1.0.1 - 2013-12-02 - Chris Jean
		Changed the deauthenticate() function to deauthentcate a user when the server reports that the user is not found. This prevents the issue where users are uanble to be removed.
	1.0.2 - 2014-02-13 - Chris Jean
		Updated error messages for failed server connections.
		Added wrap class to main settings page wrapper to allow for proper positioning of notices.
	1.1.0 - 2014-03-28 - Chris Jean
		Users are now validated and shown in valid and invalid groups.
	1.1.1 - 2014-10-13 - Chris Jean
		Updated Sync dashboard URL.
*/


class Ithemes_Sync_Settings_Page {
	private $page_name = 'solid-central';

	private $path_url = '';
	private $self_url = '';
	private $had_error = false;
	private $messages = array();
	private $sync_dashboard_url = 'https://central.solidwp.com/';


	public function __construct() {
		require_once( $GLOBALS['ithemes_sync_path'] . '/functions.php' );

		$this->path_url = Ithemes_Sync_Functions::get_url( $GLOBALS['ithemes_sync_path'] );

		list( $this->self_url ) = explode( '?', $_SERVER['REQUEST_URI'] );
		$this->self_url .= '?page=' . $this->page_name;

		add_action( 'ithemes_sync_settings_page_index', array( $this, 'index' ) );
		add_action( 'admin_print_styles', array( $this, 'add_styles' ) );
		add_action( 'admin_print_scripts', array( $this, 'add_scripts' ) );
	}

	public function add_styles() {
		wp_enqueue_style( 'ithemes-updater-settings-page-style', "{$this->path_url}/css/settings-page.css", array(), '3.0.0' );
	}

	public function add_scripts() {
		$var = 'ithemes-updater-settings-page-script';

		$translations = array(
			'confirm_dialog_text' => __( 'Are you sure that you wish to disconnect this user?', 'it-l10n-ithemes-sync' ),
		);

		wp_enqueue_script( $var, "{$this->path_url}/js/settings-page.js", array( 'jquery' ), '3.0.0' );
		wp_localize_script( $var, 'ithemes_sync_settings', $translations );
	}

	public function index() {
		$this->options = $GLOBALS['ithemes-sync-settings']->get_options();

		$this->handle_post_action();

		$this->show_settings();
	}

	private function handle_post_action() {
		$post_data = Ithemes_Sync_Functions::get_post_data( array( 'username', 'password', 'action', 'user' ), true, true );
		$action    = $post_data['action'];

		if ( 'authenticate' == $action ) {
			$this->authenticate( $post_data );
		} elseif ( 'deauthenticate' == $action ) {
			$this->deauthenticate( $post_data );
		}

		$this->options = $GLOBALS['ithemes-sync-settings']->get_options();
	}

	private function authenticate( $data ) {
		check_admin_referer( 'authenticate-user' );


		require_once( $GLOBALS['ithemes_sync_path'] . '/server.php' );


		$result = Ithemes_Sync_Server::authenticate( $data['username'], $data['password'] );

		if ( is_wp_error( $result ) ) {
			$heading = __( 'The user could not be connected.', 'it-l10n-ithemes-sync' );

			$code = $result->get_error_code();

			if ( 'http_request_failed' == $code ) {
				$message = sprintf( __( '<p>The Solid Central server was unable to be contacted. WordPress returned the following error when trying to contact the server:</p><p>%1$s</p><p>If you continue to experience problems, please contact <a target="_blank" href="%2$s">SolidWP support</a>.</p>', 'it-l10n-ithemes-sync' ), $result->get_error_message(), 'http://ithemes.com/support/' );
			} elseif ( 'ithemes-sync-server-failed-request' == $code ) {
				$message = sprintf( __( '<p>The Solid Central server was unable to process the request at this time. Please try again in a few minutes.</p><p>If you continue to experience problems, please contact <a target="_blank" href="%s">SolidWP support</a>.</p>', 'it-l10n-ithemes-sync' ), 'http://ithemes.com/support/' );
			} else {
				$message = $result->get_error_message();
			}

			$this->add_error_message( $heading, $message );

			return;
		}

		if ( empty( $result['key'] ) ) {
			$heading = __( 'The user could not be connected.', 'it-l10n-ithemes-sync' );
			$message = __( 'The connection request failed due to a server communication error. The server sent a response that did not include a authentication key.', 'it-l10n-ithemes-sync' );

			$this->add_error_message( $heading, $message );

			return;
		}

		if ( empty( $result['user_id'] ) ) {
			$heading = __( 'The user could not be connected.', 'it-l10n-ithemes-sync' );
			$message = __( 'The connection request failed due to a server communication error. The server sent a response that did not include a user ID.', 'it-l10n-ithemes-sync' );

			$this->add_error_message( $heading, $message );

			return;
		}


		$add_result = $GLOBALS['ithemes-sync-settings']->add_authentication( $result['user_id'], $data['username'], $result['key'] );

		if ( is_wp_error( $add_result ) ) {
			$heading = __( 'The user could not be connected.', 'it-l10n-ithemes-sync' );
			$message = $add_result->get_error_message();

			$this->add_error_message( $heading, $message );

			return;
		}


		$heading  = __( 'Woohoo! Your site has been connected.', 'it-l10n-ithemes-sync' );
		$messages = array();

		if ( 0 == $result['quota']['available'] ) {
			$messages[] = sprintf( __( 'Your user has now used all of the sites available to be added to Solid Central. More information can be found on the <a href="%s" target="_blank">SolidWP membership panel</a>.', 'it-l10n-ithemes-sync' ), $this->sync_dashboard_url );
		} else {
			$messages[] = sprintf( _n( 'Your site is now connected. Your user can connect to %d additional site.', 'Your site is now connected. Your user can connect to %d additional sites.', $result['quota']['available'], 'it-l10n-ithemes-sync' ), $result['quota']['available'] );
		}

		$this->add_success_message( $heading, $messages );
	}

	private function deauthenticate( $data ) {
		require_once( $GLOBALS['ithemes_sync_path'] . '/server.php' );


		$options      = $GLOBALS['ithemes-sync-settings']->get_options();
		$user_details = $GLOBALS['ithemes-sync-settings']->get_authentication_details( $data['user'] );


		$result = Ithemes_Sync_Server::deauthenticate( $data['user'], $user_details['username'], $user_details['key'] );

		if ( is_wp_error( $result ) && ( 'authentication' != $result->get_error_code() ) && 'This site has not been authenticated by this user.' != $result->get_error_message() ) {
			$heading = $result->get_error_message();
			$message = __( 'The user could not be disconnected.', 'it-l10n-ithemes-sync' );

			$this->add_error_message( $heading, $message );

			return;
		}


		$result = $GLOBALS['ithemes-sync-settings']->remove_authentication( $data['user'], $user_details['username'] );

		if ( is_wp_error( $result ) ) {
			$heading = $result->get_error_message();
			$message = __( 'The user could not be disconnected.', 'it-l10n-ithemes-sync' );

			$this->add_error_message( $heading, $message );

			return;
		}


		$heading = '';
		$message = __( 'The user was successfully disconnected.', 'it-l10n-ithemes-sync' );

		$this->add_success_message( $heading, $message );
	}

	private function show_messages() {
		foreach ( $this->messages as $class => $messages ) {
			foreach ( $messages as $message ) {
				if ( $message['messages'] === '' ) {
					$this->show_message( $message['heading'], $message['heading'], $class );
				} else {
					$this->show_message( $message['heading'], $message['messages'], $class );
				}
			}
		}
	}

	private function show_message( $heading, $messages, $class ) {

		?>
		<div class="message <?php echo $class; ?>">
			<?php foreach ( (array) $messages as $message ) : ?>
				<p><?php echo $message; ?></p>
			<?php endforeach; ?>
		</div>
		<?php

	}

	private function add_message( $heading, $messages, $class ) {
		$this->messages[ $class ][] = compact( 'heading', 'messages' );
	}

	private function add_success_message( $heading, $messages = array() ) {
		$this->add_message( $heading, $messages, 'success' );
	}

	private function add_error_message( $heading, $messages = array() ) {
		$this->add_message( $heading, $messages, 'error' );
		$this->had_error = true;
	}

	private function save_settings() {
		check_admin_referer( 'save_settings', 'ithemes_sync_nonce' );


		$settings_defaults = array();


		$settings = array();

		foreach ( $settings_defaults as $var => $val ) {
			if ( isset( $_POST[ $var ] ) ) {
				$settings[ $var ] = $_POST[ $var ];
			} else {
				$settings[ $var ] = $val;
			}
		}


		$GLOBALS['ithemes-sync-settings']->update_options( $settings );

		$this->messages[] = __( 'Settings saved', 'it-l10n-ithemes-sync' );
	}

	public function show_settings() {
		$post_data = Ithemes_Sync_Functions::get_post_data( array( 'username', 'password' ), true );

		if ( ! is_multisite() ) {
			$validations = $GLOBALS['ithemes-sync-settings']->validate_authentications();
		}

		$valid_users   = array();
		$invalid_users = array();

		uksort( $this->options['authentications'], array( $this, 'sort_usernames' ) );

		foreach ( array_keys( $this->options['authentications'] ) as $user_id ) {
			if ( ! isset( $validations ) || $validations[ $user_id ] ) {
				$valid_users[] = $user_id;
			} else {
				$invalid_users[] = $user_id;
			}
		}


		?>
		<div class="ithemes-sync-wrapper wrap">
			<?php if ( empty( $this->options['authentications'] ) ) : ?>
				<h2><?php _e( 'Connect This Site', 'it-l10n-ithemes-sync' ); ?></h2>
			<?php else : ?>
				<h2><?php _e( 'Solid Central', 'it-l10n-ithemes-sync' ); ?></h2>
			<?php endif; ?>

			<?php $this->show_messages(); ?>

			<?php if ( ! empty( $this->options['authentications'] ) ) : ?>
				<a class="ithemes-sync-button" href="<?php echo $this->sync_dashboard_url; ?>" target="_blank"><?php _e( 'Go Manage Your Connected Sites', 'it-l10n-ithemes-sync' ); ?></a>

				<div class="ithemes-sync-section ithemes-sync-manage-users">
					<h3><?php _e( 'Manage Connected Users', 'it-l10n-ithemes-sync' ); ?></h3>

					<div class="ithemes-sync-section-inner">
						<p><?php _e( 'Central allows you to connect your site with multiple users.<br>View the list of connected users below, disconnect users if needed, or add additional users below.', 'it-l10n-ithemes-sync' ); ?></p>

						<?php if ( ! empty( $valid_users ) ) : ?>
							<div class="ithemes-sync-users ithemes-sync-valid-users">
								<h4><?php _e( 'Connected Users', 'it-l10n-ithemes-sync' ); ?></h4>

								<ul>
									<?php foreach ( $valid_users as $user_id ) : ?>
										<li>
											<div class="user"><?php echo esc_attr( $this->options['authentications'][ $user_id ]['username'] ); ?></div>
											<?php $query_args = [
												'action' => 'deauthenticate',
												'user'  => $user_id,
											]; ?>
											<div class="deauthenticate"><a href="<?php echo add_query_arg( $query_args, $this->self_url ); ?>">Disconnect</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $invalid_users ) ) : ?>
							<div class="ithemes-sync-users ithemes-sync-invalid-users">
								<h4><?php _e( 'Invalid Users', 'it-l10n-ithemes-sync' ); ?></h4>

								<p><?php _e( 'The following users were not recognized by the server. Disconnect them and reconnect them again to fix this error.', 'it-l10n-ithemes-sync' ); ?></p>

								<ul>
									<?php foreach ( $invalid_users

									as $user_id ) : ?>
									<li>
										<div class="user"><?php echo esc_attr($this->options['authentications'][ $user_id ]['username'] ); ?></div>
										<?php $query_args = [
											'action' => 'deauthenticate',
											'user' => $user_id
										]; ?>
										<div class="deauthenticate"><a href="<?php echo add_query_arg( $query_args, $this->self_url ); ?>">Disconnect</a>
									</li>
								<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>


			<div class="ithemes-sync-section ithemes-sync-authorize">
				<h3><?php _e( 'Add Users', 'it-l10n-ithemes-sync' ); ?></h3>

				<div class="ithemes-sync-section-inner">
					<?php if ( empty( $this->options['authentications'] ) ) : ?>
						<p><?php _e( 'Enter your SolidWP username & password to connect this site.', 'it-l10n-ithemes-sync' ); ?></p>
					<?php else : ?>
						<p><?php _e( 'Add additional users if more than one person will be managing updates for this site.<br>To connect an additional user, enter their SolidWP username and password below.', 'it-l10n-ithemes-sync' ); ?></p>
					<?php endif; ?>

					<form id="ithemes-sync-authenticate" enctype="multipart/form-data" method="post" action="<?php echo $this->self_url; ?>">
						<label for="username"><?php _e( 'Username', 'it-l10n-ithemes-sync' ); ?></label><br>
						<input type="text" id="username" name="username" value="<?php if ( $this->had_error ) {
							echo esc_attr( $post_data['username'] );
						} ?>">

						<label for="password"><?php _e( 'Password', 'it-l10n-ithemes-sync' ); ?></label><br>
						<input type="password" id="password" name="password" value="<?php if ( $this->had_error ) {
							echo esc_attr( $post_data['password'] );
						} ?>">

						<input type="submit" id="submit" value="<?php _e( 'Connect', 'it-l10n-ithemes-sync' ); ?>">
						<input type="hidden" name="action" value="authenticate">

						<?php wp_nonce_field( 'authenticate-user' ); ?>
					</form>
				</div>
			</div>
			<?php do_action( 'sync_dev_render' ); ?>
		</div>
		<?php

	}

	private function sort_usernames( $a, $b ) {
		return strcasecmp( $this->options['authentications'][ $a ]['username'], $this->options['authentications'][ $b ]['username'] );
	}
}

new Ithemes_Sync_Settings_Page();
