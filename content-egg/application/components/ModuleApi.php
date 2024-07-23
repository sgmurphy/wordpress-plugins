<?php

namespace ContentEgg\application\components;

defined('\ABSPATH') || exit;

use ContentEgg\application\components\ai\AiProcessor;
use ContentEgg\application\Plugin;
use ContentEgg\application\components\ModuleManager;
use ContentEgg\application\helpers\TemplateHelper;
use ContentEgg\application\helpers\TextHelper;

use function ContentEgg\prnx;

/**
 * ModuleApi class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2024 keywordrush.com
 */
class ModuleApi
{

    const API_BASE = '-module-api';

    public function __construct()
    {
        \add_action('wp_ajax_content-egg-module-api', array($this, 'addApiEntryModule'));
        \add_action('wp_ajax_content-egg-ai-api', array($this, 'addApiEntryAi'));
    }

    public static function apiBase()
    {
        return Plugin::slug . self::API_BASE;
    }

    public function addApiEntryAi()
    {
        sleep(3);
        if (!\current_user_can('edit_posts'))
            throw new \Exception("Access denied.");

        \check_ajax_referer('contentegg-metabox', '_contentegg_nonce');

        if (empty($_POST['module']))
            die("Module is undefined.");

        @set_time_limit(240);

        $module_id = TextHelper::clear(sanitize_text_field(wp_unslash($_POST['module'])));
        $parser = ModuleManager::getInstance()->parserFactory($module_id);

        if (!$parser || !$parser->isActive())
            die("The module " . esc_html($parser->getId()) . " is inactive.");

        if (isset($_POST['params']))
            $params = wp_unslash($_POST['params']); // phpcs:ignore
        else
            die("AI params is undefined.");

        $params = json_decode($params, true);

        if (!$params)
            die("Error: 'ai_params' parameter cannot be empty.");

        if (!isset($params['data']) || !isset($params['title_method']) || !isset($params['description_method']))
            die("Error: Invalid Parameters");

        $title_method = TextHelper::clear(sanitize_text_field(wp_unslash($params['title_method'])));
        $description_method = TextHelper::clear(sanitize_text_field(wp_unslash($params['description_method'])));
        $items = $params['data'];

        try
        {
            $items = AiProcessor::applayAiItems($items, $title_method, $description_method);
        }
        catch (\Exception $e)
        {
            $this->formatJson(array('error' => $e->getMessage()));
        }

        $this->formatJson(array('results' => $items, 'error' => ''));
    }

    public function addApiEntryModule()
    {
        if (!\current_user_can('edit_posts'))
        {
            throw new \Exception("Access denied.");
        }

        \check_ajax_referer('contentegg-metabox', '_contentegg_nonce');

        if (empty($_POST['module']))
        {
            die("Module is undefined.");
        }

        $module_id = TextHelper::clear(sanitize_text_field(wp_unslash($_POST['module'])));
        $parser = ModuleManager::getInstance()->parserFactory($module_id);

        if (!$parser || !$parser->isActive())
        {
            die("Parser module " . esc_html($parser->getId()) . " is inactive.");
        }

        if (isset($_POST['query']))
            $query = wp_unslash($_POST['query']); // phpcs:ignore
        else
            $query = '';

        $query = json_decode($query, true);

        if (!$query)
        {
            die("Error: 'query' parameter cannot be empty.");
        }

        if (empty($query['keyword']))
        {
            die("Error: 'keyword' parameter cannot be empty.");
        }

        if ($query['keyword'][0] == '[' || filter_var($query['keyword'], FILTER_VALIDATE_URL))
        {
            $keyword = filter_var($query['keyword'], FILTER_SANITIZE_URL);
            $keyword = str_replace('[cataloglimit', '[catalog limit', $keyword);
        }
        else
        {
            $keyword = sanitize_text_field($query['keyword']);
        }

        if (!$keyword)
        {
            die("Error: 'keyword' parameter cannot be empty.");
        }

        try
        {
            $data = $parser->doMultipleRequests($keyword, $query);
            foreach ($data as $key => $item)
            {
                if (!$item->unique_id)
                {
                    throw new \Exception('Item data "unique_id" must be specified.');
                }

                if ($item->description)
                {
                    if (!TextHelper::isHtmlTagDetected($item->description))
                    {
                        $item->description = TextHelper::br2nl($item->description);
                    }

                    $item->description = TextHelper::removeExtraBreaks($item->description);
                }

                if (property_exists($item, 'price'))
                {
                    if (!(float) $item->price)
                    {
                        $item->price = 0;
                        $item->priceOld = 0;
                    }
                    elseif (!(float) $item->priceOld)
                    {
                        $item->priceOld = 0;
                    }

                    if ($item->price)
                        $item->_priceFormatted = TemplateHelper::formatPriceCurrency($item->price, $item->currencyCode);
                    if ($item->priceOld)
                        $item->_priceOldFormatted = TemplateHelper::formatPriceCurrency($item->priceOld, $item->currencyCode);
                    if ($item->description)
                        $item->_descriptionText = \wp_strip_all_tags($item->description);
                }
            }
            $this->formatJson(array('results' => $data, 'error' => ''));
        }
        catch (\Exception $e)
        {
            $this->formatJson(array('error' => $e->getMessage()));
        }
    }

    public function formatJson($data)
    {
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data);
        \wp_die();
    }
}
