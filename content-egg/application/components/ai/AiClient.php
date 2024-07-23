<?php

namespace ContentEgg\application\components\ai;

use ContentEgg\application\vendor\openai\OpenAi;

use function ContentEgg\prnx;

defined('\ABSPATH') || exit;

/**
 * AiClient class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2024 keywordrush.com
 */

abstract class AiClient
{
	const TIMEOUT = 30;
	const MAX_RETRIES = 3;
	const INITIAL_WAIT = 10;
	const DEBUG_CACHE_TTL = 2592000;

	protected $api_key;
	protected $model;
	protected $curl_info;
	protected $last_usage = array();

	public static function models()
	{
		$models = array(
			'gpt-4o-mini' => array(
				'name' => 'OpenAI: gpt-4o-mini' . ' ' . __('(recommended)', 'content-egg'),
				'class' => OpenAiClient::class,
			),
			'gpt-4o' => array(
				'name' => 'OpenAI: gpt-4o',
				'class' => OpenAiClient::class,
			),
			'gpt-3.5-turbo' => array(
				'name' => 'OpenAI: gpt-3.5-turbo',
				'class' => OpenAiClient::class,
			),
			'gpt-4' => array(
				'name' => 'OpenAI: gpt-4',
				'class' => OpenAiClient::class,
			),
			'claude-3-haiku-20240307' => array(
				'name' => 'Claude 3: haiku',
				'class' => ClaudeClient::class,
			),
			'claude-3-sonnet-20240229' => array(
				'name' => 'Claude 3: sonnet',
				'class' => ClaudeClient::class,
			),
			'claude-3-5-sonnet-20240620' => array(
				'name' => 'Claude 3.5: sonnet',
				'class' => ClaudeClient::class,
			),
			'claude-3-opus-20240229' => array(
				'name' => 'Claude 3: opus',
				'class' => ClaudeClient::class,
			),

		);

		$models = \apply_filters('cegg_ai_models', $models);
		return $models;
	}

	abstract public function getChatUrl();
	abstract public function getPayload($prompt, $system = '', $params = array());
	abstract public function getContent($response);

	public function __construct($api_key, $model)
	{
		if (is_array($api_key))
			$api_key = $api_key[array_rand($api_key)];

		$this->api_key = $api_key;
		$this->model = $model;
	}

	public static function createClient($api_key, $model)
	{
		$models = self::models();
		if (!isset($models[$model]))
			throw new \Exception('The AI model is not valid.');

		$class = $models[$model]['class'];

		return new $class($api_key, $model);
	}

	public function getHeaders()
	{
		return array(
			'Content-Type: application/json',
		);
	}

	public function getLastUsage()
	{
		return $this->last_usage;
	}

	public function query($prompt, $system = '', $params = array())
	{
		return self::retry(array($this, '_query'), array($prompt, $system, $params), self::MAX_RETRIES, self::INITIAL_WAIT);
	}

	public function _query($prompt, $system = '', $params = array())
	{
		$payload = $this->getPayload($prompt, $system, $params);

		// Debug
		if ($cache = $this->getFromCache($payload))
		{
			$response = $cache;
		}
		else
		{
			if (!$response = $this->chat($payload))
				throw new \Exception('No response from AI API.');

			$info = $this->curl_info;
			if ($info['http_code'] != 200)
			{
				$err = sprintf('AI API error code: %d.', $info['http_code']);
				if ($data = json_decode($response, true) && isset($data['error']['message']))
					$err .= ' Error message: ' . $data['error']['message'];

				throw new \Exception($err, $info['http_code']);
			}

			$this->saveToCache($payload, $response);
		}

		return $this->getContent($response);
	}

	public static function retry(callable $callable, array $arg, $max_retries = 5, $initial_wait = 5, $exponent = 2)
	{
		try
		{
			return call_user_func_array($callable, $arg);
		}
		catch (\Exception $e)
		{
			if ($max_retries > 0)
			{
				usleep($initial_wait * 1E6);
				return self::retry($callable, $arg, $max_retries - 1, $initial_wait * $exponent, $exponent);
			}

			throw $e;
		}
	}

	private function saveToCache(array $payload, $response)
	{
		if (!\ContentEgg\application\Plugin::isDevEnvironment())
			return;

		$data = '';

		if (isset($payload['model']))
			$data .= 'Model: ' . $payload['model'] . "\n";

		if (isset($payload['temperature']))
			$data .= 'Temperature: ' . $payload['temperature'] . "\n";

		if (isset($payload['system']))
			$data .= 'System: ' . $payload['system'] . "\n";

		foreach ($payload['messages'] as $m)
		{
			$data .= $m['role'] . ': ' . $m['content'] . "\n";
		}

		$data .= "----------------------------\n";
		$data .=  $this->getContent($response);
		$data .= "\n============================\n";

		$data .= $response;

		if (!file_put_contents($this->getCacheFileName($payload), $data))
			return false;
	}

	private function getFromCache(array $payload)
	{
		if (!\ContentEgg\application\Plugin::isDevEnvironment())
			return;

		$filename = $this->getCacheFileName($payload);

		if (file_exists($filename) && is_readable($filename) && filectime($filename) > time() - self::DEBUG_CACHE_TTL)
		{
			$data = file_get_contents($filename);
			$parts = explode("============================", $data);
			if (isset($parts[1]))
				return trim($parts[1]);
			else
				return $parts[0];
		}

		return false;
	}

	private function getCacheFileName(array $payload)
	{
		$to_string = array();
		array_walk_recursive($payload, function ($v) use (&$to_string)
		{
			$to_string[] = $v;
		});
		$to_string = implode('', $to_string);

		$file_name = sanitize_text_field(md5($to_string)) . '.txt';
		return trailingslashit($this->getTemporaryDirectory()) . $file_name;
	}

	protected function getTemporaryDirectory()
	{
		$upload_dir = \wp_upload_dir();
		$dir = $upload_dir['basedir'] . '/cegg-debug-ai';

		if (is_dir($dir))
			return $dir;

		$files = array(
			array(
				'file' => 'index.html',
				'content' => '',
			),
			array(
				'file' => '.htaccess',
				'content' => 'deny from all',
			),
		);

		foreach ($files as $file)
		{
			if (\wp_mkdir_p($dir) && !file_exists(trailingslashit($dir) . $file['file']))
			{
				if ($file_handle = @fopen(trailingslashit($dir) . $file['file'], 'w'))
				{
					fwrite($file_handle, $file['content']);
					fclose($file_handle);
				}
			}
		}

		if (!is_dir($dir))
			throw new \Exception('Can not create temporary directory.');

		return $dir;
	}

	public function chat(array $payload = array())
	{
		if (!isset($payload['model']))
			$payload['model'] = $this->model;

		$headers = $this->getHeaders();

		return $this->sendRequest($this->getChatUrl(), $payload, $headers);
	}

	protected function sendRequest($url, array $payload, array $headers = array())
	{
		$curl_info = array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 5,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_TIMEOUT        => self::TIMEOUT,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'POST',
			CURLOPT_POSTFIELDS     => json_encode($payload),
			CURLOPT_HTTPHEADER     => $headers,
		);

		$curl = curl_init();
		curl_setopt_array($curl, $curl_info);
		$response = curl_exec($curl);
		$this->curl_info = curl_getinfo($curl);
		curl_close($curl);

		return $response;
	}
}
