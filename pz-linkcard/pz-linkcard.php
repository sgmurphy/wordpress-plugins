<?php defined('ABSPATH' ) || wp_die; ?>
<?php
/*
Plugin Name:	Pz-LinkCard
Plugin URI:		http://popozure.info/pz-linkcard
Description:	リンクをカード形式で表示します。
Version:		2.5.5
Author:			Poporon
Author URI:		http://popozure.info
Text Domain:	pz-linkcard
Domain Path:	/language
License:		GPLv2 or later
*/

class class_pz_linkcard {

	// 設定値
	private		const	DEFAULTS	=
		array(
			'plugin-version'		=>	null,			// Cache
			'db-version'			=>	null,			// Cache

			'error-mode'			=>	0,				// Cache
			'error-hide'			=>	0,
			'error-url'				=>	null,			// Cache
			'error-time'			=>	null,			// Cache

			'special-format'		=>	null,

			'link-all'				=>	1,				// Cache
			'margin-top'			=>	'16px',
			'margin-bottom'			=>	'16px',
			'margin-left'			=>	'16px',
			'margin-right'			=>	'16px',
			'card-top'				=>	'8px',
			'card-bottom'			=>	'8px',
			'card-left'				=>	'8px',
			'card-right'			=>	'8px',
			'width'					=>	'500px',
			'content-height'		=>	'108px',
			'centering'				=>	0,
			'blockquote'			=>	0,				// Cache

			'info-position'			=>	1,				// Cache
			'use-sitename'			=>	1,				// Cache
			'display-date'			=>	1,				// Cache
			'heading'				=>	0,
			'flg-anchor'			=>	1,
			'separator'				=>	0,
			'display-url'			=>	1,				// Cache
			'thumbnail-position'	=>	2,				// Cache
			'thumbnail-width'		=>	'100px',
			'thumbnail-height'		=>	'100px',
			'thumbnail-shadow'		=>	0,
			'content-inset'			=>	0,
			'display-excerpt'		=>	1,				// Cache
			'shadow-inset'			=>	0,
			'shadow'				=>	0,
			'radius'				=>	null,
			'hover'					=>	null,
			'border-style'			=>	'solid',
			'border-width'			=>	'1px',
			'style-reset-img'		=>	1,
			'flg-more'				=>	0,				// Cache
			'sns-position'			=>	2,				// Cache
			'sns-tw'				=>	1,				// Cache
			'sns-tw-x'				=>	0,				// Cache
			'sns-fb'				=>	1,				// Cache
			'sns-hb'				=>	1,				// Cache
			'sns-po'				=>	1,				// Cache

			'title-color'			=>	'#111111',
			'title-outline'			=>	null,
			'title-outline-color'	=>	'#ffffff',
			'title-size'			=>	'16px',
			'title-height'			=>	'24px',
			'title-trim'			=>	80,				// Cache
			'title-nowrap'			=>	null,
			'url-color'				=>	'#4466ff',
			'url-outline'			=>	null,
			'url-outline-color'		=>	'#ffffff',
			'url-size'				=>	'10px',
			'url-height'			=>	'15px',
			'url-trim'				=>	250,
			'url-nowrap'			=>	1,
			'excerpt-color'			=>	'#333333',
			'excerpt-outline'		=>	null,
			'excerpt-outline-color'	=>	'#ffffff',
			'excerpt-size'			=>	'11px',
			'excerpt-height'		=>	'17px',
			'excerpt-trim'			=>	500,			// Cache
			'more-color'			=>	'#444444',
			'more-outline'			=>	null,
			'more-outline-color'	=>	'#ffffff',
			'more-size'				=>	'12px',
			'more-height'			=>	'40px',
			'info-color'			=>	'#222222',
			'info-outline'			=>	null,
			'info-outline-color'	=>	'#ffffff',
			'info-size'				=>	'12px',
			'info-height'			=>	'18px',
			'info-trim'				=>	200,			// Cache
			'added-color'			=>	'#222222',
			'added-outline'			=>	null,
			'added-outline-color'	=>	'#ffffff',
			'added-size'			=>	'12px',
			'added-height'			=>	'18px',
			'thumbnail-resize'		=>	1,

			'ex-border-color'		=>	'#888888',
			'ex-bg-color'			=>	'#ffffff',
			'ex-image'				=>	null,
			'ex-thumbnail'			=>	13,				// Cache
			'ex-thumbnail-size'		=>	'thumbnail',	// Cache
			'ex-thumbnail-alt'		=>	null,			// Cache
			'ex-favicon'			=>	3,				// Cache
			'ex-favicon-alt'		=>	null,			// Cache
			'ex-info'				=>	null,			// Cache
			'ex-more-text'			=>	null,			// Cache
			'ex-target'				=>	2,				// Cache
			'ex-get'				=>	2,
			'nofollow'				=>	0,				// Cache
			'noopener'				=>	1,				// Cache
//			'use-hatena'			=>	null,			// Cache

			'in-border-color'		=>	'#888888',
			'in-bg-color'			=>	'#f8f8f8',
			'in-image'				=>	null,
			'in-thumbnail'			=>	1,				// Cache
			'in-thumbnail-size'		=>	'thumbnail',	// Cache
			'in-thumbnail-alt'		=>	null,			// Cache
			'in-favicon'			=>	3,				// Cache
			'in-favicon-alt'		=>	null,			// Cache
			'in-info'				=>	null,			// Cache
			'in-more-text'			=>	null,			// Cache
			'in-target'				=>	null,			// Cache
			'in-get'				=>	null,			// Cache
			'flg-get-pid'			=>	0,				// Cache

			'th-border-color'		=>	'#888888',
			'th-bg-color'			=>	'#eeeeee',
			'th-image'				=>	null,
			'th-info'				=>	null,			// Cache

			'flg-relative-url'		=>	1,				// Cache
			'flg-unlink'			=>	1,				// Cache
			'flg-ssl'				=>	1,				// Cache
			'flg-redir'				=>	1,				// Cache
			'flg-referer'			=>	1,				// Cache
			'flg-agent'				=>	1,				// Cache
			'user-agent'			=>	null,			// Cache
			'flg-alive'				=>	1,				// Cache
			'flg-alive-count'		=>	0,				// Cache

			'code1'					=>	'blogcard',		// Cache
			'use-inline'			=>	null,			// Cache
			'code2'					=>	null,			// Cache
			'code3'					=>	null,			// Cache
			'code4'					=>	null,			// Cache
			'auto-atag'				=>	0,				// Cache
			'auto-url'				=>	0,				// Cache
			'auto-external'			=>	0,				// Cache
			'flg-do-shortcode'		=>	1,
			'flg-edit-insert'		=>	1,				// Cache
			'mce-priority'			=>	null,			// Cache
			'flg-edit-qtag'			=>	1,				// Cache

			'multi-mode'			=>	0,
			'multi-myid'			=>	0,
			'multi-count'			=>	0,

			'trail-slash'			=>	1,				// Cache
			'class-pc'				=>	null,			// Cache
			'class-mobile'			=>	null,			// Cache
			'flg-filemenu'			=>	0,
			'flg-initialize'		=>	1,
			'flg-compress'			=>	1,
			'flg-amp-url'			=>	0,				// Cache
			'error-mode-hide'		=>	0,				// Cache
			'saved-date'			=>	null,			// Cache
			'develop-mode'			=>	0,
			'admin-mode'			=>	0,				// Cache
			'debug-mode'			=>	0,				// Cache
			'debug-nocache'			=>	0,				// Cache
			'debug-dir'				=>	null,			// Cache
			'debug-url'				=>	null,

			'css-url'				=>	null,			// Cache
			'css-add-url'			=>	null,			// Cache
			'css-add'				=>	null,
			'css-count'				=>	0,				// Cache
			'css-path'				=>	null,
			'css-templete'			=>	null,
			'thumbnail-dir'			=>	null,			// Cache
			'thumbnail-url'			=>	null,			// Cache
			'favicon-api'			=>	'https://www.google.com/s2/favicons?domain=%DOMAIN%',	// Cache
			'thumbnail-api'			=>	'https://s.wordpress.com/mshots/v1/%URL%?w=200',		// Cache

			'initialize-exception'	=>	0,				// Cache
		);

	// 定数・プラグイン情報
	private		const	PLUGIN_NAME			=	'Pz-LinkCard';
	private		const	PLUGIN_SLUG			=	'pz-linkcard';
	private		const	PLUGIN_ACRONYM		=	'Pz-LkC';
	private		const	PLUGIN_PATH			=	'/pz-linkcard';
	private		const	OPTION_NAME			=	'pz_linkcard_options';
	private		const	OPTION_NAME_OLD		=	'Pz_LinkCard_options';
	private		const	AUTHOR_URL			=	'https://popozure.info';
	private		const	AUTHOR_DEBUG_URL	=	'https://popozure.xsrv.jp/develop/';
	private		const	AUTHOR_NAME			=	'Popozure';
	private		const	AUTHOR_TWITTER		=	'@popozure';
	private		const	AUTHOR_TWITTER_URL	=	'https://x.com/popozure';
	private		const	AUTHOR_DONATE_URL	=	'https://www.amazon.co.jp/gp/registry/wishlist/2KIBQLC1VLA9X';
	private		const	CRON_PREFIX			=	'pz_linkcard_';
	private		const	CRON_ALIVE			=	self::CRON_PREFIX.'alive';
	private		const	CRON_CHECK			=	self::CRON_PREFIX.'check';
	private		const	CACHEMAN_PAGE		=	self::PLUGIN_SLUG.'-cacheman';						// Pzカード管理のページ名
	private		const	CACHEMAN_URL		=	'/tools.php?page='.self::CACHEMAN_PAGE;				// Pzカード管理のURL
	private		const	SETTINGS_PAGE		=	self::PLUGIN_SLUG.'-settings';						// Pzカード設定のページ名
	private		const	SETTINGS_URL		=	'/options-general.php?page='.self::SETTINGS_PAGE;	// Pzカード設定のURL

	// 変数
	private		$slug;					// スラッグ
	private		$text_domain;			// テキスト ドメイン（スラッグと同じ内容）
	private		$charset;				// 文字セット
	private		$amp;					// Google AMP 0:不明 1:AMP 2:通常
	private		$datetime_format;		// 日時の書式
	private		$now;					// 現在日時（ローカル時間）
	private		$home_url;				// 自サイトのURL
	private		$scheme;				// 自サイトのスキーム
	private		$domain;				// 自サイトのドメイン名
	private		$domain_url;			// 自サイトのドメインURL
	private		$plugin_basename;		// プラグイン ディレクトリの名前
	private		$plugin_dir_path;		// プラグイン ディレクトリのパス
	private		$plugin_dir_url;		// プラグイン ディレクトリのURL
	private		$plugin_link;			// プラグインページのURL
	private		$upload_dir_path;		// アップロード ディレクトリのパス
	private		$upload_dir_url;		// アップロード ディレクトリのURL
	private		$db_name;				// DBのテーブル名
	private		$suppression;			// 出力抑制
	private		$now_page;				// 表示中のページ（1:Pzカード設定 2:Pzカード管理）
	private		$options;				// パラメータ
	private		$settings_page;			// 設定画面のパス
	private		$settings_url;			// 設定画面のURL
	private		$cacheman_page;			// 管理画面のパス
	private		$cacheman_url;			// 管理画面のURL

	public	function	__construct() {
		global							$wpdb;											// DBの宣言

		// プラグイン情報
		$default_headers = array(
			'Version'		=>	'Version',
			'Author'		=>	'Author',
			'AuthorURI'		=>	'Author URI',
			'TextDomain'	=>	'Text Domain',
		);
		$plugin_info		= get_file_data(__FILE__, $default_headers );
		define('PLUGIN_VERSION', $plugin_info['Version'] );

		$this->slug					=	basename(dirname(__FILE__ ) );						// スラッグ
		$this->text_domain			=	$this->slug;										// テキストドメイン（スラッグと同じ）
		$this->charset				=	get_bloginfo('charset' );							// 文字セット
		$this->amp					=	0;													// 今がAMP表示かどうか判定
		$this->datetime_format		=	get_option('date_format' ).' '.get_option('time_format' );	// 日時の書式
		$this->now					=	current_time('timestamp', false );					// 現在日時（ローカル時間）
		$this->db_name				=	$wpdb->prefix.'pz_linkcard';						// DBのテーブル名
		$this->plugin_basename		=	plugin_basename(__FILE__ );							// プラグイン ディレクトリの名前
		$this->plugin_dir_path		=	plugin_dir_path(__FILE__ );							// プラグイン ディレクトリのパス
		$this->plugin_dir_url		=	plugin_dir_url (__FILE__ );							// プラグイン ディレクトリのURL
		$wp_upload_dir				=	wp_upload_dir();
		$this->upload_dir_path		=	$wp_upload_dir['basedir'].'/'.$this->slug.'/';		// アップロード ディレクトリのパス
		$this->upload_dir_url		=	str_replace('http:', '', $wp_upload_dir['baseurl'] ).'/'.$this->slug.'/';	// アップロード ディレクトリのURL
		$this->suppression			=	false;												// 出力抑制（header出力前かどうか）
		$this->settings_url			=	admin_url(self::SETTINGS_URL );						// Pzカード設定のURL
		$this->cacheman_url			=	admin_url(self::CACHEMAN_URL );						// Pzカード管理のURL

		// オプション取得
		$result						=	$this->pz_load_options();

		// URL解析（自サイトチェック）（Optionsを読み込んでから）
		$this->home_url				=	esc_url(home_url() );
		$url_info					=	$this->Pz_GetURLInfo($this->home_url );
		$this->scheme				=	$url_info['scheme'];		// 自サイトのスキーム
		$this->domain				=	$url_info['domain'];		// 自サイトのドメイン名
		$this->domain_url			=	$url_info['domain_url'];	// 自サイトのドメインURL

		// 管理者モードの解除
		if	(!$this->options['debug-mode'] ) {
			$this->options['admin-mode']			=	0;
		}
		if	(!$this->options['admin-mode'] ) {
			$this->options['initialize-exception']	=	0;
		}

		// 言語の国際化（日本語化）
		load_plugin_textdomain($this->text_domain, false, $this->slug.'/languages' );

		// 管理画面のとき
		if	(is_admin() ) {
			switch	(true) {				// 現在のページ
			case	(strpos($_SERVER['REQUEST_URI'], self::SETTINGS_URL ) <> '' ):
				$this->now_page	=	1;		// Pz カード設定
			case	(strpos($_SERVER['REQUEST_URI'], self::CACHEMAN_URL ) <> '' ):
				$this->now_page	=	2;		// Pz カード管理
			default:
				$this->now_page	=	'';
			}

			register_activation_hook	(__FILE__,							array($this, 'activate' ),			10, 1 );		// プラグインを有効化するときの処理
			register_deactivation_hook	(__FILE__,							array($this, 'deactivate' ),		10, 1 );		// プラグインを無効化するときの処理
			register_uninstall_hook		(__FILE__,							array($this, 'uninstall' ),			10, 1 );		// プラグインを削除するときの処理
			add_action		('upgrader_process_complete',					array($this, 'upgrader' ),			10, 2 );		// アップデートしたときの処理
			add_action		('admin_enqueue_scripts',						array($this, 'enqueue_admin' ),		10, 1 );		// 設定メニュー用スクリプト
			add_action		('admin_notices',								array($this, 'add_notices' ),		10, 1 );		// 注意書き
			add_action		('admin_menu',									array($this, 'add_admin_menu' ),	11, 1 );		// 設定メニュー
			add_action		('wp_before_admin_bar_render',					array($this, 'add_admin_bar' ),		11,	1 );		// 管理バー
			add_action		('admin_print_footer_scripts',					array($this, 'add_footer' ),		10, 1 );		// テキストエディタ用クイックタグ
			add_filter		('plugin_action_links_'.$this->plugin_basename,	array($this, 'add_inline_menu' ),	10, 1 );		// プラグイン画面
			add_filter		('mce_buttons',									array($this, 'add_mce_button' ), 	$this->options['mce-priority'], 1 );	// ビジュアルエディタ用ボタン
			add_filter		('mce_external_plugins',						array($this, 'add_mce_plugin' ), 	$this->options['mce-priority'], 1 );	// ビジュアルエディタ用ボタン

			// WP-CRONスケジュール登録（リンク先存在チェック）
			if ($this->options['flg-alive'] ) {
				add_action(self::CRON_ALIVE, array($this, 'schedule_hook_alive' ) );
				if	(!wp_next_scheduled(self::CRON_ALIVE ) ) {
					wp_schedule_event(time() + 1800	, 'daily',	self::CRON_ALIVE );
				}
			}

			// WP-CRONスケジュール登録（SNSカウント取得）
			if ($this->options['sns-position'] ) {
				add_action(self::CRON_CHECK, array($this, 'schedule_hook_check' ) );
				if	(!wp_next_scheduled(self::CRON_CHECK ) ) {
					wp_schedule_event(time() + 10	, 'hourly',	self::CRON_CHECK );
				}
			}

		} else {
			add_action		('wp_enqueue_scripts',							array($this, 'enqueue' ) );				// スタイルシート呼び出し
			if	($this->options['auto-atag'] || $this->options['auto-url'] ) {										// 自動置き換え
				add_filter		('the_content',					array($this, 'auto_replace' ) );
				add_shortcode	(self::PLUGIN_SLUG.'-auto-replace',	array($this, 'shortcode' ), 10 );
			}
			if	($this->options['code1'] ) {																		// ショートコード1
				add_shortcode($this->options['code1'], array($this, 'shortcode' ), 10 );
			}
			if	($this->options['code2'] ) {																		// ショートコード2
				add_shortcode($this->options['code2'], array($this, 'shortcode' ), 10 );
			}
			if	($this->options['code3'] ) {																		// ショートコード3
				add_shortcode($this->options['code3'], array($this, 'shortcode' ), 10 );
			}
			if	($this->options['code4'] ) {																		// ショートコード4
				add_shortcode($this->options['code4'], array($this, 'shortcode' ), 10 );
			}
		}
	}

