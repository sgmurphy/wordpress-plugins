<?php

namespace cnb\admin\button;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\domain\CnbDomain;
use cnb\utils\CnbAdminFunctions;
use cnb\notices\CnbAdminNotices;
use cnb\utils\CnbUtils;
use WP_Error;

class CnbButtonView {
    function header() {
        echo 'Buttons ';
    }

    function get_modal_link() {
        $url = admin_url( 'admin.php' );

        return
            add_query_arg(
                array(
                    'TB_inline' => 'true',
                    'inlineId'  => 'cnb-add-new-modal',
                    'height'    => '452',
                    // 433 + 19 (19 for PRO message) seems ideal -> To hide the scrollbar. 500 to include validation errors
                    'page'      => 'call-now-button',
                    'action'    => 'new',
                    'type'      => 'single',
                    'id'        => 'new'
                ),
                $url );
    }

    public function cnb_create_new_button() {
        $url = $this->get_modal_link();
        printf(
            '<a href="%s" title="%s" class="thickbox open-plugin-details-modal cnb-button-overview-modal-add-new %s" data-title="%s">%s</a>',
            esc_url( $url ),
            esc_html__( 'Create new button' ),
            'page-title-action',
            esc_html__( 'Choose a Button type' ),
            esc_html__( 'Add New' )
        );
    }

    /**
     * Used by the button-table, in case there are no buttons to render.
     *
     * @return void
     */
    public function render_lets_create_one_link() {
        $url = $this->get_modal_link();
        printf(
            '<a href="%s" title="%s" class="thickbox open-plugin-details-modal cnb-button-overview-modal-add-new" data-title="%s">%s</a>',
            esc_url( $url ),
            esc_html__( 'Create new button' ),
            esc_html__( 'Choose a Button type' ),
            esc_html__( 'Let\'s create one!' )
        );
    }

    /**
     * @param $domain CnbDomain|WP_Error
     * @param $table Cnb_Button_List_Table
     *
     * @return void
     */
    private function set_button_filter( $domain, $table ) {
        $cnb_options = get_option( 'cnb' );
        if ( isset( $cnb_options['show_all_buttons_for_domain'] )
             && $cnb_options['show_all_buttons_for_domain'] != 1
             && $domain != null
             && ! ( $domain instanceof WP_Error ) ) {
            $table->setOption( 'filter_buttons_for_domain', $domain->id );
        }
    }

    public function BlackFridayNotice( $domain ) {
        global $cnb_coupon;
        if ( $domain !== null && ! ( $domain instanceof WP_Error ) && $domain->type !== 'PRO' ) {
            $cnb_utils = new CnbUtils();
            if ( $cnb_coupon !== null && ! is_wp_error( $cnb_coupon ) ) {
                $promoMessage = ' Upgrade to PRO with coupon code <strong><code>' . esc_html( $cnb_coupon->code ) . '</code></strong> to get 40% off your first bill!';
                $upgrade_url  = $cnb_utils->get_cnb_domain_upgrade();
                if ( isset( $upgrade_url ) && $upgrade_url ) {
                    $promoMessage .= ' <a style="color:#00d600; font-weight:600;" href="' . esc_url( $upgrade_url ) . '">Click here!</a>';
                }
                if ( $cnb_coupon->code === 'BLACKFRIDAY22WP' ) {
                    $message = '<p>💰 <strong>BLACK FRIDAY DEAL!</strong> 💰' . $promoMessage . '</p>';
                    CnbAdminNotices::get_instance()->blackfriday( $message );
                } elseif ( $cnb_coupon->code === 'CYBERMONDAY22WP' ) {
                    $message = '<p>🤖 <strong>CYBER MONDAY DEAL!</strong> 🤖' . $promoMessage . '</p>';
                    CnbAdminNotices::get_instance()->blackfriday( $message );
                }
            }
        }
    }

