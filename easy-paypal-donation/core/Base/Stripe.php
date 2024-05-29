<?php

namespace WPEasyDonation\Base;

use WPEasyDonation\API\Order;
use WPEasyDonation\Helpers\Func;
use WPEasyDonation\Helpers\Option;

class Stripe extends BaseController
{
	/**
	 * init services
	 */
	public function register()
	{
		add_action( 'init', array($this, 'checkout_redirect'));
		add_action('plugins_loaded', array($this, 'connect_completion'));
		add_action('plugins_loaded', array($this, 'disconnected'));
		add_action( 'wp_ajax_wpedon_stripe_connect_mode_change', array($this, 'connect_mode_change') );
        add_action( 'wp_ajax_wpedon_stripe_checkout_session', array($this, 'checkout_session') );
        add_action( 'wp_ajax_nopriv_wpedon_stripe_checkout_session', array($this, 'checkout_session') );
        add_action( 'plugins_loaded', array($this, 'connect_webhook_listener') );
	}

	/**
     * connection status
	 * @param null $button_id
	 * @return array|false
	 */
	public function connection_status($button_id = null)
	{
		global $wpedonStripeConnectionStatus;

		if (!isset($wpedonStripeConnectionStatus)) {
			$wpedonStripeConnectionStatus = false;

			if (empty($button_id)) {
				$options = Option::get();
				$mode = isset($options['mode_stripe']) && intval($options['mode_stripe']) === 2 ? 'live' : 'sandbox';
				$account_id = isset($options['acct_id_' . $mode]) ? $options['acct_id_' . $mode] : '';
				$token = isset($options['stripe_connect_token_' . $mode]) ? $options['stripe_connect_token_' . $mode] : '';
			} else {
				$mode = intval(get_post_meta($button_id, '_wpedon_stripe_mode', true)) === 2 ? 'live' : 'sandbox';
				$account_id = get_post_meta($button_id, '_wpedon_stripe_account_id_' . $mode, true);
				$token = get_post_meta($button_id, '_wpedon_stripe_token_' . $mode, true);
			}

			if (!empty($account_id)) {
				$url = $this->stripe_api . '?' . http_build_query(
						[
							'action' => 'checkStatus',
							'mode' => $mode,
							'account_id' => $account_id,
							'token' => $token
						]
					);

				$args = [
					'timeout' => 30,
					'headers' => [
						'Referer' => site_url($_SERVER['REQUEST_URI'])
					]
				];

				$account = wp_remote_get($url, $args);

				$account = json_decode($account['body'], true);

				if (!empty($account['payouts_enabled']) && intval($account['payouts_enabled']) === 1) {
					$wpedonStripeConnectionStatus = [
						'email' => $account['email'],
						'display_name' => $account['display_name'],
						'mode' => $mode,
						'account_id' => $account_id,
						'token' => $token
					];
				}
			}
		}
		return $wpedonStripeConnectionStatus;
	}

	/**
     * connect tab url
	 * @param null $button_id
	 * @return string
	 */
	public function connect_tab_url($button_id = null)
	{
		if (empty($button_id)) {
			$args = [
				'page' => 'wpedon_settings',
				'tab' => '4'
			];
		} else {
			$args = [
				'page' => 'wpedon_buttons',
				'action' => 'edit',
				'product' => $button_id,
                '_wpnonce' => wp_create_nonce( 'edit_' . $button_id ),
			];
		}

		return add_query_arg($args, admin_url('admin.php'));
	}

	/**
     * disconnect url
	 * @param $button_id
	 * @param $account_id
	 * @param $token
	 * @return string
	 */
	public function disconnect_url($button_id, $account_id, $token)
	{
		if (empty($button_id)) {
			$options = Option::get();
			$mode = isset($options['mode_stripe']) && intval($options['mode_stripe']) === 2 ? 'live' : 'sandbox';
		} else {
			$mode = intval(get_post_meta($button_id, '_wpedon_stripe_mode', true)) === 2 ? 'live' : 'sandbox';
		}

		return $this->stripe_api . '?' . http_build_query(
				[
					'action' => 'disconnect',
					'mode' => $mode,
					'return_url' => add_query_arg( ['wpedon-nonce' => wp_create_nonce('wpedon-stripe-disconnect')], $this->connect_tab_url($button_id) ),
					'account_id' => $account_id,
					'token' => $token,
					'button_id' => $button_id
				]
			);
	}

