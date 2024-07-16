<?php
// * This file is in /inc because of how the build process
// * works. I'd love to have the file with the Block files.

/**
 * AJAX callback for Save This Block and Tool
 * 
 * @return boolean
 */
function dpsp_ajax_send_save_this_email() {
	$dpsp_token = filter_input( INPUT_POST, '_ajax_nonce' );
	if ( empty( $dpsp_token ) || ! wp_verify_nonce( $dpsp_token, 'dpsp_token' ) ) {
		echo 0;
		wp_die();
	}

	$post = stripslashes_deep( $_POST );

	if ( empty( $post['email'] ) ) {
		echo 0;
		wp_die();
	}

	if ( ! empty( $post['snare'] ) ) { // Likely a bot
		echo 0;
		wp_die();
	}

	$settings = \Mediavine\Grow\Settings::get_setting( 'dpsp_email_save_this', [] );

	$email      	= $post['email'];
	$postID			= $post['postID'];
    $postURL    	= ( ! empty( $post['postURL'] ) ) ? $post['postURL'] : 'No link available';
    $postTitle  	= ( ! empty( $post['postTitle'] ) ) ? $post['postTitle'] : 'Untitled post';
	$siteTitle 		= get_bloginfo( 'name' );
	$siteURL 		= get_bloginfo( 'url' );
	$emailmessage	= ( ! empty( $settings['email']['emailmessage'] ) ) ? $settings['email']['emailmessage'] : '';
	$emailFromName  = ( ! empty( $settings['email']['fromname'] ) ) ? $settings['email']['fromname'] : 'Hubbub';
	$emailFromEmail = ( ! empty( $settings['email']['fromemail'] ) ) ? $settings['email']['fromemail'] : 'no-reply@morehubbub.com';
	$message_html  	= '<a href="' . esc_url($postURL) . '" target="_blank">' . esc_html($postTitle) . '</a>';
	$message_text  	= 'Here is the post you saved: ' . $postURL;

	$headers = [
		'From: ' . $emailFromName . ' <' . $emailFromEmail . '>',
		'Reply-To: ' . $emailFromName . ' <' . $emailFromEmail . '>',
	];

	$image_details = wp_get_attachment_image_src( $settings['email']['logo'], 'full' );

	$html_template = file_get_contents( __DIR__ . '/tools/email-save-this/email-template.html' );
	$html_template = str_replace( '{{MAINHEADER}}', 'You Saved This:', $html_template );
	$html_template = str_replace( '{{VERIFYBUTTON}}', '', $html_template );
	$html_template = str_replace( '{{FULLURL}}', esc_url($postURL), $html_template );
	$html_template = str_replace( '{{BODY}}', $message_html, $html_template );
	$html_template = str_replace( '{{EMAILMESSAGE}}', wp_kses_post( wpautop( $emailmessage ) ), $html_template );
	$html_template = str_replace( '{{URL}}', esc_url($postURL), $html_template );
	$html_template = str_replace( '{{SITETITLE}}', ( is_array( $image_details ) ) ? '' : '<a href="' . esc_url($siteURL) . '">' . esc_html($siteTitle) . '</a>', $html_template );
	$html_template = str_replace( '{{SITELOGO}}', ( is_array( $image_details ) ) ? '<a href="' . esc_url($siteURL) . '"><img src="' . esc_attr( $image_details[0] ) . '" alt="' . esc_attr($siteTitle) . '" width="200" /></a>' : '', $html_template );
	//DITCHED $html_template = str_replace( '{{EMAIL_PREVIEW_TEXT}}', 'You saved a link!', $html_template );
	$html_template = str_replace( '{{SITEURL}}', esc_url($siteURL), $html_template );
	$html_template = str_replace( '{{footerTITLE}}', esc_html($siteTitle), $html_template );

	add_filter( 'wp_mail_content_type', 'dpsp_set_html_mail_content_type' ); // Allows HTML email for wp_mail
	
	$sent = wp_mail( 
		sanitize_email( $email ),
		'You Saved This: ' . esc_html($postTitle),
		$html_template,
		$headers
	);

	remove_filter( 'wp_mail_content_type', 'dpsp_set_html_mail_content_type' ); // Resets wp_mail content type default to text

	// Count Saves
	$save_count = ( ! empty( get_post_meta( $postID, 'dpsp_save_this_count', true ) ) ) ? intval( get_post_meta( $postID, 'dpsp_save_this_count', true ) )+1 : 1;
	update_post_meta( $postID, 'dpsp_save_this_count', $save_count );

	/** 
	 * Store the email in a cookie
	 * Expires in 1 year
	 */
	setcookie( "hubbub-save-this-email-address", $email, strtotime('+1 year', time()), '/', COOKIE_DOMAIN );  /* expire in 1 hour */

	/**
	 * Add email address to mailing list?
	 */
	if ( isset( $settings['connection']['service'] ) && $settings['connection']['service'] != 'none' ) {

		switch( $settings['connection']['service'] ) {
			case 'convertkit':
				$convertkit_form = $settings['connection']['convertkit-form'];

				$save_this_mailing_service = \Mediavine\Grow\Connections\ConvertKit::get_instance();
				$save_this_mailing_service->add_subscriber( 
					array(
						'email' => sanitize_email( $email ),
						'form' => $convertkit_form
					));
				break;
			case 'flodesk':
				$flodesk_segment = $settings['connection']['flodesk-segment'];

				$save_this_mailing_service = \Mediavine\Grow\Connections\Flodesk::get_instance();
				$save_this_mailing_service->add_subscriber( 
					array(
						'email' => sanitize_email( $email ),
						'segment' => $flodesk_segment
					));
				break;
			case 'mailchimp':
				$mailchimp_list = $settings['connection']['mailchimp-list'];

				$save_this_mailing_service = \Mediavine\Grow\Connections\Mailchimp::get_instance();
				$save_this_mailing_service->add_subscriber( 
					array(
						'email_address' => sanitize_email( $email ),
						'list' => $mailchimp_list,
						'status' => 'subscribed'
					));
				break;
			case 'mailerlite':
					$mailerlite_group = $settings['connection']['mailerlite-group'];

					$save_this_mailing_service = \Mediavine\Grow\Connections\MailerLite::get_instance();
					$save_this_mailing_service->add_subscriber( 
						array(
							'email' => sanitize_email( $email ),
							'groups' => array( $mailerlite_group ),
						));
					break;
			case 'none':
			default:
				// None selected, do nothing.
				break;
		}
	}

	echo ( $sent ? 1 : 0 );
	wp_die();
}


