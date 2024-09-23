<?php
/*
Plugin Name:  WP Social Ninja
Plugin URI:   https://wpsocialninja.com/
Description:  Display your social feeds, reviews and chat widgets automatically and easily on your website with the all-in-one social media plugin.
Version:      3.14.1
Author:       WP Social Ninja Team - WPManageNinja LLC
Author URI:   https://wpsocialninja.com/
License:      GPLv2 or later
Text Domain:  wp-social-reviews
Domain Path:  /language
*/

defined('ABSPATH') or die;

define('WPSOCIALREVIEWS_VERSION', '3.14.1');
define('WPSOCIALREVIEWS_DB_VERSION', 120);
define('WPSOCIALREVIEWS_MAIN_FILE', __FILE__);
define('WPSOCIALREVIEWS_BASENAME', plugin_basename(__FILE__));
define('WPSOCIALREVIEWS_URL', plugin_dir_url(__FILE__));
define('WPSOCIALREVIEWS_DIR', plugin_dir_path(__FILE__));
define('WPSOCIALREVIEWS_UPLOAD_DIR_NAME', 'wp-social-ninja');

if (!defined( 'WPSOCIALREVIEWS_INSTAGRAM_MAX_RECORDS')) {
    define('WPSOCIALREVIEWS_INSTAGRAM_MAX_RECORDS', 300);
}
if (!defined( 'WPSOCIALREVIEWS_FACEBOOK_FEED_MAX_RECORDS')) {
    define('WPSOCIALREVIEWS_FACEBOOK_FEED_MAX_RECORDS', 300);
}
if (!defined( 'WPSOCIALREVIEWS_TIKTOK_MAX_RECORDS')) {
    define('WPSOCIALREVIEWS_TIKTOK_MAX_RECORDS', 300);
}

require __DIR__.'/vendor/autoload.php';

call_user_func(function($bootstrap) {
    $bootstrap(__FILE__);
}, require(__DIR__.'/boot/app.php'));

// Handle Network new Site Activation
add_action('wp_insert_site', function ($new_site) {
    if (is_plugin_active_for_network('wp-social-reviews/wp-social-reviews.php')) {
        switch_to_blog($new_site->blog_id);
        (new \WPSocialReviews\App\Hooks\Handlers\ActivationHandler())->handle(false);
        restore_current_blog();
    }
});
