<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// エラー
	$flg_error		=	false;
	
	// API URL
	$check_item		=	array('favicon-api', 'thumbnail-api' );
	foreach($check_item as $key ) {
		$temp_url	=	$this->options[$key] ? $this->options[$key] : $this->defaults[$key];
		$temp_url	=	$this->pz_EncodeURL($temp_url );
		$temp_url	=	preg_replace( array('/%DOMAIN%/i', '/%DOMAIN_URL%/i', '/%URL%/i' ), array('%DOMAIN%', '%DOMAIN_URL%', '%URL%'), $temp_url );	// パラメータ文字を大文字にする
		$temp_url	=	wp_http_validate_url($temp_url );
		$this->options[$key]	=	$temp_url;
	}
	
	// 追加CSS用URL
	$key			=	'css-add-url';
	$temp_url		=	isset($this->options[$key] ) ? $this->options[$key] : null ;
	$temp_url		=	$this->pz_EncodeURL($temp_url );
	$temp_url		=	wp_http_validate_url($temp_url );
	$this->options[$key]		=	$temp_url;
	
	// 数値
	$this->options['trim-title']		=	pz_TrimNum($this->options['trim-title'] );
	$this->options['trim-url']			=	pz_TrimNum($this->options['trim-url'] );
	$this->options['trim-excerpt']		=	pz_TrimNum($this->options['trim-excerpt'] );
	$this->options['trim-info']			=	pz_TrimNum($this->options['trim-info'] );
	
	// 数値（px）
	$this->options['width']				=	pz_TrimNumPx($this->options['width'] );				// カード幅
	$this->options['content-height']	=	pz_TrimNumPx($this->options['content-height'] );	// 記事の高さ
	$this->options['size-title']		=	pz_TrimNumPx($this->options['size-title'] );
	$this->options['size-url']			=	pz_TrimNumPx($this->options['size-url'] );
	$this->options['size-excerpt']		=	pz_TrimNumPx($this->options['size-excerpt'] );
	$this->options['size-more']			=	pz_TrimNumPx($this->options['size-more'] );
	$this->options['size-info']			=	pz_TrimNumPx($this->options['size-info'] );
	$this->options['size-added']		=	pz_TrimNumPx($this->options['size-added'] );
	$this->options['height-title']		=	pz_TrimNumPx($this->options['height-title'] );
	$this->options['height-url']		=	pz_TrimNumPx($this->options['height-url'] );
	$this->options['height-excerpt']	=	pz_TrimNumPx($this->options['height-excerpt'] );
	$this->options['height-more']		=	pz_TrimNumPx($this->options['height-more'] );
	$this->options['height-info']		=	pz_TrimNumPx($this->options['height-info'] );
	$this->options['height-added']		=	pz_TrimNumPx($this->options['height-added'] );
	$this->options['thumbnail-width']	=	pz_TrimNumPx($this->options['thumbnail-width'] );
	$this->options['thumbnail-height']	=	pz_TrimNumPx($this->options['thumbnail-height'] );
	$this->options['border-width']		=	pz_TrimNumPx($this->options['border-width'] );

	// エラー状態のチェック
	$temp		=	$this->options['error-time'];
	if	(!is_numeric($temp ) ) {
		$temp	=	@strtotime($temp );
	}
	if	($temp	<	946728000 ) {
		$temp	=	'';
	}
	$this->options['error-time']		=	$temp;
	if	($temp ) {
		$this->options['error-mode']	=	'1';
	} else {
		$this->options['error-mode']	=	null;
	}


//<a class="pz-header-title-text" href="

//<b>Warning</b>:  Undefined property: class_pz_linkcard::$author in <b>/home/popozure/popozure.xsrv.jp/public_html/develop/wp-content/plugins/pz-linkcard/lib/pz-linkcard-settings.php</b> on line <b>14</b><br /><br />
//<b>Warning</b>:  Trying to access array offset on value of type null in <b>/home/popozure/popozure.xsrv.jp/public_html/develop/wp-content/plugins/pz-linkcard/lib/pz-linkcard-settings.php</b> on line <b>14</b><br />/pz-linkcard-manager

//" rel="external noopener help" target="_blank">