    function render() {
        global $cnb_domain;

        //Prepare Table of elements
        $wp_list_table = new Cnb_Button_List_Table();

        // Set filter
        $this->set_button_filter( $cnb_domain, $wp_list_table );

        // If users come to this page before activating, we need the -settings/-premium-activation JS for the activation notice
        wp_enqueue_script( CNB_SLUG . '-settings' );
	    wp_enqueue_script( CNB_SLUG . '-premium-activation' );
	    wp_enqueue_script( CNB_SLUG . '-button-overview' );

        add_action( 'cnb_header_name', array( $this, 'header' ) );

        $data = $wp_list_table->prepare_items();

        if ( ! is_wp_error( $data ) && $cnb_domain && ! is_wp_error( $cnb_domain ) ) {
            add_action( 'cnb_after_header', array( $this, 'cnb_create_new_button' ) );

            // Check if we should warn about inactive buttons
            $views        = $wp_list_table->get_views();
            $active_views = isset( $views['active'] ) ? $views['active'] : '';
            if ( false !== strpos( $active_views, '(0)' ) ) {
                $message = '<p>You have no active buttons!</p>';
                CnbAdminNotices::get_instance()->warning( $message );
            }
        }
        $this->BlackFridayNotice( $cnb_domain );

        wp_enqueue_script( CNB_SLUG . '-form-bulk-rewrite' );
        do_action( 'cnb_header' );

        
        echo '<div class="cnb-plugin-content-wrapper">';

	    echo '<main>';
        echo '<form class="cnb_list_event" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" method="post">';
        echo '<input type="hidden" name="page" value="call-now-button-buttons" />';
        echo '<input type="hidden" name="action" value="cnb_buttons_bulk" />';
        $wp_list_table->views();
        $wp_list_table->display();
        echo '</form>';
        echo '</main>';

        echo '
            <aside>
                <div class="cnb-aside-body-wrapper">
                    <div class="cnb-aside-body">
                        <div class="cnb-content-aside-more cnb-content-aside-active">';
                            $this->render_promos();
		echo '			</div>
                    </div>
                </div>
            </aside>';

        echo '</div><!-- END .cnb-plugin-content-wrapper -->';

        // Do not add the modal code if something is wrong
        if ( ! is_wp_error( $data ) ) {
	        ( new CnbButtonModalView() )->render();
        }
        do_action( 'cnb_footer' );
    }

    private function render_promos() {
        global $cnb_domain;
        $cnb_utils   = new CnbUtils();
        $upgrade_url = $cnb_utils->get_cnb_domain_upgrade();
        if ( isset( $upgrade_url ) && $upgrade_url ) {
            if ( $cnb_domain !== null && ! ( $cnb_domain instanceof WP_Error ) && $cnb_domain->type !== 'PRO' ) {
                $promoboxes = range( 1, 3 );
                shuffle( $promoboxes );
                $promoItem             = array_rand( $promoboxes );
                $schedule_illustration = plugins_url('resources/images/scheduler.png', CNB_PLUGINS_URL_BASE );
                $custom_image          = plugins_url('resources/images/custom-image.jpg', CNB_PLUGINS_URL_BASE );
                if ( $promoItem == 1 ) {
                    ( new CnbAdminFunctions() )->cnb_promobox(
	                    'green',
	                    '',
	                    '<h4 class="cnb-center">Show a call button during office hours</h4>' .
	                    '<div class="cnb-center" style="padding: 10px 30px"><img src="' . esc_url( $schedule_illustration ) . '" alt="Upgrade your domain to PRO with an extra discount" style="max-width:300px; width:100%; height:auto;" /></div>' .
	                    '<h4 class="cnb-center">A mail button when you\'re off.</h4>',
	                    'Try the <strong>scheduler</strong> 14 days free',
	                    'Start Trial',
	                    $upgrade_url
                    );
                } elseif ( $promoItem == 2 ) {
                    ( new CnbAdminFunctions() )->cnb_promobox(
	                    'green',
	                    'PRO includes:',
	                    '<p>
                            <span class="dashicons dashicons-yes cnb-green"></span> Button scheduler<br>
                            <span class="dashicons dashicons-yes cnb-green"></span> Multi-action buttons<br>
                            <span class="dashicons dashicons-yes cnb-green"></span> Icon picker & custom images<br>
                            <span class="dashicons dashicons-yes cnb-green"></span> Advanced display rules<br>
                            <span class="dashicons dashicons-yes cnb-green"></span> Geo targeting<br>
                            <span class="dashicons dashicons-yes cnb-green"></span> Set scroll height for buttons to appear<br>
                            <span class="dashicons dashicons-yes cnb-green"></span> Slide-in content windows<br>
                            <span class="dashicons dashicons-yes cnb-green"></span> Integrate your Intercom chat</p><h3>And much more!</h3>',
	                    '<strong>Try it 14 days free!</strong>',
	                    'Start Free Trial',
	                    $upgrade_url
                    );
                } else {
                    ( new CnbAdminFunctions() )->cnb_promobox(
	                    'green',
	                    '',
	                    '<h4>Unlock more icons...</h4>' .
	                    '<p>Upgrade to Pro to enable an icon picker for your actions.</p>' .
	                    '<h4>...or personalize with Custom Images</h4>' .
	                    '<div class="cnb-center" style="padding: 0 34px"><img src="' . esc_url( $custom_image ) . '" alt="Custom button images" style="max-width:246px; width:100%; height:auto;" /></div>' .
	                    '<p>With custom images you can add your own image to your buttons. For example a headshot on a contact button.</p>',
	                    '<strong>Try it 14 days free!</strong>',
	                    'Start Free Trial',
	                    $upgrade_url
                    );
                }
            }
        }
        echo '<br class="clear">';
    }
}
