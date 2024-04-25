<?php
/**
 * Change Files permissions
 *
 * @file  The Files permissions file
 * @package HMWP/Permissions
 */
defined('ABSPATH') || die('Cheatin\' uh?');

class HMWP_Models_Permissions
{

    protected $paths = array();


    public function __construct() {


        $server_config_file = HMWP_Classes_ObjController::getClass('HMWP_Models_Rules')->getConfFile();
        $wp_config_file = HMWP_Classes_Tools::getConfigFile();
        $wp_upload_dir = $this->getUploadDir();

        //Set the main paths to check
        if(!HMWP_Classes_Tools::isWindows()){
            $paths =  array(
                ABSPATH => 0755,
                ABSPATH . HMWP_Classes_Tools::getOption('hmwp_wp-includes_url') => 0755,
                ABSPATH . HMWP_Classes_Tools::getOption('hmwp_admin_url') => 0755,
                ABSPATH . HMWP_Classes_Tools::getOption('hmwp_admin_url') . '/js' => 0755,
                WP_CONTENT_DIR => 0755,
                get_theme_root() => 0755,
                WP_PLUGIN_DIR => 0755,
                $wp_upload_dir => 0755,
                $wp_config_file => 0444,
                $server_config_file => 0444,
            );
        }else{
            $paths = [
                $wp_config_file => 0444,
                $server_config_file => 0444,
            ];
        }

        $this->paths = apply_filters('hmwp_permission_paths', $paths);
    }

    /**
     * Get the uploads directory
     *
     * @return string
     */
    protected function getUploadDir() {
        //get the uploads directory
        if (HMWP_Classes_Tools::isMultisites() && defined('BLOG_ID_CURRENT_SITE') ) {
            switch_to_blog( BLOG_ID_CURRENT_SITE );
            $wp_upload_dir = wp_upload_dir();
            restore_current_blog();
        } else {
            $wp_upload_dir = wp_upload_dir();
        }

        if(isset($wp_upload_dir['basedir']) && $wp_upload_dir['basedir'] <> ''){
            return $wp_upload_dir['basedir'];
        }

        return false;
    }

    /**
     * Return all invalid paths that don't match the recommended permissions
     *
     * @return array
     */
    public function getInvalidPermissions(){

        $values = array();
        $wp_filesystem = HMWP_Classes_ObjController::initFilesystem();

        foreach ( $this->paths as $path => $suggested ) {
            if($wp_filesystem->exists($path)){
                $display_path = preg_replace( '/^' . preg_quote( ABSPATH, '/' ) . '/', '', $path );
                $display_path = ltrim( $display_path, '/' );

                if ( empty( $display_path ) ) {
                    $display_path = '/';
                }

                //get chmod of the path
                $display_chmod = sprintf("0%d", $wp_filesystem->getchmod($path));

                if(sprintf( '%o', $suggested ) < sprintf( '%o', fileperms( $path ) & 0777 )){
                    $values[] = array(
                        'path' => $path,
                        'suggested' => $suggested,
                        'display_path' => $display_path,
                        'display_permission' => $display_chmod
                    );
                }
            }
        }

        return $values;

    }

}
