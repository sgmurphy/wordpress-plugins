<?php

namespace ContentEgg\application\components;

defined('\ABSPATH') || exit;

/**
 * ContentProduct class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2023 keywordrush.com
 */
class ContentProduct extends Content
{

	const STOCK_STATUS_IN_STOCK = 1;
	const STOCK_STATUS_OUT_OF_STOCK = -1;
	const STOCK_STATUS_UNKNOWN = 0;

	public $price;
	public $priceOld;
	public $percentageSaved;
	public $currency;
	public $currencyCode;
	public $manufacturer;
	public $category;
	public $categoryPath = array();
	public $merchant;
	public $logo;
	public $domain;
	public $rating;
	public $ratingDecimal;
	public $reviewsCount;
	public $availability;
	public $orig_url;
	public $ean;
	public $upc;
	public $sku;
	public $isbn;
	public $short_description;
	public $woo_sync;
	public $woo_attr;
	public $features = array();
	public $images = array();
	public $stock_status;
	public $img_large;
	public $group;
}
