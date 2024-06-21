<?php
/**
 * Map implementation
 * The map configurator class
 * @since 4.0.4
 */

defined( 'ABSPATH' ) || exit;

class PWS_Map {

    /**
     * General
     * @bool
     */
    private bool $enabled;

    public function __construct() {
        $this->enabled = PWS()->get_option( 'map.enable', false );

        // If the map is not enabled, the whole feature should be disabled
        if ( ! $this->enabled ) {
            return;
        }

        $provider = PWS()->get_option( 'map.provider', 'osm' );

        switch ( $provider ) {
            case 'neshan' :
                new PWS_Map_Neshan();
                break;
            case 'osm' :
                new PWS_Map_OSM();
                break;
            default:
                new PWS_Map_OSM();
        }
    }
}

new PWS_Map();