	// テキストリンクの行とURLのみの行をリンクカードへ置き換える処理（直接HTMLタグにするのでは無くショートコードに変換する。）
	public	function	auto_replace($content ) {
		if		(!$this->options['auto-external'] ) {
			// 内部リンクも外部リンクも変換する
			if	($this->options['auto-atag'] ) {
				$content	=	preg_replace('/(^|<br ?\/?>)(<p.*>)?<a\s.*href\s*=\s*[\'"]?((https?|file|ftp|data|ogg):\/\/[^\s<>]+)[\'"]?[^<]*<\/a>(<\/p>)?$/im', '[pz-linkcard-auto-replace url="$3"]', $content );
			}
			if	($this->options['auto-url'] ) {
				$content	=	preg_replace('/(^|<br ?\/?>)(<p.*>)?((https?|file|ftp|data|ogg):\/\/[^\s<>]+)(<\/p>|<br ?\/?>)?$/im', '[pz-linkcard-auto-replace url="$3"]', $content );
			}
			if	($this->options['flg-do-shortcode'] && ($this->options['auto-atag'] || $this->options['auto-url'] ) ) {
				$content	=	do_shortcode($content );
			}
			return	$content;
		} else {
			// 外部リンクのみを変換する
			if	($this->options['auto-atag'] ) {
				preg_match_all('/(^|<br ?\/?>)(<p.*>)?(<a\s.*href\s*=\s*[\'"]?((https?|file|ftp|data|ogg):\/\/[^\s<>]+)[\'"]?[^<]*<\/a>)(<\/p>)?$/im', $content, $m );
				for ($i = 0 ; $i < count($m[0]) ; $i++ ) {
					$url			=	$m[4][$i];
					$url_info		=	$this->Pz_GetURLInfo($url );	// URL解析（自サイトチェック）
					$is_external	=	$url_info['is_external'];		// 外部リンク
					if	($is_external ) {
						$tag_from	=	$m[0][$i];
						$tag_to		=	'[pz-linkcard-auto-replace url="'.$url.'"]';
						$content	=	str_replace($tag_from, $tag_to, $content );
					}
				}
			}
			if	($this->options['auto-url'] ) {
				preg_match_all('/(^|<br ?\/?>)(<p.*>)?((https?|file|ftp|data|ogg):\/\/[^\s<>]+)(<\/p>|<br ?\/?>)?$/im', $content, $m );
				for ($i	= 0 ; $i < count($m[0]) ; $i++ ) {
					$url	=	$m[3][$i];
					$url_info		=	$this->Pz_GetURLInfo($url );	// URL解析（自サイトチェック）
					$is_external	=	$url_info['is_external'];		// 外部リンク
					if	($is_external ) {
						$tag_from	=	$m[0][$i];
						$tag_to		=	'[pz-linkcard-auto-replace url="'.$url.'"]';
						$content	=	str_replace($tag_from, $tag_to, $content );
					}
				}
			}
			if	($this->options['flg-do-shortcode'] && ($this->options['auto-atag'] || $this->options['auto-url'] ) ) {
				$content	=	do_shortcode($content );
			}
			return	$content;
		}
	}

	// ショートコード処理
	public	function	shortcode($atts, $content = null, $shortcode = null ) {
		// 実行時間
		if	($this->options['debug-mode'] ) {
			if	(function_exists('hrtime' ) ) {
				$start_time		=	hrtime(true ) / 1000;
			} else {
				$start_time		=	microtime(true );
			}
			echo	PHP_EOL.'<!-- Pz-LkC [Debug mode: On] /-->'.PHP_EOL;
			echo	'<!-- Pz-LkC [shortcode]'.PHP_EOL;
			echo	'$atts='.html_entity_decode(print_r($atts, true ) );
			echo	'$content="'.html_entity_decode($content ).'"'.PHP_EOL;
			echo	'$shortcode="'.html_entity_decode($shortcode ).'"'.PHP_EOL;
			echo	'/-->'.PHP_EOL;
		}

		// キーをすべて小文字にする
		// $atts = array_change_key_case($atts, CASE_LOWER);

		// URLパラメータ
		switch	(true) {
		case	(!empty($atts['url'] ) ) :
			$url	=	$atts['url'];
			break;
		case	(!empty($atts['href'] ) ) :				// Aタグのようにhrefパラメータも有効にする
			$url	=	$atts['href'];
			break;
		case	(!empty($atts['uri'] ) ) :				// 密かに記述ミス対応（uriやurIでもurlとして判定する）
			$url	=	$atts['uri'];
			break;
		case	(!empty($atts['ur1'] ) ) :				// 密かに記述ミス対応（ur1でもurlとして判定する）
			$url	=	$atts['ur1'];
			break;
		case	(!empty($atts[0] ) ) :					// 謎の記述ミスに対応
			$url	=	$atts[0];
			break;
		case	(!empty($atts[1] ) ) :					// 謎の記述ミスに対応
			$url	=	$atts[1];
			break;
		default:
			$url	=	null;
			break;
		}

		// 最初にあるURLっぽいのを持ってくる
		if	(preg_match('/((https?|file|ftp|data|ogg):\/\/[^\s<>]+)/sui', $url, $m ) ) {
			$url	=	$m[1];
		}

		// 指定されたurlパラメータ（エラー表示用）
		$url_org	=	$url;

		// 相対URLを絶対URLに変換（ショートコードのURLで相対パス表記の場合、内部リンクと見なす）
		if	($this->options['flg-relative-url'] && !mb_strpos($url, '://' ) ) {
			$url	=	$this->pz_RelToURL(esc_url(home_url() ), $url );
		}

		// URLのサニタイズ＆エンティティ化
		$url		=	$this->pz_EncodeURL($url ,true );

		// URLエラー
		if	(!$url ) {
			if	(!$this->options['error-mode'] ) {
				$url_now								=	get_permalink();
				$post_id								=	url_to_postid($url_now );
				if	($post_id ) {
					$this->options['error-mode']		=	true;
					$this->options['error-url']			=	$url_now;
					$this->options['error-time']		=	$this->now;
					// オプション更新
					$result	=	$this->pz_UpdateOption();
				}
			}
			$tag		=	'<div class="lkc-card"><div class="lkc-this-wrap"><div class="lkc-info">'.$this->options['plugin-name'].'</div><div class="lkc-excerpt">'.__('-', $this->text_domain ).' '.__('Incorrect URL specification.', $this->text_domain ).'<br>'.__('-', $this->text_domain ).' '.__('URL', $this->text_domain ).'='.html_entity_decode($url_org ).'</div></div></div>';
			$err_info	=	print_r($atts, true );
			return			PHP_EOL.'<div id="lkc-error" class="lkc-error"><!-- '.html_entity_decode($err_info ).' -->'.$tag.'</div>'.PHP_EOL;
		}

		// URLパラメータに編集後のURLを返す
		$atts['url']	=	$url;

		// titleパラメータが無かったらNULLにする
		if	(!isset($atts['title'] ) ) {
			$atts['title']	=	null;
		}

		// excerptパラメータが無かったらNULLにする
		if	(!isset($atts['excerpt'] ) ) {
			if			(isset($atts['content'] ) ) {
				$atts['excerpt']	=	$atts['content'];
			} elseif	(isset($atts['contents'] ) ) {
				$atts['excerpt']	=	$atts['contents'];
			} elseif	(isset($atts['description'] ) ) {
				$atts['excerpt']	=	$atts['description'];
			} else {
				$atts['excerpt']	=	null;
			}
		}

		// 囲まれ文字（ショートコード1のみ有効）
		if	($shortcode == $this->options['code1'] ) {
			switch	($this->options['use-inline'] ) {
			case	1:
				$atts['excerpt']	=	isset($content ) ? $content : null;
				break;
			case	2:
				$atts['title']		=	isset($content ) ? $content : null;
				break;
			}
		}

		// 記事内容取得
		$tag	=	$this->pz_GetHTML($atts );

		// 実行時間
		if	($this->options['debug-mode'] ) {
			if	(function_exists('hrtime' ) ) {
				$end_time		=	hrtime(true ) / 1000;
			} else {
				$end_time		=	microtime(true );
			}
			$elasped_time	=	$end_time - $start_time;
			$format_time	=	number_format($elasped_time / 1000, 8, '.', ',' );
			echo	'<!-- Pz-LkC [shortcode]'.PHP_EOL;
			echo	' URL='.$url.PHP_EOL;
			echo	' ElaspedTime='.$format_time.'ms'.PHP_EOL;
			echo	'-->'.PHP_EOL;
		}
		return	$tag;
	}

