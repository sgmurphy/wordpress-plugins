<?php

namespace KrokedilKlarnaPaymentsDeps\Krokedil\SettingsPage;

\defined('ABSPATH') || exit;
use KrokedilKlarnaPaymentsDeps\Krokedil\SettingsPage\Traits\Layout;
/**
 * Support class to handle the support section of the settings page.
 */
class Support
{
    use Layout;
    /**
     * The Support for the page.
     *
     * @var array $support
     */
    protected $support = array();
    /**
     * Class constructor.
     *
     * @param array                    $support Support for the page.
     * @param array                    $sidebar Sidebar content.
     * @param \WC_Payment_Gateway|null $gateway The gateway object.
     *
     * @return void
     */
    public function __construct($support, $sidebar, $gateway = null)
    {
        $this->title = __('Support', 'krokedil-settings');
        $this->gateway = $gateway;
        $this->support = $support;
        $this->sidebar = $sidebar;
    }
    /**
     * Return the Helpscout beacon script.
     *
     * @return string;
     */
    public static function hs_beacon_script()
    {
        return '!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});';
    }
    /**
     * Enqueue the scripts for the support page.
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        // Load CSS.
        wp_enqueue_style('krokedil-support-page');
        // If the WC Version is 9.1 or above, get the container for the RestAPiUtil, else us the WC()->api class property.
        // @see https://github.com/woocommerce/woocommerce/blob/5690850e47284b3a9afd4e61dec01121159ca9e8/plugins/woocommerce/src/Internal/Utilities/LegacyRestApiStub.php#L183-L187.
        $system_report = \version_compare(WC_VERSION, '9.1', '<=') ? WC()->api->get_endpoint_data('/wc/v3/system_status') : wc_get_container()->get(\Automattic\WooCommerce\Utilities\RestApiUtil::class)->get_endpoint_data('/wc/v3/system_status');
        $beacon_id = '9c22f83e-3611-42aa-a148-1ca06de53566';
        // Localize the support scrip.
        wp_localize_script('krokedil-support-page', 'krokedil_support_params', array('systemReport' => $system_report, 'beaconId' => $beacon_id));
        // Load JS.
        wp_add_inline_script('krokedil-support-page', self::hs_beacon_script(), 'before');
        wp_enqueue_script('krokedil-support-page');
    }
    /**
     * Output the support HTML.
     *
     * @return void
     */
    public function output_page_content()
    {
        global $hide_save_button;
        $hide_save_button = \true;
        $this->enqueue_scripts();
        $content = $this->support['content'];
        ?>
		<div class='krokedil_support'>
			<div class="krokedil_support__info">
				<p><?php 
        esc_html_e('Before opening a support ticket, please make sure you have read the relevant plugin resources for a solution to your problem', 'krokedil-settings');
        ?>:</p>
				<?php 
        foreach ($content as $item) {
            ?>
					<?php 
            echo wp_kses_post($this->print_content($item));
            ?>
				<?php 
        }
        ?>
				<button type="button" class="button button-primary support-button"><?php 
        esc_html_e('Open support ticket with Krokedil', 'krokedil-settings');
        ?></button>
			</div>
		</div>
		<?php 
    }
    /**
     * Print the content.
     *
     * @param array $item The item to print.
     * @param bool  $ignore_p_tag Whether to ignore the p tag.
     *
     * @return string
     */
    public function print_content($item, $ignore_p_tag = \false)
    {
        $type = $item['type'];
        $text = '';
        switch ($type) {
            case 'text':
                $text = self::get_text($item);
                break;
            case 'link':
                $text = self::get_link($item);
                break;
            case 'link_text':
                $text = self::get_link_text($item);
                break;
            case 'list':
                $list_items = $item['items'];
                $list = '<ul class="krokedil_settings__list">';
                foreach ($list_items as $list_item) {
                    $list .= '<li>';
                    $list .= $this->print_content($list_item, \true);
                    $list .= '</li>';
                }
                $list .= '</ul>';
                $text = $list;
                break;
            case 'spacer':
                $ignore_p_tag = \true;
                $text = '<div class="krokedil_settings__spacer"></div>';
                break;
            default:
                return '';
        }
        if ($ignore_p_tag) {
            return $text;
        }
        return '<p>' . $text . '</p>';
    }
}
