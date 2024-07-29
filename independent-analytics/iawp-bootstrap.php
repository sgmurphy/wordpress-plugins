<?php

namespace IAWPSCOPED;

use IAWP\Custom_WordPress_Columns\Views_Column;
use IAWP\Dashboard_Options;
use IAWP\Data_Pruning\Pruning_Scheduler;
use IAWP\Database;
use IAWP\Date_Range\Exact_Date_Range;
use IAWP\Env;
use IAWP\Geo_Database_Background_Job;
use IAWP\Independent_Analytics;
use IAWP\Interrupt;
use IAWP\Migrations;
use IAWP\Patch;
use IAWP\Public_API\Analytics;
use IAWP\Public_API\Singular_Analytics;
use IAWP\Utils\BladeOne;
use IAWP\WP_Option_Cache_Bust;
use IAWPSCOPED\Illuminate\Support\Carbon;
\define( 'IAWP_DIRECTORY', \rtrim( \plugin_dir_path( __FILE__ ), \DIRECTORY_SEPARATOR ) );
\define( 'IAWP_URL', \rtrim( \plugin_dir_url( __FILE__ ), '/' ) );
\define( 'IAWP_VERSION', '2.7.0' );
\define( 'IAWP_DATABASE_VERSION', '34' );
\define( 'IAWP_LANGUAGES_DIRECTORY', \dirname( \plugin_basename( __FILE__ ) ) . '/languages' );
\define( 'IAWP_PLUGIN_FILE', __DIR__ . '/iawp.php' );
if ( \file_exists( \IAWPSCOPED\iawp_path_to( 'vendor/scoper-autoload.php' ) ) ) {
    require_once \IAWPSCOPED\iawp_path_to( 'vendor/scoper-autoload.php' );
} else {
    require_once \IAWPSCOPED\iawp_path_to( 'vendor/autoload.php' );
}
// This is needed because something with age gate is preventing my own helpers from loading
// The problem is that in autoload_static.php, there's some sort of caching going on where it's trying
// to not load a file twice. I'm guessing that's normally a good thing, but in our case we've made changes (scoped)
// so we do indeed want to load our version even though age gate has alreawdy learned
require_once \IAWPSCOPED\iawp_path_to( 'vendor/illuminate/collections/helpers.php' );
/**
 * @param $log
 *
 * @return void
 * @internal
 */
function iawp_log(  $log  ) : void {
    if ( \WP_DEBUG === \true && \WP_DEBUG_LOG === \true ) {
        if ( \is_array( $log ) || \is_object( $log ) ) {
            \error_log( \print_r( $log, \true ) );
        } else {
            \error_log( $log );
        }
    }
}

/** @internal */
function iawp_path_to(  string $path  ) : string {
    $path = \trim( $path, \DIRECTORY_SEPARATOR );
    return \implode( \DIRECTORY_SEPARATOR, [\IAWP_DIRECTORY, $path] );
}

/**
 * add_filter('iawp_temp_directory_path', function ($value) {
 *     return '/Users/andrew/site/wp-content/uploads/iawp';
 * });
 *
 * @param string $path
 *
 * @return string
 * @throws Exception
 * @internal
 */
function iawp_temp_path_to(  string $path  ) : string {
    $temp_directory = ( \defined( 'IAWP_TEMP_DIR' ) ? \IAWP_TEMP_DIR : \apply_filters( 'iawp_temp_directory_path', 'temp' ) );
    $path = \rtrim( $path, \DIRECTORY_SEPARATOR );
    if ( $temp_directory === 'temp' ) {
        return \IAWPSCOPED\iawp_path_to( \implode( \DIRECTORY_SEPARATOR, [$temp_directory, $path] ) );
    }
    $temp_directory = \rtrim( $temp_directory, \DIRECTORY_SEPARATOR );
    if ( !\is_writable( $temp_directory ) ) {
        \wp_mkdir_p( $temp_directory );
    }
    // Separate condition to see if wp_mkdir_p call fixed the issue
    if ( !\is_writable( $temp_directory ) ) {
        throw new \Exception('You have provided and missing or non-writable directory for the iawp_temp_directory_path filter: ' . $temp_directory);
    }
    return \implode( \DIRECTORY_SEPARATOR, [$temp_directory, $path] );
}