	// キャッシュやリンク先からリンクカードのHTMLを生成
	private	function	pz_GetHTML($atts ) {
		if	($this->options['debug-mode'] ) {
			echo	'<!-- Pz-LkC [pz_GetHTML]'.PHP_EOL;
			echo	'$atts='.html_entity_decode(print_r($atts, true ) );
			echo	'/-->'.PHP_EOL;
		}

		// リンク先URL
		$url			=	isset($atts['url'] ) ? $atts['url'] : null ;

		// URL指定なし
		if	(!$url ) {
			return	null;
		}

		// 変数の用意
		$is_internal	=	false;
		$is_samepage	=	false;
		$is_mobile		=	false;
		$data_id		=	null;
		$site_name		=	null;
		$title			=	null;
		$excerpt		=	null;
		$thumbnail_url	=	null;
		$thumbnail_alt	=	null;
		$favicon_url	=	null;
		$favicon_alt	=	null;
		$post_date		=	null;
		$post_modified	=	null;

		$update_result	=	null;

		$sns_tw			=	null;
		$sns_fb			=	null;
		$sns_hb			=	null;
		$sns_po			=	null;
		$alive_result	=	null;

		// モバイルチェック
		if	(function_exists('wp_is_mobile' ) && wp_is_mobile() ) {
			$is_mobile	=	true;
		}
		if	($this->options['debug-mode'] ) {
			echo	'<!-- Pz-LkC [pz_GetHTML] $is_mobile="'.$is_mobile.'" /-->'.PHP_EOL;
		}

		// URL解析（自サイトチェック）
		$url_info		=	$this->Pz_GetURLInfo($url );
		$scheme			=	$url_info['scheme'];		// スキーム
		$domain			=	$url_info['domain'];		// ドメイン名
		$domain_url		=	$url_info['domain_url'];	// ドメインURL
		$is_external	=	$url_info['is_external'];	// 外部リンク
		$is_internal	=	$url_info['is_internal'];	// 内部リンク
		$is_samepage	=	$url_info['is_samepage'];	// 同一ページ

		// モバイルかPCかのクラス名を追加
		$class_id		=	'linkcard';
		if	($is_mobile && $this->options['class-mobile'] ) {
			$class_id	.=	' '.esc_attr($this->options['class-mobile'] );
		} elseif	($this->options['class-pc'] ) {
			$class_id	.=	' '.esc_attr($this->options['class-pc'] );
		}

		// キャッシュから取得
		$data			=	array('url' => $url );
		$result			=	$this->pz_GetCache($data );
		if	(isset($result ) && is_array($result ) && isset($result['url'] ) ) {
			$data		=	$result;
			$data_id	=	$data['id'];
			$url		=	$data['url'];
			if	($this->options['debug-mode'] ) {
				echo	'<!-- Pz-LkC [pz_GetHTML] get from cache $data_id="'.$data_id.'" /-->'.PHP_EOL;
			}
		}

		// 内部リンクの処理
		if	($is_internal ) {
			if	($this->options['debug-mode'] ) {
				echo	'<!-- Pz-LkC [pz_GetHTML] Internal link /-->'.PHP_EOL;
			}
			// リンクターゲットの設定
			$target			=	null;									// 同じタブに開く
			if	(isset($this->options['in-target'] ) ) {
				if	($this->options['in-target'] == 1 || ($this->options['in-target'] == 2 && !$is_mobile ) ) {
					$target	=	' target="_blank"';						// 新しいタブで開く
				}
			}

			// nofollowの指定
			$rel			=	null;
			if	((isset($atts['follow'] ) && mb_strtolower($atts['follow'] ) == 'no' ) || (isset($atts['nofollow'] ) && mb_strtolower($atts['nofollow'] ) == 'true' ) ) {
				$rel		=	' rel="nofollow"';						// 要望により内部リンクでもnofollow可能（ショートコードのパラメータで指定時のみ）
			}

			// 記事の取得方法
			if	($this->options['in-get'] == 2 ) {	// 常にカード管理から
				if	(!$data_id || (isset($atts['force'] ) && $atts['force'] == true ) ) {	// キャッシュに無いとき
					$data		=	$this->pz_GetPost($data );		// 最新記事内容を取得
					$result		=	$this->pz_SetCache($data );		// 保存
				}
			} else {								// 常に最新記事から or 抜粋優先
				$data			=	$this->pz_GetPost($data );		// 最新記事内容を取得（抜粋判断はpz_GetPostで行う）
				if (!$data_id ) {
					$result		=	$this->pz_SetCache($data );		// 保存
				}
			}
		}

		// 外部リンクの処理
		if	($is_external ) {
			if	($this->options['debug-mode'] ) {
				echo	'<!-- Pz-LkC [pz_GetHTML] External link /-->'.PHP_EOL;
			}
			// リンクターゲットの設定
			$target			=	null;									// 同じタブに開く
			if	(isset($this->options['ex-target'] ) ) {
				if	($this->options['ex-target'] == 1 || ($this->options['ex-target'] == 2 && !$is_mobile ) ) {
					$target	=	' target="_blank"';						// 新しいタブで開く
				}
			}

			// noopenerとnofollowの指定
			$rel			=	'external';
			if	($this->options['nofollow'] || (isset($atts['follow'] ) && mb_strtolower($atts['follow'] ) == 'no' ) || (isset($atts['nofollow'] ) && mb_strtolower($atts['nofollow'] ) == 'true' ) ) {
				$rel		.=	' nofollow';							// nofollow指定。趣味の問題？
			}
			if	($this->options['noopener'] ) {
				$rel		.=	' noopener';
			}
			$rel			=	' rel="'.$rel.'"';

			// キャッシュが無い、もしくは強制取得
			if	((!$data_id ) || ($this->options['debug-mode']	==	true  && $this->options['debug-nocache']	==	true ) || (isset($atts['force'] ) && $atts['force'] == true ) ) {
				$result		=	$this->pz_GetCURL($data );		// cURLで記事内容を取得
				if	(isset($result ) && is_array($result ) && isset($result['url'] ) ) {
					$data	=	$result;
					$result	=	$this->pz_SetCache($data );
				}
			}
		}

		// 記事内容をセット
		$title			=	isset($data['title'] )			?	$data['title']			:	null ;
		$excerpt		=	isset($data['excerpt'] )		?	$data['excerpt']		:	null ;
		$site_name		=	isset($data['site_name'] )		?	$data['site_name']		:	null ;
		$thumbnail_url	=	isset($data['thumbnail'] )		?	$data['thumbnail']		:	null ;
		$post_date		=	isset($data['post_date'] )		?	$data['post_date']		:	null ;
		$post_modified	=	isset($data['post_modified'] )	?	$data['post_modified']	:	null ;
		$update_result	=	isset($data['update_result'] )	?	$data['update_result']	:	null ;
		$alive_result	=	isset($data['alive_result'] )	?	$data['alive_result']	:	null ;
		$no_failure		=	!empty($data['no_failure'] )	?	true					:	false ;
		$sns_tw			=	isset($data['sns_twitter'] )	?	$data['sns_twitter']	:	null ;
		$sns_fb			=	isset($data['sns_facebook'] )	?	$data['sns_facebook']	:	null ;
		$sns_hb			=	isset($data['sns_hatena'] )		?	$data['sns_hatena']		:	null ;
		$sns_po			=	isset($data['sns_pocket'] )		?	$data['sns_pocket']		:	null ;
		$html_thumbnail	=	null;
		$html_favicon	=	null;

		// ラッピング
		if	($is_internal ) {
			if	($is_samepage ) {
				$html_wrap_op	=	'<div class="lkc-this-wrap">';
				$html_wrap_cl	=	'</div>';
				$html_added_op	=	'<div class="lkc-this-added">';
				$html_added_cl	=	'</div>';
				$more			=	null;
				$more_text		=	null;
				$thumbnail_alt	=	null;
				$favicon_alt	=	null;
				$info_text		=	isset($this->options['th-info'] )		? $this->options['th-info']			: null ;
				$sw_thumbnail	=	isset($this->options['in-thumbnail'] )	? $this->options['in-thumbnail']	: 0 ;
				$sw_favicon		=	isset($this->options['in-favicon'] )	? $this->options['in-favicon']		: 0 ;
			} else {
				$html_wrap_op	=	'<div class="lkc-internal-wrap">';
				$html_wrap_cl	=	'</div>';
				$html_added_op	=	'<div class="lkc-internal-added">';
				$html_added_cl	=	'</div>';
				$more			=	isset($this->options['flg-more'] )			? $this->options['flg-more']			: null ;
				$more_text		=	isset($this->options['in-more-text'] )		? $this->options['in-more-text']		: null ;
				$thumbnail_alt	=	isset($this->options['in-thumbnail-alt'] )	? $this->options['in-thumbnail-alt']	: null ;
				$favicon_alt	=	isset($this->options['in-favicon-alt'] )	? $this->options['in-favicon-alt']		: null ;
				$info_text		=	isset($this->options['in-info'] )			? $this->options['in-info']				: null ;
				$sw_thumbnail	=	isset($this->options['in-thumbnail'] )		? $this->options['in-thumbnail']		: 0 ;
				$sw_favicon		=	isset($this->options['in-favicon'] )		? $this->options['in-favicon']			: 0 ;
			}
		} else {
			// 外部リンクで「はてなブログカード」を使う
			//if	( $this->options['use-hatena'] ) {
			//	// 「はてなブログカード」をそのまま利用する
			//	$tag		=	'<div class="lkc-iframe-wrap"><iframe src="https://hatenablog-parts.com/embed?url=' .$url.'" class="lkc-iframe" scrolling="no" frameborder="0"></iframe></div>';
			//	if	($this->options['blockquote'] ) {
			//		$tag	=	'<div class="'.$class_id.'"><blockquote class="lkc-quote">'.$tag.'</blockquote></div>';
			//	} else {
			//		$tag	=	'<div class="'.$class_id.'">'.$tag.'</div>';
			//	}
			//	return	$tag;		// タグを出力してさっさと終了
			//}
			$html_wrap_op		=	'<div class="lkc-external-wrap">';
			$html_wrap_cl		=	'</div>';
			$html_added_op		=	'<div class="lkc-external-added">';
			$html_added_cl		=	'</div>';
			$more				=	isset($this->options['flg-more'] )			? $this->options['flg-more']			: null ;
			$more_text			=	isset($this->options['ex-more-text'] )		? $this->options['ex-more-text']		: null ;
			$thumbnail_alt		=	isset($this->options['ex-thumbnail-alt'] )	? $this->options['ex-thumbnail-alt']	: null ;
			$favicon_alt		=	isset($this->options['ex-favicon-alt'] )	? $this->options['ex-favicon-alt']		: null ;
			$info_text			=	isset($this->options['ex-info'] )			? $this->options['ex-info']				: null ;
			$sw_thumbnail		=	isset($this->options['ex-thumbnail'] )		? $this->options['ex-thumbnail']		: 0 ;
			$sw_favicon			=	isset($this->options['ex-favicon'] )		? $this->options['ex-favicon']			: 0 ;
		}

		// XSS対策
		$more_text			=	esc_attr($more_text );
		$info_text			=	esc_attr($info_text );
		$thumbnail_alt		=	esc_attr($thumbnail_alt );
		$favicon_alt		=	esc_attr($favicon_alt );

		// ドメイン名の準備
		$domain_name			=	$domain;
		if	(function_exists('idn_to_utf8' ) && substr($domain, 0, 4 ) == 'xn--' ) {	// 国際ドメイン対応（日本語ドメイン対応）
			$domain_name		=	idn_to_utf8($domain, 0, INTL_IDNA_VARIANT_UTS46 );
		}

		// サイト名の準備
		$site_name				=	$site_name;

		// 表示用サイト名
		if	(($this->options['use-sitename'] ) && ($site_name ) ) {
			$disp_sitename		=	$site_name;
		} else {
			$disp_sitename		=	$domain_name;
		}

		// 表示用サイト名の文字数
		$title_sitename			=	'';
		if	($this->options['info-trim'] ) {
			$before				=	$disp_sitename;
			$disp_sitename		=	mb_strimwidth($disp_sitename, 0, $this->options['info-trim'] , '...' );
			if	($disp_sitename	<>	$before ) {		// 省略された場合はtitleタグにセットする
				$title_sitename	=	' title="'.esc_html($site_name ).'"';
			}
		}

		// タイトル
		if	(!$title ) {
			$title			=	$this->pz_DecodeURL($url, true );			// タイトル取得できていなかったらURLをセットする
		}

		// パラメータ取得（タイトル）
		if	(isset($atts['title'] ) && $atts['title'] ) {					// title パラメータ
			$title			=	$atts['title'];
			$excerpt		=	null;
		}

		// パラメータ取得（抜粋文）
		if	(isset($atts['excerpt'] ) && $atts['excerpt'] ) {				// excerpt パラメータ
			$excerpt		=	$atts['excerpt'];
		}

		// タイトル整形
		$temp			=	$title;												// タイトル
		$temp			=	strip_tags($temp );									// HTMLタグ除去
		$temp			=	str_replace(array("\r", "\n"), '', $temp );			// 改行を除去
		if	($this->options['title-trim'] ) {									// 文字数制限
			$temp		=	mb_strimwidth($temp, 0, $this->options['title-trim'] , '...' );
		} else {
			$temp		=	mb_strimwidth($temp, 0, 200 , '...' );
		}
		$temp			=	esc_html($temp );									// HTMLエスケープ
		$title			=	$temp;

		// 抜粋文整形（抜粋文非表示の場合、空欄にする）
		if	(!$this->options['display-excerpt'] ) {
			$excerpt	=	null;
		} else {
			$temp		=	$excerpt;											// 抜粋文
			$temp		=	strip_tags($temp );									// HTMLタグ除去
			$temp		=	str_replace(array("\r", "\n"), '', $temp );			// 改行を除去
			$temp		=	preg_replace('/<!--more-->.+/is', '', $temp );		// moreタグ以降削除
			$temp		=	preg_replace('/\[[^]]*\]/', '', $temp );			// ショートコードすべて除去
			if	($this->options['excerpt-trim'] ) {								// 文字数制限
				$temp	=	mb_strimwidth($temp, 0, $this->options['excerpt-trim'] , '...' );
			} else {
				$temp	=	mb_strimwidth($temp, 0, 500 , '...' );
			}
			$temp		=	esc_html($temp );									// HTMLエスケープ
			$excerpt	=	$temp;
		}

		// 代替テキスト（サムネイル）
		if	(($thumbnail_alt	<>	'' )	&&		(strstr($thumbnail_alt, '%' )	<>		'' ) ) {
			$temp				=	$thumbnail_alt;
			$temp				=	preg_replace('/%TITLE%/',		$title,					$temp );
			$temp				=	preg_replace('/%EXCERPT%/',		$excerpt,				$temp );
			$temp				=	preg_replace('/%SITE_NAME%/',	$site_name,				$temp );
			$temp				=	preg_replace('/%DOMAIN_URL%/',	$domain_url,			$temp );
			$temp				=	preg_replace('/%DOMAIN%/',		$domain,				$temp );
			$temp				=	preg_replace('/%URL%/',			rawurlencode($url ),	$temp );
			$thumbnail_alt		=	esc_html($temp );
		}

		// 代替テキスト（サイトアイコン）
		if	(($favicon_alt		<>	'' )	&&		(strstr($favicon_alt, '%' )		<>		'' ) )	{
			$temp				=	$favicon_alt;
			$temp				=	preg_replace('/%DOMAIN_URL%/',	$domain_url,			$temp );
			$temp				=	preg_replace('/%DOMAIN%/',		$domain,				$temp );
			$temp				=	preg_replace('/%URL%/',			rawurlencode($url ),	$temp );
			$favicon_alt		=	esc_html($temp );
		}

		// サムネイル取得
		if	($this->options['thumbnail-position'] ) {
			if	($sw_thumbnail == 1 || $sw_thumbnail == 13 ) {						// 直接取得
				if	($is_external ) {
					$thumbnail_url	=	$this->pz_GetThumbnail($thumbnail_url );	// 外部サイトのサムネイルをキャッシュ
				}
				if	($thumbnail_url ) {
					$html_thumbnail		=	'<img class="lkc-thumbnail-img" src="'.$thumbnail_url.'" width="'.$this->options['thumbnail-width'].'" height="'.$this->options['content-height'].'" alt="'.$thumbnail_alt.'" />';
				} elseif	($sw_thumbnail == 13 ) {								// 直接取得に失敗
					$sw_thumbnail	=	3;
				}
			}
			if	($sw_thumbnail == 3 ) {												// WebAPIを利用
				// サムネイル取得WebAPI
				if	($this->options['thumbnail-api'] ) {
					$temp					=	$this->options['thumbnail-api'];
					if	(strstr($temp, '%' )	<>	'' ) {
						$temp				=	preg_replace('/%TITLE%/',		$title,					$temp );
						$temp				=	preg_replace('/%SITE_NAME%/',	$site_name,				$temp );
						$temp				=	preg_replace('/%DOMAIN_URL%/',	$domain_url,			$temp );
						$temp				=	preg_replace('/%DOMAIN%/',		$domain,				$temp );
						$temp				=	preg_replace('/%URL%/',			rawurlencode($url ),	$temp );
					}
					$html_thumbnail	=	'<img class="lkc-thumbnail-img" src="'.$temp.'" width="'.$this->options['thumbnail-width'].'" height="'.$this->options['content-height'].'" alt="'.$thumbnail_alt.'" />';
				}
			}
		}

		// ファビコン取得
		if	($this->options['info-position'] ) {
			if	($sw_favicon == 1 || $sw_favicon == 13 ) {							// 直接取得
				if	($is_internal ) {
					$favicon_url	=	get_site_icon_url(32 );						// 自サイトのサイトアイコン
				}
				if	($favicon_url ) {
					$html_favicon	=	'<img class="lkc-favicon" src="'.$favicon_url.'" alt="'.$favicon_alt.'" width="16" height="16" />';
				} elseif	($sw_favicon == 13 ) {									// 直接取得に失敗
					$sw_favicon	=	3;
				}
			}
			if	($sw_favicon == 3 ) {												// WebAPIを利用
				// サイトアイコン取得WebAPI
				if	($this->options['favicon-api'] ) {
					$temp					=	$this->options['favicon-api'];
					if	(strstr($temp, '%' )	<>	'' ) {
						$temp				=	preg_replace('/%TITLE%/',		$title,					$temp );
						$temp				=	preg_replace('/%SITE_NAME%/',	$site_name,				$temp );
						$temp				=	preg_replace('/%DOMAIN_URL%/',	$domain_url,			$temp );
						$temp				=	preg_replace('/%DOMAIN%/',		$domain,				$temp );
						$temp				=	preg_replace('/%URL%/',			rawurlencode($url ),	$temp );
					}
					$html_favicon	=	'<img class="lkc-favicon" src="'.$temp.'" alt="'.$favicon_alt.'" width="16" height="16" />';
				}
			}
		}

		// リンク先URL
		if	(!$no_failure && $this->options['flg-unlink'] && ($alive_result < 100 || $alive_result >= 400 ) ) {
			// Not Found の時は見え消ししてリンクしない
			$html_a_op_all	=	'<div class="lkc-unlink">';
			$html_a_cl_all	=	'</div>';
			$html_a_op		=	null;
			$html_a_cl		=	null;
			$html_st_op		=	'<strike>';
			$html_st_cl		=	'</strike>';
		} elseif	($this->options['link-all'] ) {
			// カード全体をリンク（どこをクリックしても良いのが分かり易い）
			$html_a_op_all	=	'<a class="lkc-link no_icon" href="'.esc_html($url ).'"'.$target.$rel.'>';
			$html_a_cl_all	=	'</a>';
			$html_a_op		=	null;
			$html_a_cl		=	null;
			$html_st_op		=	null;
			$html_st_cl		=	null;
		} else {
			// タイトルとかURLとかを個別でリンク（タイトルや抜粋文などの文字を範囲指定をしてコピー等がし易い）
			$html_a_op_all	=	null;
			$html_a_cl_all	=	null;
			$html_a_op		=	'<a class="lkc-link no_icon" href="'.esc_html($url ).'"'.$target.$rel.'>';
			$html_a_cl		=	'</a>';
			$html_st_op		=	null;
			$html_st_cl		=	null;
		}

		// ソーシャルカウントの表示
		$sns				=	null;
		$html_sns_title		=	null;
		$html_sns_info		=	null;
		if	($this->options['sns-position'] ) {
			// カード全体をリンクにするときは表示のみ
			if	($this->options['link-all'] ) {
				if	($this->options['sns-tw'] && $sns_tw > 0 ) {
					if	($this->options['sns-tw-x'] ) {
						$sns	.=	' <div class="lkc-sns-tw">'.sprintf(($sns_tw == 1 ? __('%d tweet', $this->text_domain ) : __('%d tweets', $this->text_domain ) ), $sns_tw ).'</div>';
					} else {
						$sns	.=	' <div class="lkc-sns-tw">'.sprintf(($sns_tw == 1 ? __('%d post',  $this->text_domain ) : __('%d posts',  $this->text_domain ) ), $sns_tw ).'</div>';
					}
				}
				if	($this->options['sns-fb'] && $sns_fb > 0 ) {
					$sns	.=	' <div class="lkc-sns-fb">'.sprintf(($sns_fb == 1 ? __('%d share',  $this->text_domain ) : __('%d shares',  $this->text_domain ) ), $sns_fb ).'</div>';
				}
				if	($this->options['sns-hb'] && $sns_hb > 0 ) {
					$sns	.=	' <div class="lkc-sns-hb">'.sprintf(($sns_hb == 1 ? __('%d user',   $this->text_domain ) : __('%d users',   $this->text_domain ) ), $sns_hb ).'</div>';
				}
				if	($this->options['sns-po'] && $sns_po > 0 ) {
					$sns	.=	' <div class="lkc-sns-po">'.sprintf(($sns_po == 1 ? __('%d pocket', $this->text_domain ) : __('%d pockets', $this->text_domain ) ), $sns_po ).'</div>';
				}
			} else {
				// 外部リンクアイコンを表示させるプラグイン対応のため no_icon を付与
				$url_noscheme	=	preg_replace('/.*\/\/(.*)/', '$1', $url );	// スキームを外す
				if	($this->options['sns-tw'] && $sns_tw > 0 ) {
					if	($this->options['sns-tw-x'] ) {
						$sns	.=	' <a class="lkc-sns-tw no_icon" href="https://twitter.com/search?q=' .$url_noscheme.'&text='.esc_html($title ).'" target="_blank">'.$sns_tw.'&nbsp;tweet'.(($sns_tw > 1 ) ? 's' : null ).'</a>';
					} else {
						$sns	.=	' <a class="lkc-sns-tw no_icon" href="https://x.com/search?q=' .$url_noscheme.'&text='.esc_html($title ).'" target="_blank">'.$sns_tw.'&nbsp;post'.(($sns_tw > 1 ) ? 's' : null ).'</a>';
					}
				}
				if	($this->options['sns-fb'] && $sns_fb > 0 ) {
					$sns	.=	' <a class="lkc-sns-fb no_icon" href="https://www.facebook.com/" target="_blank">'.$sns_fb.'&nbsp;share'.(($sns_fb > 1 ) ? 's' : null ).'</a>';
				}
				if	($this->options['sns-hb'] && $sns_hb > 0 ) {
					$sns	.=	' <a class="lkc-sns-hb no_icon" href="https://b.hatena.ne.jp/entry/s/' .$url_noscheme.'" target="_blank">'.$sns_hb.'&nbsp;user'.(($sns_hb > 1 ) ? 's' : null ).'</a>';
				}
				if	($this->options['sns-po'] && $sns_po > 0 ) {
					$sns	.=	' <a class="lkc-sns-po no_icon" href="https://getpocket.com/" target="_blank">'.$sns_po.'&nbsp;pocket'.(($sns_po > 1 ) ? 's' : null ).'</a>';
				}
			}
			if	($sns ) {
				if	($this->options['sns-position'] == 1 ) {
					$html_sns_title	=	'<div class="lkc-share">'.$sns.'</div>';
				} else {
					$html_sns_info	=	'&nbsp;'.'<div class="lkc-share">'.$sns.'</div>';
				}
			}
		}

		// サムネイル
		if	($html_thumbnail ) {
			$html_thumbnail	=	'<figure class="lkc-thumbnail">'.$html_thumbnail.'</figure>';
		}

		// 表示用のURL
		$disp_url			=	esc_html($this->pz_DecodeURL($url, true ) );

		// 続きを読むボタン
		if	($more && $more_text ) {
			$html_moretag	=	'<div class="lkc-more">'.$html_a_op.'<div class="lkc-more-text">'.$more_text.'</div>'.$html_a_cl.'</div>';
		} else {
			$html_moretag	=	null;
		}

		// リンク先URL
		$html_url1			=	null;
		$html_url2			=	null;
		switch	($this->options['display-url'] ) {
		case	1:
			$html_url1	=	'<div class="lkc-url" title="'.esc_html($url ).'">'.	$html_a_op.		$html_st_op.	$disp_url.		$html_st_cl.	$html_a_cl.		'</div>';
			break;
		case	2:
			$html_url2	=	'&nbsp;<div class="lkc-url-info">'.	$html_a_op.			$html_st_op.	$disp_url.		$html_st_cl.	$html_a_cl.		'</div>';
			break;
		}

		// サイト情報
		if	($info_text ) {
			$added_info	=	$html_added_op.$info_text.$html_added_cl;
		} else {
			$added_info	=	null;
		}

		// 投稿日
		if	($this->options['display-date'] && $post_date && $is_internal ) {
			$info_date	=	'<div class="lkc-date">'.date('Y.m.d', strtotime($post_date ) ).'</div>';
		} else {
			$info_date	=	null;
		}
		$domain_info	=	'<div class="lkc-info">'.$html_a_op.$html_favicon.'<div class="lkc-domain"'.$title_sitename.'>'.$disp_sitename.'</div>'.$added_info.$html_a_cl.$html_sns_info.$html_url2.$info_date.'</div>';

		// Google AMP用 簡易タグ作成
		if	($this->amp <> 2 ) {
			if	($this->amp === 0 ) {
				$this->amp			=	2;		// 仮に 2:通常（非AMP）とする
				if	((function_exists('ampforwp_is_amp_endpoint' ) && ampforwp_is_amp_endpoint() ) || (function_exists('is_amp_endpoint' ) && is_amp_endpoint() ) || (function_exists('is_amp' ) && is_amp() ) ) {
					$this->amp		=	1;		// 1:AMP
				} else {
					if ($this->options['flg-amp-url'] ) {
						$url_now = $_SERVER["REQUEST_URI"];
						if ((substr($url_now, 4 ) === '/amp' ) || (substr($url_now, 5 ) === '/amp/' ) || (substr($url_now, 6 ) === '?amp=1' ) || (substr($url_now, 8 ) === 'type=AMP' ) ) {
							$this->amp	=	1;		// 1:AMP
						}
					}
				}
			}
			if	($this->amp === 1 ) {
				$html_tag		=	'<div class="lkc-external amp"><table border="1" cellspacing="0" cellpadding="4"><tr><td>'.$excerpt.'<br/><a href="'.esc_url($url ).'"'.$target.$rel.'>'.$title.'</a>&nbsp;-&nbsp;'.$site_name.'</td></tr></table></div>';
				return	$html_tag;		// タグを出力して終了
			}
		}

		// HTMLタグ作成
		switch	($this->options['info-position'] ) {
		case	1:		// 上側
			$tag	=	
				$html_wrap_op.
					$html_a_op_all.
						'<div class="lkc-card">'.
							$domain_info.
							'<div class="lkc-content">'.
								$html_a_op.
									$html_thumbnail.
									'<div class="lkc-title">'.
										$title.
									'</div>'.
								$html_a_cl.
								$html_sns_title.
								$html_url1.
								'<div class="lkc-excerpt">'.
									$excerpt.
								'</div>'.
								$html_moretag.
							'</div>'.
							'<div class="clear">
							</div>
						</div>'.
					$html_a_cl_all.
				$html_wrap_cl
			;
			break;
		case	2:		// 下側
			$tag	=	
				$html_wrap_op.
					$html_a_op_all.
						'<div class="lkc-card">'.
							'<div class="lkc-content">'.
								$html_a_op.
									$html_thumbnail.
									'<div class="lkc-title">'.
										$title.
									'</div>'.
								$html_a_cl.
								$html_sns_title.
								$html_url1.
								'<div class="lkc-excerpt">'.
									$excerpt.
								'</div>'.
								$html_moretag.
							'</div>'.
							$domain_info.
							'<div class="clear">
							</div>
						</div>'.
					$html_a_cl_all.
				$html_wrap_cl
			;
			break;
		case	3:		// タイトルの上側
			$tag	=	
			$html_wrap_op.$html_a_op_all.'<div class="lkc-card"><div class="lkc-content">'.$html_a_op.$html_thumbnail.$domain_info.$html_a_cl.$html_a_op.'<div class="lkc-title">'.'<div class="lkc-title-text">'.$title.'</div></div>'.$html_a_cl.$html_sns_title.$html_url1.'<div class="lkc-excerpt">'.$excerpt.'</div>'.$html_moretag.'</div><div class="clear"></div></div>'.$html_a_cl_all.$html_wrap_cl;


			break;
		default:
			$tag	=	$html_wrap_op.$html_a_op_all.'<div class="lkc-card"><div class="lkc-content">'.$html_a_op.$html_thumbnail.'<div class="lkc-title"><div class="lkc-title-text">'.$title.'</div>'.$html_sns_title.'</div>'.$html_a_cl.$html_url1.'<div class="lkc-excerpt">'.$excerpt.'</div>'.$html_moretag.'</div><div class="clear"></div></div>'.$html_a_cl_all.$html_wrap_cl;
		}

		// 引用文扱い
		if	($this->options['blockquote'] ) {
			$tag	=	'<div class="'.$class_id.'"><blockquote class="lkc-quote">'.$tag.'</blockquote></div>';
		} else {
			$tag	=	'<div class="'.$class_id.'">'.$tag.'</div>';
		}

		return	$tag;
	}