	/**
     * connect url
	 * @param int $button_id
	 * @param false $mode
	 * @return string
	 */
	public function connect_url($button_id = 0, $mode = false)
	{
		if ($mode === false) {
			$options = Option::get();
			$mode_default = isset($options['mode_stripe']) && intval($options['mode_stripe']) === 1 ? 'sandbox' : 'live';
			if (empty($button_id)) {
				$mode = $mode_default;
			} else {
				$mode_stripe = intval(get_post_meta($button_id, '_wpedon_stripe_mode', true));
				$mode = $mode_stripe === 1 ? 'sandbox' : ($mode_stripe === 2 ? 'live' : $mode_default);
			}
		}

		return $this->stripe_api . '?' . http_build_query(
				[
					'action' => 'connect',
					'mode' => $mode,
					'return_url' => add_query_arg( ['wpedon-nonce' => wp_create_nonce('wpedon-stripe-connect')], $this->connect_tab_url($button_id) ),
					'button_id' => $button_id
				]
			);
	}

	/**
     * connection status html
	 * @param int $button_id
	 * @return string
	 */
	public function connection_status_html($button_id = 0)
	{
		$button_id = intval($button_id);
		$connected = $this->connection_status($button_id);

		if ($connected) {
			$reconnect_mode = $connected['mode'] === 'sandbox' ? 'live' : 'sandbox';
			$result = sprintf(
				'<div class="notice inline notice-success wpedon-stripe-connect">
				<p><strong>%s</strong><br>%sAdministrator (Owner)</p>
			</div>
			<div>
				Your Stripe account is connected in <strong>%s</strong> mode. <a href="%s">Connect in <strong>%s</strong> mode</a>, or <a href="%s">disconnect this account</a>.
			</div>',
				$connected['display_name'],
				!empty( $connected['email'] ) ? "{$connected['email']} - " : '',
				$connected['mode'],
				$this->connect_url($button_id, $reconnect_mode),
				$reconnect_mode,
				$this->disconnect_url($button_id, $connected['account_id'], $connected['token'])
			);
		} else {
			$result = sprintf(
				'<a href="%s"" class="stripe-connect-btn">
									<span>Connect with Stripe</span>
								</a>
								<br />
								<br />
								Setup Stripe Connect. WPPlugin LLC is an official Stripe Partner. Pay as you go pricing: 1%% per-transaction fee + Stripe fees. 
								',
				$this->connect_url($button_id)
			);
		}

		return $result;
	}

	/**
	 * Open Stripe checkout in new tab
	 */
	public function checkout_redirect() {
		if ( !empty( $_GET['wpedon-stripe-checkout-redirect'] ) &&
			!empty( $_GET['sk'] ) &&
			!empty( $_GET['ai'] ) &&
			!empty( $_GET['si'] ) &&
			!empty( $_GET['rf'] )
		) {
			?>
			<script src="https://js.stripe.com/v3/"></script>
			<script>
        try {
          const stripe = Stripe('<?php echo sanitize_text_field($_GET['sk']); ?>', {
            stripeAccount: '<?php echo sanitize_text_field($_GET['ai']); ?>'
          });
          stripe.redirectToCheckout({
            sessionId: '<?php echo sanitize_text_field($_GET['si']); ?>'
          });
        } catch (error) {
          let rf = '<?php echo sanitize_text_field($_GET['rf']); ?>';
          rf += rf.indexOf('?') !== -1 ? '&' : '?';
          rf += 'wpedon_stripe_success=0';
          window.location.href = rf;
        }
			</script>
			<?php
			die();
		}
	}

