<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// shortcode
add_shortcode('wpedon', 'wpedon_shortcode');

function wpedon_shortcode($atts) {
	// get shortcode id
    $atts = shortcode_atts(array(
        'id'		=> '',
        'align' 	=> '',
        'widget' 	=> '',
        'name' 		=> '',
        'image' 	=> ''
    ), $atts);

    $post_id = $atts['id'];

	// paypal account data
	$ppcp = new \WPEasyDonation\Base\PpcpController();
	$paypal_connection_data = $ppcp->paypal_connection_data( $post_id  );

	// stripe account data
	$stripe = new \WPEasyDonation\Base\Stripe();
	$stripe_account_data = $stripe->connection_data($post_id);
	
	

	if (empty($paypal_connection_data) && empty($stripe_account_data)) return __('(Please enter your Payment methods data on the settings pages.)');

	// get settings page values
	$options = \WPEasyDonation\Helpers\Option::get();
	foreach ($options as $k => $v ) { $value[$k] = $v; }

	// get values for button
	$wpedon_button_price_type = !empty( $paypal_connection_data ) && $paypal_connection_data['connection_type'] === 'manual' ?
        'fixed' :
        esc_attr(get_post_meta($post_id,'wpedon_button_price_type',true));

	$amount = 	get_post_meta($post_id,'wpedon_button_price',true);
	$sku = 		get_post_meta($post_id,'wpedon_button_id',true);

	// price dropdown
	$wpedon_button_scpriceprice = get_post_meta($post_id,'wpedon_button_scpriceprice',true);
	$wpedon_button_scpriceaname = get_post_meta($post_id,'wpedon_button_scpriceaname',true);
	$wpedon_button_scpricebname = get_post_meta($post_id,'wpedon_button_scpricebname',true);
	$wpedon_button_scpricecname = get_post_meta($post_id,'wpedon_button_scpricecname',true);
	$wpedon_button_scpricedname = get_post_meta($post_id,'wpedon_button_scpricedname',true);
	$wpedon_button_scpriceename = get_post_meta($post_id,'wpedon_button_scpriceename',true);
	$wpedon_button_scpricefname = get_post_meta($post_id,'wpedon_button_scpricefname',true);
	$wpedon_button_scpricegname = get_post_meta($post_id,'wpedon_button_scpricegname',true);
	$wpedon_button_scpricehname = get_post_meta($post_id,'wpedon_button_scpricehname',true);
	$wpedon_button_scpriceiname = get_post_meta($post_id,'wpedon_button_scpriceiname',true);
	$wpedon_button_scpricejname = get_post_meta($post_id,'wpedon_button_scpricejname',true);

	$wpedon_button_scpricea = get_post_meta($post_id,'wpedon_button_scpricea',true);
	$wpedon_button_scpriceb = get_post_meta($post_id,'wpedon_button_scpriceb',true);
	$wpedon_button_scpricec = get_post_meta($post_id,'wpedon_button_scpricec',true);
	$wpedon_button_scpriced = get_post_meta($post_id,'wpedon_button_scpriced',true);
	$wpedon_button_scpricee = get_post_meta($post_id,'wpedon_button_scpricee',true);
	$wpedon_button_scpricef = get_post_meta($post_id,'wpedon_button_scpricef',true);
	$wpedon_button_scpriceg = get_post_meta($post_id,'wpedon_button_scpriceg',true);
	$wpedon_button_scpriceh = get_post_meta($post_id,'wpedon_button_scpriceh',true);
	$wpedon_button_scpricei = get_post_meta($post_id,'wpedon_button_scpricei',true);
	$wpedon_button_scpricej = get_post_meta($post_id,'wpedon_button_scpricej',true);

	$post_data = 	get_post($post_id);
	$name = 		$post_data->post_title;

	$rand_string = esc_attr(md5(uniqid(rand(), true)));

	// show name
	$wpedon_button_enable_name = 		get_post_meta($post_id,'wpedon_button_enable_name',true);

	// show price
	$wpedon_button_enable_price = 		get_post_meta($post_id,'wpedon_button_enable_price',true);

	// show currency
	$wpedon_button_enable_currency = 	get_post_meta($post_id,'wpedon_button_enable_currency',true);

	// live of test mode
	if ($value['mode'] == "1") {
		$account = $value['sandboxaccount'];
		$path = "sandbox.paypal";
	} elseif ($value['mode'] == "2")  {
		$account = $value['liveaccount'];
		$path = "paypal";
	}

	$account_a = get_post_meta($post_id,'wpedon_button_account',true);
	if (!empty($account_a)) { $account = $account_a; }

	// currency
	$currency_a = get_post_meta($post_id,'wpedon_button_currency',true);
	if (!empty($currency_a)) { $value['currency'] = $currency_a; }

	$currency = \WPEasyDonation\Helpers\Func::currency_code_to_iso($value['currency']);

	// language
	$language_a = get_post_meta($post_id,'wpedon_button_language',true);

	if (!empty($language_a)) { $value['language'] = $language_a; }

	if ($value['language'] == "1") {
		$language = "da_DK";
		$imagea = "https://www.paypal.com/da_DK/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/da_DK/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/da_DK/DK/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Danish

	if ($value['language'] == "2") {
		$language = "nl_BE";
		$imagea = "https://www.paypal.com/nl_NL/NL/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/nl_NL/NL/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/nl_NL/NL/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Dutch

	if ($value['language'] == "3") {
		$language = "en_US";
		$imagea = "https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //English

	if ($value['language'] == "20") {
		$language = "en_GB";
		$imagea = "https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //English - UK

	if ($value['language'] == "4") {
		$language = "fr_CA";
		$imagea = "https://www.paypal.com/fr_CA/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/fr_CA/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/fr_CA/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //French

	if ($value['language'] == "5") {
		$language = "de_DE";
		$imagea = "https://www.paypal.com/de_DE/DE/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/de_DE/DE/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //German

	if ($value['language'] == "6") {
		$language = "he_IL";
		$imagea = "https://www.paypal.com/he_IL/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/he_IL/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/he_IL/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Hebrew

	if ($value['language'] == "7") {
		$language = "it_IT";
		$imagea = "https://www.paypal.com/it_IT/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/it_IT/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/it_IT/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Italian

	if ($value['language'] == "8") {
		$language = "ja_JP";
		$imagea = "https://www.paypal.com/ja_JP/JP/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/ja_JP/JP/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/ja_JP/JP/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Japanese

	if ($value['language'] == "9") {
		$language = "no_NO";
		$imagea = "https://www.paypal.com/no_NO/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/no_NO/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/no_NO/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Norwgian

	if ($value['language'] == "10") {
		$language = "pl_PL";
		$imagea = "https://www.paypal.com/pl_PL/PL/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/pl_PL/PL/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/pl_PL/PL/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Polish

	if ($value['language'] == "11") {
		$language = "pt_BR";
		$imagea = "https://www.paypal.com/pt_PT/PT/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/pt_PT/PT/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/pt_PT/PT/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Portuguese

	if ($value['language'] == "12") {
		$language = "ru_RU";
		$imagea = "https://www.paypal.com/ru_RU/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/ru_RU/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/ru_RU/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Russian

	if ($value['language'] == "13") {
		$language = "es_ES";
		$imagea = "https://www.paypal.com/es_ES/ES/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/es_ES/ES/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/es_ES/ES/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Spanish

	if ($value['language'] == "14") {
		$language = "sv_SE";
		$imagea = "https://www.paypal.com/sv_SE/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/sv_SE/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/sv_SE/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Swedish

	if ($value['language'] == "15") {
		$language = "zh_CN";
		$imagea = "https://www.paypal.com/zh_XC/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/zh_XC/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/zh_XC/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Simplified Chinese - China

	if ($value['language'] == "16") {
		$language = "zh_HK";
		$imagea = "https://www.paypal.com/zh_HK/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/zh_HK/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/zh_HK/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Traditional Chinese - Hong Kong

	if ($value['language'] == "17") {
		$language = "zh_TW";
		$imagea = "https://www.paypalobjects.com/en_US/TW/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypalobjects.com/en_US/TW/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypalobjects.com/en_US/TW/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Traditional Chinese - Taiwan

	if ($value['language'] == "18") {
		$language = "tr_TR";
		$imagea = "https://www.paypal.com/tr_TR/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/tr_TR/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/tr_TR/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Turkish

	if ($value['language'] == "19") {
		$language = "th_TH";
		$imagea = "https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif";
		$imageb = "https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif";
		$imagec = "https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif";
		$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
		$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
		$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
		$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
	} //Thai - Thai buttons not available for donation - using US is correct

	// custom button size
	$wpedon_button_buttonsize = get_post_meta($post_id,'wpedon_button_buttonsize',true);

	if ($wpedon_button_buttonsize != "0") {
		$value['size'] = $wpedon_button_buttonsize;
	}

	if (empty($value['size'])) {
        $options = \WPEasyDonation\Helpers\Option::get();
        $value['size'] = $options['size'];
    }

	// button size
	if ($value['size'] == "1") { $img = $imagea; }
	if ($value['size'] == "2") { $img = $imageb; }
	if ($value['size'] == "3") { $img = $imagec; }
	if ($value['size'] == "4") { $img = $imaged; }
	if ($value['size'] == "5") { $img = $imagee; }
	if ($value['size'] == "6") { $img = $imagef; }
	if ($value['size'] == "7") { $img = $imageg; }
	if ($value['size'] == "8") { $img = $value['image_1']; }
	
	// image
	if (array_key_exists('image', $atts) && ($atts['image'] != "")) {
			$img = $atts['image'];
	}

	// return url
	$return = "";
	$return = $value['return'];
	$return_a = get_post_meta($post_id,'wpedon_button_return',true);
	if (!empty($return_a)) { $return = $return_a; }

	// window action
	if ($value['opens'] == "1") { $target = ""; }
	if ($value['opens'] == "2") { $target = "_blank"; }

	// alignment
	switch ( $atts['align'] ) {
		case 'left':
			$alignment = ' wpedon-align-left';
			break;
		case 'right':
			$alignment = ' wpedon-align-right';
			break;
		case 'center':
			$alignment = ' wpedon-align-center';
			break;
		default:
			$alignment = ' wpedon-align-left';
	}

	// notify url
	$notify_url = get_admin_url() . "admin-post.php?action=add_wpedon_button_ipn";

	$paypal_input_width = !empty( $paypal_connection_data ) && !empty( $paypal_connection_data['width'] ) ? intval( $paypal_connection_data['width'] ) : 0;
	$stripe_input_width = !empty( $stripe_account_data ) && !empty( $stripe_account_data['width'] ) ? intval( $stripe_account_data['width'] ) : 0;
	$wpedon_input_width = max( $paypal_input_width, $stripe_input_width );
	$output = "<style>
        .wpedon-container .wpedon-select,
        .wpedon-container .wpedon-input {
            width: {$wpedon_input_width}px;
            min-width: {$wpedon_input_width}px;
            max-width: {$wpedon_input_width}px;
        }
    </style>";

	$output .= "<div class='wpedon-container{$alignment}'>";

	// text description title
	if ($wpedon_button_enable_name == "1" || ($wpedon_button_enable_price == "1" && $wpedon_button_price_type !== 'manual')) {
		$output .= "<label>";
	}

	if ($wpedon_button_enable_name == "1") {
		$output .= esc_html($name);
	}

	if ($wpedon_button_price_type !== 'manual' && $wpedon_button_enable_name == "1" && $wpedon_button_enable_price == "1") {
		$output .= "<br /><span class='price'>";
	}

	if ($wpedon_button_price_type !== 'manual' && $wpedon_button_enable_price == "1") {
		$output .= esc_html($amount) ."</span>";
	}

	if ($wpedon_button_price_type !== 'manual' && $wpedon_button_enable_price == "1") {
		if ($wpedon_button_enable_currency == "1") {
			$output .= esc_html($currency);
		}
	}

	if ($wpedon_button_enable_name == "1" || ($wpedon_button_enable_price == "1" && $wpedon_button_price_type !== 'manual')) {
		$output .= "</label><br />";
	}

	if ( $wpedon_button_price_type === 'manual' ) {
		// price input
		$output .= '<div><br/>';
		$output .= '<label>' . __( 'Donation amount' ) . " ({$currency})</label>";
		$output .= '<br />';
		$output .= "<input type='number' min='1' step='any' name='ddm_{$rand_string}' class='wpedon-input' value='{$amount}' />";
		$output .= "<script>
                jQuery(document).ready(function($){
                    jQuery('[name=\"ddm_{$rand_string}\"]').on('change', function(){
                      jQuery('#amount_$rand_string').val($(this).val());
                      jQuery('#price_$rand_string').val($(this).val());
                    });
                });
            </script>";
		$output .= '<br/><br/></div>';
	} elseif (!empty($wpedon_button_scpriceprice)) {
		// price dropdown menu

		// dd is active so set first value just in case no option is selected by user
		$amount =$wpedon_button_scpricea;

		$output .= "
		<script>
		jQuery(document).ready(function(){
			jQuery('#dd_$rand_string').on('change', function() {
			  jQuery('#amount_$rand_string').val(this.value);
              jQuery('#price_$rand_string').val(this.value);
			});
		});
		</script>
		";


		if (!empty($wpedon_button_scpriceprice)) { $output .= "<br /><label style='font-size:11pt !important;'>" . esc_html($wpedon_button_scpriceprice) . "</label><br /><select class='wpedon-select' name='dd_$rand_string' id='dd_$rand_string'>"; }
		if (!empty($wpedon_button_scpriceaname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpricea) . "'>" . esc_html($wpedon_button_scpriceaname) . "</option>"; }
		if (!empty($wpedon_button_scpricebname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpriceb) . "'>" . esc_html($wpedon_button_scpricebname) . "</option>"; }
		if (!empty($wpedon_button_scpricecname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpricec) . "'>" . esc_html($wpedon_button_scpricecname) . "</option>"; }
		if (!empty($wpedon_button_scpricedname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpriced) . "'>" . esc_html($wpedon_button_scpricedname) . "</option>"; }
		if (!empty($wpedon_button_scpriceename)) { $output .= "<option value='" . esc_attr($wpedon_button_scpricee) . "'>" . esc_html($wpedon_button_scpriceename) . "</option>"; }
		if (!empty($wpedon_button_scpricefname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpricef) . "'>" . esc_html($wpedon_button_scpricefname) . "</option>"; }
		if (!empty($wpedon_button_scpricegname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpriceg) . "'>" . esc_html($wpedon_button_scpricegname) . "</option>"; }
		if (!empty($wpedon_button_scpricehname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpriceh) . "'>" . esc_html($wpedon_button_scpricehname) . "</option>"; }
		if (!empty($wpedon_button_scpriceiname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpricei) . "'>" . esc_html($wpedon_button_scpriceiname) . "</option>"; }
		if (!empty($wpedon_button_scpricejname)) { $output .= "<option value='" . esc_attr($wpedon_button_scpricej) . "'>" . esc_html($wpedon_button_scpricejname) . "</option>"; }
		if (!empty($wpedon_button_scpriceprice)) { $output .= "</select><br /><br />"; }
	}

	// override name field if passed as shortcode attribute
	if (!empty($atts['name'])) {
		$name = $atts['name'];
	}

    if (!empty($paypal_connection_data) && $paypal_connection_data['connection_type'] === 'manual') {
        $output .= "<form target='$target' action='https://www.$path.com/cgi-bin/webscr' method='post' class='wpedon-form'>";
        $output .= "<input type='hidden' name='cmd' value='_donations' />";
        $output .= "<input type='hidden' name='business' value='" . esc_attr($account) . "' />";
        $output .= "<input type='hidden' name='currency_code' value='" . esc_attr($currency) . "' />";
        $output .= "<input type='hidden' name='notify_url' value='" . esc_attr($notify_url) . "'>";
        $output .= "<input type='hidden' name='lc' value='" . $language . "'>";
        $output .= "<input type='hidden' name='bn' value='WPPlugin_SP'>";
        $output .= "<input type='hidden' name='return' value='" . esc_attr($return) . "' />";
        $output .= "<input type='hidden' name='cancel_return' value='" . esc_attr($value['cancel']) . "' />";
        $output .= "<input class='wpedon_paypalbuttonimage' type='image' src='" . esc_attr($img) . "' border='0' name='submit' alt='Make your payments with PayPal. It is free, secure, effective.' style='border: none;'>";
        $output .= "<img alt='' border='0' style='border:none;display:none;' src='https://www.paypal.com/$language/i/scr/pixel.gif' width='1' height='1'>";
    } else {
        $form_classes = ['wpedon-form'];
        if ( empty( $paypal_connection_data['advanced_cards'] ) ) {
            $form_classes[] = 'wpedon-form-disabled';
        }
        $form_classes = implode( ' ', $form_classes );
        $output .= "<form class='{$form_classes}' id='{$rand_string}' action='#' method='post'>";
    }
    if ( !empty( $paypal_connection_data ) && $paypal_connection_data['connection_type'] === 'ppcp' ) {
        $output .= wpedon_ppcp_html( $paypal_connection_data, $rand_string );
    }
    if ( !empty( $stripe_account_data )) {
        if ($stripe_account_data['show'] != '2') {
            $message = '';
            if ( isset( $_GET['wpedon_stripe_success'] ) ) {
                if ( $_GET['wpedon_stripe_success'] == 1 ) {
                    $message = '<span class="payment-success">' . __( 'The payment was successful' ) . '</span>';
                } elseif ( $_GET['wpedon_stripe_success'] == 0 ) {
                    if ( isset($_GET['payment_cancelled']) && $_GET['payment_cancelled'] == 1 ) {
                        $message = '<span class="payment-error">' . __( 'The payment was cancelled' ) . '</span>';
                    } else {
                        $message = '<span class="payment-error">' . __( 'An unknown payment error has occurred. Please try again' ) . '</span>';
                    }
                }
            }
            if (isset($stripe_account_data['width'])) {
                $output .= "<style>.wpedon-stripe-button-container >* {max-width: {$stripe_account_data['width']}px !important;}</style>";
            }
            $output .= "<div class='wpedon-stripe-button-container'>";
            $output .= "<a href='#' class='wpedon-stripe-button'><span>" . __( 'Donate with Stripe' ) . "</span></a>";
            $output .= "</div>";
            $output .= "<div class='wpedon-payment-message'>{$message}</div>";
        }
    }
    $output .= "<input type='hidden' name='amount' id='amount_$rand_string' value='" . esc_attr($amount) . "' />";
    $output .= "<input type='hidden' name='price' id='price_$rand_string' value='" . esc_attr($amount) . "' />";
    $output .= "<input type='hidden' name='item_number' value='" . esc_attr($sku) . "' />";
    $output .= "<input type='hidden' name='item_name' value='" . esc_attr($name) . "' />";
    $output .= "<input type='hidden' name='name' value='" . esc_attr($name) . "' />";
	$output .= "<input type='hidden' name='custom' value='" . esc_attr($post_id) . "'>";
    $output .= "<input type='hidden' name='no_shipping' value='" . esc_attr($value['no_shipping']) . "'>";
    $output .= "<input type='hidden' name='no_note' value='" . esc_attr($value['no_note']) . "'>";
    $output .= "<input type='hidden' name='currency_code' value='" . esc_attr($currency) . "'>";
    $output .= "</form>";

	$output .= '</div>';
	return $output;
}


function wpedon_ppcp_html( $connection_data, $rand_string ) {
	$sdk_attr = [
		'client-id' => $connection_data['client_id'],
		'merchant-id' => $connection_data['seller_id'],
		'currency' => $connection_data['currency'],
		'intent' => $connection_data['intent'],
		'components' => 'buttons,funding-eligibility'
	];

	if ( !empty( $connection_data['advanced_cards'] ) ) {
		$sdk_attr['components'] .= ',hosted-fields';
	}

	if ( $connection_data['locale'] !== 'default' ) {
		$sdk_attr['locale'] = $connection_data['locale'];
	}

	$wpedon_paypal_funding = json_encode( $connection_data['enable-funding'] );

	$enable_funding = array_filter( $connection_data['enable-funding'], function($i) { return $i !== 'paypal'; } );
	if ( !empty( $enable_funding ) ) {
		$sdk_attr['enable-funding'] = implode( ',', $enable_funding );
	}

	$sdk_url = add_query_arg( $sdk_attr, 'https://www.paypal.com/sdk/js' );

	ob_start();

	if ( !defined( 'WPEDON_PPCP_JS_SDK_LOADED' ) ) {
		?>
		<script
			src='<?php echo $sdk_url; ?>'
			data-partner-attribution-id='<?php echo $connection_data['bn_code']; ?>'
			<?php if ( !empty( $connection_data['advanced_cards'] ) ) { echo 'data-client-token="' . $connection_data['client_token'] . '"'; } ?>
		></script>
		<style>
        .wpedon-paypal-button-container > *,
        .wpedon-paypal-hosted-fields-container .wpedon-paypal-btn,
        .wpedon-form .wpedon-or {
            width: <?php echo $connection_data['width']; ?>px;
            min-width: <?php echo $connection_data['width']; ?>px;
            max-width: <?php echo $connection_data['width']; ?>px;
        }
        .wpedon-paypal-hosted-fields-container .wpedon-paypal-btn {
            height: <?php echo $connection_data['height']; ?>px;
        }
		</style>
		<script>
      const wpedonPaypalFunding = <?php echo $wpedon_paypal_funding; ?>;
		</script>
		<?php
		define( 'WPEDON_PPCP_JS_SDK_LOADED', 1 );
	}
	?>

	<!-- Buttons container -->
	<div id='wpedon-paypal-button-container-<?php echo $rand_string; ?>' class='wpedon-paypal-button-container wpedon-<?php echo $connection_data['layout']; ?>'></div>

	<?php if ( !empty( $connection_data['advanced_cards'] ) ) { ?>
		<!-- Advanced credit and debit card payments form -->
		<div class="wpedon-or"><span>or</span></div>
		<div id='wpedon-paypal-hosted-fields-container-<?php echo $rand_string; ?>' class='wpedon-paypal-button-container wpedon-paypal-hosted-fields-container wpedon-<?php echo $connection_data['layout']; ?>'>
			<div id="wpedon-card-form-<?php echo $rand_string; ?>" class="wpedon-card-form">
				<div class="card-field-wrapper">
					<div id="number-<?php echo $rand_string; ?>" class="card_field"></div>
				</div>
				<div class="card-field-wrapper">
					<div id="expirationDate-<?php echo $rand_string; ?>" class="card_field"></div>
				</div>
				<div class="card-field-wrapper">
					<div id="cvv-<?php echo $rand_string; ?>" class="card_field"></div>
				</div>
				<div class="card-field-wrapper">
					<input type="text" id="card-holder-first-name-<?php echo $rand_string; ?>" name="card-holder-first-name-<?php echo $rand_string; ?>" autocomplete="off" placeholder="First name" class="card_field" />
				</div>
				<div class="card-field-wrapper">
					<input type="text" id="card-holder-last-name-<?php echo $rand_string; ?>" name="card-holder-last-name-<?php echo $rand_string; ?>" autocomplete="off" placeholder="Last name" class="card_field" />
				</div>
				<div class="card-field-wrapper">
					<div id="postalCode-<?php echo $rand_string; ?>" class="card_field"></div>
				</div>
				<div>
					<button class="wpedon-paypal-btn color-<?php echo $connection_data['color']; ?>"><?php echo $connection_data['acdc_button_text']; ?></button>
				</div>
			</div>
		</div>
	<?php } ?>
	<div id='wpedon-paypal-message-<?php echo $rand_string; ?>' class='wpedon-payment-message'></div>




	<script>
    const message_<?php echo $rand_string; ?> = document.getElementById('wpedon-paypal-message-<?php echo $rand_string; ?>');
    if ( typeof paypal === 'undefined' ) {
      message_<?php echo $rand_string; ?>.innerHTML = '<span class="payment-error">An error occurred while connecting PayPal SDK. Check the plugin settings.</span>';
      throw 'An error occurred while connecting PayPal SDK. Check the plugin settings.';
    }

    paypal.getFundingSources().forEach(function (fundingSource) {
      if ( wpedonPaypalFunding.indexOf(fundingSource) > -1 ) {
        const style = {
          shape: '<?php echo $connection_data['shape']; ?>',
          label: 'donate',
          height: <?php echo $connection_data['height']; ?>
        };

        if ( fundingSource !== 'card' ) {
          let color = '<?php echo $connection_data['color']; ?>';
          if (fundingSource === 'venmo' && color === 'gold') {
            color = 'blue';
          } else if (['ideal', 'bancontact', 'giropay', 'eps', 'sofort', 'mybank', 'p24'].indexOf(fundingSource) > -1 && ['gold', 'blue'].indexOf(color) > -1) {
            color = 'default';
          } else if (fundingSource === 'credit' && ['darkblue', 'black', 'white'].indexOf(color) === -1) {
              color = 'darkblue';
          }
          style.color = color;
        }

        const button = paypal.Buttons({
          fundingSource: fundingSource,
          style: style,
          createOrder: function() {
            message_<?php echo $rand_string; ?>.innerHTML = '';

            const form = document.getElementById('<?php echo $rand_string; ?>');
            const formData = new FormData(form);
            formData.append('action', 'wpedon-ppcp-order-create');
            formData.append('nonce', wpedon.nonce);

            return fetch(wpedon.ajaxUrl, {
              method: 'post',
              body: formData
            }).then(function(response) {
              return response.json();
            }).then(function(data) {
              let orderID = false;
              if (data.success && data.data.order_id) {
                orderID = data.data.order_id;
              } else {
                throw data.data && data.data.message ? data.data.message : 'An unknown error occurred while creating the order. Please reload the page and try again.';
              }
              return orderID;
            });
          },
          onApprove: function(data) {
            const formData = new FormData();

            formData.append('action', 'wpedon-ppcp-order-finalize');
            formData.append('nonce', wpedon.nonce);
            formData.append('order_id', data.orderID);

            return fetch(wpedon.ajaxUrl, {
              method: 'post',
              body: formData
            }).then(function(response) {
              return response.json();
            }).then(function(data) {
              if (data.success) {
			    var return_url = '<?= $connection_data['return']; ?>';
                if (return_url.length && fundingSource !== 'card') {
                  window.location.href = return_url;
                } else {
                  message_<?php echo $rand_string; ?>.innerHTML = '<span class="payment-success">The payment was successful</span>';
                }
              } else {
                throw data.data.message;
              }
            });
          },
          onCancel: function() {
            if (wpedon.cancel.length && fundingSource !== 'card') {
              window.location.href = wpedon.cancel;
            } else {
              message_<?php echo $rand_string; ?>.innerHTML = '<span class="payment-error">Payment Cancelled.</span>';
            }
          },
          onError: function (error) {
            message_<?php echo $rand_string; ?>.innerHTML = '<span class="payment-error">' + (error ? error : '<?php echo wpedon_free_ppcp_js_sdk_error_message(); ?>') + '</span>';
          }
        });

        if (button.isEligible()) {
          button.render('#wpedon-paypal-button-container-<?php echo $rand_string; ?>');
        }
      }
    });

		<?php if ( !empty( $connection_data['advanced_cards'] ) ) { ?>
    if ( paypal.HostedFields.isEligible() ) {
      const cardForm_<?php echo $rand_string; ?> = document.querySelector("#wpedon-card-form-<?php echo $rand_string; ?>"),
        firstName_<?php echo $rand_string; ?> = document.getElementById('card-holder-first-name-<?php echo $rand_string; ?>'),
        lastName_<?php echo $rand_string; ?> = document.getElementById('card-holder-last-name-<?php echo $rand_string; ?>');

      firstName_<?php echo $rand_string; ?>.addEventListener('input', (e) => {
        if (e.target.value.length === 0) {
          e.target.classList.add('invalid');
        } else {
          e.target.classList.remove('invalid');
        }
      });

      lastName_<?php echo $rand_string; ?>.addEventListener('input', (e) => {
        if (e.target.value.length === 0) {
          e.target.classList.add('invalid');
        } else {
          e.target.classList.remove('invalid');
        }
      });

      let orderId_<?php echo $rand_string; ?>;
      paypal.HostedFields.render({
        styles: {
          '.invalid': {
            'color': 'red'
          }
        },
        fields: {
          number: {
            selector: "#number-<?php echo $rand_string; ?>",
            placeholder: "Card Number"
          },
          expirationDate: {
            selector: "#expirationDate-<?php echo $rand_string; ?>",
            placeholder: "Expiration"
          },
          cvv: {
            selector: "#cvv-<?php echo $rand_string; ?>",
            placeholder: "CVV"
          },
          postalCode: {
            selector: "#postalCode-<?php echo $rand_string; ?>",
            placeholder: "Billing zip code / Postal code"
          }
        },
        createOrder: function() {
          if ( cardForm_<?php echo $rand_string; ?>.classList.contains('processing') ) return false;
          cardForm_<?php echo $rand_string; ?>.classList.add('processing');

          message_<?php echo $rand_string; ?>.innerHTML = '';

          const form = document.getElementById('<?php echo $rand_string; ?>');
          const formData = new FormData(form);
          formData.append('action', 'wpedon-ppcp-order-create');
          formData.append('nonce', wpedon.nonce);

          return fetch(wpedon.ajaxUrl, {
            method: 'post',
            body: formData
          }).then(function(response) {
            return response.json();
          }).then(function(data) {
            if (data.success && data.data.order_id) {
              orderId_<?php echo $rand_string; ?> = data.data.order_id;
            } else {
              throw data.data && data.data.message ? data.data.message : 'An unknown error occurred while creating the order. Please reload the page and try again.';
            }
            return orderId_<?php echo $rand_string; ?>;
          });
        }
      }).then(function(cardFields) {
        cardFields.on('validityChange', function (event) {
          const field = event.fields[event.emittedBy];
          if (field.isEmpty || !field.isValid) {
            cardFields.addClass(event.emittedBy, 'invalid');
            document.getElementById(event.emittedBy + '-<?php echo $rand_string; ?>').classList.add('invalid');
          } else {
            cardFields.removeClass(event.emittedBy, 'invalid');
            document.getElementById(event.emittedBy + '-<?php echo $rand_string; ?>').classList.remove('invalid');
          }
        });

        document.getElementById("<?php echo $rand_string; ?>").addEventListener('submit', (e) => {
          e.preventDefault();

          let formValid = true;

          const state = cardFields.getState();
          for (let k in state.fields) {
            if (!state.fields[k].isValid) {
              formValid = false;
              cardFields.addClass(k, 'invalid');
              document.getElementById(k + '-<?php echo $rand_string; ?>').classList.add('invalid');
            } else {
              cardFields.removeClass(k, 'invalid');
              document.getElementById(k + '-<?php echo $rand_string; ?>').classList.remove('invalid');
            }
          }

          if (firstName_<?php echo $rand_string; ?>.value.length === 0) {
            formValid = false;
            firstName_<?php echo $rand_string; ?>.classList.add('invalid');
          } else {
            firstName_<?php echo $rand_string; ?>.classList.remove('invalid');
          }

          if (lastName_<?php echo $rand_string; ?>.value.length === 0) {
            formValid = false;
            lastName_<?php echo $rand_string; ?>.classList.add('invalid');
          } else {
            lastName_<?php echo $rand_string; ?>.classList.remove('invalid');
          }

          if (!formValid) {
            message_<?php echo $rand_string; ?>.innerHTML = '<span class="payment-error">Please correct the errors in the fields above.</span>';
            return false;
          }

          cardFields.submit({
            cardholderName: firstName_<?php echo $rand_string; ?>.value + ' ' + lastName_<?php echo $rand_string; ?>.value
          }).then(function () {
            const formData = new FormData();

            formData.append('action', 'wpedon-ppcp-order-finalize');
            formData.append('nonce', wpedon.nonce);
            formData.append('order_id', orderId_<?php echo $rand_string; ?>);
            formData.append('acdc', true);

            return fetch(wpedon.ajaxUrl, {
              method: 'post',
              body: formData
            }).then(function(res) {
              return res.json();
            }).then(function (data) {
              if (data.success) {
			    var return_url = '<?= $connection_data['return']; ?>';
                if (return_url.length) {
                  window.location.href = return_url;
                } else {
                  message_<?php echo $rand_string; ?>.innerHTML = '<span class="payment-success">The payment was successful</span>';
                }
              } else {
                throw {message: data.data.message};
              }
              cardForm_<?php echo $rand_string; ?>.classList.remove('processing');
            })
          }).catch(function (error) {
            console.error(error);
            let message = '';
            if (error && error.details) {
              let errors = {};
              for (let k in error.details) {
                let fieldName = '';
                let messageItem = new Array();
                if (error.details[k].field) {
                  if (error.details[k].field.indexOf('payment_source/card/number') > -1) {
                    cardFields.addClass('number', 'invalid');
                    document.getElementById('number-<?php echo $rand_string; ?>').classList.add('invalid');
                  } else if (error.details[k].field.indexOf('payment_source/card/security_code') > -1) {
                    cardFields.addClass('cvv', 'invalid');
                    document.getElementById('cvv-<?php echo $rand_string; ?>').classList.add('invalid');
                  } else if (error.details[k].field.indexOf('payment_source/card/expiry') > -1) {
                    cardFields.addClass('expirationDate', 'invalid');
                    document.getElementById('expirationDate-<?php echo $rand_string; ?>').classList.add('invalid');
                  }

                  fieldName = error.details[k].field
                    .replace('/payment_source/card/expiry', 'Expiration')
                    .replace('/payment_source/card/security_code', 'CVV')
                    .replace('payment_source/card/security_code', 'CVV')
                    .replace('/payment_source/card/number', 'Card Number');
                  messageItem.push('<strong>' + fieldName + '</strong>');
                }
                if (error.details[k].description) {
                  messageItem.push(error.details[k].description);
                }
                errors[fieldName] = messageItem.join(': ');
              }
              message = Object.values(errors).join('<br>');
            } else if ( error && error.message ) {
              message = error.message;
            } else {
              message = '<?php echo wpedon_free_ppcp_js_sdk_error_message(); ?>';
            }
            message_<?php echo $rand_string; ?>.innerHTML = '<span class="payment-error">' + message + '</span>';
            cardForm_<?php echo $rand_string; ?>.classList.remove('processing');
          });
        });
      });
    } else {
      // Hides card fields if the merchant isn't eligible
      document.querySelector("#wpedon-card-form-<?php echo $rand_string; ?>").style = 'display: none';
    }
		<?php } ?>
	</script>
	
	
	
	<?php

	return ob_get_clean();
}

function wpedon_free_ppcp_js_sdk_error_message() {
	return '<strong>Site admin</strong>, an error was detected in the plugin settings.</br>Please check the PayPal connection and product settings (price, name, etc.)';
}