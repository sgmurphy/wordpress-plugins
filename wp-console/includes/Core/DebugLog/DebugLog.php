<?php

namespace WPConsole\Core\DebugLog;

class DebugLog {

    /**
     * Class constructor
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct() {
        add_filter( 'wp_console_rest_controllers', [ $this, 'add_rest_controller' ] );
    }

    /**
     * Add REST controller
     *
     * @since 1.0.0
     *
     * @param array $controllers
     *
     * @return void
     */
    public function add_rest_controller( $controllers ) {
        $controllers->debug_log = new RestController();
        return $controllers;
    }
}