/** @internal */
function iawp_url_to(  string $path  ) : string {
    $path = \trim( $path, '/' );
    return \implode( '/', [\IAWP_URL, $path] );
}

/**
 * @param string $path
 * @param bool $prefer_parent_site_upload_path If it's a multisite installation, use the parent sites upload folder
 * @return string
 * @internal
 */
function iawp_upload_path_to(  string $path, bool $prefer_parent_site_upload_path = \false  ) : string {
    $path = \trim( $path, \DIRECTORY_SEPARATOR );
    $upload_directory = \wp_upload_dir()['basedir'];
    if ( $prefer_parent_site_upload_path && \is_multisite() ) {
        $site = \get_site();
        if ( $site !== null ) {
            \switch_to_blog( \intval( $site->site_id ) );
            $upload_directory = \wp_upload_dir()['basedir'];
            \restore_current_blog();
        }
    }
    return \implode( \DIRECTORY_SEPARATOR, [$upload_directory, $path] );
}

/**
 * Determines if the user is running a licensed pro version
 *
 * @return bool
 * @internal
 */
function iawp_is_pro() : bool {
    return \false;
}

/**
 * Determines if the user is running a free version or an unlicensed pro version
 * @return bool
 * @internal
 */
function iawp_is_free() : bool {
    return !\IAWPSCOPED\iawp_is_pro();
}

/** @internal */
function iawp_dashboard_url(  array $query_arguments = []  ) : string {
    $default_query_arguments = [
        'page' => 'independent-analytics',
    ];
    return \add_query_arg( \array_merge( $default_query_arguments, $query_arguments ), \admin_url( 'admin.php' ) );
}

/** @internal */
function iawp_blade() {
    if ( !\file_exists( \IAWPSCOPED\iawp_temp_path_to( 'template-cache' ) ) ) {
        \wp_mkdir_p( \IAWPSCOPED\iawp_temp_path_to( 'template-cache' ) );
    }
    $blade = BladeOne::create();
    $blade->share( 'env', new Env() );
    return $blade;
}

/** @internal */
function iawp_icon(  string $icon  ) : string {
    try {
        return \IAWPSCOPED\iawp_blade()->run( 'icons.plugins.' . $icon );
    } catch ( \Throwable $e ) {
        return '';
    }
}

/**
 * Get the currently installed database version
 *
 * @return int
 * @internal
 */
function iawp_db_version() : int {
    return \intval( \get_option( 'iawp_db_version', '0' ) );
}

/** @internal */
function iawp_intify(  $value  ) {
    if ( \is_string( $value ) && \ctype_digit( $value ) ) {
        return \intval( $value );
    }
    return $value;
}

/**
 * iawp_singular_analytics('60', new DateTime('-3 days'), new DateTime());
 *
 * @param string|int $singular_id
 * @param DateTime $from
 * @param DateTime $to
 *
 * @return Singular_Analytics|null
 * @internal
 */
function iawp_singular_analytics(  $singular_id, \DateTime $from, \DateTime $to  ) : ?Singular_Analytics {
    $date_range = new Exact_Date_Range($from, $to);
    return Singular_Analytics::for( $singular_id, $date_range );
}

/**
 * iawp_analytics(new DateTime('-3 days'), new DateTime());
 *
 * @param DateTime $from
 * @param DateTime $to
 *
 * @return Analytics
 * @internal
 */
function iawp_analytics(  \DateTime $from, \DateTime $to  ) : Analytics {
    $date_range = new Exact_Date_Range($from, $to);
    return Analytics::for( $date_range );
}

