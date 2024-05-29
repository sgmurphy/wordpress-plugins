<?php

namespace WPEasyDonation\Helpers;

class Func
{
	/**
	 * currency code to iso
	 * @param $code
	 * @return string
	 */
	public static function currency_code_to_iso($code): string
	{
		$currencies = [
			'1' => 'AUD',
			'2' => 'BRL',
			'3' => 'CAD',
			'4' => 'CZK',
			'5' => 'DKK',
			'6' => 'EUR',
			'7' => 'HKD',
			'8' => 'HUF',
			'9' => 'ILS',
			'10' => 'JPY',
			'11' => 'MYR',
			'12' => 'MXN',
			'13' => 'NOK',
			'14' => 'NZD',
			'15' => 'PHP',
			'16' => 'PLN',
			'17' => 'GBP',
			'18' => 'RUB',
			'19' => 'SGD',
			'20' => 'SEK',
			'21' => 'CHF',
			'22' => 'TWD',
			'23' => 'THB',
			'24' => 'TRY',
			'25' => 'USD'
		];

		return !empty( $currencies[$code] ) ? $currencies[$code] : 'USD';
	}

	/**
	 * language to locale
	 * @param $code
	 * @return string[]
	 */
	public static function language_to_locale( $code ): array
	{
		switch ( $code ) {
			// Danish
			case '1':
				$language = "da_DK";
				$imagea = "https://www.paypal.com/da_DK/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/da_DK/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/da_DK/DK/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Dutch
			case '2':
				$language = "nl_BE";
				$imagea = "https://www.paypal.com/nl_NL/NL/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/nl_NL/NL/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/nl_NL/NL/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// English
			case '3':
				$language = "en_US";
				$imagea = "https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// French
			case '4':
				$language = "fr_CA";
				$imagea = "https://www.paypal.com/fr_CA/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/fr_CA/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/fr_CA/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// German
			case '5':
				$language = "de_DE";
				$imagea = "https://www.paypal.com/de_DE/DE/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/de_DE/DE/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Hebrew
			case '6':
				$language = "he_IL";
				$imagea = "https://www.paypal.com/he_IL/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/he_IL/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/he_IL/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Italian
			case '7':
				$language = "it_IT";
				$imagea = "https://www.paypal.com/it_IT/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/it_IT/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/it_IT/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Japanese
			case '8':
				$language = "ja_JP";
				$imagea = "https://www.paypal.com/ja_JP/JP/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/ja_JP/JP/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/ja_JP/JP/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Norwegian
			case '9':
				$language = "no_NO";$imagea = "https://www.paypal.com/no_NO/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/no_NO/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/no_NO/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Polish
			case '10':
				$language = "pl_PL";
				$imagea = "https://www.paypal.com/pl_PL/PL/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/pl_PL/PL/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/pl_PL/PL/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Portuguese
			case '11':
				$language = "pt_BR";
				$imagea = "https://www.paypal.com/pt_PT/PT/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/pt_PT/PT/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/pt_PT/PT/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// russian
			case '12':
				$language = "ru_RU";
				$imagea = "https://www.paypal.com/ru_RU/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/ru_RU/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/ru_RU/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Spanish
			case '13':
				$language = "es_ES";
				$imagea = "https://www.paypal.com/es_ES/ES/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/es_ES/ES/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/es_ES/ES/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Swedish
			case '14':
				$language = "sv_SE";
				$imagea = "https://www.paypal.com/sv_SE/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/sv_SE/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/sv_SE/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Simplified Chinese - China
			case '15':
				$language = "zh_CN";
				$imagea = "https://www.paypal.com/zh_XC/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/zh_XC/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/zh_XC/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Traditional Chinese - Hong Kong
			case '16':
				$language = "zh_HK";
				$imagea = "https://www.paypal.com/zh_HK/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/zh_HK/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/zh_HK/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Traditional Chinese - Taiwan
			case '17':
				$language = "zh_TW";
				$imagea = "https://www.paypalobjects.com/en_US/TW/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypalobjects.com/en_US/TW/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypalobjects.com/en_US/TW/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Turkish
			case '18':
				$language = "tr_TR";
				$imagea = "https://www.paypal.com/tr_TR/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/tr_TR/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/tr_TR/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Thai
			case '19':
				$language = "th_TH";
				$imagea = "https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// English - UK
			case '20':
				$language = "en_GB";
				$imagea = "https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
				break;

			// Default
			default:
				$language = 'default';
				$imagea = "https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif";
				$imageb = "https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif";
				$imagec = "https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif";
				$imaged = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png";
				$imagee = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png";
				$imagef = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png";
				$imageg = "https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png";
		}

		return [
			'locale' => $language,
			'imagea' => $imagea,
			'imageb' => $imageb,
			'imagec' => $imagec,
			'imaged' => $imaged,
			'imagee' => $imagee,
			'imagef' => $imagef,
			'imageg' => $imageg,
		];
	}

	/**
	 * zero decimal currencies
	 * @return string[]
	 */
	public static function zero_decimal_currencies () {
		return [
			'BIF',
			'CLP',
			'DJF',
			'GNF',
			'JPY',
			'KMF',
			'KRW',
			'MGA',
			'PYG',
			'RWF',
			'UGX',
			'VND',
			'VUV',
			'XAF',
			'XOF',
			'XPF'
		];
	}

	/**
	 * format stripe amount
	 * @param $amount
	 * @param $currency
	 * @return float|int
	 */
	public static function format_stripe_amount( $amount, $currency ) {
		$zero_decimal_currencies = self::zero_decimal_currencies();

		$amount = round( floatval( $amount ), 2 );
		if ( !in_array( strtoupper( $currency ), $zero_decimal_currencies ) ) {
			$amount = $amount * 100;
		}

		return $amount;
	}
}