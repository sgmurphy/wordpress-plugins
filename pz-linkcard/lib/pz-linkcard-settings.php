<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// echo '<pre>'.print_r($this->options, true).'</pre>';

	// デバグモード・管理モード
	$debug_mode		=	isset($this->options['debug-mode'] )		?	intval($this->options['debug-mode'] )		:	0;
	$admin_mode		=	isset($this->options['admin-mode'] )		?	intval($this->options['admin-mode'] )		:	0;
	$develop_mode	=	isset($this->options['develop-mode'] )		?	intval($this->options['develop-mode'] )		:	0;
	$menu_error		=	isset($this->options['error-mode'] )		?	intval($this->options['error-mode'] )		:	0;
	$menu_multi		=	isset($this->options['multi-mode'] )		?	intval($this->options['multi-mode'] )		:	0;
	$menu_initialize=	isset($this->options['flg-initialize'] )	?	intval($this->options['flg-initialize'] )	:	0;

	// 引数・変数の設定
	$page			=	'pz-linkcard-settings';						// 設定画面のページ
	$action			=	isset($_POST['action'] )					?	esc_attr($_POST['action'] )					:	null;
	$submit			=	isset($_POST['submit'] )					?	esc_attr($_POST['submit'] )					:	null;
	$tab_now		=	isset($_POST['tab-now'] )					?	esc_attr($_POST['tab-now'] )				:	null;

	// 入力値
	$properties		=	null;
	if	(isset($_POST['properties'] ) ) {
		$properties		=	self::DEFAULTS;
		foreach	($_POST['properties']	as	$key => $value ) {
			$properties[$key]	=	stripslashes($value );
		}
		ksort($properties );
	}

	// 画面入力値で修正
	$debug_mode		=	isset($properties['debug-mode'] )			?	intval($properties['debug-mode'] )			:	$debug_mode;
	$admin_mode		=	isset($properties['admin-mode'] )			?	intval($properties['admin-mode'] )			:	$admin_mode;
	$develop_mode	=	isset($properties['develop-mode'] )			?	intval($properties['develop-mode'] )		:	$develop_mode;
	$menu_error		=	isset($properties['error-mode'] )			?	intval($properties['error-mode'] )			:	$menu_error;
	$menu_multi		=	isset($properties['multi-mode'] )			?	intval($properties['multi-mode'] )			:	$menu_multi;
	$menu_initialize=	isset($properties['flg-initialize'] )		?	intval($properties['flg-initialize'] )		:	$menu_initialize;

	// マルチサイト
	$is_multisite	=	function_exists('is_multisite' )			?	is_multisite()								:	false;
	$is_subdomain	=	function_exists('is_subdomain_install' )	?	is_subdomain_install()						:	false;
	$multi_myid		=	function_exists('get_current_blog_id' )		?	get_current_blog_id()						:	0;
	$multi_count	=	0;
	if	($is_multisite ) {
		$menu_multi		=	1;
		$j				=	0;
		for ($i = 1; $i <= 1000; $i++ ) {
			$multi_detail	=	get_blog_details($i );
			if	(!$multi_detail ) {
				break;
			}
			if	(!$multi_detail->deleted ) {
				$j++;
				$multi_count			=	$j;
				$multi[$j]['id']		=	$multi_detail->blog_id;		// ブログID
				$multi[$j]['name']		=	$multi_detail->blogname;	// ブログ名
				$multi[$j]['url']		=	$multi_detail->home;		// ブログURL（Home_URL）
				$multi[$j]['domain']	=	preg_replace('/.*\/\/(.*)/', '$1', $multi_detail->home );	// ドメイン名
			}
		}
	}
	if	(!$is_multisite && $menu_multi &&  (!$debug_mode || !$admin_mode ) ) {
		$menu_multi	=	0;
	}

	// 変更の保存ボタンを押したとき
	if	(!$action	&&	$submit ) {
		$action		=	'save-changed';
	}

	// 出力するHTML
	$html_develop	=	'';
	$html_style		=	'';
	$html_title		=	'';
	$html_input		=	'';
	$html_notice	=	'';
	$html_overlay	=	'';

	// スタイルシート再生成の有無
	$flg_style		=	false;			// スタイルシートを再生成するか

	// 開発者モードの表示
	if ($develop_mode ) {
		$html_develop	=	'<style>#wpadminbar { background-color: #0a8 !important; }</style><div class="pz-lkc-develop-message">'.__('Currently working in a development environment.', $this->text_domain ).'</div>';
	}

	// ページの見出し表示（設定）
	$page_class	=	' pz-lkc-settings';
	$switch_link	=	esc_url($this->cacheman_url );
	$switch_icon	=	__('&#x1f5c3;&#xfe0f;', $this->text_domain );
	$switch_label	=	__('Manager', $this->text_domain );
	$title_icon		=	__('&#x2699;&#xfe0f;', $this->text_domain );
	$title_label	=	__('Pz-LinkCard Settings', $this->text_domain );
	$help_page		=	self::AUTHOR_URL.'/pz-linkcard-manager';
	$html_title		=	'<div class="pz-lkc-plugin">'.self::PLUGIN_NAME.' ver.'.PLUGIN_VERSION.'</div><div class="pz-lkc-dashboard'.$page_class.' wrap"><div class="pz-header"><a class="pz-header-switch" href="'.$switch_link.'"><span class="pz-header-switch-icon">'.$switch_icon.'</span><span class="pz-header-switch-label">'.$switch_label.'</span></a><h1><span class="pz-header-title"><span class="pz-header-title-icon">'.$title_icon.'</span><span class="pz-header-title-text">'.$title_label.'</span><a class="pz-help-icon" href="'.$help_page.'" rel="external noopener help" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain ).'" alt="help"></a></h1></div>';

	// POSTする値 INPUT要素
	$temp_param		=
		array(
			'debug-mode'		=>		intval($debug_mode ),
			'admin-mode'		=>		intval($admin_mode ),
			'develop-mode'		=>		intval($develop_mode ),
			'multi-mode'		=>		intval($menu_multi ),
			'tab-now'			=>		esc_attr($tab_now ),
		);
	foreach		($temp_param		as	$temp_name => $temp_value ) {
		$html_input	.=	'<input type="hidden" name="'.$temp_name.'" value="'.$temp_value.'" title="'.$temp_name.'" size="4" />';
	}

	// モードによって表示させる
	$html_style		.=	$debug_mode		==	0	?	'.pz-lkc-debug-only { display: none; } '	:	'';
	$html_style		.=	$admin_mode		==	0	?	'.pz-lkc-admin-only { display: none; } '	:	'';
	$html_style		.=	$develop_mode	==	0	?	'.pz-lkc-develop-only { display: none; } '	:	'';
	if	($html_style ) {
		$html_style	=	'<style>'.$html_style.'</style>';
	}

	// 画面描画
	echo	$html_develop;
	echo	$html_style;
	echo	$html_title;
	echo	'<div><form action="" method="post">';
	wp_nonce_field('pz-lkc-settings' );			// nonce

	// 記述エラー
	if	($this->options['error-mode'] ) {
		if	(!$this->options['error-mode-hide'] ) {
			$html_notice	.=	'<div class="notice notice-error is-dismissible"><p><strong>'.self::PLUGIN_NAME.': '.__('Invalid URL parameter in ', $this->text_domain ).'<a href="'.$this->options['error-url'].'#lkc-error" target="_blank">'.$this->options['error-url'].'</a></strong><br>'.__('*', $this->text_domain ).' '.__('You can cancel this message from <a href="./options-general.php?page=pz-linkcard-settings">the setting screen</a>.', $this->text_domain ).'</p></div>';
		}
	}

	// プラグインのバージョンが違っている
	if	($this->options['plugin-version']	<>	PLUGIN_VERSION ) {
		$html_notice		.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('The plugin may have been updated.', $this->text_domain ).'</strong></p></div>';
		$flg_style			=	true;
	}

	// 定義漏れチェック
	if	($properties ) {
		foreach	(self::DEFAULTS as $key => $value ) {
			if	(!array_key_exists($key, $properties ) ) {
				$html_notice	.=	'<div class="notice notice-error is-dismissible">'.sprintf(__('Undefined key "%s" in Properties.<br/>It may be a glitch. Please inform the developer. (%s)', $this->text_domain ), $key, '<a href="https://x.com/'. self::AUTHOR_TWITTER .'" target="_blank">@'.self::AUTHOR_TWITTER.'</a>' ).'</div>';
			}
		}
		foreach	($properties as $key => $value ) {
			if	(!array_key_exists($key, self::DEFAULTS ) ) {
				$html_notice	.=	'<div class="notice notice-error is-dismissible">'.sprintf(__('Undefined key "%s" in DEFAULTS.<br/>It may be a glitch. Please inform the developer. (%s)', $this->text_domain ), $key, '<a href="https://x.com/'. self::AUTHOR_TWITTER .'" target="_blank">@'.self::AUTHOR_TWITTER.'</a>' ).'</div>';
			}
		}
	}

	// アクションの指示があったとき
	if	($action ) {
		check_admin_referer('pz-lkc-settings' );		// nonceチェック
		
		switch	($action ) {
		case	'save-changed':								// 変更を保存ボタン
			$flg_change			=	false;
			if	(isset($_POST['properties'] ) ) {
				$properties	=	self::DEFAULTS;
				foreach	($_POST['properties']	as	$key => $value ) {
					$properties[$key]	=	stripslashes($value );
					if	(array_key_exists($key, $this->options ) ) {
						if	($value		!==	$this->options[$key] ) {
							$flg_change	=	true;		// 変更あり
						}
					}
				}
			} else {
				$html_notice	.=	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Could not retrieve the content to be changed.', $this->text_domain ).'</strong></p></div>';
			}
			
			// パラメーターに変更があった場合
			if	($flg_change ) {
				$this->options			=	$properties;
				$flg_error				=	false;						// エラーの有無
				require_once ('pz-linkcard-settings-validate.php' );	// 値の検証
				if	(!$flg_error ) {
					$result	=	$this->pz_save_options();				// オプションの更新
					if	($result ) {
						$html_notice	.=	'<div class="notice notice-success is-dismissible"><p><strong>'.__('Succeeded in saving the settings.', $this->text_domain ).'</strong></p></div>';
					} else {
						$html_notice	.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('The settings have not changed.', $this->text_domain ).'</strong></p></div>';
					}
				}
			}
			$flg_style			=	true;				// スタイルシートの再生成
			break;

		case	'init-plugin':							// プラグインの再起動
			$this->activate();
			$flg_style			=	true;				// スタイルシートの再生成
			break;

		case	'init-settings':						// 設定の初期化
			$result		=	$this->pz_initialize_options();
			if	($result ) {
				$flg_style		=	true;				// スタイルシートの再生成
				$properties		=	$this->options;
				$html_notice	.=	'<div class="notice notice-success is-dismissible"><p><strong>'.__('Succeeded in initialize the settings.', $this->text_domain ).'</strong></p></div>';
			} else {
				$html_notice	.=	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Failed to initialize the settings.', $this->text_domain ).'</strong></p></div>';
			}
			break;

		case	'clear-error':
			$flg_style			=	false;
			$this->options['error-mode']	=	0;
			$result	=	$this->pz_save_options();	// オプションの更新
			break;

		case	'run-pz_linkcard_check':
			$flg_style			=	false;
			break;

		case	'run-pz_linkcard_alive':
			$flg_style			=	false;
			break;

		default:

		}
	}

	// スタイルシート生成
	if	($flg_style ) {
		$result		=	$this->pz_SetStyle();
		switch		($result ) {
		case	1:
			$html_notice	.=	'<div class="notice notice-success is-dismissible"><p><strong>'.__('Updated the appearance of the LinkCard.', $this->text_domain).'</strong></p></div>';
			break;
		case	2:
			$html_notice	.=	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Failed to save CSS-File.', $this->text_domain).'</strong></p></div>';
			break;
		case	3:
			$html_notice	.=	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Failed to call CSS-Template.', $this->text_domain).'</strong></p></div>';
		default:
		}
	}

	// メッセージ表示
	echo	$html_notice;
	echo	$html_input;

	// ぽぽづれ。のURL
	$pz_url			=	self::AUTHOR_URL;
	$pz_url_info	=	$this->Pz_GetURLInfo($pz_url );
	$pz_domain		=	$pz_url_info['domain'];				// ドメイン名
	$pz_domain_url	=	$pz_url_info['domain_url'];			// ドメインURL

	// Pz-LinkCardのURL
	$plugin_url			=	self::AUTHOR_URL.self::PLUGIN_PATH;

	// HELPアイコン
	$help_open			=	'&nbsp;<a href="'.$pz_url.'/pz-linkcard-settings-';
	$help_close			=	'" rel="external noopener help" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" class="pz-lkc-help-icon" title="'.__('Help', $this->text_domain ).'" alt="help"></a>';

	// 各種ロゴ
	$logo_pz		=	'<img src="'.$this->plugin_dir_url.'img/icon_popozure.ico"    width="16" height="16" alt="'.__('Popozure Logo',		$this->text_domain ).'">';
	$logo_pz_lkc	=	'<img src="'.$this->plugin_dir_url.'img/icon-pz-linkcard.png" width="16" height="16" alt="'.__('Pz-LinkCard Logo',	$this->text_domain ).'">';
	$logo_wp		=	'<img src="'.$this->plugin_dir_url.'img/icon_WordPress.png"   width="16" height="16" alt="'.__('WordPress.org Logo',$this->text_domain ).'">';
	$logo_tw		=	'<img src="'.$this->plugin_dir_url.'img/icon_twitter.svg"     width="16" height="16" alt="'.__('Twitter Logo',		$this->text_domain ).'">';
	$logo_x			=	'<img src="'.$this->plugin_dir_url.'img/icon_twitter.svg"     width="16" height="16" alt="'.__('Twitter Logo',		$this->text_domain ).'">';
	$logo_az		=	'<img src="'.$this->plugin_dir_url.'img/icon_amazon.png"      width="16" height="16" alt="'.__('Amazon Logo',		$this->text_domain ).'">';

	// 修正履歴
	$changelog		=	'';
	if	(!function_exists('wp_is_mobile' ) || !wp_is_mobile() ) {
		$changelog	=	file_get_contents($this->plugin_dir_path.'/readme.txt' );											// readme.txt を読み込み
		preg_match('/== Changelog ==[^=]*(=\s*[^=]*\s*=[^=]*=\s*[^=]*\s*=[^=]*=\s*[^=]*\s*=[^=]*=\s*[^=]*\s*=[^=]*=\s*[^=]*\s*=[^=]*)/m', $changelog, $m );
		$changelog	=	$m[1];
		$changelog	=	trim($changelog );
		$changelog	=	esc_html($changelog );
		$changelog	=	preg_replace('/^\* /mi', '*&ensp;', $changelog);													// 日本語文の行のインデント調整
		$changelog	=	preg_replace('/^  /mi', '&ensp;&ensp;', $changelog);												// 英文の行のインデント調整
		$changelog	=	preg_replace('/= (.*) =\n/i', '<h4>'.__('Version', $this->text_domain ).' $1</h4>', $changelog);	// バージョン番号の表記調整
		$changelog	=	preg_replace('/（thanks ([0-9]+#comment-[0-9]+).*）/i',						' (Thanks <a href="'.$pz_url.'/?p=$1" rel="external noopener noreferrer" target="_blank">'.$logo_pz.'$1</a>)', $changelog);										// Popozure.info のコメントへのリンク
		$changelog	=	preg_replace('/（thanks [^@]*@([A-Za-z]+[A-Za-z0-9_]+).* twitter.*）/i',	' (Thanks <a href="https://www.twitter.com/$1" rel="external noopener noreferrer" target="_blank">'.$logo_tw.'@$1</a>)', $changelog);				// Twitterアカウントへのリンク
		$changelog	=	preg_replace('/（thanks [^@]*@([A-Za-z]+[A-Za-z0-9_]+).* x.*）/i',			' (Thanks <a href="https://www.x.com/$1" rel="external noopener noreferrer" target="_blank">'.$logo_x.'@$1</a>)', $changelog);							// Xアカウントへのリンク
		$changelog	=	preg_replace('/（thanks [^@]*@([A-Za-z]+[A-Za-z0-9_]+).* wordpress.*）/i',	' (Thanks <a href="https://wordpress.org/support/users/$1/" rel="external noopener noreferrer" target="_blank">'.$logo_wp.'@$1</a>)', $changelog);	// WordPress.orgアカウントへのリンク
		$changelog	=	str_replace(PHP_EOL, '<br>', $changelog );															// 改行をBRタグに変換
		$changelog	=	'<div class="pz-lkc-basic-changelog">'.$changelog.'</div>';
	}
