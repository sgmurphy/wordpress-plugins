<?php
namespace WPUmbrella\Controller\BackupV4;

use WPUmbrella\Core\Models\AbstractController;
use WPUmbrella\Helper\Host;

class CheckBackupCapabilities extends AbstractController
{
    protected function checkNinjaFirewall()
    {
        if (!function_exists('nfw_get_option')) {
            return false;
        }

        $options = nfw_get_option('nfw_options');

        if (isset($options['post_b64']) && !empty($options['post_b64'])) {
            return true;
        }

        return false;
    }

    public function executeGet($params)
    {
        global $wpdb;

        return $this->returnResponse([
            'ninja_firewall_options' => [
                'post_b64' => $this->checkNinjaFirewall(),
            ]
        ]);
    }
}