	/**
	 * Connect completion
	 */
	function connect_completion()
	{
		if (empty($_GET['wpedon_stripe_connect_completion']) ||
			intval($_GET['wpedon_stripe_connect_completion']) !== 1 ||
			empty($_GET['mode']) ||
			empty($_GET['account_id']) ||
			empty($_GET['token']) ||
			!isset($_GET['button_id']) ||
			!current_user_can('manage_options')) {
			return;
		}

		// nonce check
		if (!isset($_GET['wpedon-nonce']) || !wp_verify_nonce($_GET['wpedon-nonce'], 'wpedon-stripe-connect')) {
			wp_die('Security check failed');
		}

		$account_id = sanitize_text_field($_GET['account_id']);
		$token = sanitize_text_field($_GET['token']);
		$mode = $_GET['mode'] === 'live' ? 'live' : 'sandbox';
		$mode_stripe = $mode === 'live' ? 2 : 1;
		$button_id = intval($_GET['button_id']);

		if (empty($button_id)) {
			$options = Option::get();
			$options['acct_id_' . $mode] = $account_id;
			$options['stripe_connect_token_' . $mode] = $token;
			$options['mode_stripe'] = $mode_stripe;
			if (isset($options['stripe_connect_notice_dismissed'])) {
				unset($options['stripe_connect_notice_dismissed']);
			}
			Option::update($options);
		} else {
			update_post_meta($button_id, '_wpedon_stripe_account_id_' . $mode, $account_id);
			update_post_meta($button_id, '_wpedon_stripe_token_' . $mode, $token);
		}

		$return_url = $this->connect_tab_url($button_id);

		/**
		 * Filters the URL users are returned to after Stripe connect completed
		 *
		 * @param $return_url URL to return to.
		 *
		 */
		$return_url = apply_filters('wpedon_stripe_connect_return_url', $return_url);

		wp_redirect($return_url);
	}

	/**
	 * Disconnected
	 */
	function disconnected()
	{
		if (empty($_GET['wpedon_stripe_disconnected']) ||
			intval($_GET['wpedon_stripe_disconnected']) !== 1 ||
			empty($_GET['mode']) ||
			empty($_GET['account_id']) ||
			!isset($_GET['button_id']) ||
			!current_user_can('manage_options')) {
			return;
		}

		// nonce check
		if (!isset($_GET['wpedon-nonce']) || !wp_verify_nonce($_GET['wpedon-nonce'], 'wpedon-stripe-disconnect')) {
			wp_die('Security check failed');
		}

		$mode = $_GET['mode'] === 'live' ? 'live' : 'sandbox';
		$mode_stripe = $mode === 'live' ? 2 : 1;
		$button_id = intval($_GET['button_id']);
		if (empty($button_id)) {
			$options = Option::get();
			if ($options['acct_id_' . $mode] === $_GET['account_id']) {
				$options['mode_stripe'] = $mode_stripe;
				$options['acct_id_' . $mode] = '';
				$options['stripe_connect_token_' . $mode] = '';
				Option::update($options);
			}
		} else {
			update_post_meta($button_id, '_wpedon_stripe_mode', $mode_stripe);
			update_post_meta($button_id, '_wpedon_stripe_account_id_' . $mode, '');
			update_post_meta($button_id, '_wpedon_stripe_token_' . $mode, '');
		}

		$return_url = $this->connect_tab_url($button_id);

		/**
		 * Filters the URL users are returned to after Stripe disconnect completed
		 *
		 *
		 * @param $return_url URL to return to.
		 */
		$return_url = apply_filters('wpedon_stripe_disconnect_return_url', $return_url);

		wp_redirect($return_url);
	}








/**
 * Retrieves connection data for a given button ID.
 * Values are fetched from post meta, and fallback to global options if not available.
 * @param int $button_id
 * @return array|null False if critical data is missing, otherwise returns connection data array.
 */
function connection_data($button_id) {
    // Initialize options for fallback
    $options = Option::get();

    // Fetch the mode, checking post meta first
    $modeValue = get_post_meta($button_id, '_wpedon_stripe_mode', true);
    if ($modeValue === '') { // Check if the post meta is empty, meaning not set
        $modeValue = $options['mode_stripe'] ?? '1'; // Default to '1' if not set in options either
    }
    $mode = $modeValue === '2' ? 'live' : 'sandbox';

    // Fetch account ID
    $account_id = get_post_meta($button_id, "_wpedon_stripe_account_id_{$mode}", true);
    if (empty($account_id)) {
        $account_id = $options["acct_id_{$mode}"] ?? '';
    }

    // Fetch token
    $token = get_post_meta($button_id, "_wpedon_stripe_token_{$mode}", true);
    if (empty($token)) {
        $token = $options["stripe_connect_token_{$mode}"] ?? '';
    }

    // Fetch show setting
    $show = get_post_meta($button_id, 'wpedon_button_disable_stripe', true);
    if ($show === '') {
        $show = $options['disable_stripe'] ?? '0'; // Default to '0' if not set in options
    }

    // Fetch width
    $width = get_post_meta($button_id, 'wpedon_button_stripe_width', true);
    if ($width === '') {
        $width = $options['stripe_width'] ?? '';
    }

    // Determine if Stripe should be disabled based on the 'show' value
    if ($show == '2') {
        return null;
    }

    // Check if essential data is available
    if (empty($account_id) || empty($token)) {
        return false;
    }
	
	// Fetch the success URL from post meta or use a default
	$return_url = get_post_meta($button_id, 'wpedon_button_return', true);

    // Return the connection data
    return [
        'mode' => $mode,
        'account_id' => $account_id,
        'token' => $token,
        'show' => $show,
        'width' => $width,
		'return_url' => $return_url
    ];
}



















