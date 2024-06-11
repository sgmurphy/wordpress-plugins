<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	$result		=	0;

	if (!isset($this->options['style']) || !$this->options['style']) {
		$css_path	=	$this->options['css-path'];
		$css_temp	=	$this->options['css-templete'];

		// テンプレートファイルの読み込み
		$file_text	=	file_get_contents($css_temp);
		if ($file_text) {
			// かんたん書式設定
			switch ($this->options['special-format']) {
			case 'LkC': // Pz-LkC Default
				$file_text		=	str_replace('/*EX-IMAGE*/',			'background-image: linear-gradient(#78f 0%, #78f 10%, #fff 30%);', $file_text );
				$file_text		=	str_replace('/*IN-IMAGE*/',			'background-image: linear-gradient(#ca4 0%, #ca4 10%, #fff 30%);', $file_text );
				$file_text		=	str_replace('/*TH-IMAGE*/',			'background-image: linear-gradient(#ca4 0%, #ca4 10%, #eee 30%);', $file_text );
				if	($this->options['info-position'] === '1') {
					$file_text	=	str_replace('/*INFO-COLOR*/',		'color: #fff;', $file_text );
					$file_text	=	str_replace('/*ADDED-COLOR*/',		'color: #fff;', $file_text );
				}
				break;
			case 'hbc': // ノーマル（はてなブログカード風）
				$file_text	=	str_replace('/*EX-BORDER*/',			'border: 1px solid rgba(0,0,0,0.1);', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/',			'border: 1px solid rgba(0,0,0,0.1);', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/',			'border: 1px solid rgba(0,0,0,0.1);', $file_text );
				$file_text	=	str_replace('/*RADIUS*/',				'border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px;', $file_text );
				$file_text	=	str_replace('/*SHADOW*/',				'box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);', $file_text );
				break;
			case 'smp': // Simple（サムネイルとタイトル）
				$file_text	=	str_replace('/*EX-BORDER*/',			'border: none;', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/',			'border: none;', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/',			'border: none;', $file_text );
				$file_text	=	str_replace('/*NONE-INFO*/',			'display: none !important;', $file_text );
				$file_text	=	str_replace('/*NONE-EXCERPT*/',			'display: none !important;', $file_text );
				break;
			case 'cmp': // コンパクト（Twitter風）
				$file_text	=	str_replace('/*EX-BORDER*/',			'border: 1px solid rgba(0,0,0,0.1);', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/',			'border: 1px solid rgba(0,0,0,0.1);', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/',			'border: 1px solid rgba(0,0,0,0.1);', $file_text );
				$file_text	=	str_replace('/*CONTENT-HEIGHT*/',		'height: 108px;', $file_text );
				$file_text	=	str_replace('/*WRAP-MARGIN*/',			'margin: 0;', $file_text );
				$file_text	=	str_replace('/*PADDING*/',				'padding: 0;', $file_text );
				$file_text	=	str_replace('/*RADIUS*/',				'border-radius: 16px; -webkit-border-radius: 16px; -moz-border-radius: 16px;', $file_text );
				$file_text	=	str_replace('/*CARD-TOP*/',				'margin: 0;', $file_text );
				$file_text	=	str_replace('/*CARD-BOTTOM*/',			'', $file_text );
				$file_text	=	str_replace('/*CARD-LEFT*/',			'', $file_text );
				$file_text	=	str_replace('/*CARD-RIGHT*/',			'', $file_text );
				$file_text	=	str_replace('/*MARGIN-TITLE*/',			'margin: 30px 0 0 108px;', $file_text );
				$file_text	=	str_replace('/*MARGIN-URL*/',			'margin: 0 0 0 108px;', $file_text );
				$file_text	=	str_replace('/*MARGIN-EXCERPT*/',		'margin: 0 0 0 108px;', $file_text );
				$file_text	=	str_replace('/*CONTENT-PADDING*/',		'padding: 0;', $file_text );
				$file_text	=	str_replace('/*CONTENT-MARGIN*/',		'margin: 0;', $file_text );
				$content_height		= intval(preg_replace('/[^0-9]/', '', isset($this->options['content-height'] ) ? $this->options['content-height']  : self::DEFAULTS['content-height']  ) );
				$file_text	=	str_replace('/*THUMBNAIL-WIDTH*/',		'display: block; overflow: hidden;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-HEIGHT*/',		'height: 108px;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-IMG-WIDTH*/',	'width: 100px;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-IMG-HEIGHT*/',	'height: 108px;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-POSITION*/',	'float: left;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-MARGIN*/',		'margin: 0 8px 0 0;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 16px 0 0 16px;', $file_text );
				$file_text	=	str_replace('/*POSITION-INFO*/',		'position: absolute; top: 8px; left: 108px;', $file_text );
				break;
			case 'JIN': // 見出し（テーマJIN風）
				$file_text	=	str_replace('/*MARGIN-TOP*/',			'margin: 24px auto 30px auto;', $file_text );
				$file_text	=	str_replace('/*MARGIN-BOTTOM*/',		'', $file_text );
				$file_text	=	str_replace('/*MARGIN-LEFT*/',			'', $file_text );
				$file_text	=	str_replace('/*MARGIN-RIGHT*/',			'', $file_text );
				$file_text	=	str_replace('/*CARD-TOP*/',				'margin: 24px 20px 20px 20px;', $file_text );
				$file_text	=	str_replace('/*CARD-BOTTOM*/',			'', $file_text );
				$file_text	=	str_replace('/*CARD-LEFT*/',			'', $file_text );
				$file_text	=	str_replace('/*CARD-RIGHT*/',			'', $file_text );
				$file_text	=	str_replace('/*WIDTH*/',				'max-width: 96%;', $file_text );
				$file_text	=	str_replace('/*RADIUS*/',				'border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px;', $file_text );
				$file_text	=	str_replace('/*WRAP-MARGIN*/',			'margin: 0 auto;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL- WIDTH*/',		'max-width: 150px;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL- HEIGHT*/',	'height: 108px; overflow: hidden;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL- IMG-WIDTH*/',	'width: 150px;', $file_text );
				$file_text	=	str_replace('/*HOVER*/',				'opacity: 0.8;', $file_text );
				$file_text	=	str_replace('/*OPTION*/',				'.linkcard p { display: none; }', $file_text );
				$file_text	=	str_replace('/*ADDED-COLOR*/',			'color: #fff;', $file_text );
				$file_text	=	str_replace('/*ADDED-SIZE*/',			'font-size: 12px;', $file_text );
				$file_text	=	str_replace('/*ADDED-HEIGHT*/',			'line-height: 30px;', $file_text );
				$added_height	=	intval(preg_replace('/[^0-9]/', '', isset($this->options['added-height'] ) ? $this->options['added-height']  : self::DEFAULTS['added-height']  ) );
				$heading_height	=	intval( $added_height / 2 );
				$heading_padding =	intval( $added_height / 4 );
				$file_text		=	str_replace('/*EX-HEADING*/',		'position: absolute; top: -15px; left: 20px; padding: 0 10px; background-color: '.$this->options['ex-border-color'].'; border-radius: 2px;', $file_text );
				$file_text		=	str_replace('/*IN-HEADING*/',		'position: absolute; top: -15px; left: 20px; padding: 0 10px; background-color: '.$this->options['in-border-color'].'; border-radius: 2px;', $file_text );
				$file_text		=	str_replace('/*TH-HEADING*/',		'position: absolute; top: -15px; left: 20px; padding: 0 10px; background-color: '.$this->options['th-border-color'].'; border-radius: 2px;', $file_text );
				if (isset($this->options['thumbnail-resize']) && $this->options['thumbnail-resize'] == '1') {
					$size_title			=	intval(preg_replace('/[^0-9]/', '', isset($this->options['title-size']) ? $this->options['title-size'] : self::DEFAULTS['title-size'] ) );
					$size_excerpt		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['excerpt-size']) ? $this->options['excerpt-size'] : self::DEFAULTS['excerpt-size'] ) );
					$height_title		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['title-height']) ? $this->options['title-height'] : self::DEFAULTS['title-height'] ) );
					$height_excerpt		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['excerpt-height']) ? $this->options['excerpt-height'] : self::DEFAULTS['excerpt-height'] ) );
					$thumbnail_width	=	150;
					$file_text	=	str_replace('/*RESIZE*/',
						'@media screen and (max-width: 767px)  { .lkc-internal-wrap { max-width: 100% } .lkc-external-wrap { max-width: 100% } .lkc-this-wrap { max-width: 100% } .lkc-title { font-size: '.intval($size_title * 0.9).'px; line-height: '.intval($height_title * 0.9).'px; } .lkc-excerpt { font-size: '.intval($size_excerpt * 0.95).'px; } .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.9).'px; } .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.9).'px; } }'.
						'@media screen and (max-width: 512px)  { .lkc-internal-wrap { max-width: 100% } .lkc-external-wrap { max-width: 100% } .lkc-this-wrap { max-width: 100% } .lkc-title { font-size: '.intval($size_title * 0.8).'px; line-height: '.intval($height_title * 0.8).'px; } .lkc-excerpt { font-size: '.intval($size_excerpt * 0.80).'px; } .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.7).'px; } .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.7).'px; } }'.
						'@media screen and (max-width: 320px)  { .lkc-internal-wrap { max-width: 100% } .lkc-external-wrap { max-width: 100% } .lkc-this-wrap { max-width: 100% } .lkc-title { font-size: '.intval($size_title * 0.7).'px; line-height: '.intval($height_title * 0.7).'px; } .lkc-excerpt { font-size: '.intval($size_excerpt * 0.60).'px; } .lkc-thumbnail { max-width: '.intval($thumbnail_width * 0.5).'px; } .lkc-thumbnail-img { max-width: '.intval($thumbnail_width * 0.5).'px; } }', $file_text );
				}
				$file_text		=	str_replace('/*SCALE*/',		'transform: scale(1.1);', $file_text );
				$file_text		=	str_replace('/*TRANSFORM*/',	'-webkit-transition: color 0.4s ease, background 0.4s ease, transform 0.4s ease, opacity 0.4s ease, border 0.4s ease, padding 0.4s ease, left 0.4s ease, box-shadow 0.4s ease; transition: color 0.4s ease, background 0.4s ease, transform 0.4s ease, opacity 0.4s ease, border 0.4s ease, padding 0.4s ease, left 0.4s ease, box-shadow 0.4s ease;', $file_text );
				break;
			case 'ecl': // 囲み
				$css	=	'.lkc-external-wrap         , .lkc-internal-wrap         , .lkc-this-wrap         { transition: all 0.7s ease-in-out; border-width: 2px; }';
				$css	.=	'.lkc-external-wrap::before , .lkc-internal-wrap::before , .lkc-this-wrap::before { content: ""; display: block; position: absolute; border: 2px solid #888888; box-sizing: border-box; width: 24px; height: 24px; transition: all 0.7s ease-in-out; top: -6px; left: -6px; border-width: 2px 0 0 2px; }';
				$css	.=	'.lkc-external-wrap::after  , .lkc-internal-wrap::after  , .lkc-this-wrap::after  { content: ""; display: block; position: absolute; border: 2px solid #888888; box-sizing: border-box; width: 24px; height: 24px; transition: all 0.7s ease-in-out; bottom: -6px; right: -6px; border-width: 0 2px 2px 0; }';
				$css	.=	'.lkc-external-wrap:hover         { border-color: '.$this->options['ex-bg-color'].'; }';
				$css	.=	'.lkc-internal-wrap:hover         { border-color: '.$this->options['in-bg-color'].'; }';
				$css	.=	'.lkc-this-wrap:hover             { border-color: '.$this->options['th-bg-color'].'; }';
				$css	.=	'.lkc-external-wrap:hover::before { width: calc(100% + 12px); height: calc(100% + 12px); border-color: '.$this->options['ex-bg-color'].'; }';
				$css	.=	'.lkc-internal-wrap:hover::before { width: calc(100% + 12px); height: calc(100% + 12px); border-color: '.$this->options['in-bg-color'].'; }';
				$css	.=	'.lkc-this-wrap:hover::before     { width: calc(100% + 12px); height: calc(100% + 12px); border-color: '.$this->options['th-bg-color'].'; }';
				$css	.=	'.lkc-external-wrap:hover::after  { width: calc(100% + 12px); height: calc(100% + 12px); border-color: '.$this->options['ex-bg-color'].'; }';
				$css	.=	'.lkc-internal-wrap:hover::after  { width: calc(100% + 12px); height: calc(100% + 12px); border-color: '.$this->options['in-bg-color'].'; }';
				$css	.=	'.lkc-this-wrap:hover::after      { width: calc(100% + 12px); height: calc(100% + 12px); border-color: '.$this->options['th-bg-color'].'; }';
				$file_text	=	str_replace('/*OPTION*/',			$css, $file_text );
				break;
			case 'ref': // 反射
				$css	=	'.lkc-external-wrap               , .lkc-internal-wrap               , .lkc-this-wrap               { overflow: hidden; }';
				$css	.=	'.lkc-external-wrap:hover::before , .lkc-internal-wrap:hover::before , .lkc-this-wrap:hover::before { margin-left: 300% ; }';
				$css	.=	'.lkc-external-wrap::before       , .lkc-internal-wrap::before       , .lkc-this-wrap::before       { content: ""; display: block; width: 500px; height: 120px; position: absolute; top: -10px; left: -500px; transform: rotate(-45deg); transition: all .3s ease-in-out; }';
				$css	.=	'.lkc-external-wrap::before { background: '.$this->options['ex-border-color'].';';
				$css	.=	'.lkc-internal-wrap::before { background: '.$this->options['in-border-color'].';';
				$css	.=	'.lkc-this-wrap::before     { background: '.$this->options['th-border-color'].';';
				$file_text	=	str_replace('/*OPTION*/', $css, $file_text );
				break;
			case 'wxp': // Windows XP
				$file_text	=	str_replace('/*EX-BORDER*/',		'border: none;', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/',		'border: none;', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/',		'border: none;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-MARGIN*/',	'margin: 0 8px;', $file_text );
				$file_text	=	str_replace('/*CONTENT-MARGIN*/',	'margin: 8px 0;', $file_text );
				$css	=	'.lkc-external-wrap a , .lkc-internal-wrap a , .lkc-this-wrap a { cursor: default; }';
				$css	=	'.lkc-unlink *	{ color: #888; }';
				$css	.=	'.lkc-card		{ margin: 16px; padding: 0; border: 3px #1f61e3 solid; border-radius: 5px; background: #eeecdf; }';
				$css	.=	'.lkc-info		{ margin: 0; padding: 4px; background: linear-gradient(to bottom, #2790ff, #1f61e3); background: -webkit-linear-gradient(top, #2790ff, #1f61e3); font-weight: bold; font-size: 11px; line-height: 16px; }';
				$css	.=	'.lkc-info *	{ color: #fff; }';
				$css	.=	'.lkc-title		{ padding: 0; }';
				$css	.=	'.lkc-url		{ padding: 4px; cursor: pointer; }';
				$css	.=	'.lkc-excerpt	{ padding: 4px; }';
				$file_text	=	str_replace('/*OPTION*/', $css, $file_text );
				break;
			case 'w95': // Windows 95
				$file_text	=	str_replace('/*EX-BORDER*/',		'border: none;', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/',		'border: none;', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/',		'border: none;', $file_text );
				$file_text	=	str_replace('/*CONTENT-MARGIN*/',	'margin: 4px 0;', $file_text );
				$css	=	'.lkc-external-wrap a , .lkc-internal-wrap a , .lkc-this-wrap a { cursor: default; }';
				$css	=	'.lkc-unlink *	{ color: #888; }';
				$css	.=	'.lkc-card		{ margin: 16px; padding: 4px; border: 3px #c0c7c8 solid; background: #e0e0e0; border: 1px #87888f solid; }';
				$css	.=	'.lkc-info		{ margin: 0; padding: 4px; border: 1px #87888f solid; background: #0000a8; font-weight: bold; font-size: 11px; line-height: 16px; }';
				$css	.=	'.lkc-info *	{ color: #fff; font-weight: normal; }';
				$css	.=	'.lkc-title		{ padding: 0; }';
				$css	.=	'.lkc-url		{ padding: 4px; cursor: pointer; }';
				$css	.=	'.lkc-excerpt	{ padding: 4px; }';
				$file_text	=	str_replace('/*OPTION*/', $css, $file_text );
				break;
			case 'ct1': // セロファンテープ（中央）
				$file_text	=	str_replace('/*WRAP-BEFORE*/',		'content: "";display: block;position: absolute;left: 40%;top: -16px;width: 95px;height: 25px;z-index: 2;background-color: rgba(243,245,228,0.5);border: 2px solid rgba(255,255,255,0.5);-webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-webkit-transform: rotate(3deg);-moz-transform: rotate(3deg);-o-transform: rotate(3deg);', $file_text );
				$file_text	=	str_replace('/*SHADOW*/',			'box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);', $file_text );
				break;
			case 'ct2': // セロファンテープ（左右）
				$file_text	=	str_replace('/*MARGIN-LEFT*/',		'margin-left: 40px;', $file_text );
				$file_text	=	str_replace('/*MARGIN-RIGHT*/',		'margin-right: 25px;', $file_text );
				$file_text	=	str_replace('/*WRAP-BEFORE*/',		'content: "";display: block;position: absolute;left: -40px;top: -4px;width: 75px;height: 25px;z-index: 2;background-color: rgba(243,245,228,0.5);border: 2px solid rgba(255,255,255,0.5);-webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-webkit-transform: rotate(-45deg);-moz-transform: rotate(-45deg);-o-transform: rotate(-45deg);', $file_text );
				$file_text	=	str_replace('/*WRAP-AFTER*/',		'content: "";display: block;position: absolute;right: -20px;top: -2px;width: 75px;height: 25px;z-index: 2;background-color: rgba(243,245,228,0.5);border: 2px solid rgba(255,255,255,0.5);-webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-webkit-transform: rotate(16deg);-moz-transform: rotate(16deg);-o-transform: rotate(16deg);transform: rotate(16deg);', $file_text );
				$file_text	=	str_replace('/*SHADOW*/',			'box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);', $file_text );
				break;
			case 'ct3': // セロファンテープ（長め）
				$file_text	=	str_replace('/*MARGIN-LEFT*/',		'margin-left: 32px;', $file_text );
				$file_text	=	str_replace('/*MARGIN-RIGHT*/',		'margin-right: 32px;', $file_text );
				$file_text	=	str_replace('/*WRAP-BEFORE*/', 		'content: "";display: block;position: absolute;left: -5%;top: -12px;width: 110%;height: 25px;z-index: 2;background-color: rgba(243,245,228,0.5);border: 2px solid rgba(255,255,255,0.5);-webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8);box-shadow: 1px 1px 4px rgba(200,200,180,0.8);-webkit-transform: rotate(-3deg);-moz-transform: rotate(-3deg);-o-transform: rotate(-3deg);', $file_text );
				$file_text	=	str_replace('/*SHADOW*/',			'box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);', $file_text );
				break;
			case 'ct4': // セロファンテープ（斜め）
				$file_text	=	str_replace('/*MARGIN-LEFT*/',		'margin-left: 24px;', $file_text );
				$file_text	=	str_replace('/*WRAP-BEFORE*/',		'content: ""; display: block; position: absolute; left: -24px; top: 0px; width: 200px; height: 25px; z-index: 2; background-color: rgba(243,245,228,0.5); border: 2px solid rgba(255,255,255,0.5); -webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8); -moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8); box-shadow: 1px 1px 4px rgba(200,200,180,0.8); -webkit-transform: rotate(-8deg); -moz-transform: rotate(-8deg); -o-transform: rotate(-8deg);', $file_text );
				$file_text	=	str_replace('/*SHADOW*/',			'box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);', $file_text );
				break;
			case 'ppc': // 紙めくれ
				$file_text	=	str_replace('/*WRAP-AFTER*/',		'z-index: -1; content:""; height: 10px; width: 60%; position: absolute; right: 16px; bottom: 14px; left: auto; transform: skew(5deg) rotate(3deg); -webkit-transform: skew(5deg) rotate(3deg); -moz-transform: skew(5deg) rotate(3deg); box-shadow: 0 16px 16px rgba(0,0,0,1); -webkit-box-shadow: 0 16px 16px rgba(0,0,0,1); -moz-box-shadow: 0 16px 12px rgba(0,0,0,1);', $file_text );
				$file_text	=	str_replace('/*SHADOW*/',			'box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.8);', $file_text );
				$file_text	=	str_replace('/*OPTION*/',			'article { position: relative; z-index: 0; } article blockquote { position: relative; z-index: 0; }', $file_text );
				break;
			case 'tac': // テープと紙めくれ
				$file_text	=	str_replace('/*MARGIN-LEFT*/',		'margin-left: 24px;', $file_text );
				$file_text	=	str_replace('/*WRAP-BEFORE*/',		'content: ""; display: block; position: absolute; left: -24px; top: 0px; width: 200px; height: 25px; z-index: 2; background-color: rgba(243,245,228,0.5); border: 2px solid rgba(255,255,255,0.5); -webkit-box-shadow: 1px 1px 4px rgba(200,200,180,0.8); -moz-box-shadow: 1px 1px 4px rgba(200,200,180,0.8); box-shadow: 1px 1px 4px rgba(200,200,180,0.8); -webkit-transform: rotate(-8deg); -moz-transform: rotate(-8deg); -o-transform: rotate(-8deg);', $file_text );
				$file_text	=	str_replace('/*WRAP-AFTER*/',		'z-index: -1; content:""; height: 10px; width: 60%; position: absolute; right: 16px; bottom: 14px; left: auto; transform: skew(5deg) rotate(3deg); -webkit-transform: skew(5deg) rotate(3deg); -moz-transform: skew(5deg) rotate(3deg); box-shadow: 0 16px 16px rgba(0,0,0,1); -webkit-box-shadow: 0 16px 16px rgba(0,0,0,1); -moz-box-shadow: 0 16px 12px rgba(0,0,0,1);', $file_text );
				$file_text	=	str_replace('/*SHADOW*/',			'box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.8);', $file_text );
				$file_text	=	str_replace('/*OPTION*/',			'article { position: relative; z-index: 0; } article blockquote { position: relative; z-index: 0; }', $file_text );
				break;
			case 'sBR': // 縫い目（青＆赤）
				$file_text	=	str_replace('/*EX-BORDER*/',		'border: 2px dashed rgba(255,255,255,0.5);', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/',		'border: 2px dashed rgba(255,255,255,0.5);', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/',		'border: 2px dashed rgba(255,255,255,0.5);', $file_text );
				$file_text	=	str_replace('/*EX-BGCOLOR*/',		'background: #bcddff; box-shadow: 0 0 0 5px #aabbee, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #aabbee, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #aabbee, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				$file_text	=	str_replace('/*IN-BGCOLOR*/',		'background: #f8d0d0; box-shadow: 0 0 0 5px #e8a8a8, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #e8a8a8, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #e8a8a8, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				$file_text	=	str_replace('/*TH-BGCOLOR*/',		'background: #f29db0; box-shadow: 0 0 0 5px #de8899, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #de8899, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #de8899, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				break;
			case 'sGY': // 縫い目（緑＆黄）
				$file_text	=	str_replace('/*EX-BORDER*/',		'border: 2px dashed rgba(255,255,255,0.5);', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/',		'border: 2px dashed rgba(255,255,255,0.5);', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/',		'border: 2px dashed rgba(255,255,255,0.5);', $file_text );
				$file_text	=	str_replace('/*EX-BGCOLOR*/',		'background: #acefdd; box-shadow: 0 0 0 5px #8abecb, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #8abecb, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #8abecb, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				$file_text	=	str_replace('/*IN-BGCOLOR*/',		'background: #ffde51; box-shadow: 0 0 0 5px #fbca4d, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #fbca4d, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #fbca4d, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				$file_text	=	str_replace('/*TH-BGCOLOR*/',		'background: #f0e0b0; box-shadow: 0 0 0 5px #decca0, 3px 3px 6px 4px rgba(0,0,0,0.6); -moz-box-shadow: 0 0 0 5px #decca0, 3px 3px 6px 4px rgba(0,0,0,0.6); -webkit-box-shadow: 0 0 0 5px #decca0, 3px 3px 6px 4px rgba(0,0,0,0.6);', $file_text );
				break;
			case 'pin': // 押しピン（綺麗な画像募集中）
				$file_text	=	str_replace('/*WRAP-AFTER*/',		'content: ""; display: block; position: absolute; background-image: url("'.$this->plugin_dir_url.'img/pin.png"); background-repeat: no-repeat; background-position: center; left: 47%; top: -16px; width: 40px; height: 40px; z-index: 1; pointer-events: none;', $file_text );
				break;
			case 'inN': // 中立青緑（イングレス風）
				$file_text	=	str_replace('/*EX-BORDER*/',		'border: 4px solid #59fbea;', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/',		'border: 4px solid #59fbea;', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/',		'border: 4px solid #59fbea;', $file_text );
				$file_text	=	str_replace('/*TITLE-COLOR*/',		'color: #59fbea;', $file_text );
				$file_text	=	str_replace('/*URL-COLOR*/',		'color: #59fbea;', $file_text );
				$file_text	=	str_replace('/*EXCERPT-COLOR*/',	'color: #59fbea;', $file_text );
				$file_text	=	str_replace('/*INFO-COLOR*/',		'color: #59fbea;', $file_text );
				$file_text	=	str_replace('/*EX-BGCOLOR*/',		'background-color: rgba( 35,100, 93,0.9);', $file_text );
				$file_text	=	str_replace('/*IN-BGCOLOR*/',		'background-color: rgba(  8, 25, 23,0.9);', $file_text );
				$file_text	=	str_replace('/*TH-BGCOLOR*/',		'background-color: rgba( 89,251,234,0.05);', $file_text );
				break;
			case 'inI': // 情報オレンジ（イングレス風）
				$color		=	'#ebbc4a';
				$file_text	=	str_replace('/*EX-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*TITLE-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*URL-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*EXCERPT-COLOR*/',	'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*MORE-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*INFO-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*ADDED-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*EX-BGCOLOR*/',		'background-color: rgba( 94, 75, 29,0.9);', $file_text );
				$file_text	=	str_replace('/*IN-BGCOLOR*/',		'background-color: rgba( 23, 18,  7,0.9);', $file_text );
				$file_text	=	str_replace('/*TH-BGCOLOR*/',		'background-color: rgba(235,188, 74,0.05);', $file_text );
				break;
			case 'inE': // エンライテッドカラー（イングレス風）
				$color		=	'#28f428';
				$file_text	=	str_replace('/*EX-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*TITLE-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*URL-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*EXCERPT-COLOR*/',	'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*MORE-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*INFO-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*ADDED-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*EX-BGCOLOR*/',		'background-color: rgba( 16, 97, 16,0.9);', $file_text );
				$file_text	=	str_replace('/*IN-BGCOLOR*/',		'background-color: rgba(  4, 24,  4,0.9);', $file_text );
				$file_text	=	str_replace('/*TH-BGCOLOR*/',		'background-color: rgba( 40,244, 40,0.05);', $file_text );
				break;
			case 'inR': // レジスタンスカラー（イングレス風）
				$color		=	'#00c2ff';
				$file_text	=	str_replace('/*EX-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*IN-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*TH-BORDER*/', 		'border: 4px solid '.$color.';', $file_text );
				$file_text	=	str_replace('/*TITLE-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*URL-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*EXCERPT-COLOR*/',	'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*MORE-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*INFO-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*ADDED-COLOR*/',		'color: '.$color.';', $file_text );
				$file_text	=	str_replace('/*EX-BGCOLOR*/',		'background-color: rgba(  0, 77,102,0.9);', $file_text );
				$file_text	=	str_replace('/*IN-BGCOLOR*/',		'background-color: rgba(  0, 19, 25,0.9);', $file_text );
				$file_text	=	str_replace('/*TH-BGCOLOR*/',		'background-color: rgba(  0,194,255,0.05);', $file_text );
				break;
			case 'slt': // ネタ？：斜め
				$file_text	=	str_replace('/*WRAP*/',				'transform:skew(-10deg) rotate(1deg);-webkit-transform: skew(-10deg) rotate(1deg);-moz-transform:skew(-10deg) rotate(1deg);', $file_text );
				$file_text	=	str_replace('/*MARGIN-LEFT*/',		'margin-left: 12px;', $file_text );
				$file_text	=	str_replace('/*MARGIN-RIGHT*/',		'margin-right: 30px;', $file_text );
				break;
			case '3Dr': // ネタ？：立体
				$file_text	=	str_replace('/*WRAP*/',				'-webkit-transform:perspective(150px) scale3d(0.84,0.9,1) rotate3d(1,0,0,12deg);', $file_text );
				$file_text	=	str_replace('/*SHADOW*/',			'box-shadow: 0 20px 16px rgba(0, 0, 0, 0.6) , 0px 32px 32px rgba(0, 0, 0, 0.2) inset;', $file_text );
				break;
			case 'sqr': // スクエア（WordPress標準風）
				$file_text	=	str_replace('/*HEIGHT*/',				'height: 340px;', $file_text );
				$file_text	=	str_replace('/*CONTENT-HEIGHT*/',		'height: 340px;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-POSITION*/',	'display: block;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-MARGIN*/',		'margin: 0;', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-WIDTH*/',		'', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-HEIGHT*/',		'', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-IMG-WIDTH*/',	'width: calc(100% - 2px);', $file_text );
				$file_text	=	str_replace('/*THUMBNAIL-IMG-HEIGHT*/',	'height: 200px; overflow: hidden;', $file_text );
				break;
			}

			// 文字色
			$file_text	=	str_replace('/*TITLE-COLOR*/',		'color: '.$this->options['title-color'].';', $file_text );
			$file_text	=	str_replace('/*URL-COLOR*/',		'color: '.$this->options['url-color'].';', $file_text );
			$file_text	=	str_replace('/*EXCERPT-COLOR*/',	'color: '.$this->options['excerpt-color'].';', $file_text );
			$file_text	=	str_replace('/*INFO-COLOR*/',		'color: '.$this->options['info-color'].';', $file_text );
			if (!$this->options['added-color']) {
				$this->options['added-color']	=	$this->options['info-color'];
				$this->options['added-size']	=	$this->options['info-size'];
				$this->options['added-height']	=	$this->options['info-height'];
				$this->options['outline-added']	=	$this->options['outline-info'];
			}
			$file_text	=	str_replace('/*ADDED-COLOR*/',		'color: '.$this->options['added-color'].';', $file_text );
			$file_text	=	str_replace('/*MORE-COLOR*/',		'color: '.$this->options['more-color'].';', $file_text );

			// 文字の大きさ
			$file_text	=	str_replace('/*TITLE-SIZE*/',		'font-size: '.$this->options['title-size'].';', $file_text );
			$file_text	=	str_replace('/*URL-SIZE*/',			'font-size: '.$this->options['url-size'].';', $file_text );
			$file_text	=	str_replace('/*EXCERPT-SIZE*/',		'font-size: '.$this->options['excerpt-size'].';', $file_text );
			$file_text	=	str_replace('/*INFO-SIZE*/',		'font-size: '.$this->options['info-size'].';', $file_text );
			$file_text	=	str_replace('/*ADDED-SIZE*/',		'font-size: '.$this->options['added-size'].';', $file_text );
			$file_text	=	str_replace('/*MORE-SIZE*/',		'font-size: '.$this->options['more-size'].';', $file_text );

			// 行の高さ
			$file_text	=	str_replace('/*TITLE-HEIGHT*/',	'line-height: '.$this->options['title-height'].';', $file_text );
			$file_text	=	str_replace('/*URL-HEIGHT*/',		'line-height: '.$this->options['url-height'].';', $file_text );
			$file_text	=	str_replace('/*EXCERPT-HEIGHT*/',	'line-height: '.$this->options['excerpt-height'].';', $file_text );
			$file_text	=	str_replace('/*INFO-HEIGHT*/',		'line-height: '.$this->options['info-height'].';', $file_text );
			$file_text	=	str_replace('/*ADDED-HEIGHT*/',	'line-height: '.$this->options['added-height'].';', $file_text );
			$file_text	=	str_replace('/*MORE-HEIGHT*/',		'line-height: '.$this->options['more-height'].';', $file_text );

			// 文字の縁取り
			if (isset($this->options['outline-title']) && $this->options['outline-title'] == '1') {
				$file_text = str_replace('/*TITLE-OUTCOLOR*/',	'text-shadow: 0 -1px '.$this->options['title-outline-color'].', 1px -1px '.$this->options['title-outline-color'].', 1px 0 '.$this->options['title-outline-color'].', 1px 1px '.$this->options['title-outline-color'].', 0 1px '.$this->options['title-outline-color'].', -1px 1px '.$this->options['title-outline-color'].', -1px 0 '.$this->options['title-outline-color'].', -1px -1px '.$this->options['title-outline-color'].';', $file_text );
			}
			if (isset($this->options['outline-url']) && $this->options['outline-url'] == '1') {
				$file_text = str_replace('/*URL-OUTCOLOR*/',	'text-shadow: 0 -1px '.$this->options['url-outline-color'].', 1px -1px '.$this->options['url-outline-color'].', 1px 0 '.$this->options['url-outline-color'].', 1px 1px '.$this->options['url-outline-color'].', 0 1px '.$this->options['url-outline-color'].', -1px 1px '.$this->options['url-outline-color'].', -1px 0 '.$this->options['url-outline-color'].', -1px -1px '.$this->options['url-outline-color'].';', $file_text );
			}
			if (isset($this->options['outline-excerpt']) && $this->options['outline-excerpt'] == '1') {
				$file_text = str_replace('/*EXCERPT-OUTCOLOR*/','text-shadow: 0 -1px '.$this->options['excerpt-outline-color'].', 1px -1px '.$this->options['excerpt-outline-color'].', 1px 0 '.$this->options['excerpt-outline-color'].', 1px 1px '.$this->options['excerpt-outline-color'].', 0 1px '.$this->options['excerpt-outline-color'].', -1px 1px '.$this->options['excerpt-outline-color'].', -1px 0 '.$this->options['excerpt-outline-color'].', -1px -1px '.$this->options['excerpt-outline-color'].';', $file_text );
			}
			if (isset($this->options['outline-info']) && $this->options['outline-info'] == '1') {
				$file_text = str_replace('/*INFO-OUTCOLOR*/',	'text-shadow: 0 -1px '.$this->options['info-outline-color'].', 1px -1px '.$this->options['info-outline-color'].', 1px 0 '.$this->options['info-outline-color'].', 1px 1px '.$this->options['info-outline-color'].', 0 1px '.$this->options['info-outline-color'].', -1px 1px '.$this->options['info-outline-color'].', -1px 0 '.$this->options['info-outline-color'].', -1px -1px '.$this->options['info-outline-color'].';', $file_text );
			}
			if (isset($this->options['outline-added']) && $this->options['outline-added'] == '1') {
				$file_text = str_replace('/*ADDED-OUTCOLOR*/',	'text-shadow: 0 -1px '.$this->options['added-outline-color'].', 1px -1px '.$this->options['added-outline-color'].', 1px 0 '.$this->options['added-outline-color'].', 1px 1px '.$this->options['added-outline-color'].', 0 1px '.$this->options['added-outline-color'].', -1px 1px '.$this->options['added-outline-color'].', -1px 0 '.$this->options['added-outline-color'].', -1px -1px '.$this->options['added-outline-color'].';', $file_text );
			}
			if (isset($this->options['outline-more']) && $this->options['outline-more'] == '1') {
				$file_text = str_replace('/*MORE-OUTCOLOR*/',	'text-shadow: 0 -1px '.$this->options['more-outline-color'].', 1px -1px '.$this->options['more-outline-color'].', 1px 0 '.$this->options['more-outline-color'].', 1px 1px '.$this->options['more-outline-color'].', 0 1px '.$this->options['more-outline-color'].', -1px 1px '.$this->options['more-outline-color'].', -1px 0 '.$this->options['more-outline-color'].', -1px -1px '.$this->options['more-outline-color'].';', $file_text );
			}

			// カードの周りへの余白
			if	($this->options['margin-top']		!==		'') {
				$file_text		=	str_replace('/*MARGIN-TOP*/',		'margin-top: '.		$this->options['margin-top'].	' !important;', $file_text );
			}
			if	($this->options['margin-bottom']	!==		'') {
				$file_text		=	str_replace('/*MARGIN-BOTTOM*/',	'margin-bottom: '.	$this->options['margin-bottom'].' !important;', $file_text );
			}
			if	($this->options['margin-left']		!==		'') {
				$file_text		=	str_replace('/*MARGIN-LEFT*/',		'margin-left: '.	$this->options['margin-left'].	' !important;', $file_text );
			}
			if	($this->options['margin-right']		!==		'') {
				$file_text		=	str_replace('/*MARGIN-RIGHT*/',		'margin-right: '.	$this->options['margin-right'].	' !important;', $file_text );
			}

			// カードの余白等調整
			$file_text = str_replace('/*PADDING*/',				'padding: 0;', $file_text );

			// カード内側の余白
			$margin_top		=	$this->options['card-top']		== ''	? '8px' : $this->options['card-top'];
			$margin_bottom	=	$this->options['card-bottom']	== ''	? '8px' : $this->options['card-bottom'];
			$margin_left	=	$this->options['card-left']		== ''	? '8px' : $this->options['card-left'];
			$margin_right	=	$this->options['card-right']	== ''	? '8px' : $this->options['card-right'];
			$file_text		=	str_replace('/*CARD-TOP*/',		'margin-top: '.		$margin_top.	';', $file_text );
			$file_text		=	str_replace('/*CARD-BOTTOM*/',	'margin-bottom: '.	$margin_bottom.	';', $file_text );
			$file_text		=	str_replace('/*CARD-LEFT*/',	'margin-left: '.	$margin_left.	';', $file_text );
			$file_text		=	str_replace('/*CARD-RIGHT*/',	'margin-right: '.	$margin_right.	';', $file_text );

			// img のスタイルを強制リセット
			if (isset($this->options['style-reset-img'])) {
				$file_text	=	str_replace('/*RESET-IMG*/',	'margin: 0 !important; padding: 0; border: none;', $file_text );
				$file_text	=	str_replace('/*STATIC*/',		'position: static !important;', $file_text );
				$file_text	=	str_replace('/*IMPORTANT*/',	'!important', $file_text );
			} else {
				$file_text	=	str_replace('/*IMPORTANT*/',	'', $file_text );
			}

			// 外部リンク背景
			if ($this->options['ex-bg-color']) {
				$file_text = str_replace('/*EX-BGCOLOR*/',		'background-color: '.$this->options['ex-bg-color'].';', $file_text );
			}
			$bg_image		=	esc_url($this->options['ex-image'] );
			if ($bg_image ) {
				if (preg_match('/https?(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $bg_image ) ) {
					$file_text = str_replace('/*EX-IMAGE*/',	'background-image: url("'.$bg_image.'");', $file_text );
				} else {
					$file_text = str_replace('/*EX-IMAGE*/',	'background-image: '.$bg_image.';', $file_text );
				}
			}

			// 内部リンク背景
			if ($this->options['in-bg-color']) {
				$file_text = str_replace('/*IN-BGCOLOR*/',		'background-color: '.$this->options['in-bg-color'].';', $file_text );
			}
			$bg_image		=	esc_url($this->options['in-image'] );
			if ($bg_image ) {
				if (preg_match('/https?(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $bg_image)) {
					$file_text = str_replace('/*IN-IMAGE*/',	'background-image: url("'.$bg_image.'");', $file_text );
				} else {
					$file_text = str_replace('/*IN-IMAGE*/',	'background-image: '.$bg_image.';', $file_text );
				}
			}

			// 同ページリンク背景色
			if ($this->options['th-bg-color']) {
				$file_text = str_replace('/*TH-BGCOLOR*/',		'background-color: '.$this->options['th-bg-color'].';', $file_text );
			}
			$bg_image		=	esc_url($this->options['th-image'] );
			if ($bg_image ) {
				if (preg_match('/https?(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $bg_image)) {
					$file_text = str_replace('/*TH-IMAGE*/',	'background-image: url("'.$bg_image.'");', $file_text );
				} else {
					$file_text = str_replace('/*TH-IMAGE*/',	'background-image: '.$bg_image.';', $file_text );
				}
			}

			// センタリング指定あり	
			if (isset($this->options['centering']) && $this->options['centering'] == '1') {
				$file_text = str_replace('/*WRAP-MARGIN*/',				'margin: 0 auto;', $file_text );
				$file_text = str_replace('/*HATENA-WRAP-MARGIN*/',		'margin: 0 auto;', $file_text );
			} else {
				$file_text = str_replace('/*WRAP-MARGIN*/', 			'margin: 0;', $file_text );
				$file_text = str_replace('/*HATENA-WRAP-MARGIN*/',		'margin: 0;', $file_text );
			}

			// 角まる指定あり
			switch ($this->options['radius']) {
			case null:
				$file_text = str_replace('/*RADIUS*/',					'', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'', $file_text );
				break;
			case '2':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 2px; -webkit-border-radius: 2px; -moz-border-radius: 2px;', $file_text );
				break;
			case '1':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 6px; -webkit-border-radius: 6px; -moz-border-radius: 6px;', $file_text );
				break;
			case '3':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 16px; -webkit-border-radius: 16px; -moz-border-radius: 16px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px;', $file_text );
				break;
			case '4':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 32px; -webkit-border-radius: 32px; -moz-border-radius: 32px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 12px; -webkit-border-radius: 12px; -moz-border-radius: 12px;', $file_text );
				break;
			case '5':
				$file_text = str_replace('/*RADIUS*/',					'border-radius: 64px; -webkit-border-radius: 64px; -moz-border-radius: 64px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-RADIUS*/',		'border-radius: 16px; -webkit-border-radius: 16px; -moz-border-radius: 16px;', $file_text );
				break;
			}

			// 影あり
			if (isset($this->options['shadow']) && $this->options['shadow'] == '1') {
				if (isset($this->options['shadow-inset']) && $this->options['shadow-inset'] == '1') {
					$file_text = str_replace('/*SHADOW*/',		'box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.4) , 0 0 16px rgba(0, 0, 0, 0.3) inset;', $file_text );
				} else {
					$file_text = str_replace('/*SHADOW*/',		'box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.4);', $file_text );
				}
			} else {
				if (isset($this->options['shadow-inset']) && $this->options['shadow-inset'] == '1') {
					$file_text = str_replace('/*SHADOW*/',		'box-shadow: 0 0 16px rgba(0, 0, 0, 0.5) inset;', $file_text );
				}
			}

			// マウスを乗せたとき
			switch ($this->options['hover']) {
			case '1':
				$file_text = str_replace('/*HOVER*/',			'opacity: 0.8;', $file_text );
				break;
			case '2':
				$file_text = str_replace('/*WRAP*/',			'transition: all 0.3s ease 0s;', $file_text );
				$file_text = str_replace('/*HOVER*/',			'box-shadow: 0 4px 8px rgba(0, 0, 0, 0.25); transform: translateY(-4px);', $file_text );
				break;
			case '3':
				$file_text = str_replace('/*WRAP*/',			'transition: all 0.3s ease 0s;', $file_text );
				$file_text = str_replace('/*HOVER*/',			'box-shadow: 16px 16px 16px rgba(0, 0, 0, 0.5); transform: translateY(-4px);', $file_text );
				break;
			case '7':
				$file_text = str_replace('/*WRAP*/',			'transition: all 0.3s ease 0s;', $file_text );
				$file_text = str_replace('/*HOVER*/',			'border-radius: 40px;', $file_text );
				break;
			}

			// サムネイル影あり
			$shadow_width		=	2;
			if (isset($this->options['thumbnail-shadow']) && $this->options['thumbnail-shadow'] == '1') {
				$file_text = str_replace('/*THUMBNAIL-SHADOW*/',	'box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.7);', $file_text );
				$shadow_width	=	10;
			}

			// サムネイルの位置とサイズtest
			$thumbnail_width	= intval(preg_replace('/[^0-9]/', '', isset($this->options['thumbnail-width']) ? $this->options['thumbnail-width'] : self::DEFAULTS['thumbnail-width'] ) );
			$thumbnail_height	= intval(preg_replace('/[^0-9]/', '', isset($this->options['thumbnail-height'] ) ? $this->options['thumbnail-height']  : self::DEFAULTS['thumbnail-height']  ) );
			$content_width		= intval(preg_replace('/[^0-9]/', '', isset($this->options['width']) ? $this->options['width'] : self::DEFAULTS['thumbnail-width'] ) );
			$content_height		= intval(preg_replace('/[^0-9]/', '', isset($this->options['content-height'] ) ? $this->options['content-height']  : self::DEFAULTS['content-height']  ) );
			switch ($this->options['thumbnail-position']) {
			case '1':			// 右側にサムネイル
				$file_text = str_replace('/*THUMBNAIL-POSITION*/',	'float: right;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-MARGIN*/',	'margin: 0 0 0 8px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-WIDTH*/',		'width: '.($thumbnail_width + $shadow_width ).'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-WIDTH*/',		'width: '.$thumbnail_width.'px !important;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-HEIGHT*/',	'height: '.$thumbnail_height.'px !important;', $file_text );
				break;
			case '2':			// 左側にサムネイル
				$file_text = str_replace('/*THUMBNAIL-POSITION*/',	'float: left;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-MARGIN*/',	'margin: 0 8px 0 0;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-WIDTH*/',		'width: '.($thumbnail_width + $shadow_width ).'px;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-WIDTH*/',		'width: '.$thumbnail_width .'px !important;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-HEIGHT*/',	'height: '.$thumbnail_height.'px !important;', $file_text );
				break;
			case '3':			// 上側にサムネイル
				$file_text = str_replace('/*THUMBNAIL-POSITION*/',	'display: block;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-MARGIN*/',	'margin: 0 0 8px 0;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-WIDTH*/',	'width: calc(100% - 2px) !important;', $file_text );
				$file_text = str_replace('/*THUMBNAIL-IMG-HEIGHT*/','height: '.$thumbnail_height.'px !important; overflow: hidden;', $file_text );
				break;
			}

			// サムネイルのリサイズ
			if (isset($this->options['thumbnail-resize']) && $this->options['thumbnail-resize'] == '1') {
				$size_title			=	intval(preg_replace('/[^0-9]/', '', isset($this->options['title-size'] )		? $this->options['title-size']		: self::DEFAULTS['title-size'] ) );
				$size_excerpt		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['excerpt-size'] )		? $this->options['excerpt-size']	: self::DEFAULTS['excerpt-size'] ) );
				$height_title		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['title-height'] )		? $this->options['title-height']	: self::DEFAULTS['title-height'] ) );
				$height_excerpt		=	intval(preg_replace('/[^0-9]/', '', isset($this->options['excerpt-height'] )	? $this->options['excerpt-height']	: self::DEFAULTS['excerpt-height'] ) );
				$thumbnail_width	=	intval(preg_replace('/[^0-9]/', '', isset($this->options['thumbnail-width'] )	? $this->options['thumbnail-width']	: self::DEFAULTS['thumbnail-width'] ) );
				$file_text = str_replace('/*RESIZE*/',
					'@media screen and (max-width: 600px)  { .lkc-title { font-size: '.intval($size_title * 0.9).'px; line-height: '.intval($height_title * 0.9).'px; } .lkc-excerpt { font-size: '.intval($size_excerpt * 0.95).'px; } .lkc-thumbnail { width: '.intval($thumbnail_width * 0.9).'px; } }'.
					'@media screen and (max-width: 480px)  { .lkc-title { font-size: '.intval($size_title * 0.8).'px; line-height: '.intval($height_title * 0.8).'px; } .lkc-excerpt { font-size: '.intval($size_excerpt * 0.8 ).'px; } .lkc-thumbnail { width: '.intval($thumbnail_width * 0.7).'px; } }'.
					'@media screen and (max-width: 320px)  { .lkc-title { font-size: '.intval($size_title * 0.7).'px; line-height: '.intval($height_title * 0.7).'px; } .lkc-excerpt { font-size: '.intval($size_excerpt * 0.6 ).'px; } .lkc-thumbnail { width: '.intval($thumbnail_width * 0.5).'px; } }', $file_text );
			}

			// 横幅
			if ($this->options['width']) {
				$file_text = str_replace('/*WIDTH*/',				'max-width: '.$this->options['width'].';', $file_text );
			} else {
				$file_text = str_replace('/*WIDTH*/',				'width: 100%;', $file_text );
			}

			// タイトルを折り返さない
			if ($this->options['title-nowrap']) {
				$file_text = str_replace('/*TITLE-NOWRAP*/',		'white-space: nowrap; text-overflow: ellipsis;', $file_text );
			}

			// URLを折り返さない
			if ($this->options['url-nowrap']) {
				$file_text = str_replace('/*URL-NOWRAP*/',			'white-space: nowrap; text-overflow: ellipsis;', $file_text );
			}

			// 記事情報の高さ
			$file_text	=	str_replace('/*CONTENT-HEIGHT*/',		'height: '.$this->options['content-height'].';', $file_text );

			// 枠線の太さ
			$border_width	=	strval(intval(preg_replace('/[^0-9]/', '', $this->options['border-width'] ) ) );
			$border_style	=	isset($this->options['border-style'] ) ? $this->options['border-style'] : self::DEFAULTS['border-style'];
			$border			=	$border_width.'px '.$border_style.' ';
			$ex_border		=	$border.(isset($this->options['ex-border-color']) ? $this->options['ex-border-color'] : self::DEFAULTS['ex-border-color']).';';
			$in_border		=	$border.(isset($this->options['in-border-color']) ? $this->options['in-border-color'] : self::DEFAULTS['in-border-color']).';';
			$th_border		=	$border.(isset($this->options['th-border-color']) ? $this->options['th-border-color'] : self::DEFAULTS['th-border-color']).';';
			$file_text		=	str_replace('/*EX-BORDER*/',	'border: '.$ex_border, $file_text );
			$file_text		=	str_replace('/*IN-BORDER*/',	'border: '.$in_border, $file_text );
			$file_text		=	str_replace('/*TH-BORDER*/',	'border: '.$th_border, $file_text );

			// 抜粋文の部分を凹ませる
			if (isset($this->options['content-inset']) && $this->options['content-inset'] == '1') {
				$file_text	=	str_replace('/*CONTENT-PADDING*/',	'padding: 6px;', $file_text );
				$file_text	=	str_replace('/*CONTENT-INSET*/',	'box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5) inset;', $file_text );
				$file_text	=	str_replace('/*CONTENT-BGCOLOR*/',	'background-color: rgba(255, 255, 255, 0.8 );', $file_text );
			}

			// 記事情報のマージン（上下）
			switch ($this->options['info-position']) {
			case 1:				// サイト情報が上（記事内容の上に余白を設定）
				$file_text	=	str_replace('/*CONTENT-MARGIN*/',		'margin: 8px 0 0 0;', $file_text );
				break;
			case 2:				// サイト情報が下（記事内容の下に余白を設定）
				$file_text	=	str_replace('/*CONTENT-MARGIN*/',		'margin: 0 0 8px 0;', $file_text );
				break;
			default:
				$file_text	=	str_replace('/*CONTENT-MARGIN*/',		'margin: 0;', $file_text );
				break;
			}

			// 抜粋文のマージン
			$file_text = str_replace('/*MARGIN-EXCERPT*/',		'margin: 0;', $file_text );

			// サイト情報の区切り線
			if (isset($this->options['separator']) && $this->options['separator'] == '1') {
				switch ($this->options['info-position']) {
				case '1':
					$file_text	=	str_replace('/*SEPARATOR*/',	'border-top: 1px solid '.$this->options['info-color'].';', $file_text );
					break;
				case '2':
					$file_text	=	str_replace('/*SEPARATOR*/',	'border-bottom: 1px solid '.$this->options['info-color'].';', $file_text );
					break;
				}
			}

			// 付加情報
			if (isset($this->options['heading']) && $this->options['heading'] == '1') {
				$added_height	=	intval(preg_replace('/[^0-9]/', '', isset($this->options['added-height'] ) ? $this->options['added-height']  : self::DEFAULTS['added-height']  ) );
				$heading_height	=	intval( $added_height / 2 );
				$heading_padding =	intval( $added_height / 4 );
				$file_text		=	str_replace('/*EX-HEADING*/',	'position: absolute; top: -'.$heading_height.'px; left: 20px; padding: 0 '.$heading_padding.'px; background-color: '.$this->options['ex-border-color'].'; border-radius: 2px;', $file_text );
				$file_text		=	str_replace('/*IN-HEADING*/',	'position: absolute; top: -'.$heading_height.'px; left: 20px; padding: 0 '.$heading_padding.'px; background-color: '.$this->options['in-border-color'].'; border-radius: 2px;', $file_text );
				$file_text		=	str_replace('/*TH-HEADING*/',	'position: absolute; top: -'.$heading_height.'px; left: 20px; padding: 0 '.$heading_padding.'px; background-color: '.$this->options['th-border-color'].'; border-radius: 2px;', $file_text );
			}

			// 続きを読むボタン
			switch ($this->options['flg-more']) {
			case	'1':
				$file_text = str_replace('/*STYLE-MORE*/',		'padding: 4px; margin: 4px 0;', $file_text );
				break;
			case	'2':
				$file_text = str_replace('/*STYLE-MORE*/',		'border: 1px solid #888; text-align: center; padding: 4px; margin: 4px 0;', $file_text );
				break;
			case	'3':
				$file_text = str_replace('/*STYLE-MORE*/',		'border: 1px solid #888; border-radius: 6px; text-align: center; padding: 4px; margin: 4px 0; background-color: #46f;', $file_text );
				break;
			case	'4':
				$file_text = str_replace('/*STYLE-MORE*/',		'border: 1px solid #888; border-radius: 6px; text-align: center; padding: 4px; margin: 4px 0; background-color: #888;', $file_text );
				break;
			}

			// アンカーの文字装飾
			if (isset($this->options['flg-anchor']) && $this->options['flg-anchor'] == '1') {
				$file_text = str_replace('/*ANCHOR*/',			'text-decoration: none !important;', $file_text );
			}

			// 追加CSS
			if (isset($this->options['css-add'])) {
				$file_text = str_replace('/*CSS-ADD*/',			$this->options['css-add'], $file_text );
			} else {
				$file_text = str_replace('/*CSS-ADD*/',			'', $file_text );
			}

			// ぽぽづれ。へのリンクを表示する
			if (isset($this->options['plugin-link']) && $this->options['plugin-link'] == '1') {
				$file_text = str_replace('/*CREDIT*/',			'display: block;', $file_text );
			} else {
				$file_text = str_replace('/*CREDIT*/',			'display: none;', $file_text );
			}

			// ファイルの圧縮
			if	($this->options['flg-compress'] ) {
				$header		=	'/*'.self::PLUGIN_ACRONYM.PLUGIN_VERSION.'#'.$this->now.'*/';			// プラグイン名追加
				$file_text	=	$this->pz_CompressCSS($file_text );																			// CSS圧縮
				$file_text	=	$file_text.$header;
			} else {
				$charset	=	'@charset "'.$this->charset.'";';
				$header		=	'/* '.$this->options['plugin-name'].' ver.'.$this->options['plugin-version'].' CSS #'.$this->now.' */';		// プラグイン名追加
				$file_text	=	preg_replace('/\s*\/\*[^*]*\*+([^\/][^*]*\*+)*\//', '', $file_text );										// コメント除去
				$file_text	=	$charset.PHP_EOL.$header.PHP_EOL.$file_text;
			}
			
			// ファイル出力
			$result_put			=	file_put_contents($css_path, $file_text);
			if ($result_put ) {
				$result		=	1;
			} else {
				$result		=	2;
			}
		} else {
			$result			=	3;
		}
	}