if ( !\extension_loaded( 'pdo' ) || !\extension_loaded( 'pdo_mysql' ) ) {
    $interrupt = new Interrupt('interrupt.pdo');
    $interrupt->render();
    return;
}
if ( \IAWPSCOPED\iawp_db_version() === 0 && !Database::has_correct_database_privileges() ) {
    $interrupt = new Interrupt('interrupt.missing-database-permissions');
    $interrupt->render( [
        'missing_privileges' => Database::missing_database_privileges(),
    ] );
    return;
}
global $wpdb;
if ( \strlen( $wpdb->prefix ) > 25 ) {
    $interrupt = new Interrupt('interrupt.database-prefix-too-long');
    $interrupt->render( [
        'prefix' => $wpdb->prefix,
        'length' => \strlen( $wpdb->prefix ),
    ] );
    return;
}
if ( Migrations\Migrations::is_database_ahead_of_plugin() ) {
    $interrupt = new Interrupt('interrupt.database-ahead-of-plugin');
    $interrupt->render();
    return;
}
if ( \get_option( 'iawp_missing_tables' ) === '1' ) {
    if ( \IAWPSCOPED\iawp_db_version() === 0 ) {
        \delete_option( 'iawp_missing_tables' );
    } else {
        $interrupt = new Interrupt('interrupt.missing-database-tables');
        $interrupt->render();
        return;
    }
}
// These can be updated in background jobs. Always get the actual value from the database.
WP_Option_Cache_Bust::register( 'iawp_is_migrating' );
WP_Option_Cache_Bust::register( 'iawp_is_database_downloading' );
WP_Option_Cache_Bust::register( 'iawp_db_version' );
WP_Option_Cache_Bust::register( 'iawp_geo_database_version' );
/** @internal */
function iawp() {
    return Independent_Analytics::getInstance();
}

\IAWPSCOPED\iawp();
\register_activation_hook( \IAWP_PLUGIN_FILE, function () {
    \wp_mkdir_p( \IAWPSCOPED\iawp_temp_path_to( 'template-cache' ) );
    if ( \IAWPSCOPED\iawp_db_version() === 0 ) {
        // If there is no database installed, run migration on current process
        Migrations\Migrations::create_or_migrate();
    } else {
        // If there is a database, run migration in a background process
        Migrations\Migration_Job::maybe_dispatch();
    }
    Geo_Database_Background_Job::maybe_dispatch();
    \update_option( 'iawp_need_clear_cache', \true, \true );
    \IAWPSCOPED\iawp()->cron_manager->schedule_refresh_salt();
    ( new Pruning_Scheduler() )->schedule();
    if ( \IAWPSCOPED\iawp_is_pro() ) {
        \IAWPSCOPED\iawp()->email_reports->schedule();
    }
    // Set current version for changelog notifications
    \update_option( 'iawp_last_update_viewed', \IAWP_VERSION, \true );
    if ( \IAWPSCOPED\iawp_db_version() > 0 && Database::is_missing_all_tables() ) {
        \update_option( 'iawp_missing_tables', '1', \true );
    }
} );
\register_deactivation_hook( \IAWP_PLUGIN_FILE, function () {
    \IAWPSCOPED\iawp()->cron_manager->unschedule_daily_salt_refresh();
    ( new Pruning_Scheduler() )->unschedule();
    if ( \IAWPSCOPED\iawp_is_pro() ) {
        \IAWPSCOPED\iawp()->email_reports->unschedule();
    }
    \wp_delete_file( \trailingslashit( \WPMU_PLUGIN_DIR ) . 'iawp-performance-boost.php' );
    \delete_option( 'iawp_must_use_directory_not_writable' );
} );
/*
* The admin_init hook will fire when the dashboard is loaded or an admin ajax request is made
*/
\add_action( 'admin_init', function () {
    Carbon::setLocale( \get_locale() );
    Migrations\Migrations::handle_migration_18_error();
    Migrations\Migrations::handle_migration_22_error();
    Migrations\Migrations::handle_migration_29_error();
    Patch::patch_2_6_2_incorrect_email_report_schedule();
    $options = Dashboard_Options::getInstance();
    $options->maybe_redirect();
    new Migrations\Migration_Job();
    if ( \get_option( 'iawp_db_version', '0' ) === '0' ) {
        // If there is no database installed, run migration on current process
        Migrations\Migrations::create_or_migrate();
    } else {
        // If there is a database, run migration in a background process
        Migrations\Migration_Job::maybe_dispatch();
    }
    Geo_Database_Background_Job::maybe_dispatch();
} );
Views_Column::initialize();