	// URLのエンコード（DB格納用のURL作成）
	private	function	pz_EncodeURL($url = null, $sanitize = false ) {
		// URLのサニタイズ
		if	($sanitize ) {
			$url	=	$this->pz_SanitizeURL($url );
		}

		// URL指定なし
		if	(!$url ) {
			return	null;
		}

		// 日本語がある
		if	(!preg_match("/^[\x20-\x7E]+$/", $url ) ) {
			// 国際ドメイン対応（日本語ドメイン対応）
			$url_info			=	$this->pz_GetURLInfo($url );
			if	(function_exists('idn_to_utf8' ) && !preg_match("/^[\x20-\x7E]+$/", $url_info['domain'] ) ) {
				$domain_before	=	(isset($url_info['scheme'] ) ? $url_info['scheme'] : null).'://'.(isset($url_info['domain'] ) ? $url_info['domain'] : null);
				$domain_after	=	(isset($url_info['scheme'] ) ? $url_info['scheme'] : null).'://'.(isset($url_info['domain'] ) ? idn_to_ascii($url_info['domain'], 0, INTL_IDNA_VARIANT_UTS46 ) : null);
				$url			=	$domain_after.mb_substr($url, mb_strlen($domain_before ) );		// URLのスキーム＋ドメイン部分だけ入れ替え
			}

			// 日本語がある
			if	(!preg_match("/^[\x20-\x7E]+$/", $url ) ) {
				$url	=	$this->pz_EncodeURI($url );			// エンティティ化
			}
		}

		// エンコードしたURLを返却
		return		$url;
	}

	// URLのデコード（表示用URL作成）
	private	function	pz_DecodeURL($url = null, $sanitize = false ) {
		// URLのサニタイズ
		if	($sanitize ) {
			$url	=	$this->pz_SanitizeURL($url );
		}

		// URL指定なし
		if	(!$url ) {
			return	null;
		}

		// 国際ドメイン対応（日本語ドメイン対応）
		$url_info			=	$this->pz_GetURLInfo($url );
		if	(function_exists('idn_to_utf8' ) && substr($url_info['domain'], 0, 4 ) == 'xn--' ) {
			$domain_before	=	(isset($url_info['scheme'] ) ? $url_info['scheme'] : null).'://'.(isset($url_info['domain'] ) ? $url_info['domain'] : null);
			$domain_after	=	(isset($url_info['scheme'] ) ? $url_info['scheme'] : null).'://'.(isset($url_info['domain'] ) ? idn_to_utf8($url_info['domain'], 0, INTL_IDNA_VARIANT_UTS46 ) : null);
			$url			=	$domain_after.mb_substr($url, mb_strlen($domain_before ) );		// URLのスキーム＋ドメイン部分だけ入れ替え
		}

		// エンティティ文字のデコード
		do {
			$url			=	rawurldecode($url );
		} while (mb_strpos($url, '%25' ) !== false );	// %25 = % が残っていたら、再度デコード

		// 半角空白があったらエンティティ化（エンコード）
		$url				=	str_replace(' ', '%20', $url );
		$url				=	str_replace("'", '%27', $url );

		// HTMLタグをエスケープ
		$url				=	htmlspecialchars($url );

		// デコードしたURLを返却
		return		$url;
	}

	// URLのサニタイズ
	private	function	pz_SanitizeURL($url = null ) {

		// URL指定なし
		if	(!$url ) {
			return	null;
		}

		// Aタグがあったら最初にあるAタグのhrefを持ってくる
		//if	(preg_match('/<a .*href\s*=\s*[\'"]?([^ \'"<>$]+)/sui', $url, $m ) ) {
		//	$url	=	$m[1];
		//}

		// 前後のクォート文字を除去する
		$url	=	preg_replace('/^[\'"‘’“”″]+|[\'"‘’“”″]+$/', '', $url );
		$url	=	str_replace(' ', '+', $url );

		// 最初にあるURLっぽいのを持ってくる
		if	(preg_match('/((https?|file|ftp|data|ogg):\/\/[^\s<>]+)/sui', $url, $m ) ) {
			$url	=	$m[1];
		}

		// エスケープ
		$url	=	str_replace(array(' ', "'" ), array('+', '%27' ), $url );
		$url	=	esc_url($url );

		// 最後のスラッシュの除去
		switch	($this->options['trail-slash'] ) {
		case	1:							// URLがドメイン名だけの場合、最後のスラッシュを除外する
			$url_info			=	$this->pz_GetURLInfo($url );
			if	(!isset($url_info['path'] ) || $url_info['path'] == '/' ) {
				$url	=	rtrim($url, '/' );
			}
			break;
		case	2:							// 常に最後のスラッシュを除外する
			$url	=	rtrim($url, '/' );
			break;
		}

		// エンティティ文字がある
		if	(mb_strpos($url, '%' ) !== false) {
			$url	=	$this->pz_DecodeURL($url ,false );
		}

		// 日本語がある
		if	(!preg_match('/^[\x20-\x7E]+$/', $url ) ) {
			$url		=	$this->pz_EncodeURL($url, false);
		}

		// サニタイズしたURLを返却する（エンティティ化済）
		return	$url;
	}

