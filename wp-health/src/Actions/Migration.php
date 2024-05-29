<?php
namespace WPUmbrella\Actions;


use WPUmbrella\Core\Hooks\ExecuteHooks;

class Migration implements ExecuteHooks
{
    public function hooks()
    {
        add_action('admin_init', [$this, 'upgrader']);
    }

    public function upgrader()
    {
        $currentVersion = get_option('wphealth_version');

        if (version_compare($currentVersion, WP_UMBRELLA_VERSION, '<')) {
            update_option('wphealth_version', WP_UMBRELLA_VERSION, false);
        }

		// Migrate project with secret token
		if ($currentVersion && version_compare($currentVersion, '2.7.0', '<')) {
			$apiKey = wp_umbrella_get_api_key();

			$secretToken = wp_umbrella_generate_random_string(128);
			$options = wp_umbrella_get_service('Option')->getOptions([
				"secure" => false
			]);

			$options['secret_token'] = $secretToken;

			wp_umbrella_get_service('Option')->setOptions($options);

			$responseValidateSecret = wp_umbrella_get_service('Projects')->validateSecretToken([
				'base_url' => site_url(),
				'rest_url' => rest_url(),
				'secret_token' => $secretToken
			], $apiKey);

			if(!is_array($responseValidateSecret) || !isset($responseValidateSecret['success'])){
				unset($options['secret_token']);
				wp_umbrella_get_service('Option')->setOptions($options);
				return;
			}

			if(!$responseValidateSecret['success']){
				return;
			}

			$options = wp_umbrella_get_service('Option')->getOptions([
				"secure" => false
			]);

			$options['secret_token'] = $secretToken;

			wp_umbrella_get_service('Option')->setOptions($options);
        }

		// Migrate project with hash tokens
		if ($currentVersion && version_compare($currentVersion, '2.11.0', '<')) {
			$secretToken = wp_umbrella_get_secret_token();

			$options = wp_umbrella_get_service('Option')->getOptions([
				"secure" => false
			]);

			$options['secret_token'] = wp_umbrella_get_service('WordPressContext')->getHash($options['secret_token']);

			wp_umbrella_get_service('Option')->setOptions($options);
        }
    }
}