	/**
	 * connect mode change
	 */
	function connect_mode_change()
	{
		if (!wp_verify_nonce($_POST['nonce'], 'wpedon-request') || !current_user_can('manage_options')) {
			wp_send_json_error();
		}

		$val = intval($_POST['val']);
		$options = Option::get();
		$button_id = isset($_POST['button_id']) ? intval($_POST['button_id']) : 0;
		if (empty($button_id)) {
			$options['mode_stripe'] = in_array($val, [1, 2]) ? $val : 2;
			Option::update($options);
		} else {
			$mode_stripe = in_array($val, [1, 2]) ? $val : 0;
			update_post_meta($button_id, '_wpedon_stripe_mode', $mode_stripe);
		}

		wp_send_json_success([
			'statusHtml' => $this->connection_status_html($button_id)
		]);
	}

	/**
	 * checkout session
	 */
	function checkout_session()
	{
		if (!wp_verify_nonce($_POST['nonce'], 'wpedon-frontend-request')) {
			wp_send_json_error([
				'message' => 'Security error. The payment has not been made. Please reload the page and try again.'
			]);
		}

		parse_str($_POST['data'], $post_data);
		$data = $this->get_checkout_data($post_data);
		

		$stripe_connection_data = $this->connection_data($data['button_id']);
		if (empty($stripe_connection_data)) {
			wp_send_json_error([
				'message' => 'Stripe connection error. Please contact the site administrator.'
			]);
		}

		$description = [];
		$metadata = [];
		if (!empty($sku)) {
			$description[] = 'Sku: ' . $data['sku'];
			$metadata['sku'] = $data['sku'];
		}

		foreach ($data['metadata'] as $item) {
			$description[] = $item['key'] . ': ' . $item['value'];
			$metadata[sanitize_key($item['key'])] = $item['value'];
		}

		$line_items = [
			[
				'price_data' => [
					'currency' => strtolower($data['currency']),
					'unit_amount' => Func::format_stripe_amount($data['item_price'], $data['currency']),
					'product_data' => [
						'name' => $data['name'],
						'description' => implode(', ', $description),
						'metadata' => $metadata
					],
				],
				'quantity' => $data['quantity'],
				'tax_data' => [
					'tax_rate' => $data['tax_rate'],
					'tax' => $data['tax']
				]
			]
		];
		
		
		
		$shipping_options = null;
		if (!empty($data['shipping'])) {
			$shipping_options = [
				[
					'shipping_rate_data' => [
						'display_name' => 'Fixed amount',
						'type' => 'fixed_amount',
						'fixed_amount' => [
							'amount' => Func::format_stripe_amount($data['shipping'], $data['currency']),
							'currency' => strtolower($data['currency'])
						]
					]
				]
			];
		}

		$order = new Order();
		$order_id = $order->create(array_merge($data, ['payment_status' => 'pending', 'payment_method' => 'stripe', 'mode' => $stripe_connection_data['mode']]));
		$current_user_id = get_current_user_id();
		$current_url = sanitize_url($_POST['location']);
		$options = Option::get();
		$success_url = !empty($stripe_connection_data['return_url']) ? $stripe_connection_data['return_url'] : (!empty($options['return']) ? $options['return'] : add_query_arg(['wpedon_stripe_button' => $data['button_id'], 'wpedon_stripe_success' => 1], $current_url));
		$cancel_url = !empty($options['cancel']) ?
			$options['cancel'] :
			add_query_arg(
				[
					'wpedon_stripe_button' => $data['button_id'],
					'wpedon_stripe_success' => 0,
					'payment_cancelled' => 1
				],
				$current_url
			);

		$stripe_connect_url = $this->stripe_api . '?' . http_build_query([
				'action' => 'checkoutSession',
				'mode' => $stripe_connection_data['mode'],
				'billing_address_collection' => $data['no_shipping'] === 2 ? 'required' : 'auto',
				'line_items' => $line_items,
				'shipping_options' => $shipping_options,
				'success_url' => $success_url,
				'cancel_url' => $cancel_url,
				'notice_url' => $this->connect_webhook_url(),
				'client_reference_id' => $order_id . '|' . $data['button_id'] . '|' . $current_user_id,
				'account_id' => $stripe_connection_data['account_id'],
				'token' => $stripe_connection_data['token'],
				'button_id' => $data['button_id']
			]);


		$response = wp_remote_get($stripe_connect_url, [
			'timeout' => 30,
			'headers' => [
				'Referer' => site_url($_SERVER['REQUEST_URI'])
			]
		]);

		$body = wp_remote_retrieve_body($response);
		$checkout_session = json_decode($body);

		if (empty($checkout_session->session_id) || empty($checkout_session->stripe_key)) {
			wp_send_json_error([
				'message' => !empty($checkout_session->message) ? $checkout_session->message : 'An unexpected error occurred. Please try again.'
			]);
		}

        $order->update($order_id, [
			'session_id' => $checkout_session->session_id,
			'payment_amount' => $checkout_session->amount_total / 100,
			'txn_id' => $checkout_session->payment_intent
		]);

		wp_send_json_success([
			'sessionId' => $checkout_session->session_id,
			'stripeKey' => $checkout_session->stripe_key,
			'accountId' => $stripe_connection_data['account_id']
		]);
	}

