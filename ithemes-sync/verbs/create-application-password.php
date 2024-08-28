<?php
/**
 * Implementation of the create-application-password verb.
 *
 * This verb is used to create an application password for the user.
 *
 * @package Ithemes_Sync
 */

/**
 * Class Ithemes_Sync_Verb_Create_Application_Password
 */
class Ithemes_Sync_Verb_Create_Application_Password extends Ithemes_Sync_Verb {

	// The UUIDv5 for central.solidwp.com.
	const APP_ID = 'aff8ad0a-3359-5385-9bbd-c11b5655814a';

	// The Application Name in WP.
	CONST APP_NAME = 'SolidWP';

	// The Verb name.
	public static $name = 'create-application-password';
	public static $description = 'Create an Application Password.';
	public static $status_element_name = 'application-password';
	public static $show_in_status_by_default = false;

	/**
	 * Run the verb.
	 *
	 * Create an application password for the user.
	 *
	 * @see WP_Application_Passwords::create_new_application_password()
	 *
	 * @param array $arguments The arguments for the verb.
	 *
	 * @return array|false Array with the user_login, unhashed password, and app password details. False on failure.
	 */
	public function run( $arguments = array() ) {

		if( ! is_user_logged_in() ) {
			return [
				'errors' => [
					'no-user' => __('User is not logged in.', 'it-l10n-ithemes-sync'),
				],
			];
		}

		$user = wp_get_current_user();
		
		if ( $user->ID === 0 ) {
			return [
				'errors' => [
					'no-user' => __('User is not logged in.', 'it-l10n-ithemes-sync'),
				],
			];
		}

		$existing = null;

		// Note: Not using `application_name_exists_for_user` or `get_user_application_password`,
		// we are searching for the app password by app_id.
		$passwords = WP_Application_Passwords::get_user_application_passwords( $user->ID );

		foreach ( $passwords as $password ) {
			if ( $password['app_id'] === self::APP_ID ) {
				$existing = $password;
			}
		}


		// If an app password exists, delete it.
		if ( $existing ) {
			$result = WP_Application_Passwords::delete_application_password( $user->ID, $existing['uuid'] );

			if ( is_wp_error( $result ) ) {
				return array(
					'errors' => array(
						$result->get_error_code() => $result->get_error_message(),
					)
				);
			}
		}

		// Create the app password.
		$app_password = WP_Application_Passwords::create_new_application_password(
			$user->ID,
			array(
				'name'   => self::APP_NAME . ' ' . date_i18n( 'M j, Y g:i A' ),
				'app_id' => self::APP_ID,
			)
		);

		if ( is_wp_error( $app_password ) ) {
			return array(
				'errors' => array(
					$app_password->get_error_code() => $app_password->get_error_message(),
				),
			);
		}

		if ( count( $app_password ) !== 2 ) {
			return [
				'errors' => [
					'invalid-record' => __('Invalid application password.', 'it-l10n-ithemes-sync'),
				],
			];
		}

		return array(
			'user_login' => $user->user_login,
			'password'   => $app_password[0],
			'details'    => $app_password[1],
			'rest_api'   => rest_url(),
		);
	}

}