/**
 * AJAX callback for Save This Block and Tool for Email Verification
 * 
 * @return boolean
 */
function dpsp_ajax_verify_save_this_email() {
	$hubbub_save_this_verify_token = filter_input( INPUT_POST, '_ajax_nonce' );

	if ( empty( $hubbub_save_this_verify_token ) || ! wp_verify_nonce( $hubbub_save_this_verify_token, 'hubbub_save_this_verify' ) ) {
		echo 0;
		wp_die();
	}

	$post = stripslashes_deep( $_POST );

	if ( empty( $post['email'] ) ) {
		echo 0;
		wp_die();
	}

	$email      	= $post['email'];
	$siteTitle 		= get_bloginfo( 'name' );
	$siteURL 		= get_bloginfo( 'url' );

	// Determine default email address
	// If email address includes domain name, use it
	// If any other domain, use wordpress@domain.com
	$website_domain = str_replace( 'www.', '', parse_url( get_site_url(), PHP_URL_HOST ));
	$default_email_address = ( strpos( get_option('admin_email'), $website_domain ) === false ) ? 'wordpress@' . $website_domain : get_option('admin_email');

	$emailFromName  = ( ! empty( $settings['email']['fromname'] ) ) ? $settings['email']['fromname'] : esc_html($siteTitle);
	$emailFromEmail = ( ! empty( $settings['email']['fromemail'] ) ) ? $settings['email']['fromemail'] : $default_email_address;

	$headers = [
		'From: ' . $emailFromName . ' <' . $emailFromEmail . '>',
		'Reply-To: ' . $emailFromName . ' <' . $emailFromEmail . '>',
	];

	$verify_link = admin_url( 'admin.php?page=dpsp-email-save-this&verify=' . rand(1,53453439) );

	$html_template = file_get_contents( __DIR__ . '/tools/email-save-this/email-template.html' );
	$html_template = str_replace( '{{MAINHEADER}}', '', $html_template );
	$html_template = str_replace( '{{BODY}}', '', $html_template );
	$html_template = str_replace( '{{EMAILMESSAGE}}', '<strong>Success! 🎉<br/>Sending email works from<br/>your website.</strong><br/>Please click the button below to confirm.<br /><br/>', $html_template );
	$html_template = str_replace( '{{URL}}', $verify_link, $html_template );
	$html_template = str_replace( '{{FULLURL}}', $verify_link, $html_template );
	$html_template = str_replace( '{{SITETITLE}}', esc_html($siteTitle), $html_template );
	$html_template = str_replace( '{{VERIFYBUTTON}}', '<p><a href="' . $verify_link . '" style="padding: 10px 15px;display: inline-block;border-radius: 5px;background: #363535;color: #ffffff;"class="btn btn-primary">Confirm Success</a></p>', $html_template );
	$html_template = str_replace( '{{SITELOGO}}', '', $html_template );
	$html_template = str_replace( '{{SITEURL}}', esc_url($siteURL), $html_template );
	$html_template = str_replace( '{{footerTITLE}}', esc_html($siteTitle), $html_template );

	add_filter( 'wp_mail_content_type', 'dpsp_set_html_mail_content_type' ); // Allows HTML email for wp_mail
	
	$sent = wp_mail( 
		sanitize_email( $email ),
		'Hubbub Pro: Verify Save This Email',
		$html_template,
		$headers
	);

	remove_filter( 'wp_mail_content_type', 'dpsp_set_html_mail_content_type' ); // Resets wp_mail content type default to text
	
	echo ( $sent ? 1 : 0 );
	wp_die();
}

function dpsp_set_html_mail_content_type() {
	return 'text/html';
}