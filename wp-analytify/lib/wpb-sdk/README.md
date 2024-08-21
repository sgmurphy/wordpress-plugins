# WPB SDK

A SDK for plugin. Primarily used for logging infromation.

## Installation
Clone the repo by using git clone https://github.com/WPBrigade/wpb-sdk.git

## Usage
Add folder to the main directory of the Plugin. And add the following snippet at the top of the plugin main file after the doc comments for the sdk to start working. Like the plugin name is sdk-test-plugin, then have to do following:

```php
if ( ! function_exists( 'stp_wpb' ) ) {
	// Create a helper function for easy SDK access.
	function stp_wpb() {
		global $stp_wpb;

		if ( ! isset( $stp_wpb ) ) {
			// Include  SDK.
			require_once __DIR__ . '/wpb-sdk/start.php';
			$stp_wpb = wpb_dynamic_init(
				array(
					'id'             => '{id of the plugin according to the products table of the telemetry}',
					'slug'           => 'sdk-test-plugin',
					'type'           => 'plugin',
					'public_key'     => '{public key provided by telemetry}',
					'is_premium'     => false,
					'has_addons'     => false,
					'has_paid_plans' => false,
					'menu'           => array(),
				)
			);
		}

		return $stp_wpb;
	}

	// Init .
	stp_wpb();
	// Signal that SDK was initiated.
	do_action( 'stp_wpb_loaded' );
}
```