?>
				<span class="pz-lkc-submit-hide"><?php submit_button(); ?></span><?php /* [Enter]を押したとき用 */?>
				<div class="pz-lkc-tabs">
<?php
	// [DEBUG] 暫定対応
	$show_error			=	($menu_error		==	0	?	'style="display: none;"' : '' );
	$show_basic			=	'';
	$show_position		=	'';
	$show_display		=	'';
	$show_letter		=	'';
	$show_external		=	'';
	$show_internal		=	'';
	$show_samepage		=	'';
	$show_check			=	'';
	$show_editor		=	'';
	$show_multisite		=	($menu_multi		==	0	?	'style="display: none;"' : '' );
	$show_advanced		=	'';
	$show_etc			=	'';
	$show_initialize	=	($menu_initialize	==	0	?	'style="display: none;"' : '' );
	$show_admin			=	($admin_mode		==	0	?	'style="display: none;"' : '' );
	// [DEBUG] 暫定対応
?>
				<a class="pz-lkc-tab pz-lkc-red"	name="pz-lkc-error"			href="#pz-lkc-error"		<?php echo $show_error;			?>><?php _e('Error', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-hide"	name="pz-lkc-basic"			href="#pz-lkc-basic"		<?php echo $show_basic;			?>><?php _e('Basic', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-position"		href="#pz-lkc-position"		<?php echo $show_position;		?>><?php _e('Position', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-display"		href="#pz-lkc-display"		<?php echo $show_display;		?>><?php _e('Display', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-letter"		href="#pz-lkc-letter"		<?php echo $show_letter;		?>><?php _e('Letter', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-external"		href="#pz-lkc-external"		<?php echo $show_external;		?>><?php _e('External Link', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-internal"		href="#pz-lkc-internal"		<?php echo $show_internal;		?>><?php _e('Internal Link', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-samepage"		href="#pz-lkc-samepage"		<?php echo $show_samepage;		?>><?php _e('Same Page Link', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-check"			href="#pz-lkc-check"		<?php echo $show_check;			?>><?php _e('Link Check', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-editor"		href="#pz-lkc-editor"		<?php echo $show_editor;		?>><?php _e('Editor', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-orange"	name="pz-lkc-multisite"		href="#pz-lkc-multisite"	<?php echo $show_multisite;		?>><?php _e('Multi Site', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-advanced"		href="#pz-lkc-advanced"		<?php echo $show_advanced;		?>><?php _e('Advanced', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-etc"			href="#pz-lkc-etc"			<?php echo $show_etc;			?>><?php _e('etc.', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab"				name="pz-lkc-initialize"	href="#pz-lkc-initialize"	<?php echo $show_initialize;	?>><?php _e('Initialize', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-purple"	name="pz-lkc-admin"			href="#pz-lkc-admin"		<?php echo $show_admin;			?>><?php _e('Admin', $this->text_domain ); ?></a>
			</div>

			<?php
				require_once('pz-linkcard-settings-error.php' );			// 「エラー」タブ
				require_once('pz-linkcard-settings-basic.php' );			// 「基本」タブ
				require_once('pz-linkcard-settings-position.php' );			// 「配置」タブ
				require_once('pz-linkcard-settings-display.php' );			// 「表示」タブ
				require_once('pz-linkcard-settings-letter.php' );			// 「文字」タブ
				require_once('pz-linkcard-settings-link.php' );				// 「外部リンク」「内部リンク」「同ページ」タブ
				require_once('pz-linkcard-settings-check.php' );			// 「リンク先の検査」タブ
				require_once('pz-linkcard-settings-editor.php' );			// 「エディター」タブ
				require_once('pz-linkcard-settings-multisite.php' );		// 「マルチサイト」タブ
				require_once('pz-linkcard-settings-advanced.php' );			// 「上級者向け」タブ
				require_once('pz-linkcard-settings-etc.php' );				// 「その他」タブ
				require_once('pz-linkcard-settings-initialize.php' );		// 「初期化」タブ
				require_once('pz-linkcard-settings-admin.php' );			// 「管理者」タブ
			?>
		</form>
	</div>
	<div class="pz-button-top" title="<?php _e('Scroll to the top', $this->text_domain ); ?>"><?php _e('^<br>Top', $this->text_domain ); ?></div>
</div>
<?php
// echo	'<div id="pz-lkc-overlay-proc"></div>';

// 数値にする
function pz_TrimNum($val ) {
	$val		=	mb_convert_kana($val, 'n' );
	$val		=	strtolower($val );
	$val		=	preg_replace('/[^0-9]/', '', $val );
	if	($val	<>	null) {
		$val	=	intval($val );
	}
	return	$val;
}

// 数値にする
function pz_TrimNumPx($val ) {
	$unit		=	null;
	$val		=	mb_convert_kana($val, 'n' );
	$val		=	strtolower($val );
	if (substr($val, -1 ) == '%') {
		$unit	=	'%';
	} else {
		$unit	=	'px';
	}
	$val		=	preg_replace('/[^0-9]/', '', $val );
	if	($val	<>	null) {
		$val	=	$val.$unit;
	}
	return	$val;
}

// HTMLカラーコード
function pz_CheckColorCode($val ) {
	if	(preg_match('/^#([0-9A-F]{6}|[0-9A-F]{3})$/i', $val ) ) {
		return true;
	}
}

// ディレクトリ配下の使用サイズ
function pz_GetDirSize($dir ) {
	$size	=	0;
	$handle	=	opendir($dir );
	if	(!$handle ) {
		return	null;
	}
	while ($file = readdir($handle ) ) {
		$fullpath = $dir.'/'.$file;
		if	(is_dir($fullpath ) ) {
			if	($file !== '..' && $file !== '.' ) {
				$size += pz_GetDirSize($fullpath );
			}
		} else {
			$size += filesize($fullpath );
		}
	}
	return $size;
}

// 数値をKB、MB、TBの単位に変換
function pz_GetSizeStringSi($val ) {
	$label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
	for($i = 0; $val >= 1024 && $i < (count($label ) -1 ); $val /= 1024, $i++ );
	return (round($val, 2 ).' '.$label[$i] );
}

// 数値をKB、MB、TBの単位に変換
function pz_GetStringBytes($val ) {
	if	($val == 1 ) {
		return number_format($val ).' byte';
	} else {
		return number_format($val ).' bytes';
	}
}