	// 内部サイト・外部サイトの判断
	private	function	pz_GetURLInfo($url ) {
		// URLの指定なし
		if	(!isset($url ) ) {
			return	null;
		}

		// 内部リンク判定
		$domain_url			=	$this->home_url;									// ドメインURL
		if	(mb_substr($url, 0, mb_strlen($domain_url ) ) == $domain_url ) {
			$is_external	=	false;
			$is_samepage	=	false;
			$is_internal	=	true;		// 内部リンク
			$url_m			=	parse_url($domain_url );							// URLパース（ドメイン名などを抽出）
			$scheme			=	isset($url_m['scheme'] ) ? $url_m['scheme']	: null;	// スキーム
			$domain			=	mb_substr($domain_url, mb_strlen($scheme ) + 3 );	// ドメイン
			if	(get_permalink() == $url ) {
				$is_samepage	=	true;	// 同一ページリンク
			}
		} else {
			$is_external	=	true;		// 外部リンク
			$is_samepage	=	false;
			$is_internal	=	false;
			$url_m			=	parse_url($url );									// URLパース（ドメイン名などを抽出）
			$scheme			=	isset($url_m['scheme'] )	? $url_m['scheme']				: null;		// スキーム
			$scheme_c		=	$scheme						? $scheme.':'					: null;
			$domain			=	isset($url_m['host'] )		? $url_m['host']				: null;		// ドメイン名
			$domain_url		=	isset($url_m['host'] )		? $scheme_c.'//'.$url_m['host']	: null;		// ドメインURL
		}

		// サブディレクトリ型マルチサイト対応（内部リンク判定の場合のみ）
		if	($is_internal && function_exists('is_multisite' ) && is_multisite() && function_exists('is_subdomain_install' ) && !is_subdomain_install() && function_exists('is_main_site' ) && is_main_site() ) {
			$blog_myid		=	get_current_blog_id();
			$blog_id		=	0;
			for ($i = 1; $i <= 1000; $i++ ) {
				$blog_url	=	get_site_url($i );
				if	(!$blog_url ) {
					break;
				}
				if	($i <> $blog_myid ) {
					if (mb_substr($url, 0, mb_strlen($blog_url ) ) == $blog_url ) {
						$domain_url		=	$blog_url;
						$domain			=	preg_replace('/.*\/\/(.*)/', '$1', $blog_url );
						$is_external	=	true;		// 外部リンク
						$is_samepage	=	false;
						$is_internal	=	false;
						break;
					}
				}
			}
		}

		// 返り値
		$ret_arr['is_external']	=	$is_external;		// 外部リンク
		$ret_arr['is_internal']	=	$is_internal;		// 内部リンク
		$ret_arr['is_samepage']	=	$is_samepage;		// 同一ページリンク
		$ret_arr['scheme']		=	$scheme;			// スキーム
		$ret_arr['domain']		=	$domain;			// ドメイン
		$ret_arr['domain_url']	=	$domain_url;		// ドメインURL
		$ret_arr['port']		=	isset($url_m['port'] )		? $url_m['port']		: null;		// ポート
		$ret_arr['user']		=	isset($url_m['user'] )		? $url_m['user']		: null;		// ユーザー名
		$ret_arr['pass']		=	isset($url_m['pass'] )		? $url_m['pass']		: null;		// パスワード
		$ret_arr['path']		=	isset($url_m['path'] )		? $url_m['path']		: null;		// パス（ドメイン名以降）
		$ret_arr['query']		=	isset($url_m['query'] )		? $url_m['query']		: null;		// クエスチョンマーク ? 以降
		$ret_arr['fragment']	=	isset($url_m['fragment'] )	? $url_m['fragment']	: null;		// ハッシュマーク # 以降

		return		$ret_arr;
	}

	// 相対パスをURLにする
	private	function	pz_RelToURL($base_url = null, $rel_path = null ) {
		if	($this->options['debug-mode'] ) {
			echo	'<!-- Pz-LkC [pz_RelToURL]'.PHP_EOL;
			echo	'$base_url='.esc_html($base_url ).PHP_EOL;
			echo	'$rel_path='.esc_html($rel_path ).PHP_EOL;
			echo	'/-->'.PHP_EOL;
		}

		// ベースURLをパース
		$base_url	=	$this->Pz_SanitizeURL($base_url );					// 念のためサニタイズ
		$info_base	=	$this->Pz_GetURLInfo($base_url );
		$info_rel	=	$this->Pz_GetURLInfo($rel_path );

		// 絶対パスだった場合（スキームあり）
		if	($info_rel['scheme'] ) {
			$return_url	=	$rel_path;
			return			$return_url;
		}

		// 絶対パスだった場合（スキーム省略）
		if	(substr($rel_path, 0, 2 )	==	'//' ) {
			$return_url	=	$info_base['scheme'].':'.$rel_path;
			return			$return_url;
		}

		// ルート指定
		if	(substr($rel_path, 0, 1 )	==	'/' ) {
			$return_url	=	$info_base['domain_url'].$rel_path;
			return			$return_url;
		}

		// とりあえずくっつける
		$return_url		=	trim($base_url, '/' ).'/'.$rel_path;
		return				$return_url;
	}

	// 日本語URLをHTMLエンコードする
	private	function	pz_EncodeURI($url ) {
		$pattern	=
			array(
				// UnEscaped
				'%2D'=>'-', '%5F'=>'_', '%2E'=>'.', '%21'=>'!', '%25'=>'%', '%7E'=>'~', '%2A'=>'*', '%28'=>'(', '%29'=>')',
				// Reserved
				'%3B'=>';', '%2C'=>',', '%2F'=>'/', '%3F'=>'?', '%3A'=>':', '%40'=>'@', '%26'=>'&', '%3D'=>'=', '%2B'=>'+', '%24'=>'$',
				// Score
				'%23'=>'#'
			);
		$url		=	rawurlencode($url );
		$url		=	strtr($url, $pattern);
		return		$url;
	}

	// ソーシャルカウント取得
	private	function	pz_RenewSNSCount($data ) {
		if	($this->options['debug-mode'] ) {
			echo	'<!-- Pz-LkC [pz_RenerSNSCount]'.PHP_EOL;
			echo	'$data="'.esc_html(print_r($data, true ) ).'"<br>';
			echo	'/-->'.PHP_EOL;
		}
		if	(!$this->options['sns-position'] ) {
			return	null;
		}
		if	(!isset($data ) || !is_array($data ) ) {
			return	null;
		}

		$data	=	$this->pz_GetCache($data );
		if	(!isset($data ) || !is_array($data ) ) {
			return	null;
		}

		// ソーシャルカウント
		$sns_renew	= false;
		$update_cnt	= false;

		// タイムオーバー
		$opt	=	array('timeout' => 30 );

		// 保存期間満了でソーシャルカウントをリセット
		if	($this->now > $data['sns_nexttime'] && $data['update_result'] >= 100 && $data['update_result'] < 400 ) {
			$sns_renew		=	true;
		}

		// エンコードURL
		$url_raw	=	rawurlencode($data['url'] );

		// Twitter Digitminimiのcount.jsoonを使用
		//if	(isset($this->options['sns-tw'] ) && !is_null($this->options['sns-tw'] ) ) {
		//	$count_before	=	isset($data['sns_twitter'] ) ? $data['sns_twitter'] : -1;
		//	if	($sns_renew || $count_before < 0 ) {
		//		$result	=	wp_safe_remote_get('https://jsoon.digitiminimi.com/twitter/count.json?url=' .$url_raw, $opt );
		//		if	(isset($result ) && !is_wp_error($result ) && $result['response']['code'] == 200 ) {
		//			$json 	=	json_decode($result['body'] );
		//			$count	=	intval($json->count );
		//			if	($count > $count_before ) {
		//				$data['sns_twitter']	=	$count;
		//				$update_cnt	=	true;
		//			}
		//		}
		//	}
		//}

		// facebook
		//if	(isset($this->options['sns-fb'] ) && !is_null($this->options['sns-fb'] ) ) {
		//	$count_before	=	intval(isset($data['sns_facebook'] ) ? $data['sns_facebook'] : -1 );
		//	if	($sns_renew || $count_before < 0 ) {
		//		$result	=	wp_safe_remote_get('https://graph.facebook.com?fields=og_object{engagement}&id=' .$url_raw, $opt );
		//		if	(isset($result ) && !is_wp_error($result ) && $result['response']['code'] == 200 ) {
		//			$json 	=	json_decode($result['body'] );
		//			$count	=	intval($json->{'og_object'}->{'engagement'}->{'count'});
		//			if	($count > $count_before ) {
		//				$data['sns_facebook']	=	$count;
		//				$update_cnt	=	true;
		//			}
		//		}
		//	}
		//}

		// はてなブックマーク
		if	(isset($this->options['sns-hb'] ) && !is_null($this->options['sns-hb'] ) ) {
			$count_before	=	isset($data['sns_hatena'] ) ? $data['sns_hatena'] : -1;
			if	($sns_renew || $count_before < 0 ) {
				$result	=	wp_safe_remote_get('http://api.b.st-hatena.com/entry.count?url=' .$url_raw, $opt );
				if	(isset($result ) && !is_wp_error($result ) && $result['response']['code'] == 200 ) {
					$count	=	intval($result['body'] );
					if	($count > $count_before ) {
						$data['sns_hatena']	=	$count;
						$update_cnt	=	true;
					}
				}
			}
		}

		// Pocket
		if	(isset($this->options['sns-po'] ) && !is_null($this->options['sns-po'] ) ) {
			$count_before	=	isset($data['sns_pocket'] ) ? $data['sns_pocket'] : -1;
			if	($sns_renew || $count_before < 0 ) {
				$result	=	wp_safe_remote_get('https://widgets.getpocket.com/api/saves?url=' .$url_raw, $opt );
				if	(isset($result ) && !is_wp_error($result ) && $result['response']['code'] == 200 ) {
					$json 	=	json_decode($result['body'] );
					$count	=	intval($json->saves );
					if	($count > $count_before ) {
						$data['sns_pocket']	=	$count;
						$update_cnt	=	true;
					}
				}
			}
		}

		// 登録してから一週間までは毎日、それ以降は週一回更新（取得が固まらないようにランダム時間付与）
		$data['sns_time']			=	$this->now;
		if	($update_cnt || ($this->now - $data['regist_time'] < WEEK_IN_SECONDS ) ) {
			$data['sns_nexttime']	=	$this->now + DAY_IN_SECONDS + rand(0, DAY_IN_SECONDS );	// 1day + 0-24h
		} else {
			$data['sns_nexttime']	=	$this->now + WEEK_IN_SECONDS + rand(0, DAY_IN_SECONDS );	// 7days + 0-24h
		}
		// MINUTE_IN_SECONDS	= 60
		// HOUR_IN_SECONDS		= 60	*	MINUTE_IN_SECONDS	= 3600
		// DAY_IN_SECONDS		= 24	*	HOUR_IN_SECONDS		= 86400
		// WEEK_IN_SECONDS		= 7		*	DAY_IN_SECONDS		= 604800
		// YEAR_IN_SECONDS		= 365	*	DAY_IN_SECONDS

		// DBの宣言
		global	$wpdb;

		// DB更新
		$result	=	$wpdb->update($this->db_name, $data, array('id' => $data['id'] ) );

		return	$data;
	}

	// キャッシュデータを取得
	private	function	pz_GetCache($data ) {
		if	(!isset($data ) || !is_array($data ) ) {
			return	null;
		}
		global	$wpdb;
		if	(!empty($data['url'] ) ) {
			$url		=	$data['url'];
			$data		=	$wpdb->get_row($wpdb->prepare("SELECT * FROM $this->db_name WHERE url=%s", $url ) );
		} elseif	(isset($data['id'] ) && !is_null($data['id'] ) ) {
			$data_id	=	intval($data['id'] );
			$data		=	$wpdb->get_row($wpdb->prepare("SELECT * FROM $this->db_name WHERE id=%d", $data_id ) );
		} else {
			return	null;
		}
		if	($wpdb->last_error ) {			// DBエラーのとき、初期化する
			$this->activate();
		}

		if	(is_wp_error($data ) ) {
			return	null;
		}
		return (array) $data;				// Arrayに直して返す
	}