	/**
	 * Stripe Connect webhook url
	 * @param string $return
	 * @return string|string[]
	 */
	function connect_webhook_url($return = 'str')
	{
		$arg = 'wpedon_notice';
		$val = 'stripewebhook';

		if ($return == 'str') {
			$result = add_query_arg($arg, $val, get_site_url());
		} else {
			$result = [
				'arg' => $arg,
				'val' => $val
			];
		}

		return $result;
	}

	/**
	 * Register Stripe Connect webhook listener.
	 */
	function connect_webhook_listener()
	{
		$webhook_url = $this->connect_webhook_url('arr');
		if (!isset($_REQUEST[$webhook_url['arg']]) || $_REQUEST[$webhook_url['arg']] != $webhook_url['val']) {
			return;
		}

		// check required arguments
		if (empty($_REQUEST['order_id']) ||
			empty($_REQUEST['status']) ||
			empty($_REQUEST['session_id']) ||
			!isset($_REQUEST['transaction_id']) ||
			empty($_REQUEST['mode']) ||
			empty($_REQUEST['token']) ||
			!isset($_REQUEST['button_id']) ||
			!isset($_REQUEST['customer_email'])) {
			wp_send_json([
				'result' => 'failed',
				'message' => 'One or more required parameters are not set'
			]);
		}

		$button_id = intval($_REQUEST['button_id']);
		$stripe_connection_data = $this->connection_data($button_id);

		$order_id = intval(explode('|', sanitize_text_field($_REQUEST['order_id']))[0]);
		$session_id = get_post_meta($order_id, 'wpedon_button_session_id', true);
		$txn_id = get_post_meta($order_id, 'wpedon_button_txn_id', true);
		$mode = get_post_meta($order_id, 'wpedon_button_mode', true);

		// check token
		if ($_REQUEST['token'] !== $stripe_connection_data['token'] ||
			$session_id != $_REQUEST['session_id'] ||
			$txn_id != $_REQUEST['transaction_id'] ||
			$mode != $_REQUEST['mode']) {
			wp_send_json([
				'result' => 'failed',
				'message' => 'The token is invalid'
			]);
		};

		$order_id = intval(explode('|', sanitize_text_field($_REQUEST['order_id']))[0]);

		$payer_email = sanitize_email($_REQUEST['customer_email']);

		$order = new Order();
		$order->update($order_id, [
			'payer_email' => $payer_email,
			'payment_status' => sanitize_text_field($_REQUEST['status']),
            'payment_currency' => sanitize_text_field($_REQUEST['currency']),
		]);

		$item_name = get_the_title($order_id);
		$item_number = get_post_meta($order_id, 'wpedon_button_item_number', true);
		$purchased_quantity = get_post_meta($order_id, 'wpedon_button_quantity', true);
		$payment_amount = get_post_meta($order_id, 'wpedon_button_payment_amount', true) . get_post_meta($order_id, 'wpedon_button_payment_currency', true);
		$txn_id = get_post_meta($order_id, 'wpedon_button_txn_id', true);
		$post_id = $order_id;

		// send emails
		$send_admin_email = "1";
		$send_customer_email = "1";
		include_once('admin_emails.php');

		wp_send_json([
			'result' => 'success'
		]);
	}
}