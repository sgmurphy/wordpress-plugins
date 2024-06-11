<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// エラー
	$flg_error					=	false;
	
	// API URL
	$check_item					=	array('favicon-api', 'thumbnail-api' );
	foreach($check_item			as	$key ) {
		$temp_value				=	isset($this->options[$key] )	?	$this->options[$key]	:	self::DEFAULTS[$key];
		$temp_value				=	$this->pz_EncodeURL($temp_value );
		$temp_value				=	preg_replace( array('/%DOMAIN%/i', '/%DOMAIN_URL%/i', '/%URL%/i' ), array('%DOMAIN%', '%DOMAIN_URL%', '%URL%'), $temp_value );	// パラメータ文字を大文字にする
		$temp_value				=	wp_http_validate_url($temp_value );
		$this->options[$key]	=	$temp_value;
	}
	
	// 追加CSS用URL
	$check_item					=	array('css-add-url' );
	foreach($check_item			as	$key ) {
		$temp_value				=	isset($this->options[$key] )	?	
		$this->options[$key]	:	
		self::DEFAULTS[$key];
		$temp_value				=	$this->pz_EncodeURL($temp_value );
		$temp_value				=	wp_http_validate_url($temp_value );
		$this->options[$key]	=	$temp_value;
	}
	
	// 数値
	$check_item					=	array('title-trim', 'url-trim', 'excerpt-trim', 'info-trim' );
	foreach($check_item			as	$key ) {
		$temp_value				=	isset($this->options[$key] )	?	$this->options[$key]	:	self::DEFAULTS[$key];
		$this->options[$key]	=	pz_TrimNum($temp_value );
	}
	
	// 数値（px）
	$check_item					=	array('width', 'content-height', 'title-size', 'url-size', 'excerpt-size', 'more-size', 'info-size', 'added-size', 'title-height', 'url-height', 'excerpt-height', 'more-height', 'info-height', 'added-height', 'thumbnail-height', 'thumbnail-width', 'border-width' );
	foreach($check_item			as	$key ) {
		$temp_value				=	isset($this->options[$key] )	?	$this->options[$key]	:	self::DEFAULTS[$key];
		$this->options[$key]	=	pz_TrimNumPx($temp_value );
	}
	
	// 色コード
	$check_item					=	array('title-color', 'title-outline-color', 'url-color', 'url-outline-color', 'excerpt-color', 'excerpt-outline-color', 'more-color', 'more-outline-color', 'info-color', 'info-outline-color', 'added-color', 'added-outline-color', 'ex-border-color', 'ex-bg-color', 'in-border-color', 'in-bg-color', 'th-border-color', 'th-bg-color' );
	foreach($check_item as $key ) {
		$temp_value				=	isset($this->options[$key] )	?	$this->options[$key]	:	self::DEFAULTS[$key];
		$temp_value				=	preg_replace('/^#([0-9a-f])([0-9a-f])([0-9a-f])$/i', '#$1$1$2$2$3$3', $temp_value );
		if	(preg_match('/^#[0-9a-f]{6}$/i', $temp_value ) ) {
			$temp_value			=	strtolower($temp_value );
		}
		$this->options[$key]	=	$temp_value;
	}

	// エラー状態のチェック
	$temp		=	$this->options['error-time'];
	if	(!is_numeric($temp ) ) {
		$temp	=	@strtotime($temp );
	}
	if	($temp	<	946728000 ) {
		$temp	=	'';
	}
	$this->options['error-time']		=	$temp;