	// キャッシュデータを保存
	private	function	pz_SetCache($data ) {
		// 項目が空っぽ
		if	(!isset($data ) || !is_array($data ) ) {
			return	null;
		}
		if	(!isset($data['url'] ) || !$data['url'] ) {
			return	null;
		}

		// リンク先URL
		$url					=	$this->pz_EncodeURL($data['url'] ,true );
		if	(!$url ) {
			return	null;
		}

		// URL戻す
		$data['url']			=	$url;

		// URLからキーの生成
		$data['url_key']		=	hash('sha256', $url, true );

		// ID
		if	(isset($data['id'] ) && !$data['id'] ) {
			unset($data['id']);
		}

		// URL解析（自サイトチェック）
		$url_info					=	$this->Pz_GetURLInfo($url );
		$data['scheme']				=	$url_info['scheme'];														// スキーム
		$data['domain']				=	$url_info['domain'];														// ドメイン名

		// 記事内容等
		$data['site_name']			=	isset($data['site_name'] )		? $data['site_name']		: null;			// リンク先：サイト名称
		$data['title']				=	isset($data['title'] )			? $data['title']			: null;			// リンク先：タイトル
		$data['excerpt']			=	isset($data['excerpt'] )		? $data['excerpt']			: null;			// リンク先：抜粋文
		$data['thumbnail']			=	isset($data['thumbnail'] )		? $data['thumbnail']		: null;			// リンク先：サムネイルURL
		$data['favicon']			=	isset($data['favicon'] )		? $data['favicon']			: null;			// リンク先：サイトアイコンURL
		$data['charset']			=	isset($data['charset'] )		? $data['charset']			: 'Unknown';	// リンク先：文字コード
		if	(!isset($data['update_result'] ) || $data['update_result'] <= 0 ) {
			$data['update_result']	=	200;
		}
		$data['no_failure']			=	isset($data['no_failure'] )		? $data['no_failure']		: 0 ;			// 結果コードがエラーでも成功と見なす

		// 登録時情報
		if	(!isset($data['regist_time'] ) || !$data['regist_time'] ) {
			$data['regist_title']	=	$data['title'];																// 登録時：タイトル
			$data['regist_excerpt']	=	$data['excerpt'];															// 登録時：抜粋文
			$data['regist_charset']	=	$data['charset'];															// 登録時：文字コード
			$data['regist_result']	=	$data['update_result'];														// 登録時：結果コード
			$data['regist_time']	=	$this->now;
		}

		// 日本語項目のエンティティ文字を出コード
		$data['title']				=	html_entity_decode($data['title'] );										// リンク先：タイトル
		$data['excerpt']			=	html_entity_decode($data['excerpt'] );										// リンク先：抜粋文
		$data['regist_title']		=	html_entity_decode($data['regist_title'] );									// 登録時：タイトル
		$data['regist_excerpt']		=	html_entity_decode($data['regist_excerpt'] );								// 登録時：抜粋文

		// 生存確認
		if	(!isset($data['alive_time'] ) || !$data['alive_time'] ) {
			$data['alive_result']	=	$data['update_result'];
			$data['alive_time']		=	$this->now;
			$data['alive_nexttime']	=	$this->now + WEEK_IN_SECONDS * 4 + rand(0, DAY_IN_SECONDS );
		}

		// SNS関連
		$data['sns_twitter']		=	isset($data['sns_twitter']	)	? $data['sns_twitter']		: -1;			// SNS：Twitter
		$data['sns_facebook']		=	isset($data['sns_facebook'] )	? $data['sns_facebook']		: -1;			// SNS：facebook
		$data['sns_hatena']			=	isset($data['sns_hatena'] )		? $data['sns_hatena']		: -1;			// SNS：はてなブックマーク
		$data['sns_pocket']			=	isset($data['sns_pocket'] )		? $data['sns_pocket']		: -1;			// SNS：ポケット
		$data['sns_nexttime']		=	isset($data['sns_nexttime'] )	? $data['sns_nexttime']		: $this->now;	// SNS：次回取得日時
		$data['sns_time']			=	isset($data['sns_time'] )		? $data['sns_time']			: $this->now;	// SNS：最終取得日時

		// 使われている記事ID
		global	$wpdb;
		$use_post_id_t				=	$wpdb->get_results($wpdb->prepare("SELECT id FROM $wpdb->prefix"."posts WHERE post_type = 'post' AND post_content LIKE '%%%s%%' ORDER BY id ASC", $data['url'] ) );
		if	($use_post_id_t ) {
			$use_post_id_t			=	(array) $use_post_id_t[0];
			$use_post_id_t			=	array_unique($use_post_id_t );
			$use_post_id_t			=	array_values($use_post_id_t );
		} else {
			$use_post_id_t			=	array();
		}
		$data['use_post_id1']		=	isset($use_post_id_t[0])		? $use_post_id_t[0]			: null;
		$data['use_post_id2']		=	isset($use_post_id_t[1])		? $use_post_id_t[1]			: null;
		$data['use_post_id3']		=	isset($use_post_id_t[2])		? $use_post_id_t[2]			: null;
		$data['use_post_id4']		=	isset($use_post_id_t[3])		? $use_post_id_t[3]			: null;
		$data['use_post_id5']		=	isset($use_post_id_t[4])		? $use_post_id_t[4]			: null;
		$data['use_post_id6']		=	isset($use_post_id_t[5])		? $use_post_id_t[5]			: null;

		// 更新内容
		$data['mod_title']			=	($data['title'] <> $data['regist_title'] ? true : false );					// 更新：登録後からタイトル変更有無
		$data['mod_excerpt']		=	($data['title'] <> $data['regist_title'] ? true : false );					// 更新：登録後から抜粋文変更有無

		// 最終更新日時
		$data['update_time']		=	$this->now;

		// DB更新キー取得
		if	(!isset($data['id'] ) || !$data['id']) {
			$now	=	$this->pz_GetCache(array('url' => $data['url'] ) );
			if	(isset($now['id'] ) ) {
				$data['id']	=	$now['id'];
			}
		}

		// DB更新
		global	$wpdb;
		$result		=	null;
		if	(isset($data['id'] ) ) {
			$result	=	$wpdb->update($this->db_name, $data, array('id' => $data['id'] ) );
		}

		// DB更新失敗の場合、挿入
		if	(!$result ) {
			// 新規の場合、IDをクリア
			unset($data['id'] );
			$result	=	$wpdb->insert($this->db_name, $data );
			// DB挿入失敗の場合、日本語項目（サイト名）をクリアして挿入
			if	(!$result ) {
				unset($data['site_name'] );
				$result =	$wpdb->insert($this->db_name, $data );
				// DB挿入失敗の場合、日本語項目（概要文）をクリアして挿入
				if	(!$result ) {
					unset($data['excerpt'] );
					$result =	$wpdb->insert($this->db_name, $data );
					// DB挿入失敗の場合、日本語項目（タイトル）をクリアして挿入
					if	(!$result ) {
						unset($data['title'] );
						$result =	$wpdb->insert($this->db_name, $data );
						// DB挿入失敗の場合、諦める
						if	(!$result ) {
							return	null;
						}
					}
				}
			}
		}
		return	$this->pz_GetCache($data );	// 登録された内容を読み直す
	}

	// キャッシュデータを削除
	private	function	pz_DelCache($data ) {
		global	$wpdb;
		if	(!isset($data ) || !is_array($data ) ) {
			return	null;
		}
		if	(isset($data['id'] ) ) {
			$result		=	$wpdb->delete($this->db_name, array('id' => $data['id'] ), array('%d' ) );
			if	($result ) {
				return	true;
			}
		}
		if	(isset($data['url'] ) ) {
			$result		=	$wpdb->delete($this->db_name, array('url' => $data['url'] ), array('%s' ) );
			if	($result ) {
				return	true;
			}
		}
		return	null;
	}

	// 内部リンク・記事情報取得
	private	function	pz_GetPost($data ) {
		// 初期化
		$url			=	null;
		$post_id		=	null;
		$site_name		=	null;
		$domain_url		=	null;
		$domain			=	null;
		$title			=	null;
		$excerpt		=	null;
		$thumbnail		=	null;
		$favicon		=	null;
		$post_date		=	0;
		$post_fodified	=	0;

		// サイト名取得
		$site_name		=	get_bloginfo('name' );

		// ドメイン名
		$domain			=	$this->domain;
		$domain_url		=	$this->domain_url;

		// サイトアイコン
		if	(function_exists('has_site_icon' ) && has_site_icon() ) {
			$favicon		=	get_site_icon_url(16, null, 0 );
		}

		// 記事内容
		$url					=	$data['url'];
		$post_id				=	url_to_postid($url );				// 記事IDを取得
		if	($this->options['debug-mode'] ) {
			echo	'<!-- Pz-LkC [PID='.$post_id.'] /-->'.PHP_EOL;
		}

		if	(!$post_id && $this->options['flg-get-pid'] ) {
			$url				=	$this->Pz_GetRedirURL($data );		// 本当の記事URLを取得
			$post_id			=	url_to_postid($url );				// 記事IDを取得
			if	($this->options['debug-mode'] ) {
				echo	'<!-- Pz-LkC [PID='.$post_id.'(REDIR)] /-->'.PHP_EOL;
			}
		}

		if	($post_id ) {
			// 記事IDが取得できた場合
			$update_result		=	200;						// 外部取得と同じコードをセット
			$post				=	get_post($post_id );		// 記事情報
			$title				=	$post->post_title;			// 記事タイトル
			$excerpt			=	$post->post_content;		// 記事内容から抜粋
			if	($this->options['in-get'] == 1 && $post->post_excerpt ) {
				$excerpt		=	$post->post_excerpt;		// 抜粋文
			}
			$post_date			=	$post->post_date;			// 投稿日
			$post_modified		=	$post->post_modified;		// 更新日
			$thumbnail_id		=	get_post_thumbnail_id($post_id );	// サムネイル
			if	($thumbnail_id ) {
				$thumbnail_size		=	$this->options['in-thumbnail-size'] ? $this->options['in-thumbnail-size'] : 'thumbnail' ;
				$attach				=	wp_get_attachment_image_src($thumbnail_id, $thumbnail_size, true );
				if	(isset($attach ) && count($attach ) > 3 && isset($attach[0] ) ) {
					$thumbnail		=	$attach[0];
					if	(preg_match('/.*(\/\/.*)/', $thumbnail, $m ) ) {		// スキームを外す
						$thumbnail	=	$m[1];
					}
				}
			}
		} else {
			// 記事IDが取得できなかった場合
			$update_result		=	404;
			$title				=	get_bloginfo('name' );
			$excerpt			=	get_bloginfo('description' );
			$post_date			=	0;
			$post_modified		=	0;
			$thumbnail			=	null;

			// カテゴリ ページの処理
			$cat_dir			=	get_option('category_base' );
			$cat_url			=	$this->domain_url.'/'.($cat_dir ? $cat_dir : 'category' ).'/';
			$cat_len			=	mb_strlen($cat_url );
			if	(mb_substr($url, 0, $cat_len ) == $cat_url ) {
				$cat_slug		=	mb_substr($url, $cat_len );
				$cat_data		=	get_category_by_slug($cat_slug );
				if	($cat_data ) {
					$cat_count		=	($cat_data->count - 0 );
					$title			=	__('Category', $this->text_domain ).' '.__('‘', $this->text_domain ).$cat_data->name.__('’', $this->text_domain );
					$excerpt		=	__('(', $this->text_domain ).__('Count', $this->text_domain ).':'.($cat_data->count - 0 ).__(')', $this->text_domain ).' '.$cat_data->description;
					$update_result	=	200;
				} else {
					$title			=	__('Category', $this->text_domain ).' '.__('‘', $this->text_domain ).rawurldecode($cat_slug ).__('’', $this->text_domain );
					$excerpt		=	__('Not Found', $this->text_domain );
					$update_result	=	403;
				}
			} else {
				// タグ ページの処理
				$cat_dir			=	get_option('tag_base' );
				$cat_url			=	$this->domain_url.'/'.($cat_dir ? $cat_dir : 'tag' ).'/';
				$cat_len			=	mb_strlen($cat_url );
				if	(mb_substr($url, 0, $cat_len ) == $cat_url ) {
					$cat_slug		=	mb_substr($url, $cat_len );
					$cat_data		=	get_tags(array('slug' => $cat_slug ) );
					if	($cat_data ) {
						$title			=	__('Tag', $this->text_domain ).' '.__('‘', $this->text_domain ).$cat_data[0]->name.__('’', $this->text_domain );
						$excerpt		=	__('(', $this->text_domain ).__('Count', $this->text_domain ).':'.($cat_data[0]->count - 0 ).__(')', $this->text_domain ).' '.$cat_data[0]->description;
						$update_result	=	200;
					} else {
						$title			=	__('Tag', $this->text_domain ).' '.__('‘', $this->text_domain ).rawurldecode($cat_slug ).__('’', $this->text_domain );
						$excerpt		=	__('Not Found', $this->text_domain );
						$update_result	=	403;
					}
				} else {
					if	(!$post_id && $this->options['flg-get-pid'] ) {
						$data		=	$this->Pz_GetCURL($data );		// 外部サイトとして読み込み
						return			$data;
					}
				}
			}
		}

		// タイトル整形
		if				($str	=	$title ) {										// 代入しながら判定
			if			($str	=	strip_tags($str ) ) {							// HTMLタグ除去
				if		($str	=	esc_html($str ) ) {								// HTMLエスケープ
					if	($str	=	str_replace(array("\r", "\n"), '', $str ) ) {	// 改行を除去
						$str	=	mb_strimwidth($str, 0, 200, '...' );			// 200文字制限
					}
				}
			}
			$title		=	$str;
		}

		// 抜粋文整形
		if							($str	=	$excerpt ) {										// 代入しながら判定
			if						($str	=	strip_tags($str ) ) {								// HTMLタグ除去
				if					($str	=	esc_html($str ) ) {									// HTMLエスケープ
					if				($str	=	str_replace(array("\r", "\n"), '', $str ) ) {		// 改行を除去
						if			($str	=	preg_replace('/<!--more-->.+/is', '', $str ) ) {	// moreタグ以降削除
							if		($str	=	preg_replace('/\[[^]]*\]/', '', $str ) ) {			// ショートコードすべて除去
									$str	=	mb_strimwidth($str, 0, 500, '...' );				// 500文字制限
							}
						}
					}
				}
			}
			$excerpt		=	$str;
		}

		// データセット
		if	(isset($data['title'] ) && $data['title'] == $title ) {
			$before['mod_title']	=	false;
		} else {
			$before['mod_title']	=	true;
		}
		if	(isset($data['excerpt'] ) && $data['excerpt'] == $excerpt ) {
			$before['mod_excerpt']	=	false;
		} else {
			$before['mod_excerpt']	=	true;
		}
		if	(!isset($data['use_post_id1'] ) ) {
			$data['use_post_id1']	=	get_the_ID();
		}
		$url_info					=	$this->Pz_GetURLInfo($url );	// URL解析（自サイトチェック）
		$data['scheme']				=	$url_info['scheme'];			// スキーム
		$data['domain']				=	$url_info['domain'];			// ドメイン名
		$data['site_name']			=	$site_name;
		$data['title']				=	$title;
		$data['excerpt']			=	$excerpt;
		$data['thumbnail']			=	$thumbnail;
		$data['favicon']			=	$favicon;
		$data['charset']			=	'UTF-8';
		$data['update_result']		=	$update_result;
		$data['alive_result']		=	$update_result;
		$data['favicon']			=	$favicon;
		$data['use_post_id1']		=	$post_id;
		$data['post_date']			=	$post_date;
		$data['post_modified']		=	$post_modified;
		return	$data;
	}

	// リダイレクト先URL取得
	private	function	pz_GetRedirURL($data ) {
		$url				=	$data['url'];
		$error				=	false;
		if	(function_exists('curl_init' ) ) {							// cURLを使用する
			$update_result	=	0;
			$ch				=	curl_init($url );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,	true );			// データで取得
			curl_setopt($ch, CURLOPT_NOBODY,			true );			// ヘッダのみ取得
			curl_setopt($ch, CURLOPT_TIMEOUT,			120 );			// タイムアウト
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,	true );			// リダイレクトを処理する
			curl_setopt($ch, CURLOPT_MAXREDIRS,			5 );			// リダイレクトを処理する階層
			$html			=	curl_exec($ch );						// cURL実行
			$err_no			=	curl_errno($ch );						// cURLエラーコード
			if	($err_no ) {
				$error			=	true;
				$update_result	=	$err_no;
			} else {
				$header			=	curl_getinfo($ch );
				$update_result	=	$header['http_code'];				// HTTPステータス
				$url			=	$header['url'];
			}
			curl_close($ch );
		}
		return	$url;
	}

	// 外部リンク・記事情報取得
	private	function	pz_GetCURL($data ) {
		if	($this->options['debug-mode'] ) {
			echo	'<!-- Pz-LkC [pz_GetCURL]'.PHP_EOL;
			echo	'$data="'.esc_html(print_r($data, true ) ).PHP_EOL;
			echo	'/-->'.PHP_EOL;
		}

		// リンク先URL
		$url			=	isset($data['url']) ? $data['url'] : null ;

		// URL指定なし
		if	(!$url ) {
			return	null;
		}

		// URLエンコード
		$url			=	$this->pz_EncodeURL($url ,true );

		// 初期化
		$domain			=	null;
		$sitename		=	null;
		$author			=	null;
		$type			=	null;
		$title			=	null;
		$excerpt		=	null;
		$thumbnail_url	=	null;
		$favicon_url	=	null;
		$charset		=	null;
		$http_code		=	null;
		$error			=	false;

		// URL解析（自サイトチェック）
		$url_info		=	$this->Pz_GetURLInfo($url );
		$scheme			=	$url_info['scheme'];		// スキーム
		$domain			=	$url_info['domain'];		// ドメイン名
		$domain_url		=	$url_info['domain_url'];	// ドメインURL

		// リンク先サイトのアクセス
		if	(function_exists('curl_init' ) ) {							// cURLを使用する
			$ch				=	curl_init($url );						// cURLハンドル取得
			// cURL パラメータ
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );			// データで取得
			curl_setopt($ch, CURLOPT_TIMEOUT, 8 );						// タイムアウト
			if	($this->options['flg-referer'] ) {
				curl_setopt($ch, CURLOPT_REFERER, get_permalink() );	// リファラ
			}
			if	($this->options['flg-agent'] ) {
				curl_setopt($ch, CURLOPT_USERAGENT, $this->options['user-agent'] );				// ユーザーエージェントにPz-LinkCard-Crawlerを使う
			} else {
				curl_setopt($ch, CURLOPT_USERAGENT,	esc_html($_SERVER['HTTP_USER_AGENT'] ) );	// アクセス者のユーザーエージェントを使う
			}
			if	($this->options['flg-redir'] ) {
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );		// リダイレクトを処理する
				curl_setopt($ch, CURLOPT_MAXREDIRS, 8 );				// リダイレクトを処理する階層
				curl_setopt($ch, CURLOPT_AUTOREFERER, true );			// リダイレクト用リファラを自動セット
			} else {
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false );		// リダイレクトを処理しない
			}
			curl_setopt($ch, CURLOPT_COOKIESESSION, true );				// セッションCOOKIEを使用する
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, ($this->options['flg-ssl'] ) );	// SSL検証
			curl_setopt($ch, CURLOPT_FAILONERROR, false );				// HTTPエラーのときcURLをエラーにしない
			// cURL 実行
			$curl_data			=	curl_exec($ch );					// cURL実行
			$err_no				=	curl_errno($ch );					// cURLエラーコード
			$err_message		=	curl_error($ch );					// cURLエラーメッセージ

			// エラーチェック
			if ($err_no ) {
				$error			=	true;
				$http_header	=	null;
				$http_type		=	null;
				$http_body		=	null;
				$http_code		=	$err_no;
			} else {
				$http_header	=	curl_getinfo($ch );					// HTTPヘッダー
				$http_type		=	$http_header['content_type'];		// Content_Type
				$http_body		=	$curl_data;							// HTTPボディー
				$http_code		=	$http_header['http_code'];			// HTTPステータス
				if	($http_code >= 400 ) {
					$error		=	true;
				}
			}
			curl_close($ch );
		} else {														// cURLが使用できない場合
			// wp_remote_get 実行
			$rget_data			=	wp_safe_remote_get($url );				// wp_remote_get実行
			$err_no				=	is_wp_error($rget_data );			// wp_remote_getエラー有無
			$err_message		=	null;								// wp_remote_getエラーメッセージ
			// エラーチェック
			if ($err_no ) {
				$error			=	true;
				$http_header	=	null;
				$http_type		=	null;
				$http_body		=	null;
				$http_code		=	-1;
			} else {
				$http_header	=	$rget_data['response'];				// HTTPヘッダー
				$http_type		=	$http_header['content_type'];		// Content_Type
				$http_body		=	$rget_data['body'];					// HTTPボディー
				$http_code		=	$http_header['code'];				// HTTPステータス
				if	($http_code >= 400 ) {
					$error		=	true;
				}
			}
		}

		if	(strtolower(substr($http_type, 0, 9) ) === 'text/html' && $http_body ) {
			$charset		=	mb_detect_encoding($http_body, null, false );
			if	($charset ) {
				$http_body	=	mb_convert_encoding($http_body, $this->charset, $charset );
			}
			if	(preg_match('/charset\s*=\s*[\'"]*([A-Za-z0-9\-_]*)/si', $http_body, $m ) ) {
				$charset	=	strtolower($m[1] );
			}
		}

		if	($charset ) {
			// HEADタグ（METAタグ解析）
			$html_head		=	null;
			$tags			=	null;
			if	(preg_match('/<\s*head[^>]*>(.*)<\s*\/head\s*>/si', $http_body, $m ) ) {
				$html_head	=	$m[1];
				$tags		=	$this->pz_GetMeta($html_head );
			} else {
				$tags		=	$this->pz_GetMeta($http_body );
			}

			// Open Graph Protcol
			$og_url			=	isset($tags['og:url'] )				? $tags['og:url']				: null;
			$og_type		=	isset($tags['og:type'] )			? $tags['og:type']				: null;
			$og_sitename	=	isset($tags['og:site_name'] )		? $tags['og:site_name']			: null;
			$og_author		=	null;
			$og_title		=	isset($tags['og:title'] )			? $tags['og:title']				: null;
			$og_excerpt		=	isset($tags['og:description'] )		? $tags['og:description']		: null;
			$og_image		=	isset($tags['og:image'] )			? $tags['og:image']				: null;
			$og_favicon		=	null;

			// Twitter card
			$tw_url			=	null;
			$tw_sitename	=	isset($tags['twitter:site'] )		? $tags['twitter:site']			: null;
			$tw_author		=	isset($tags['twitter:creator'] )	? $tags['twitter:creator']		: null;
			$tw_type		=	isset($tags['twitter:card'] )		? $tags['twitter:card']			: null;
			$tw_title		=	isset($tags['twitter:title'] )		? $tags['twitter:title']		: null;
			$tw_excerpt		=	isset($tags['twitter:description'] )? $tags['twitter:description']	: null;
			$tw_image		=	isset($tags['twitter:image'] )		? $tags['twitter:image']		: null;
			$tw_favicon		=	null;

			// HTML
			$title			=	isset($tags['title'] )				? $tags['title']				: null;
			$excerpt		=	isset($tags['description'] )		? $tags['description']			: null;

			// 優先順序
			if	($og_title ) {
				$title			=	$og_title;
				$excerpt		=	$og_excerpt;
			} elseif ($tw_title ) {
				$title			=	$tw_title;
				$excerpt		=	$tw_excerpt;
			}
			if	($og_image ) {
				$thumbnail_url	=	$og_image;
			} elseif ($tw_image ) {
				$thumbnail_url	=	$tw_image;
			}
			$sitename			=	$og_sitename;

			// サムネイルURL取得
			if			($thumbnail_url	&& !preg_match('/^https*:\/\//i', $thumbnail_url, $m ) ) {
				$thumbnail_url	=	$this->pz_RelToURL($url, $thumbnail_url );
			}
			$thumbnail_url		=	$this->pz_EncodeURL($thumbnail_url, true );

			// サイトアイコンURL取得
			if			(isset(	$tags['icon'] )				&& $tags['icon'] ) {
				$favicon_url	=	$tags['icon'];
			} elseif	(isset(	$tags['shortcut icon'] )	&& $tags['shortcut icon'] ) {
				$favicon_url	=	$tags['shortcut icon'];
			} elseif	(isset(	$tags['apple-touch-icon'] )	&& $tags['apple-touch-icon'] ) {
				$favicon_url	=	$tags['apple-touch-icon'];
			}
			if			($favicon_url && !preg_match('/^https*:\/\//i', $favicon_url, $m ) ) {
				$favicon_url	=	$this->pz_RelToURL($url, $favicon_url );
			}
			$favicon_url		=	$this->pz_EncodeURL($favicon_url, true );

			// タイトル整形
			$title				=	mb_strimwidth($title, 0, 500, '...' );		// 500文字制限

			// 抜粋文整形
			$excerpt			=	mb_strimwidth($excerpt, 0, 1000, '...' );	// 1000文字制限
		}

		// 呼ばれている記事
		if	(!isset($data['use_post_id1'] ) ) {
			$data['use_post_id1']	=	get_the_ID();
		}

		// リダイレクト先URL
		if	(isset($http_header['url'] ) && $http_header['url'] && $url <> $http_header['url'] ) {
			$url_redir	=	$http_header['url'];
		} else {
			$url_redir	=	null;
		}

		// データセット
		$data['id']					=	isset($data['id'])				? $data['id']				: null;			// リンクカードID
		$data['url']				=	$url;																		// リンク先：URL
		$data['url_redir']			=	$url_redir;																	// リンク先：リダイレクト先URL
		$data['url_key']			=	isset($data['url_key'])			? $data['url_key']			: null;			// リンク先：URLハッシュ値
		$data['scheme']				=	$scheme;																	// リンク先：URLスキーム
		$data['domain']				=	$domain;																	// リンク先：URLドメイン
		$data['site_name']			=	$sitename;																	// リンク先：サイト名称
		$data['title']				=	$title;																		// リンク先：タイトル
		$data['excerpt']			=	$excerpt;																	// リンク先：抜粋文
		$data['thumbnail']			=	$thumbnail_url;																// リンク先：サムネイルURL
		$data['favicon']			=	$favicon_url;																// リンク先：サイトアイコンURL
		$data['charset']			=	$charset;																	// リンク先：文字コード
		$data['alive_time']			=	$this->now;																	// 生存確認：確認日時
		$data['alive_nexttime']		=	$this->now + WEEK_IN_SECONDS * 4 + rand(0, DAY_IN_SECONDS );				// 生存確認：次回確認日時
		$data['alive_result']		=	$http_code;																	// 生存確認：HTTPレスポンス
		$data['sns_twitter']		=	isset($data['sns_twitter']	)	? $data['sns_twitter']		: -1;			// SNS：Twitter
		$data['sns_facebook']		=	isset($data['sns_facebook'] )	? $data['sns_facebook']		: -1;			// SNS：facebook
		$data['sns_hatena']			=	isset($data['sns_hatena'] )		? $data['sns_hatena']		: -1;			// SNS：はてなブックマーク
		$data['sns_pocket']			=	isset($data['sns_pocket'] )		? $data['sns_pocket']		: -1;			// SNS：ポケット
		$data['sns_time']			=	isset($data['sns_time']) 		? $data['sns_time']			: 0;			// SNS：最終取得日時
		$data['sns_nexttime']		=	isset($data['sns_nexttime'] )	? $data['sns_nexttime']		: 0;			// SNS：次回取得日時
		$data['use_post_id1']		=	isset($data['use_post_id1'] )	? $data['use_post_id1']		: null;			// 呼ばれている記事
		$data['use_post_id2']		=	isset($data['use_post_id2'] )	? $data['use_post_id2']		: null;			// 呼ばれている記事
		$data['use_post_id3']		=	isset($data['use_post_id3'] )	? $data['use_post_id3']		: null;			// 呼ばれている記事
		$data['use_post_id4']		=	isset($data['use_post_id4'] )	? $data['use_post_id4']		: null;			// 呼ばれている記事
		$data['use_post_id5']		=	isset($data['use_post_id5'] )	? $data['use_post_id5']		: null;			// 呼ばれている記事
		$data['use_post_id6']		=	isset($data['use_post_id6'] )	? $data['use_post_id6']		: null;			// 呼ばれている記事
		$data['regist_title']		=	isset($data['regist_title'] )	? $data['regist_title']		: $title;		// 登録時：タイトル
		$data['regist_excerpt']		=	isset($data['regist_excerpt'] )	? $data['regist_excerpt']	: $excerpt;		// 登録時：抜粋文
		$data['regist_charset']		=	isset($data['regist_charset'] )	? $data['regist_charset']	: $charset;		// 登録時：文字コード
		$data['regist_time']		=	isset($data['regist_time'] )	? $data['regist_time']		: 0;			// 登録時：登録日時
		$data['regist_result']		=	isset($data['regist_result'] )	? $data['regist_result']	: $http_code;	// 登録時：HTTPレスポンス
		$data['mod_title']			=	false;																		// 更新：登録後からタイトル変更有無
		$data['mod_excerpt']		=	false;																		// 更新：登録後から抜粋文変更有無
		$data['update_time']		=	$this->now;																	// 更新：最終更新日
		$data['update_result']		=	$http_code;																	// 更新：HTTPレスポンス
		return	$data;
	}

	// TITLEとMETAタグを分解
	private	function	pz_GetMeta($html, $tags	=	null, $clear	=	false ) {
		if	($clear == true || !isset($tags ) ) {
			$tags	=	null;
			$tags	=	array('none' => 'none' );
		}

		// TITLEタグ
		if	(preg_match('/<\s*title\s*[^>]*>\s*([^<]*)\s*<\s*\/title\s*[^>]*>/si', $html, $m ) ) {
			$tags['title']	=	esc_html($m[1]);
		}

		// metaタグ パース
		$match	=	null;
		preg_match_all('/<\s*meta\s(?=[^>]*?\b(?:name|property)\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*\/?\s*>|\s\w+\s*=) ))[^>]*?\bcontent\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*\/?\s*>|\s\w+\s*=) )[^>]*>/is', $html, $match );
		if	(isset($match ) && is_array($match ) && count($match ) == 3 && count($match[1] ) > 0 ) {
			foreach($match[1] as &$m ) {
				$m	=	strtolower($m );
			}
			unset($m );
			$tags	+=	array_combine($match[1], $match[2] );
		}

		// linkタグ パース
		$match	=	null;
		preg_match_all('/<\s*link\s(?=[^>]*?\brel\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*\/?\s*>|\s\w+\s*=) ))[^>]*?\bhref\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*\/?\s*>|\s\w+\s*=) )[^>]*>/is', $html, $match );
		if	(isset($match ) && is_array($match ) && count($match ) == 3 && count($match[1] ) > 0 ) {
			foreach($match[1] as &$m ) {
				$m	=	strtolower($m );
			}
			unset($m );
			$tags	+=	array_combine($match[1], $match[2] );
		}

		return	$tags;
	}

	// サムネイル取得（外部リンクOGP画像取得）
	private	function	pz_GetThumbnail($thumbnail_url, $force = false, $stamp = false ) {
		if	(!isset($thumbnail_url ) || !$thumbnail_url || $thumbnail_url == 'https://s0.wp.com/i/blank.jpg' ) {
			return	null;
		}

		// サムネイルのディレクトリとディレクトリURL
		$file_dir		=	$this->options['thumbnail-dir'];
		$file_dir_url	=	$this->options['thumbnail-url'];
		if	(!$file_dir || !$file_dir_url ) {
			return			null;
		}

		// 画像URLを元にしてファイル名を生成
		$file_name		=	bin2hex(hash('sha256', esc_url($thumbnail_url ), true ) );	// ファイル名（URLをハッシュしてファイル名にする）
		$file_ext		=	'.jpeg';											// 拡張子
		$file_path_jpeg	=	$file_dir.$file_name.$file_ext;						// ファイルのフルパス
		$file_url		=	$file_dir_url.$file_name.$file_ext;					// 画像URL

		// ファイル名が見つかったときの処理
		if	(!$force ) {		// 強制取得の指定なし
			if	(file_exists	($file_path_jpeg ) ) {							// ファイルが見つかった（拡張子あり）
				if	(filesize($file_path_jpeg ) < 34 ) {						// JPEGのヘッダが34バイトなので、それ未満は取得できていないファイル
					return	null;
				}
				if	($stamp === true ) {
					$file_url	.=	'?'.date('yyyymmdd-his', filemtime($file_path_jpeg ) );	// ファイルスタンプ
				}
				return		$file_url;
			}
			$file_path_old	=	$file_dir.$file_name;							// ファイルのフルパス（旧バージョン）
			if	(file_exists	($file_path_old ) ) {							// ファイルが見つかった（拡張子なし）
				rename		($file_path_old, $file_path_jpeg );					// 拡張子ありにリネーム
				if	(filesize($file_path_jpeg ) < 34 ) {						// JPEGのヘッダが34バイトなので、それ未満は取得できていないファイル
					return	null;
				}
				if	($stamp === true ) {
					$file_url	.=	'?'.date('yyyymmdd-his', filemtime($file_path_jpeg ) );	// ファイルスタンプ
				}
				return		$file_url;
			}
		}

		// cURLで画像取得
		$ch			=	curl_init();
		curl_setopt($ch, CURLOPT_URL, $thumbnail_url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );		// リダイレクトを処理する
		curl_setopt($ch, CURLOPT_MAXREDIRS, 8 );				// リダイレクトを処理する階層
		curl_setopt($ch, CURLOPT_AUTOREFERER, true );			// リダイレクト用リファラを自動セット

		curl_setopt($ch, CURLOPT_TIMEOUT, 10 );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3 );
		$body		=	curl_exec($ch );
		$header		=	curl_getinfo($ch );
		curl_close($ch );
		if	($header['http_code']	>=	400 ) {					// 指定されたURLの画像が存在しない
			touch($file_path_jpeg );							// 空ファイル作成
			return	null;
		}

		// 画像生成
		$image			=	@imagecreatefromstring($body );		// 画像読み込み
		if	($image		===	false ) {
			touch($file_path_jpeg );							// 空ファイル作成
			return	null;
		}

		$image_width	=	@imagesx($image );					// 画像の横
		$image_height	=	@imagesy($image );					// 画像の縦
		if	($image_width === false || $image_height === false || $image_width < 8 || $image_height < 8 ) {		// 8x8未満は画像ではないと見なす
			touch($file_path_jpeg );							// 空ファイル作成
			return	null;
		}

		// 変換後の画像サイズ
		switch	($this->options['ex-thumbnail-size']) {
		case	'thumbnail':
			$new_width	=	150;								// 幅
			$new_height	=	150;								// 高さ
			break;
		case	'medium':
			$new_width	=	300;
			$new_height	=	300;
			break;
		case	'large':
			$new_width	=	1024;
			$new_height	=	1024;
			break;
		case	'full':
			$new_width	=	$image_width;
			$new_height	=	$image_height;
			break;
		default:
			$new_width	=	150;
			$new_height	=	150;
			break;
		}

		// 縦横比を保つ
		if			($image_width > $image_height ) {									// 幅の方が大きい
			$new_height	=	intval($image_height * ($new_width  / $image_width ) );		// 幅に合わせる
		} elseif	($image_width < $image_height ) {									// 高さの方が大きい
			$new_width	=	intval($image_width  * ($new_height / $image_height ) );	// 高さに合わせる
		}
		if	($new_width <= 1 || $new_height <= 1 ) {
			touch($file_path_jpeg );													// 空ファイル作成
			return	null;
		}

		// パレットを用意
		$image_pallet	=	imagecreatetruecolor($new_width, $new_height );
		if	(!$image_pallet ) {
			touch($file_path_jpeg );													// 空ファイル作成
			return	null;
		}

		// 画像ファイルを保存
		imagecopyresampled($image_pallet, $image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height );	// サイズ変更してコピー
		imagejpeg($image_pallet, $file_path_jpeg );										// JPEGで保存

		if	($stamp === true ) {
			$file_url	.=	'?'.date('yyyymmdd-his', filemtime($file_path_jpeg ) );		// ファイルスタンプ
		}

		return	$file_url;																// 画像URLを返す
	}

	// 設定を取得する
	private	function	pz_load_options() {
		
		// パラメーターを取得
		$this->options			=	get_option(self::OPTION_NAME );			// オプション値を取得
		if		(!$this->options || !is_array($this->options ) ) {
			$this->options		=	get_option(self::OPTION_NAME_OLD );		// オプション値を取得（古いオプション名）
			if	(!$this->options || !is_array($this->options ) ) {
				$this->options	=	self::DEFAULTS;
			} else {
				$result			=	update_option(self::OPTION_NAME, $this->options );
				$result			=	delete_option(self::OPTION_NAME_OLD );
			}
		}

		// バージョンが違う場合、初期処理を実行する
		if	($this->options['plugin-version']	<>	PLUGIN_VERSION ) {
			$this->activate();												// プラグインの再起動
			$this->options['plugin-version']	=	PLUGIN_VERSION;
			if	($this->options['css-count']	>	10 ) {
				$this->options['css-count']		=	0;
			}
			$result				=	update_option(self::OPTION_NAME, $this->options );
			if	($result		==	false ) {
				return	false;
			}
		}

		return	true;
	}

	// 設定を更新する
	private	function	pz_save_options() {
		// 変更前
		$return_status	=	false;
		$before			=	get_option(self::OPTION_NAME_OLD, self::DEFAULTS );

		// 変更有無チェック
		if	($before <> $this->options ) {
			$return_status					=	true;			// 更新あり
			$this->options['saved-date']	=	$this->now;		// 保存日時をセット
		}

		// CSSバージョン（CSSキャッシュ対策）
		$this->options['css-count']			+=	1;

		// 必要ディレクトリが無い場合、作り直す
		require_once('lib/pz-linkcard-settings-setup.php' );

		// 設定の更新
		$result				=	update_option(self::OPTION_NAME_OLD, $this->options );
		if	($result		=	false) {
			$return_status	=	false;
		}

		// デバグ用ログ出力
		if	($this->options['debug-mode'] ) {
			$result_log	=	$this->pz_OutputLOG('Update_Option(Result='.$result.')' );
			$result_log	=	$this->pz_OutputLOG(print_r($this->options, true ) );
		}
		
		// 返却
		return	$return_status;
	}

	// 設定を初期化する
	private	function	pz_initialize_options() {
		// 初期化
		$before				=	$this->options;
		$this->options		=	self::DEFAULTS;
		
		// 引き継ぐ設定値
		$takeover			=	array('css-templete', 'css-path', 'thumbnail-dir', 'thumbnail-url', 'debug-dir', 'debug-url', 'saved-date', 'db-version' );
		if	($before['initialize-exception'] ) {
			// 初期化例外が有効の時に引き継ぐ設定値
			array_push($takeover, 'initialize-exception', 'admin-mode', 'debug-mode' );
		}
		
		// 設定を引き継ぐ
		foreach($takeover as $key ) {
			$this->options[$key]			=	$before[$key];
		}
		
		// ブログID
		$this->options['multi-myid']		=	get_current_blog_id();
		
		// CSS更新用カウント
		$this->options['css-count']			=	self::DEFAULTS['css-count'];
		
		// プラグインのバージョン
		$this->options['plugin-version']	=	PLUGIN_VERSION;
		
		// 設定を更新する
		$result	=	$this->pz_save_options();
		return	$result;
	}

	// スタイルシート生成
	private	function	pz_SetStyle() {
		$result		=	0;
		require_once('lib/pz-linkcard-style.php' );
		return	$result;
	}

	// スタイルシート圧縮
	private	function	pz_CompressCSS($style ) {
		// 参考：https://shimotsuki.wwwxyz.jp/20200930-650
		$replaces	=	[];
		$replaces['/@charset [^;]+;/' ] = '';
		$replaces['/([\s:]url\()[\"\']([^\"\']+)[\"\'](\)[\s;}])/' ] = '${1}${2}${3}';
		$replaces['/(\/\*(?=[!]).*?\*\/|\"(?:(?!(?<!\\\)\").)*\"|\'(?:(?!(?<!\\\)\').)*\')|\s+/' ] = '${1} ';
		$replaces['/(\/\*(?=[!]).*?\*\/|\"(?:(?!(?<!\\\)\").)*\"|\'(?:(?!(?<!\\\)\').)*\')|\/\*.*?\*\/|\s+([:])\s+|\s+([)])|([(:])\s+/s' ] = '${1}${2}${3}${4}';
		$replaces['/\s*(\/\*(?=[!]).*?\*\/|\"(?:(?!(?<!\\\)\").)*\"|\'(?:(?!(?<!\\\)\').)*\'|[ :]calc\([^;}]+\)[ ;}]|[!$&+,\/;<=>?@^_{|}~]|\A|\z)\s*/s' ] = '${1}';
		$style		=	preg_replace(array_keys($replaces ), array_values($replaces ), $style );
		do {
			$style	=	preg_replace('/(})[^{]*{}/', '$1', $style );		// 空の要素除去
		} while (preg_match('/;[^{]*{}/', $style ) );
		$style		=	trim($style );
		$style		=	'@charset "'.$this->charset.'";'.$style;			// 文字セット
		return		$style;
	}

	// デバグ用の文字列表示
	private	function	pz_HTTPMessage($result ) {
		$http_message	=	array();
		require_once('lib/pz-linkcard-error-code.php' );
		if	(isset($http_message[$result] ) ) {
			return	$http_message[$result];
		}
		return		null;
	}

	// デバグ用の文字列表示
	private	function	pz_OutputLOG($user_message ) {
		if	($this->options['debug-dir'] ) {
			$now			=	current_time('timestamp', false );
			$message		=	date('Y-m-d H:i:s', $now ).' '.$user_message.(mb_substr($user_message, -1, 1) == PHP_EOL ? null : PHP_EOL );
			$filename		=	$this->options['debug-dir'].$this->slug.'_'.date('Ymd', $now ).'.log';
			$result			=	file_put_contents($filename, $message, FILE_APPEND );
			return			$result;
		}
	}

	// 通常時のスタイルシート
	public	function	enqueue($hook ) {
		$this->amp		=	null;
		$css_version	=	PLUGIN_VERSION.'.'.$this->options['css-count'];
		wp_enqueue_style	(self::PLUGIN_SLUG,			$this->options['css-url'],		array(), $css_version );
		if	($this->options['css-add-url'] ) {
			wp_enqueue_style(self::PLUGIN_SLUG.'-add',	$this->options['css-add-url'],	array(), $css_version );
		}
	}

	// 管理画面のスタイルシート、スクリプト設定
	public	function	enqueue_admin($hook ) {
		wp_enqueue_script	(self::PLUGIN_SLUG.'-admin',	plugins_url('js/admin-settings.js', __FILE__ ),	array('jquery' ),	PLUGIN_VERSION, true );
		wp_enqueue_style	(self::PLUGIN_SLUG.'-admin',	plugin_dir_url(__FILE__ ).'css/admin.css',		array(),			PLUGIN_VERSION );
	}

	// 管理画面時の設定（フッター）
	public	function	add_footer() {
		// テキスト エディタ用のクイックタグ
		if	($this->options['flg-edit-qtag'] ) {
			if	(wp_script_is('quicktags' ) ) {
				echo '<script>QTags.addButton(\'pz-lkc\',\''.__('Linkcard', $this->text_domain ).'\',\'['.$this->options['code1'].' url="\',\'"]\',\'\',\''.__('Make Linkcard', $this->text_domain ).'\' );</script>';
			}
		}
		// ビジュアル エディタ用の挿入ダイアログ
		require_once('lib/pz-linkcard-modal.php' );
	}

	// 管理画面時の注意書き設定
	public	function	add_notices() {
	//	if	($this->options['error-mode'] ) {
	//		if	(!$this->options['error-mode-hide'] ) {
	//			echo '<div class="notice notice-error is-dismissible"><p><strong>'.$this->options['plugin-name'].': '.__('Invalid URL parameter in ', $this->text_domain ).'<a href="'.$this->options['error-url'].'#lkc-error" target="_blank">'.$this->options['error-url'].'</a></strong><br>'.__('*', $this->text_domain ).' '.__('You can cancel this message from <a href=".'.self::SETTINGS_URL.'">the setting screen</a>.', $this->text_domain ).'</p></div>';
	//		}
	//	}
	}

	// 管理画面時のスタイルシート、スクリプト設定
	public	function	add_mce_button($buttons ) {
		if	($this->options['flg-edit-insert'] ) {
			$buttons[]		=	'pz_linkcard_insert_shortcode';
		}
		return	$buttons;
	}
	public	function	add_mce_plugin($plugins ) {
		if	($this->options['flg-edit-insert'] ) {
			$plugins[ "pz_linkcard_tinymce" ]	=	$this->plugin_dir_url.'js/mce-button.js';
		}
		return	$plugins;
	}

	// 管理画面＞プラグイン＞一覧＞クイックメニュー
	public	function	add_inline_menu($links ) {
		return array_merge(
			$links,
			array(
				'manager'	=>	'<a href="'.$this->cacheman_url.'">'.__('Manager' , $this->text_domain ).'</a>',
				'settings'	=>	'<a href="'.$this->settings_url.'">'.__('Settings', $this->text_domain ).'</a>',
			)
		);
	}

	// 管理バーのメニュー追加（記述エラーやリンク切れなど）（未実装）
	public	function	add_admin_bar() {
	//	global $wp_admin_bar;
	//	$wp_admin_bar->add_menu(array('id' => 'pz-lkc',									'title' => 'Pzカード',											'href' => '#' ) );
	//	$wp_admin_bar->add_menu(array('id' => 'pz-settings',	'parent' => 'pz-lkc',	'title' => __('LinkCard Cache Manager',	$this->text_domain ),	'href' => '#',	'meta' => array('target' => '_parent' ) ) );
	//	$wp_admin_bar->add_menu(array('id' => 'pz-cacheman',	'parent' => 'pz-lkc',	'title' => __('LinkCard Settings',		$this->text_domain ),	'href' => '#',	'meta' => array('target' => '_parent' ) ) );
	}

	// 管理画面のサブメニュー追加
	public	function	add_admin_menu() {
		$menu_manager	=	__('Pz-LinkCard Manager',	$this->text_domain );
		$menu_settings	=	__('Pz-LinkCard Settings',	$this->text_domain );
		if	($this->options['flg-alive'] && $this->options['flg-alive-count'] ) {
			global	$wpdb;
			$result		=	$wpdb->get_row("SELECT COUNT(*) AS count FROM $this->db_name WHERE alive_result < 100 OR alive_result >= 400");
			if	(isset($result ) && isset($result->count ) ) {
				$menu_manager	.=	'&nbsp;<span class="update-plugins"><span class="update-count lkc-menu-count">'.$result->count.'</span></span>';
			}
		}
		add_management_page	(__('Pz-LinkCard Manager',		$this->text_domain ),	$menu_manager,		'manage_options', 	self::CACHEMAN_PAGE,	array($this, 'page_cacheman' ) );
		add_options_page	(__('Pz-LinkCard Settings',		$this->text_domain ),	$menu_settings,		'manage_options', 	self::SETTINGS_PAGE,	array($this, 'page_settings' ) );
	}
	
	// 管理画面＞Pz カード管理
	public	function	page_cacheman() {
		require_once('lib/pz-linkcard-cacheman.php' );
	}

	// 管理画面＞Pz カード設定
	public	function	page_settings() {
		require_once('lib/pz-linkcard-settings.php' );
	}

	// プラグインを有効化
	public	function	activate() {
		require_once('lib/pz-linkcard-init.php' );
	}

	// プラグインを無効化
	public	function	deactivate() {
		wp_clear_scheduled_hook(self::DEFAULTS['cron-alive'] );		// WP-CRONスケジュール停止（リンク先存在チェック）
		wp_clear_scheduled_hook(self::DEFAULTS['cron-check'] );		// WP-CRONスケジュール停止（SNSカウント取得）
	}

	// プラグインを削除
	public	function	uninstall() {
	}

	// 更新完了
	public	function	upgrader($upgrader_object, $options ) {
	//	// 参考：https://club.jidaikobo.com/knowledge/177.html
	//	if			($options['action'] == 'update' && $options['type'] == 'plugin' ) {
	//		if		(isset($options['plugins'] ) && is_array($options['plugins'] ) ) {
	//			foreach	($options['plugins'] as $plugin ) {
	//				// $plugin
	//			}
	//		} else {
	//			if	(isset($options['plugin'] ) ) {
	//				// $options['plugin']
	//			}
	//		}
	//	}
	}

	// WP-CRONスケジュール（SNSカウント取得）
	public	function	schedule_hook_check() {
		require_once('lib/pz-linkcard-cron-sns.php' );
		return	$log;
	}

	// WP-CRONスケジュール（存在チェック）
	public	function	schedule_hook_alive() {
		require_once('lib/pz-linkcard-cron-alive.php' );
		return	$log;
	}
}
$class_pz_linkcard	=	new class_pz_linkcard;
