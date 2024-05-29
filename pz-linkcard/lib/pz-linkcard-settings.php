<?php defined('ABSPATH' ) || wp_die; ?>
<?php /* 開発者モード */ if ($this->options['develop-mode'] ) { echo '<style>#wpadminbar { background-color: #0a8 !important; }</style><div class="pz-lkc-develop-message">'.__('Currently working in a development environment.', $this->text_domain ).'</div>'; } ?>
<div class="pz-lkc-dashboard pz-lkc-settings wrap">
	<div class="pz-header">
		<a class="pz-header-switch" href="<?php echo esc_url($this->cacheman_url ); ?>">
			<span class="pz-header-switch-icon"><?php _e('&#x1f5c3;&#xfe0f;', $this->text_domain ); ?></span>
			<span class="pz-header-switch-label"><?php _e('Manager', $this->text_domain ); ?></span>
		</a>
		<h1 class="pz-header-title">
			<span class="pz-header-title-icon"><?php echo __('&#x2699;&#xfe0f;', $this->text_domain ); ?></span>
			<span class="pz-header-title-text"><?php _e('LinkCard Settings', $this->text_domain ); ?></span>
			<a class="pz-header-title-text" href="<?php echo $this->author['website']; ?>/pz-linkcard-manager" rel="external noopener help" target="_blank">
				<img src="<?php echo $this->plugin_dir_url.'img/help.png'; ?>" width="16" height="16" title="<?php _e('Help', $this->text_domain ); ?>" alt="help">
			</a>
		</h1>
	</div>

<?php
	// 記述エラー
	if	($this->options['error-mode'] ) {
		if	(!$this->options['error-mode-hide'] ) {
			// echo '<div class="notice notice-error is-dismissible"><p><strong>'.$this->options['plugin-name'].': '.__('Invalid URL parameter in ', $this->text_domain ).'<a href="'.$this->options['error-url'].'#lkc-error" target="_blank">'.$this->options['error-url'].'</a></strong><br>'.__('*', $this->text_domain ).' '.__('You can cancel this message from <a href="./options-general.php?page=pz-linkcard-settings">the setting screen</a>.', $this->text_domain ).'</p></div>';
			echo '<div class="notice notice-error is-dismissible"><p><strong>'.$this->options['plugin-name'].': '.__('Invalid URL parameter in ', $this->text_domain ).'<a href="'.$this->options['error-url'].'#lkc-error" target="_blank">'.$this->options['error-url'].'</a></strong><br>'.__('*', $this->text_domain ).' '.__('You can cancel this message from <a href="./options-general.php?page=pz-linkcard-settings">the setting screen</a>.', $this->text_domain ).'</p></div>';
		}
	}

	// 変数の設定
	$action		=	isset($_REQUEST['action'] )			? esc_attr($_REQUEST['action'] )			: null;
	$tab_now	=	isset($_REQUEST['pz-lkc-tab-now'] )	? esc_attr($_REQUEST['pz-lkc-tab-now'] )	: null;

	// ぽぽづれ。のURL
	$pz_url			=	$this->options['author-url'];
	$pz_url_info	=	$this->Pz_GetURLInfo($pz_url );
	$pz_domain		=	$pz_url_info['domain'];				// ドメイン名
	$pz_domain_url	=	$pz_url_info['domain_url'];			// ドメインURL

	// Pz-LinkCardのURL
	$plugin_url			=	$this->options['author-url'].$this->options['plugin-path'];

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

	if	(isset($_REQUEST['properties'] ) ) {
		check_admin_referer('pz-lkc-settings' );

		// 入力された値
		$flg_change				=	false;
		$properties				=	$this->defaults;
		foreach($_REQUEST['properties'] as $key => $value ) {
			$properties[$key]	=	stripslashes($_REQUEST['properties'][$key] );
			if	($properties[$key]	!=	$this->options[$key] ) {
				$flg_change				=	true;
			}
		}

		switch	($action ) {
		case	'init-settings':
			$result			=	$this->pz_InitializeOption();	// オプションの初期化
			if	($result ) {
				echo	'<div class="notice notice-success is-dismissible"><p><strong>'.__('Succeeded in initialize the settings.', $this->text_domain ).'</strong></p></div>';
			} else {
				echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Failed to initialize the settings.', $this->text_domain ).'</strong></p></div>';
			}
			$result			=	$this->pz_SetStyle();			// スタイルシート生成
			break;
		case	'clear-error':
			$this->options['error-mode']	=	null;
			$result	=	$this->pz_UpdateOption();				// オプションの更新
			
			break;
		case	'run-pz_linkcard_check':
			break;
		case	'run-pz_linkcard_alive':
			break;
		default:
			$this->options	=	$properties;

			// 値の検証
			$flg_error				=	false;
			require_once ('pz-linkcard-settings-validate.php' );
			if	(!$flg_error ) {
				$result	=	$this->pz_UpdateOption();		// オプションの更新
				if	($result ) {
					echo	'<div class="notice notice-success is-dismissible"><p><strong>'.__('Succeeded in saving the settings.', $this->text_domain ).'</strong></p></div>';
				} else {
					//echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Failed to save settings.', $this->text_domain ).'</strong></p></div>';
					echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('The settings have not changed.', $this->text_domain ).'</strong></p></div>';
				}
			}
			$ressult		=	$this->pz_SetStyle();			// スタイルシート生成
		}
	}

	// バージョンが違っているか、「プラグインの再起動」を押したとき、アクティべーション時の処理を実行
	if	(($this->options['plugin-version'] <> $this->defaults['plugin-version'] ) || ($action == 'init-plugin' ) ) {
		// アクティベーションを実行
		$this->activate();
	}

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

	// マルチサイト
	$is_multisite		=	false;
	$is_subdomain		=	false;
	$multi_myid			=	get_current_blog_id();
	$multi_count		=	0;
	if	(function_exists('is_multisite' ) && is_multisite() ) {
		$is_multisite		=	true;
		if	(function_exists('is_subdomain_install' ) && is_subdomain_install() ) {
			$is_subdomain	=	true;
		}
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
?>
	<div>
		<form action="" method="post">
			<?php wp_nonce_field('pz-lkc-settings' ); ?>
			<span class="pz-lkc-hide"><?php submit_button(); ?></span><?php /* [Enter]を押したとき用 */?>

			<input type="text" class="pz-lkc-tab-now pz-lkc-hide" name="pz-lkc-tab-now"    value="<?php echo esc_attr($tab_now ); ?>" />
			<input type="text" class="pz-lkc-display pz-lkc-hide" name="pz-lkc-debug"      value="<?php echo esc_attr($this->options['debug-mode'] ); ?>"/>
			<input type="text" class="pz-lkc-display pz-lkc-hide" name="pz-lkc-develop"    value="<?php echo esc_attr($this->options['develop-mode'] ); ?>"/>
			<input type="text" class="pz-lkc-display pz-lkc-hide" name="pz-lkc-error"      value="<?php echo esc_attr($this->options['error-mode'] ); ?>"/>
			<input type="text" class="pz-lkc-display pz-lkc-hide" name="pz-lkc-multisite"  value="<?php echo esc_attr($is_multisite ); ?>"/>
			<input type="text" class="pz-lkc-display pz-lkc-hide" name="pz-lkc-admin"      value="<?php echo esc_attr($this->options['admin-mode'] ); ?>"/>
			<input type="text" class="pz-lkc-display pz-lkc-hide" name="pz-lkc-initialize" value="<?php echo esc_attr($this->options['flg-initialize'] ); ?>"/>

			<div class="pz-lkc-tabs">
				<a class="pz-lkc-tab pz-lkc-hide pz-lkc-red" name="pz-lkc-error"      href="#pz-lkc-error"      ><?php _e('Error', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-basic"      href="#pz-lkc-basic"      ><?php _e('Basic', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-position"   href="#pz-lkc-position"   ><?php _e('Position', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-display"    href="#pz-lkc-display"    ><?php _e('Display', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-letter"     href="#pz-lkc-letter"     ><?php _e('Letter', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-external"   href="#pz-lkc-external"   ><?php _e('External Link', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-internal"   href="#pz-lkc-internal"   ><?php _e('Internal Link', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-samepage"   href="#pz-lkc-samepage"   ><?php _e('Same Page Link', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-check"      href="#pz-lkc-check"      ><?php _e('Link Check', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-editor"     href="#pz-lkc-editor"     ><?php _e('Editor', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-hide" name="pz-lkc-multisite"  href="#pz-lkc-multisite"  ><?php _e('Multi Site', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-advanced"   href="#pz-lkc-advanced"   ><?php _e('Advanced', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-show" name="pz-lkc-etc"        href="#pz-lkc-etc"        ><?php _e('etc.', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-hide" name="pz-lkc-initialize" href="#pz-lkc-initialize" ><?php _e('Initialize', $this->text_domain ); ?></a>
				<a class="pz-lkc-tab pz-lkc-hide" name="pz-lkc-admin"      href="#pz-lkc-admin"      ><span class="pz-lkc-admin-text"><?php _e('Admin', $this->text_domain ); ?></span></a>
			</div>

			<?php // Admin Mode Only
			if	($this->options['admin-mode'] ) {
				require_once('pz-linkcard-settings-admin.php' );
			}
			?>

			<div class="pz-lkc-page" id="pz-lkc-error">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Error Settings', $this->text_domain ).$help_open.'error'.$help_close; ?></h3>
				<div class="pz-error-text">
					<?php _e('The shortcode description is incorrect. Please open the "Linked Articles" section and correct it.', $this->text_domain ); ?>
				</div>
				<table class="pz-lkc-set-table form-table">
					<tr>
						<th scope="row"><?php _e('Post URL', $this->text_domain ); ?></th>
						<td>
							<a href="<?php echo esc_url($this->options['error-url'] ); ?>" class="pz-lkc-error-url"><?php echo esc_url($this->options['error-url'] ); ?></a>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Occurrence Time', $this->text_domain ); ?></th>
						<td>
							<span><?php echo is_numeric($this->options['error-time'] ) ? date($this->datetime_format, $this->options['error-time'] ) : $this->options['error-time']; ?></span>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Error Reset', $this->text_domain ); ?></th>
						<td>
							<button type="submit" name="action" value="clear-error" class="pz-lkc-button"><?php _e('Reset', $this->text_domain ); ?></button>
							&ensp;<span><?php _e('Cancel the error condition.', $this->text_domain ); ?></span>
							<br /><span class="pz-warning"><?php _e('* If you have not corrected the error, you may still get an error even if you cancel the error.', $this->text_domain ); ?></span>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>
			
			<div class="pz-lkc-page" id="pz-lkc-basic">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Basic Settings', $this->text_domain ).$help_open.'basic'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Easy format', $this->text_domain ); ?></th>
						<td>
							<select name="properties[special-format]">
								<option value=""	<?php selected($this->options['special-format'] == ''    ); ?>><?php _e('None', $this->text_domain ); ?></option>
								<option value="LkC"	<?php selected($this->options['special-format'] == 'LkC' ); ?>><?php _e('Pz-LkC Default', $this->text_domain ); ?></option>

								<option value="hbc"	<?php selected($this->options['special-format'] == 'hbc' ); ?>><?php _e('Normal', $this->text_domain ); ?></option>
								<option value="cmp"	<?php selected($this->options['special-format'] == 'cmp' ); ?>><?php _e('Compact', $this->text_domain ); ?></option>
								<option value="smp"	<?php selected($this->options['special-format'] == 'smp' ); ?>><?php _e('Simple', $this->text_domain ); ?></option>
								<option value="JIN"	<?php selected($this->options['special-format'] == 'JIN' ); ?>><?php _e('Headline', $this->text_domain ); ?></option>

								<option value="ct1"	<?php selected($this->options['special-format'] == 'ct1' ); ?>><?php _e('Cellophane tape "center"', $this->text_domain ); ?></option>
								<option value="ct2"	<?php selected($this->options['special-format'] == 'ct2' ); ?>><?php _e('Cellophane tape "Top corner"', $this->text_domain ); ?></option>
								<option value="ct3"	<?php selected($this->options['special-format'] == 'ct3' ); ?>><?php _e('Cellophane tape "long"', $this->text_domain ); ?></option>
								<option value="ct4"	<?php selected($this->options['special-format'] == 'ct4' ); ?>><?php _e('Cellophane tape "digonal"', $this->text_domain ); ?></option>
								<option value="tac"	<?php selected($this->options['special-format'] == 'tac' ); ?>><?php _e('Cellophane tape and curling', $this->text_domain ); ?></option>
								<option value="ppc"	<?php selected($this->options['special-format'] == 'ppc' ); ?>><?php _e('Curling paper', $this->text_domain ); ?></option>

								<option value="sBR"	<?php selected($this->options['special-format'] == 'sBR' ); ?>><?php _e('Stitch blue & red', $this->text_domain ); ?></option>
								<option value="sGY"	<?php selected($this->options['special-format'] == 'sGY' ); ?>><?php _e('Stitch green & yellow', $this->text_domain ); ?></option>

								<option value="sqr"	<?php selected($this->options['special-format'] == 'sqr' ); ?>><?php _e('Square', $this->text_domain ); ?></option>

								<option value="ecl"	<?php selected($this->options['special-format'] == 'ecl' ); ?>><?php _e('Enclose', $this->text_domain ); ?></option>
								<option value="ref"	<?php selected($this->options['special-format'] == 'ref' ); ?>><?php _e('Reflection', $this->text_domain ); ?></option>

								<option value="inI"	<?php selected($this->options['special-format'] == 'inI' ); ?>><?php _e('Infomation orange', $this->text_domain ); ?></option>
								<option value="inN"	<?php selected($this->options['special-format'] == 'inN' ); ?>><?php _e('Neutral bluegreen', $this->text_domain ); ?></option>
								<option value="inE"	<?php selected($this->options['special-format'] == 'inE' ); ?>><?php _e('Enlightened green', $this->text_domain ); ?></option>
								<option value="inR"	<?php selected($this->options['special-format'] == 'inR' ); ?>><?php _e('Resistance blue', $this->text_domain ); ?></option>

								<option value="wxp"	<?php selected($this->options['special-format'] == 'wxp' ); ?>><?php _e('Windows XP', $this->text_domain ); ?></option>
								<option value="w95"	<?php selected($this->options['special-format'] == 'w95' ); ?>><?php _e('Windows 95', $this->text_domain ); ?></option>

								<option value="slt"	<?php selected($this->options['special-format'] == 'slt' ); ?>><?php _e('Slanting', $this->text_domain ); ?></option>

								<option value="3Dr"	<?php selected($this->options['special-format'] == '3Dr' ); ?>><?php _e('3D Rotate', $this->text_domain ); ?></option>
								<option value="pin"	<?php selected($this->options['special-format'] == 'pin' ); ?>><?php _e('Pushpin', $this->text_domain ); ?></option>
							</select>
							<br><span class="pz-lkc-note"><?php echo __('*', $this->text_domain ).' '.__('It applies over other formatting settings.', $this->text_domain ); ?></span>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Saved Datetime', $this->text_domain ); ?></th>
						<td>
							<input type="text" size="40" value="<?php echo is_numeric($this->options['saved-date'] ) ? date($this->datetime_format, $this->options['saved-date'] ) : $this->options['saved-date']; ?>" readonly="readonly" />
							<input name="properties[saved-date]" type="text" value="<?php echo $this->options['saved-date']; ?>" class="pz-lkc-admin-only" readonly="readonly" />
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>

				<h2><?php echo	__('Changelog', $this->text_domain ); ?></h3>
				<div class="pz-lkc-changelog">
					<?php echo	$changelog; ?>
				</div>
				<?php submit_button(); ?>

				<h2><?php echo	__('Related Information', $this->text_domain ); ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php echo	__('How to', $this->text_domain ).' '.__('(', $this->text_domain ).__('Japanese Only', $this->text_domain ).__(')', $this->text_domain ); ?></th>
						<td>
							<p><?php echo	esc_attr($this->options['plugin-name'] ).' Ver.'.esc_attr($this->options['plugin-version'] ); ?></p>
							<p><a href="<?php echo	esc_attr($plugin_url ); ?>" rel="external noopener" target="_blank"><?php echo	esc_attr($plugin_url ); ?></a></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Author's Site", $this->text_domain ); ?></th>
						<td><?php echo	__('Popozure.', $this->text_domain ).' ('.__("Poporon's PC Daily Diary", $this->text_domain ).')'; ?><BR><a href="<?php echo $pz_url; ?>" rel="external noopener" target="_blank"><?php echo $pz_url; ?></A></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('When in Trouble', $this->text_domain ); ?></th>
						<td><?php echo	__('Twitter Account', $this->text_domain ); ?><BR><a href="https://twitter.com/<?php echo	$this->options['author-twitter']; ?>" rel="external noopener" target="_blank">@<?php echo	$this->options['author-twitter']; ?></A></td>
					</tr>

					<tr class="pz-lkc-debug-only">
						<th scope="row"><?php _e('Donation', $this->text_domain ); ?></th>
						<td><a href="https://www.amazon.co.jp/gp/registry/wishlist/2KIBQLC1VLA9X" rel="external noopenner noreferrer" target="_blank" target="_blank"><?php _e('Wishlist', $this->text_domain ); ?></a></td>
					</tr>

				</table>
				<?php submit_button(); ?>
			</div>
			
			<div class="pz-lkc-page" id="pz-lkc-position">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Position Settings', $this->text_domain ).$help_open.'position'.$help_close; ?></h3>

				<table class="pz-lkc-position-margin">
					<tr>
						<td></td>
						<td>
							<?php _e('Margin top', $this->text_domain ); ?><br>
							<select name="properties[margin-top]">
								<option value=""	 <?php selected($this->options['margin-top'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
								<option value="0"	 <?php selected($this->options['margin-top'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
								<option value="4px"	 <?php selected($this->options['margin-top'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
								<option value="8px"	 <?php selected($this->options['margin-top'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
								<option value="16px" <?php selected($this->options['margin-top'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
								<option value="32px" <?php selected($this->options['margin-top'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
								<option value="40px" <?php selected($this->options['margin-top'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
								<option value="64px" <?php selected($this->options['margin-top'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
							</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<td style="vertical-align: middle; text-align: left;">
							<?php _e('Margin left', $this->text_domain ); ?><br>
							<select name="properties[margin-left]">
								<option value=""	 <?php selected($this->options['margin-left'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
								<option value="0"	 <?php selected($this->options['margin-left'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
								<option value="4px"	 <?php selected($this->options['margin-left'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
								<option value="8px"	 <?php selected($this->options['margin-left'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
								<option value="16px" <?php selected($this->options['margin-left'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
								<option value="32px" <?php selected($this->options['margin-left'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
								<option value="40px" <?php selected($this->options['margin-left'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
								<option value="64px" <?php selected($this->options['margin-left'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
							</select>
						</td>

						<td class="pz-lkc-position-margin-card">
							<table class="form-table">
								<tr>
									<td colspan="3">
										<?php _e('Margin top', $this->text_domain ); ?><br>
										<select name="properties[card-top]">
											<option value=""	 <?php selected($this->options['card-top'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
											<option value="0"	 <?php selected($this->options['card-top'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
											<option value="4px"	 <?php selected($this->options['card-top'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
											<option value="8px"	 <?php selected($this->options['card-top'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
											<option value="16px" <?php selected($this->options['card-top'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
											<option value="24px" <?php selected($this->options['card-top'] == '24px' ); ?>><?php _e('24px', $this->text_domain ); ?></option>
											<option value="32px" <?php selected($this->options['card-top'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
											<option value="40px" <?php selected($this->options['card-top'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
											<option value="64px" <?php selected($this->options['card-top'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="text-align: left;">
										<?php _e('Margin left', $this->text_domain ); ?><br>
										<select name="properties[card-left]">
											<option value=""	 <?php selected($this->options['card-left'] == ''	  ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
											<option value="0"	 <?php selected($this->options['card-left'] == '0'	  ); ?>><?php _e('0', $this->text_domain ); ?></option>
											<option value="4px"	 <?php selected($this->options['card-left'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
											<option value="8px"	 <?php selected($this->options['card-left'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
											<option value="16px" <?php selected($this->options['card-left'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
											<option value="24px" <?php selected($this->options['card-left'] == '24px' ); ?>><?php _e('24px', $this->text_domain ); ?></option>
											<option value="32px" <?php selected($this->options['card-left'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
											<option value="40px" <?php selected($this->options['card-left'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
											<option value="64px" <?php selected($this->options['card-left'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
										</select>
									</td>
									<td>
										<?php _e('Width', $this->text_domain ); ?> <input name="properties[width]"          type="text" size="2" value="<?php echo	esc_attr($this->options['width'] ); ?>" /><br>
										<?php _e('Height', $this->text_domain ); ?><input name="properties[content-height]" type="text" size="2" value="<?php echo	esc_attr($this->options['content-height'] ); ?>" /><br>
									</td>
									<td style="text-align: right;">
										<?php _e('Margin right', $this->text_domain ); ?><br>
										<select name="properties[card-right]">
											<option value=""	 <?php selected($this->options['card-right'] == ''	   ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
											<option value="0"	 <?php selected($this->options['card-right'] == '0'	   ); ?>><?php _e('0', $this->text_domain ); ?></option>
											<option value="4px"	 <?php selected($this->options['card-right'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
											<option value="8px"	 <?php selected($this->options['card-right'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
											<option value="16px" <?php selected($this->options['card-right'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
											<option value="24px" <?php selected($this->options['card-right'] == '24px' ); ?>><?php _e('24px', $this->text_domain ); ?></option>
											<option value="32px" <?php selected($this->options['card-right'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
											<option value="40px" <?php selected($this->options['card-right'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
											<option value="64px" <?php selected($this->options['card-right'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<?php _e('Margin bottom', $this->text_domain ); ?><br>
										<select name="properties[card-bottom]">
											<option value=""	 <?php selected($this->options['card-bottom'] == ''		); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
											<option value="0"	 <?php selected($this->options['card-bottom'] == '0'	); ?>><?php _e('0', $this->text_domain ); ?></option>
											<option value="4px"	 <?php selected($this->options['card-bottom'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
											<option value="8px"	 <?php selected($this->options['card-bottom'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
											<option value="16px" <?php selected($this->options['card-bottom'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
											<option value="24px" <?php selected($this->options['card-bottom'] == '24px' ); ?>><?php _e('24px', $this->text_domain ); ?></option>
											<option value="32px" <?php selected($this->options['card-bottom'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
											<option value="40px" <?php selected($this->options['card-bottom'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
											<option value="64px" <?php selected($this->options['card-bottom'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
										</select>
									</td>
								</tr>
							</table>

						</td>
						<td style="vertical-align: middle; text-align: right;">
							<?php _e('Margin right', $this->text_domain ); ?><br>
							<select name="properties[margin-right]">
								<option value=""	 <?php selected($this->options['margin-right'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
								<option value="0"	 <?php selected($this->options['margin-right'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
								<option value="4px"	 <?php selected($this->options['margin-right'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
								<option value="8px"	 <?php selected($this->options['margin-right'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
								<option value="16px" <?php selected($this->options['margin-right'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
								<option value="32px" <?php selected($this->options['margin-right'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
								<option value="40px" <?php selected($this->options['margin-right'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
								<option value="64px" <?php selected($this->options['margin-right'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input name="properties[centering]" type="checkbox" value="1" <?php checked($this->options['centering'] ); ?> /><?php _e('Centering', $this->text_domain ); ?>
						</td>
						<td>
							<?php _e('Margin bottom', $this->text_domain ); ?><br>
							<select name="properties[margin-bottom]">
								<option value=""	 <?php selected($this->options['margin-bottom'] == ''     ); ?>><?php _e('Not defined', $this->text_domain ); ?></option>
								<option value="0"	 <?php selected($this->options['margin-bottom'] == '0'    ); ?>><?php _e('0', $this->text_domain ); ?></option>
								<option value="4px"	 <?php selected($this->options['margin-bottom'] == '4px'  ); ?>><?php _e('4px', $this->text_domain ); ?></option>
								<option value="8px"	 <?php selected($this->options['margin-bottom'] == '8px'  ); ?>><?php _e('8px', $this->text_domain ); ?></option>
								<option value="16px" <?php selected($this->options['margin-bottom'] == '16px' ); ?>><?php _e('16px', $this->text_domain ); ?></option>
								<option value="32px" <?php selected($this->options['margin-bottom'] == '32px' ); ?>><?php _e('32px', $this->text_domain ); ?></option>
								<option value="40px" <?php selected($this->options['margin-bottom'] == '40px' ); ?>><?php _e('40px', $this->text_domain ); ?></option>
								<option value="64px" <?php selected($this->options['margin-bottom'] == '64px' ); ?>><?php _e('64px', $this->text_domain ); ?></option>
							</select>
						</td>
						<td>
						</td>
					</tr>
				</table>

				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Link the Whole', $this->text_domain ); ?></th>
						<td>
							<label>
								<input name="properties[link-all]" type="checkbox" value="1" <?php checked($this->options['link-all'] ); ?> />
								<?php _e('Enclose the entire card at anchor.', $this->text_domain ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Use Blockquote Tag', $this->text_domain ); ?></th>
						<td><label><input name="properties[blockquote]" type="checkbox" value="1" <?php checked($this->options['blockquote'] ); ?> /><?php _e('Without using DIV tag, and use BLOCKQUOTE tag.', $this->text_domain ); _e('(Deprecated)', $this->text_domain ); ?></label></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>
			
			<div class="pz-lkc-page" id="pz-lkc-display">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Display Settings', $this->text_domain ).$help_open.'display'.$help_close; ?></h3>
				<table class="form-table" style="width: 100%;">
					<tr>
						<th scope="row"><?php _e('Layout', $this->text_domain ); ?></th>
						<td>
							<table class="pz-lkc-display-layout">
								<tr>
									<td colspan="2">
										<?php _e('Site Information', $this->text_domain ); ?>
										<select name="properties[info-position]">
											<option value=""  <?php selected($this->options['info-position'] == ''  ); ?>><?php _e('None',				$this->text_domain ); ?></option>
											<option value="1" <?php selected($this->options['info-position'] == '1' ); ?>><?php _e('Upper Side',		$this->text_domain ); ?></option>
											<option value="3" <?php selected($this->options['info-position'] == '3' ); ?>><?php _e('Above the Title',	$this->text_domain ); ?></option>
											<option value="2" <?php selected($this->options['info-position'] == '2' ); ?>><?php _e('Under Side',		$this->text_domain ); ?></option>
										</select>
										<label><input name="properties[use-sitename]" type="checkbox" value="1" <?php checked($this->options['use-sitename'] ); ?> /><?php _e('Use SiteName', $this->text_domain ); ?></label>
									</td>
								</tr>
								<tr>
									<td><label><input name="properties[display-date]" type="checkbox" value="1" <?php checked($this->options['display-date'] ); ?> /><?php _e('For internal links, display the posting date', $this->text_domain ); ?></label></td>
									<td rowspan="10" class="pz-lkc-display-layout-thumbnail">
										<table class="pz-lkc-display-thumbnail">
											<tr>
												<td><?php _e('Thumbnail', $this->text_domain ); ?></td>
											</tr>
											<tr>
												<td>
													<?php _e('Position', $this->text_domain ); ?>
													<select name="properties[thumbnail-position]">
														<option value="0" <?php selected($this->options['thumbnail-position'] == '0' ); ?>><?php _e('None',			$this->text_domain ); ?></option>
														<option value="1" <?php selected($this->options['thumbnail-position'] == '1' ); ?>><?php _e('Right Side',	$this->text_domain ); ?></option>
														<option value="2" <?php selected($this->options['thumbnail-position'] == '2' ); ?>><?php _e('Left Side',	$this->text_domain ); ?></option>
														<option value="3" <?php selected($this->options['thumbnail-position'] == '3' ); ?>><?php _e('Upper Side',	$this->text_domain ); ?></option>
													</select>
												</td>
											</tr>
											<tr>
												<td><?php _e('Width', $this->text_domain );  ?><input name="properties[thumbnail-width]"	type="text" size="2" value="<?php echo $this->options['thumbnail-width']; ?>" /></td>
											</tr>
											<tr>
												<td><?php _e('Height', $this->text_domain ); ?><input name="properties[thumbnail-height]"	type="text" size="2" value="<?php echo $this->options['thumbnail-height']; ?>" /></td>
											</tr>
											<tr>
												<td><label><input name="properties[thumbnail-shadow]" type="checkbox" value="1" <?php checked($this->options['thumbnail-shadow'] ); ?> /><?php _e('Shadow', $this->text_domain ); ?></label></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td><label><input name="properties[heading]" type="checkbox" value="1" <?php checked($this->options['heading'] ); ?> /><?php _e('Make additional information heading display', $this->text_domain ); ?></label></td>
								</tr>
								<tr>
									<td><label><input name="properties[flg-anker]" type="checkbox" value="1" <?php checked($this->options['flg-anker'] ); ?> /><?php _e('Turn off the anchor text underlining', $this->text_domain ); ?></label></td>
								</tr>
								<tr>
									<td><label><input name="properties[separator]" type="checkbox" value="1" <?php checked($this->options['separator'] ); ?> /><?php _e('Separator line', $this->text_domain ); ?></label></td>
								</tr>
								<tr>
									<td>
										<label>
											<?php _e('Display URL', $this->text_domain ); ?>
											<select name="properties[display-url]">
												<option value=""  <?php selected($this->options['display-url'] == ''  ); ?>><?php _e('None',				$this->text_domain ); ?></option>
												<option value="1" <?php selected($this->options['display-url'] == '1' ); ?>><?php _e('Under Title',			$this->text_domain ); ?></option>
												<option value="2" <?php selected($this->options['display-url'] == '2' ); ?>><?php _e('Bihind Site-Info',	$this->text_domain ); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[content-inset]" type="checkbox" value="1" <?php checked($this->options['content-inset'] ); ?> /><?php _e('Hollow content area', $this->text_domain ); ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[display-excerpt]" type="checkbox" value="1" <?php checked($this->options['display-excerpt'] ); ?> /><?php _e('Display excerpt', $this->text_domain ); ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[shadow-inset]" type="checkbox" value="1" <?php checked($this->options['shadow-inset'] ); ?> /><?php _e('Hollow', $this->text_domain ); ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[shadow]" type="checkbox" value="1" <?php checked($this->options['shadow'] ); ?> /><?php _e('Shadow', $this->text_domain ); ?></label></td>
									</td>
								</tr>
								<tr>
									<td>
										<?php _e('Round a square', $this->text_domain ); ?>
										<select name="properties[radius]">
											<option value=""  <?php selected($this->options['radius'] == ''  ); ?>><?php _e('None',	$this->text_domain ); ?></option>
											<option value="2" <?php selected($this->options['radius'] == '2' ); ?>><?php _e('4px',	$this->text_domain ); ?></option>
											<option value="1" <?php selected($this->options['radius'] == '1' ); ?>><?php _e('8px',	$this->text_domain ); ?></option>
											<option value="3" <?php selected($this->options['radius'] == '3' ); ?>><?php _e('16px',	$this->text_domain ); ?></option>
											<option value="4" <?php selected($this->options['radius'] == '4' ); ?>><?php _e('32px',	$this->text_domain ); ?></option>
											<option value="5" <?php selected($this->options['radius'] == '5' ); ?>><?php _e('64px',	$this->text_domain ); ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<label>
											<?php _e('When the mouse is on', $this->text_domain ); ?>
											<select name="properties[hover]">
												<option value=""  <?php selected($this->options['hover'] == ''  ); ?>><?php _e('None',			$this->text_domain ); ?></option>
												<option value="1" <?php selected($this->options['hover'] == '1' ); ?>><?php _e('Lighten',		$this->text_domain ); ?></option>
												<option value="2" <?php selected($this->options['hover'] == '2' ); ?>><?php _e('Hover (light)',	$this->text_domain ); ?></option>
												<option value="3" <?php selected($this->options['hover'] == '3' ); ?>><?php _e('Hover (dark)',	$this->text_domain ); ?></option>
												<option value="7" <?php selected($this->options['hover'] == '7' ); ?>><?php _e('Radius',		$this->text_domain ); ?></option>
											</select>
										</label>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Border', $this->text_domain ); ?></th>
						<td>
							<select name="properties[border-style]">
								<option value="none"	<?php selected($this->options['border-style'] == 'none'   ); ?>><?php _e('None',	$this->text_domain ); ?></option>
								<option value="solid"	<?php selected($this->options['border-style'] == 'solid'  ); ?>><?php _e('Solid',	$this->text_domain ); ?></option>
								<option value="dotted"	<?php selected($this->options['border-style'] == 'dotted' ); ?>><?php _e('Dotted',	$this->text_domain ); ?></option>
								<option value="dashed"	<?php selected($this->options['border-style'] == 'dashed' ); ?>><?php _e('Dashed',	$this->text_domain ); ?></option>
								<option value="double"	<?php selected($this->options['border-style'] == 'double' ); ?>><?php _e('Double',	$this->text_domain ); ?></option>
								<option value="groove"	<?php selected($this->options['border-style'] == 'groove' ); ?>><?php _e('Groove',	$this->text_domain ); ?></option>
								<option value="ridge"	<?php selected($this->options['border-style'] == 'ridge'  ); ?>><?php _e('Ridge',	$this->text_domain ); ?></option>
								<option value="inset"	<?php selected($this->options['border-style'] == 'inset'  ); ?>><?php _e('Inset',	$this->text_domain ); ?></option>
								<option value="outset"	<?php selected($this->options['border-style'] == 'outset' ); ?>><?php _e('Outset',	$this->text_domain ); ?></option>
							</select>
							&nbsp;<?php _e('Width', $this->text_domain ); ?><input name="properties[border-width]" type="text" size="2" value="<?php echo	$this->options['border-width']; ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Reset Image Style', $this->text_domain ); ?></th>
						<td><label><input name="properties[style-reset-img]" type="checkbox" value="1" <?php checked($this->options['style-reset-img'] ); ?> /><?php _e('When unnecessary frame is displayed on the image, you can improve it by case', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('More Button', $this->text_domain ); ?></th>
						<td>
							<select name="properties[flg-more]">
								<option value=""  <?php selected($this->options['flg-more'] == ''  ); ?>><?php _e('None',			$this->text_domain ); ?></option>
								<option value="1" <?php selected($this->options['flg-more'] == '1' ); ?>><?php _e('Text link',		$this->text_domain ); ?></option>
								<option value="2" <?php selected($this->options['flg-more'] == '2' ); ?>><?php _e('Simple button',	$this->text_domain ); ?></option>
								<option value="3" <?php selected($this->options['flg-more'] == '3' ); ?>><?php _e('Blue',			$this->text_domain ); ?></option>
								<option value="4" <?php selected($this->options['flg-more'] == '4' ); ?>><?php _e('Dark',			$this->text_domain ); ?></option>
							</select>
							<p><?php _e('*', $this->text_domain ); ?> <?php _e('It is recommended that you leave the card height blank when using this setting.', $this->text_domain ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Display SNS Count', $this->text_domain ); ?></th>
						<td>
							<select name="properties[sns-position]">
								<option value=""  <?php selected($this->options['sns-position'] == ''  ); ?>><?php _e('None',				$this->text_domain ); ?></option>
								<option value="1" <?php selected($this->options['sns-position'] == '1' ); ?>><?php _e('Bihind Title',		$this->text_domain ); ?></option>
								<option value="2" <?php selected($this->options['sns-position'] == '2' ); ?>><?php _e('Bihind Site-Info',	$this->text_domain ); ?></option>
							</select>
							<ul>
								<li>
									<label><input name="properties[sns-tw]"	  type="checkbox" value="1" <?php checked($this->options['sns-tw']   ); ?> /><?php echo __('X (Twitter)',	$this->text_domain ).__('* number is not updated',	$this->text_domain ); ?></label>
									<label><input name="properties[sns-tw-x]" type="checkbox" value="1" <?php checked($this->options['sns-tw-x'] ); ?> /><?php echo __('Change the unit of measure to "tweets".', $this->text_domain ); ?></label>
								</li>
								<li><label><input name="properties[sns-fb]"	type="checkbox" value="1" <?php checked($this->options['sns-fb'] ); ?> /><?php echo __('Facebook',		$this->text_domain ).__('* number is not updated',	$this->text_domain ); ?></label></li>
								<li><label><input name="properties[sns-hb]"	type="checkbox" value="1" <?php checked($this->options['sns-hb'] ); ?> /><?php echo __('Hatena',		$this->text_domain ); ?></label></li>
								<li><label><input name="properties[sns-po]"	type="checkbox" value="1" <?php checked($this->options['sns-po'] ); ?> /><?php echo __('Pocket',		$this->text_domain ); ?></label></li>
							</ul>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>
			
			<div class="pz-lkc-page" id="pz-lkc-letter">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Letter Settings', $this->text_domain ).$help_open.'letter'.$help_close; ?></h3>
				<table class="form-table">
					<?php
						$table	=	array(
							array( 'slug' => 'title'	,	'title' => __('Title',				$this->text_domain )	),
							array( 'slug' => 'url'		,	'title' => __('URL',				$this->text_domain )	),
							array( 'slug' => 'excerpt'	,	'title' => __('Excerpt',			$this->text_domain )	),
							array( 'slug' => 'more'		,	'title' => __('More Button',		$this->text_domain )	),
							array( 'slug' => 'info'		,	'title' => __('Site Information',	$this->text_domain )	),
							array( 'slug' => 'added'	,	'title' => __('Added Information',	$this->text_domain )	),
						);
						foreach ($table as $t) {
					?>
					<tr>
						<th scope="row"><?php echo	$t['title']; ?></th>
						<td>
							<div class="pz-lkc-letter-box">
								<div>
									<?php _e('Color', $this->text_domain ); ?>
									<?php $name = 'color-'.$t['slug'];			$val = esc_attr($this->options[$name] ); ?>
									<input name="properties[<?php echo	$name; ?>]" type="color"    value="<?php echo	$val; ?>" class="pz-lkc-sync-text"  />
									<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" class="pz-lkc-sync-text pz-lkc-letter-color-code" />
									&emsp;
									<?php $name = 'outline-'.$t['slug'];			$val = esc_attr($this->options[$name] ); ?>
									<label>
									<input name="properties[<?php echo	$name; ?>]" type="checkbox" value="1" <?php checked($val ); ?> /><?php _e('Outline', $this->text_domain ); ?></label>
									<?php $name = 'outline-color-'.$t['slug'];	$val = esc_attr($this->options[$name] ); ?>
									<input name="properties[<?php echo	$name; ?>]" type="color"    value="<?php echo	$val; ?>" class="pz-lkc-sync-text" />
									<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" class="pz-lkc-sync-text pz-lkc-letter-color-code" />
								</div>
								<div>
									<?php _e('Size', $this->text_domain ); ?>
									<?php $name = 'size-'.$t['slug'];			$val = esc_attr($this->options[$name] ); ?>
									<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" size="2" />
									&emsp;
									<?php _e('Height',	$this->text_domain ); ?>
									<?php $name = 'height-'.$t['slug'];			$val = esc_attr($this->options[$name] ); ?>
									<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" size="2" />
									&emsp;
									<?php $name = 'trim-'.$t['slug'];			if ( array_key_exists($name, $this->options ) ) { $val = esc_attr($this->options[$name] ); ?>
										<?php _e('Length',	$this->text_domain ); ?>
										<input name="properties[<?php echo	$name; ?>]" type="text"     value="<?php echo	$val; ?>" size="2" />
									<?php } ?>
									<?php $name = 'nowrap-'.$t['slug'];			if ( array_key_exists($name, $this->options ) ) { $val = esc_attr($this->options[$name] ); ?>
										<label><input name="properties[<?php echo	$name; ?>]" type="checkbox" value="1" <?php checked($val ); ?>><?php _e('No wrap', $this->text_domain ); ?></label>
									<?php } ?>
								</div>
							</div>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<th scope="row"><?php _e('Resize', $this->text_domain ); ?></th>
						<td colspan="4"><label><input name="properties[thumbnail-resize]" type="checkbox" value="1" <?php checked($this->options['thumbnail-resize'] ); ?> /><?php _e('Adjust thumbnail and letter size according to width.', $this->text_domain ); ?></label></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>
			
			<?php
				$title	=	array(
					array( 'slug' => 'ex',	'type' => 'external',	'title' => __('External Link Settings',		$this->text_domain )	),
					array( 'slug' => 'in',	'type' => 'internal',	'title' => __('Internal Link Settings',		$this->text_domain )	),
					array( 'slug' => 'th',	'type' => 'samepage',	'title' => __('Same Page Link Settings',	$this->text_domain )	),
				);
				foreach ($title as $t) {
			?>
			<div class="pz-lkc-page" id="pz-lkc-<?php echo $t['type']; ?>">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	$t['title'].$help_open.$t['type'].'-link'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Border Color', $this->text_domain ); ?></th>
						<td>
							<input name="properties[<?php echo $t['slug']; ?>-border-color]" type="color" value="<?php echo esc_attr($this->options[$t['slug'].'-border-color'] ); ?>" class="pz-lkc-sync-text" />
							<input name="properties[<?php echo $t['slug']; ?>-border-color]" type="text"  value="<?php echo esc_attr($this->options[$t['slug'].'-border-color'] ); ?>" class="pz-lkc-sync-text pz-lkc-letter-color-code" />
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Background Color', $this->text_domain ); ?></th>
						<td>
							<input name="properties[<?php echo $t['slug']; ?>-bgcolor]" type="color" value="<?php echo esc_attr($this->options[$t['slug'].'-bgcolor'] ); ?>" class="pz-lkc-sync-text" />
							<input name="properties[<?php echo $t['slug']; ?>-bgcolor]" type="text"  value="<?php echo esc_attr($this->options[$t['slug'].'-bgcolor'] ); ?>" class="pz-lkc-sync-text pz-lkc-letter-color-code" />
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Background Image', $this->text_domain ); ?></th>
						<td><input name="properties[<?php echo $t['slug']; ?>-image]" type="text" size="80" value="<?php echo	esc_attr($this->options[$t['slug'].'-image'] ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Thumbnail', $this->text_domain ); ?></th>
						<td>
							<?php if ($t['slug'] == 'th' ) { ?>
							<select disabled="disabled">
								<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
							</select>
							<?php } else { ?>
							<select name="properties[<?php echo $t['slug']; ?>-thumbnail]" class="pz-lkc-sync-check">
								<option value=""   <?php selected($this->options[$t['slug'].'-thumbnail'] == ''   ); ?>><?php _e('None',							$this->text_domain ); ?></option>
								<option value="1"  <?php selected($this->options[$t['slug'].'-thumbnail'] == '1'  ); ?>><?php _e('Direct',							$this->text_domain ); ?></option>
								<option value="3"  <?php selected($this->options[$t['slug'].'-thumbnail'] == '3'  ); ?>><?php _e('Use WebAPI',						$this->text_domain ); ?></option>
								<option value="13" <?php selected($this->options[$t['slug'].'-thumbnail'] == '13' ); ?>><?php _e('Use WebAPI ,if can not direct',	$this->text_domain ); ?></option>
							</select>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Thumbnail Size', $this->text_domain ); ?></th>
						<td>
							<?php if ($t['slug'] == 'th' ) { ?>
							<select disabled="disabled">
								<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
							</select>
							<?php } else { ?>
							<select name="properties[<?php echo $t['slug']; ?>-thumbnail-size]">
								<option value="thumbnail" <?php selected($this->options[$t['slug'].'-thumbnail-size'] == 'thumbnail' ); ?>><?php _e('Thumbnail (150px)',	$this->text_domain ); ?></option>
								<option value="medium"	  <?php selected($this->options[$t['slug'].'-thumbnail-size'] == 'medium'    ); ?>><?php _e('Medium (300px)',		$this->text_domain ); ?></option>
								<option value="large"	  <?php selected($this->options[$t['slug'].'-thumbnail-size'] == 'large'     ); ?>><?php _e('Large (1024px)',		$this->text_domain ); ?></option>
								<option value="full"	  <?php selected($this->options[$t['slug'].'-thumbnail-size'] == 'full'      ); ?>><?php _e('Full size',			$this->text_domain ); ?></option>
							</select>
							<?php } ?>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Thubnail Alt Text', $this->text_domain ); ?></th>
						<td>
							<?php if ($t['slug'] == 'th' ) { ?>
							<input type="text" value="<?php _e('It is common with setting Internal-link', $this->text_domain ); ?>" class="regular-text" disabled="disabled" />
							<?php } else { ?>
							<input name="properties[<?php echo $t['slug']; ?>-thumbnail-alt]" type="text" value="<?php echo	esc_attr($this->options[$t['slug'].'-thumbnail-alt'] ); ?>" class="regular-text" /></td>
							<?php } ?>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Site Icon', $this->text_domain ); ?></th>
						<td>
							<?php if ($t['slug'] == 'th' ) { ?>
							<select disabled="disabled">
								<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
							</select>
							<?php } else { ?>
							<select name="properties[<?php echo $t['slug']; ?>-favicon]">
								<option value=""   <?php selected($this->options[$t['slug'].'-favicon'] == ''   ); 																													?>><?php _e('None',								$this->text_domain ); ?></option>
								<option value="1"  <?php selected($this->options[$t['slug'].'-favicon'] == '1'  ); disabled($t['slug'] == 'ex' || ($t['slug'] == 'in' && !function_exists('has_site_icon') || !has_site_icon() ) ); ?>><?php _e('Direct',							$this->text_domain ); ?></option>
								<option value="3"  <?php selected($this->options[$t['slug'].'-favicon'] == '3'  );																													?>><?php _e('Use WebAPI',						$this->text_domain ); ?></option>
								<option value="13" <?php selected($this->options[$t['slug'].'-favicon'] == '13' ); disabled($t['slug'] == 'ex' || ($t['slug'] == 'in' && !function_exists('has_site_icon') || !has_site_icon() ) ); ?>><?php _e('Use WebAPI ,if can not direct',	$this->text_domain ); ?></option>
							</select>
							<?php } ?>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Site Icon Alt Text', $this->text_domain ); ?></th>
						<td>
							<?php if ($t['slug'] == 'th' ) { ?>
							<input type="text" value="<?php _e('It is common with setting Internal-link', $this->text_domain ); ?>" class="regular-text" disabled="disabled" />
							<?php } else { ?>
							<input name="properties[<?php echo $t['slug']; ?>-favicon-alt]" type="text" value="<?php echo	esc_attr($this->options[$t['slug'].'-favicon-alt'] ); ?>" class="regular-text" /></td>
							<?php } ?>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Added Information', $this->text_domain ); ?></th>
						<td><input name="properties[<?php echo $t['slug']; ?>-info]" type="text" value="<?php echo	esc_attr($this->options[$t['slug'].'-info'] ); ?>" class="regular-text" /></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Text of More Button', $this->text_domain ); ?></th>
						<td>
							<?php if ($t['slug'] == 'th' ) { ?>
							<input type="text" value="<?php _e('It is common with setting Internal-link', $this->text_domain ); ?>" class="regular-text" disabled="disabled" />
							<?php } else { ?>
							<input name="properties[<?php echo $t['slug']; ?>-more-text]" type="text" value="<?php echo	esc_attr($this->options[$t['slug'].'-more-text'] ); ?>" class="regular-text" />
							<?php } ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Open New Window/Tab', $this->text_domain ); ?></th>
						<td>
							<?php if ($t['slug'] == 'th' ) { ?>
							<select disabled="disabled">
								<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
							</select>
							<?php } else { ?>
							<select name="properties[<?php echo $t['slug']; ?>-target]">
								<option value=""  <?php selected($this->options[$t['slug'].'-target'] == ''  ); ?>><?php _e('None',					$this->text_domain ); ?></option>
								<option value="1" <?php selected($this->options[$t['slug'].'-target'] == '1' ); ?>><?php _e('All client',			$this->text_domain ); ?></option>
								<option value="2" <?php selected($this->options[$t['slug'].'-target'] == '2' ); ?>><?php _e('Other than mobile',	$this->text_domain ); ?></option>
							</select>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Get Contents', $this->text_domain ); ?></th>
						<td>
							<?php if ($t['slug'] == 'th' ) { ?>
							<select disabled="disabled">
								<option selected="selected"><?php _e('It is common with setting Internal-link', $this->text_domain ); ?></option>
							</select>
							<?php } else { ?>
							<select name="properties[<?php echo $t['slug']; ?>-get]">
								<option value=""  <?php disabled($t['slug'] == 'ex' ); selected($t['slug'] <> 'ex' && $this->options[$t['slug'].'-get'] == ''  ); ?>><?php _e('Always extract from the latest articles', $this->text_domain ); ?></option>
								<option value="1" <?php disabled($t['slug'] == 'ex' ); selected($t['slug'] <> 'ex' && $this->options[$t['slug'].'-get'] == '1' ); ?>><?php _e('If "excerpt" is set, give priority to it', $this->text_domain ); ?></option>
								<option value="2" <?php                                selected($t['slug'] <> 'ex' && $this->options[$t['slug'].'-get'] == '2' ); ?>><?php _e('Always display the contents registered in card management', $this->text_domain ); ?></option>
							</select>
							<?php } ?>
						</td>
					</tr>
					<?php if ($t['slug'] == 'ex' ) { ?>
					<tr>
						<th scope="row"><?php _e('Set NoFollow', $this->text_domain ); ?></th>
						<td><label><input name="properties[nofollow]" type="checkbox" value="1" <?php checked($this->options['nofollow'] ); ?> /><?php _e('In the case of an external site, it puts the "nofollow".', $this->text_domain ); _e('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Set NoOpener', $this->text_domain ); ?></th>
						<td><label><input name="properties[noopener]" type="checkbox" value="1" <?php checked($this->options['noopener'] ); ?> /><?php _e('In the case of an external site, it puts the "noopener".', $this->text_domain ); ?></label></td>
					</tr>
					<?php } else { ?>
					<tr>
						<th scope="row"><?php _e('Retry Get PID', $this->text_domain ); ?></th>
						<td>
							<label>
								<?php if ($t['slug'] == 'th' ) { ?>
								<input type="checkbox" checked="checked" disabled="disabled" /><?php _e('It is common with setting Internal-link', $this->text_domain ); ?>
								<?php } else { ?>
								<input type="checkbox" name="properties[flg-get-pid]" value="1" <?php checked($this->options['flg-get-pid'] ); ?> /><?php _e('When the `Post ID` can not be acquired, it is acquired again.', $this->text_domain ); ?></label>
								<?php } ?>
							</label>
						</td>
					</tr>
					<tr><th scope="row"></th><td><label><input type="checkbox" disabled="disabled" /></label></td></tr>
					<?php } ?>
				</table>
				<?php submit_button(); ?>
			</div>
			<?php } ?>

			<div class="pz-lkc-page" id="pz-lkc-check">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Link Check Settings', $this->text_domain ).$help_open.'link-check'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Relative URL', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-relative-url]" type="checkbox" value="1" <?php checked($this->options['flg-relative-url'] ); ?> /><?php _e('For relative-specified URLs, complement the site URL.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Do Not Link at Error', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-unlink]" type="checkbox" value="1" <?php checked($this->options['flg-unlink'] ); ?> /><?php _e('When access status is "403", "404", "410", unlink.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Disable SSL Verification', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-ssl]" type="checkbox" value="1" <?php checked($this->options['flg-ssl'] ); ?> /><?php _e('Try setting if the contents of the SSL site can not be acquired.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Follow Location', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-redir]" type="checkbox" value="1" <?php checked($this->options['flg-redir'] ); ?> /><?php _e('Track when the link destination is redirected.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Set Referer', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-referer]" type="checkbox" value="1" <?php checked($this->options['flg-referer'] ); ?> /><?php _e('Notify the article URL to the link destination.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Use User-Agent', $this->text_domain ); ?></th>
						<td>
							<label><input name="properties[flg-agent]" type="checkbox" value="1" class="pz-lkc-sync-check" <?php checked($this->options['flg-agent'] ); ?> /><?php _e('Notify using Pz-LinkCard to the link destination.', $this->text_domain ); ?></label>
							<p>&emsp;&ensp;<input name="properties[user-agent]" type="text" size="80" value="<?php echo	esc_attr($this->options['user-agent'] ); ?>" /></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Broken Link Checker', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-alive]" type="checkbox" value="1" <?php checked($this->options['flg-alive'] ); ?> /><?php _e('Alive confirmation of the link destination.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Broken Link Count', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-alive-count]" type="checkbox" value="1" <?php checked($this->options['flg-alive-count'] ); ?> /><?php _e('The number of broken links is displayed next to the submenu.', $this->text_domain ); ?></label></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>
			
			<div class="pz-lkc-page" id="pz-lkc-editor">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Editor Settings', $this->text_domain ).$help_open.'editor'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Convert from Text Link', $this->text_domain ); ?></th>
						<td><label><input name="properties[auto-atag]" type="checkbox" class="pz-lkc-sync-check" value="1" <?php checked($this->options['auto-atag'] ); ?> /><?php _e('Convert lines with text link only to Linkcard.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Convert from URL', $this->text_domain ); ?></th>
						<td><label><input name="properties[auto-url]" type="checkbox" class="pz-lkc-sync-check" value="1" <?php checked($this->options['auto-url'] ); ?> /><?php _e('Convert lines with URL only to Linkcard.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('External Link Only', $this->text_domain ); ?></th>
						<td><label><input name="properties[auto-external]" type="checkbox" value="1" <?php checked($this->options['auto-external'] ); ?> /><?php _e('Convert only external links.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Do Shortcode', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-do-shortcode]" type="checkbox" value="1" <?php checked($this->options['flg-do-shortcode'] ); ?> /><?php _e('Force shortcode development.', $this->text_domain ); ?></label></td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Add Insert Button', $this->text_domain ); ?></th>
						<td>
							<label><input name="properties[flg-edit-insert]" type="checkbox" value="1" <?php checked($this->options['flg-edit-insert'] ); ?> /><?php _e('Add insert button to visual editor.', $this->text_domain ); ?></label>
							<P>&emsp;&ensp;<?php _e('Filter Priority:', $this->text_domain ); ?><input name="properties[mce-priority]" type="number" min="0" max="9999" size="80" value="<?php echo esc_attr($this->options['mce-priority'] ); ?>" /><?php _e('(Null or 0-9999)',  $this->text_domain ); ?></P>
							<P>&emsp;&ensp;<?php _e('Setting a larger value may improve when the insert button does not appear in the editor.', $this->text_domain ); ?></P>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Add Quick Tag', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-edit-qtag]" type="checkbox" value="1" <?php checked($this->options['flg-edit-qtag'] ); ?> /><?php _e('Add quick tag button to text editor.', $this->text_domain ); ?></label></td>
					</tr>

					<tr>
						<th scope="row"><?php _e('ShortCode 1', $this->text_domain ); ?></th>
						<td>[<input name="properties[code1]" type="text" class="pz-lkc-shortcode pz-lkc-shortcode-1" value="<?php echo	esc_attr($this->options['code1'] ); ?>" /> url="http://popozure.info" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]<p><?php _e('Case-sensitive', $this->text_domain ); ?></p></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Use InLineText', $this->text_domain ); ?></th>
						<td>
							[<span class="pz-lkc-shortcode-copy"><?php echo	esc_attr($this->options['code1'] ); ?></span> url="http://xxx"]
							<select name="properties[use-inline]" class="pz-lkc-shortcode-enabled">
								<option value=""	<?php selected($this->options['use-inline'] == ''  ); ?>><?php _e('No use',			$this->text_domain ); ?></option>
								<option value="1"	<?php selected($this->options['use-inline'] == '1' ); ?>><?php _e('Use to excerpt',	$this->text_domain ); ?></option>
								<option value="2"	<?php selected($this->options['use-inline'] == '2' ); ?>><?php _e('Use to title',	$this->text_domain ); ?></option>
							</select>
							[/<span class="pz-lkc-shortcode-copy"><?php echo	esc_attr($this->options['code1'] ); ?></span>]
							<p><?php _e('This setting applies only to the Shortcode1', $this->text_domain ); ?></p></td>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('ShortCode 2', $this->text_domain ); ?></th>
						<td>[<input name="properties[code2]" type="text" class="pz-lkc-shortcode" value="<?php echo	esc_attr($this->options['code2'] ); ?>" /> url="http://popozure.info" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]<p><?php _e('Case-sensitive', $this->text_domain ); ?></p></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('ShortCode 3', $this->text_domain ); ?></th>
						<td>[<input name="properties[code3]" type="text" class="pz-lkc-shortcode" value="<?php echo	esc_attr($this->options['code3'] ); ?>" /> url="http://popozure.info" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]<p><?php _e('Case-sensitive', $this->text_domain ); ?></p></td>
					</tr>
					<tr class="pz-lkc-admin-only">
						<th scope="row"><?php _e('ShortCode 4', $this->text_domain ); ?></th>
						<td>[<input name="properties[code4]" type="text" class="pz-lkc-shortcode" value="<?php echo	esc_attr($this->options['code4'] ); ?>" /> url="http://popozure.info" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]<p><?php _e('Case-sensitive', $this->text_domain ); ?></p></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Parameters', $this->text_domain ); ?></th>
						<td>
							<p><?php echo __('ex1.', $this->text_domain ).'&ensp;'.__('Specify only URL parameters.', $this->text_domain ); ?><div class="pz-lkc-shortcode-example pz-click-all-select">[<span class="pz-lkc-shortcode-copy"><?php echo esc_attr($this->options['code1'] ); ?></span> url="http://xxx"]</div></p>
							<p><?php echo __('ex2.', $this->text_domain ).'&ensp;'.__('Specify URL and title parameters.', $this->text_domain ); ?><div class="pz-lkc-shortcode-example pz-click-all-select">[<span class="pz-lkc-shortcode-copy"><?php echo esc_attr($this->options['code1'] ); ?></span> url="http://xxx" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span>]</div></p>
							<p><?php echo __('ex3.', $this->text_domain ).'&ensp;'.__('Specify URL, title and content parameters.', $this->text_domain ); ?><div class="pz-lkc-shortcode-example pz-click-all-select">[<span class="pz-lkc-shortcode-copy"><?php echo esc_attr($this->options['code1'] ); ?></span> url="http://xxx" <span class="pz-lkc-shortcode-title"><span class="pz-lkc-shortcode-parameter">title</span>="xxxxxx"</span> <span class="pz-lkc-shortcode-content"><span class="pz-lkc-shortcode-parameter">content</span>="xxxxxx"</span>]</div></p>
							<p><?php _e('For any shortcode you can change the title and excerpt with `title` parameter and `content` parameter', $this->text_domain ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>

			<div class="pz-lkc-page" id="pz-lkc-multisite">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Multi Site Information', $this->text_domain ).$help_open.'multisite'.$help_close; ?></h3>
				<div style="padding: 4px; color: #444444; background-color: #ffaaaa; text-align: center;"><?php echo __('*', $this->text_domain ).' '.__('Cannot be changed', $this->text_domain ); ?></div>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Multi Site', $this->text_domain ); ?></th>
						<td>
							<select>
								<option value="0" <?php selected(!$is_multisite ); disabled( $is_multisite ); ?>><?php _e('Disabled',			$this->text_domain ); ?></option>
								<option value="1" <?php selected( $is_multisite ); disabled(!$is_multisite ); ?>><?php _e('Enabled',			$this->text_domain ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Type', $this->text_domain ); ?></th>
						<td>
							<select <?php disabled(!$is_multisite ); ?>>
								<option value="0" <?php selected(!$is_subdomain ); disabled( $is_subdomain ); ?>><?php _e('Subdirectories',	$this->text_domain ); ?></option>
								<option value="1" <?php selected( $is_subdomain ); disabled(!$is_subdomain ); ?>><?php _e('Subdomains',		$this->text_domain ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Current Blog ID', $this->text_domain ); ?></th>
						<td>
							<input name="properties[multi-myid]" type="text" size="8" value="<?php echo	esc_attr($multi_myid ); ?>" readonly="readonly" />
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Number of Sites', $this->text_domain ); ?></th>
						<td>
							<input name="properties[multi-count]" type="text" size="8" value="<?php echo	esc_attr($multi_count ); ?>" readonly="readonly" />
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Table Name', $this->text_domain ); ?></th>
						<td><input type="text" size="40" value="<?php echo esc_html($this->db_name ); ?>" readonly="readonly" /></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Link to SubSite', $this->text_domain ); ?></th>
						<td><label><input type="checkbox" value="1" checked="checked" readonly="readonly" /><?php _e('Treat links to subsites as external links.', $this->text_domain ); ?></label></td>
					</tr>
				</table>
				<?php submit_button(); ?>

				<h2><?php echo	__('Site List', $this->text_domain ).$help_open.'multisite'.$help_close; ?></h3>
				<div style="padding: 4px; color: #444444; background-color: #ffaaaa; text-align: center;"><?php echo __('*', $this->text_domain ).' '.__('Cannot be changed', $this->text_domain ); ?></div>
				&nbsp;
				<table class="pz-lkc-multi-list widefat striped">
					<thead>
						<tr>
							<th scope="col" class="pz-lkc-multi-head-current"><?php _e('Current', $this->text_domain ); ?></th>
							<th scope="col" class="pz-lkc-multi-head-blog-id"><?php _e('Blog ID', $this->text_domain ); ?></th>
							<th scope="col" class="pz-lkc-multi-head-site-name"><?php _e('Site Name', $this->text_domain ); ?></th>
							<th scope="col" class="pz-lkc-multi-head-url"><?php _e('URL', $this->text_domain ); ?></th>
							<th scope="col" class="pz-lkc-multi-head-domain"><?php _e('Domain', $this->text_domain ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i = 1; $i <= $multi_count; $i++) { ?>
						<tr>
							<th class="pz-lkc-multi-body-current" scope="row"><input type="checkbox" value="1" readonly="readonly" <?php checked($multi[$i]['id'] == $multi_myid ); ?> /></th>
							<td class="pz-lkc-multi-body-blog-id"><input name="properties[multi-<?php echo	$i; ?>-id]"     type="hidden" value="<?php echo	$multi[$i]['id'];     ?>" /><?php echo	$multi[$i]['id'];     ?></td>
							<td class="pz-lkc-multi-body-site-name"><input name="properties[multi-<?php echo	$i; ?>-name]"   type="hidden" value="<?php echo	$multi[$i]['name'];   ?>" /><?php echo	$multi[$i]['name'];   ?></td>
							<td class="pz-lkc-multi-body-url"><input name="properties[multi-<?php echo	$i; ?>-url]"    type="hidden" value="<?php echo	$multi[$i]['url'];    ?>" /><?php echo	$multi[$i]['url'];    ?></td>
							<td class="pz-lkc-multi-body-domain"><input name="properties[multi-<?php echo	$i; ?>-domain]" type="hidden" value="<?php echo	$multi[$i]['domain']; ?>" /><?php echo	$multi[$i]['domain']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php submit_button(); ?>
			</div>

			<div class="pz-lkc-page" id="pz-lkc-advanced">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Senior Settings', $this->text_domain ).$help_open.'advanced'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Trailing Slash', $this->text_domain ); ?></th>
						<td>
							<select name="properties[trail-slash]">
								<option value=""  <?php selected($this->options['trail-slash'] == ''  ); ?>><?php _e('As it',							$this->text_domain ); ?></option>
								<option value="1" <?php selected($this->options['trail-slash'] == '1' ); ?>><?php _e('When only domain name, remove',	$this->text_domain ); ?></option>
								<option value="2" <?php selected($this->options['trail-slash'] == '2' ); ?>><?php _e('Always remove',					$this->text_domain ); ?></option>
							</select>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Class ID to be Added (for PC)', $this->text_domain ); ?></th>
						<td><input name="properties[class-pc]"			type="text" size="40" value="<?php echo	(isset($this->options['class-pc'] ) ? esc_attr($this->options['class-pc'] ) : '' ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Class ID to be Added (for Mobile)', $this->text_domain ); ?></th>
						<td><input name="properties[class-mobile]"		type="text" size="40" value="<?php echo	(isset($this->options['class-mobile'] ) ? esc_attr($this->options['class-mobile'] ) : '' ); ?>" /><br>
					</tr>

					<tr>
						<th scope="row"><?php _e('Compress', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-compress]" type="checkbox" value="1" <?php checked($this->options['flg-compress'] ); ?> /><?php _e('Compress CSS and JavaScript to improve access speed.', $this->text_domain ); ?></label></td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Google AMP determination', $this->text_domain ); ?></th>
						<td>
							<p><label><input name="properties[flg-amp-url]" type="checkbox" value="1" <?php checked($this->options['flg-amp-url'] ); ?> /><?php echo __('Simplified display if the URL ends with "/amp", "/amp/", or "/?amp=1".', $this->text_domain ).__('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?></label></p>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Hide URL Error', $this->text_domain ); ?></th>
						<td><label><input name="properties[error-mode-hide]" type="checkbox" value="1" class="pz-lkc-tab-show" <?php checked($this->options['error-mode-hide'] ); ?> /><?php echo __('Do not display an error on the admin page.', $this->text_domain ).__('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?></label></td>
					</tr>
				</table>
				<?php submit_button(); ?>

				<h2><?php echo	__('Extension Settings', $this->text_domain ).$help_open.'extension'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('File Menu', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-filemenu]" type="checkbox" value="1" <?php checked($this->options['flg-filemenu'] ); ?> /><?php _e('Display the file menu on the card management screen.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Initialize Tab', $this->text_domain ); ?></th>
						<td><label><input name="properties[flg-initialize]" type="checkbox" value="1" class="pz-lkc-tab-show" <?php checked($this->options['flg-initialize'] ); ?> /><?php _e('Display the initialize tab on the settings screen.', $this->text_domain ); ?></label></td>
					</tr>
					<tr>
						<th scope="row"><span class="pz-lkc-debug-text"><?php _e('Survey Mode', $this->text_domain ); ?></span></th>
						<td><label class="pz-lkc-debug-text"><input name="properties[debug-mode]" type="checkbox" value="1" class="pz-lkc-tab-show" <?php checked($this->options['debug-mode'] ); ?> /><?php echo __('Outputs some events and setting information to a log file.', $this->text_domain ).__('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?></label></td>
					</tr>

					<tr class="pz-lkc-debug-only">
						<th scope="row"><span class="pz-lkc-admin-text"><?php _e('Administrator Mode', $this->text_domain ); ?></span></th>
						<td><label class="pz-lkc-admin-text"><input name="properties[admin-mode]" type="checkbox" value="1" class="pz-lkc-tab-show" <?php checked($this->options['admin-mode'] ); if (!$this->options['admin-mode'] ) {echo 'readonly="readonly"'; }; if (!$this->options['admin-mode'] ) { echo 'ondblclick="this.readOnly=false;"'; } ?> /><?php echo __('Display information that is not normally needed or open special settings.', $this->text_domain ).__('<span class="pz-warning">(Deprecated)</span>', $this->text_domain ); ?></label></td>
					</tr>

					<tr class="pz-lkc-develop-only">
						<th scope="row"><span><?php _e('Develop Mode', $this->text_domain ); ?></span></th>
						<td><label class="pz-lkc-debug-text"><input name="properties[develop-mode]" type="checkbox" value="1" class="pz-lkc-tab-show" <?php checked($this->options['develop-mode'] ); ?> readonly="readonly" /><?php _e('Currently working in a development environment.', $this->text_domain ); ?></label></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>

			<div class="pz-lkc-page" id="pz-lkc-etc">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Stylesheet Settings', $this->text_domain ).$help_open.'css'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Stylesheet URL', $this->text_domain ); ?></th>
						<td>
							<p><input name="properties[css-url]"	type="url"  size="80" title="<?php echo	esc_attr($this->options['css-url'] ); ?>" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['css-url'] ); ?>" readonly="readonly" /></p>
							<p><?php _e('Schemes (http and https) are omitted.', $this->text_domain ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Stylesheet URL to Add', $this->text_domain ); ?></th>
						<td><input name="properties[css-url-add]"	type="url"  size="80" title="<?php echo	esc_attr($this->options['css-url-add'] ); ?>" value="<?php echo	esc_attr($this->options['css-url-add'] ); ?>" /><br><p><?php echo	__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$this->home_url.'/style.css '.__(')', $this->text_domain ); ?></p></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Stylesheet Text to Add', $this->text_domain ); ?></th>
						<td><input name="properties[css-add]"		type="text" size="80" title="<?php echo	esc_attr($this->options['css-add'] ); ?>" value="<?php echo	esc_attr($this->options['css-add'] ); ?>" /></td>
					</tr>
					<tr class="pz-lkc-admin-only">
						<th scope="row"><?php _e('Stylesheet Version', $this->text_domain ); ?></th>
						<td><input name="properties[css-count]"		type="text" size="10" title="<?php echo	esc_attr($this->options['css-count'] ); ?>" value="<?php echo	esc_attr($this->options['css-count'] ); ?>" readonly="readonly" <?php if ($this->options['admin-mode'] ) { echo	'ondblclick="this.readOnly=false;" '; }?>/></td>
					</tr>
					<tr class="pz-lkc-admin-only">
						<th scope="row"><?php _e('Stylesheet File', $this->text_domain ); ?></th>
						<td><input name="properties[css-path]"		type="text" size="80" title="<?php echo	esc_attr($this->options['css-path'] ); ?>" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['css-path'] ); ?>" readonly="readonly" /></td>
					</tr>
					<tr class="pz-lkc-admin-only">
						<th scope="row"><?php _e('Stylesheet Templete File', $this->text_domain ); ?></th>
						<td><input name="properties[css-templete]"	type="text" size="80" title="<?php echo	esc_attr($this->options['css-templete'] ); ?>" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['css-templete'] ); ?>" readonly="readonly" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>

				<h2><?php echo	__('Image Settings', $this->text_domain ).$help_open.'image'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Image Cache URL', $this->text_domain ); ?></th>
						<td>
							<p><input name="properties[thumbnail-url]" type="url" title="<?php echo	$this->options['thumbnail-url']; ?>" class="pz-click-all-select" value="<?php echo	$this->options['thumbnail-url']; ?>" size="80" readonly="readonly" /></p>
							<p><?php _e('Schemes (http and https) are omitted.', $this->text_domain ); ?></p>
							<p><?php $size = pz_GetDirSize($this->options['thumbnail-dir'] ); echo	__('Used', $this->text_domain ).__(': ', $this->text_domain ).pz_GetSizeStringSi($size).' ('.pz_GetStringBytes($size).')'; ?></p>
						</td>
					</tr>
					<tr class="pz-lkc-admin-only">
						<th scope="row"><?php _e('Image Cache Directory', $this->text_domain ); ?></th>
						<td>
							<p><input name="properties[thumbnail-dir]" type="text" title="<?php echo	$this->options['thumbnail-dir']; ?>" class="pz-click-all-select" value="<?php echo	$this->options['thumbnail-dir']; ?>" size="80" readonly="readonly" /></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>

				<h2 class="pz-lkc-debug-only"><?php echo	__('Survey Settings', $this->text_domain ); ?></h3>
				<table class="form-table pz-debug-only">
					<tr class="pz-lkc-debug-only">
						<th scope="row"><?php _e('Log URL', $this->text_domain ); ?></th>
						<td>
							<p><input name="properties[debug-url]" type="url" title="<?php echo	$this->options['debug-url']; ?>" class="pz-click-all-select" value="<?php echo	$this->options['debug-url']; ?>" size="80" readonly="readonly" /></p>
							<p><?php $size = pz_GetDirSize($this->options['debug-dir'] ); echo	__('Used', $this->text_domain ).__(': ', $this->text_domain ).pz_GetSizeStringSi($size).' ('.pz_GetStringBytes($size).')'; ?></p>
						</td>
					</tr>
					<tr class="pz-lkc-admin-only">
						<th scope="row"><?php _e('Log Directory', $this->text_domain ); ?></th>
						<td>
							<p><input name="properties[debug-dir]" type="text" title="<?php echo	$this->options['debug-dir']; ?>" class="pz-click-all-select" value="<?php echo	$this->options['debug-dir']; ?>" size="80" readonly="readonly" /></p>
						</td>
					</tr>
				</table>

				<h2><?php echo	__('Web-API Settings', $this->text_domain ).$help_open.'web-api'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Site Icon API', $this->text_domain ); ?></th>
						<td>
							<input name="properties[favicon-api]" type="url" size="80" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['favicon-api'] ); ?>" />
							<p><?php echo	__('%DOMAIN% replace to domain name.', $this->text_domain ).' '.__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$pz_domain.' '.__(')', $this->text_domain ).'<br>'.__('%DOMAIN_URL% replace to domain URL.').' '.__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$pz_domain_url.' '.__(')', $this->text_domain ).'<br>'.__('%URL% replace to URL.', $this->text_domain ).' '.__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$pz_url.$this->options['plugin-path'].' '.__(')', $this->text_domain ); ?>
							<p><?php _e('ex1.', $this->text_domain ); ?><input name="" type="text" size="70" class="pz-click-all-select" value="https://www.google.com/s2/favicons?domain=%DOMAIN%" readonly="readonly" /></p>
							<p><?php _e('ex2.', $this->text_domain ); ?><input name="" type="text" size="70" class="pz-click-all-select" value="https://favicon.hatena.ne.jp/?url=%URL%" readonly="readonly" /></p>
						</td>
					</tr>
					<tr>
						<th scope="row" rowspan="3"><?php _e('Thumbnail API', $this->text_domain ); ?></th>
						<td>
							<input name="properties[thumbnail-api]" type="url" size="80" class="pz-click-all-select" value="<?php echo	esc_attr($this->options['thumbnail-api'] ); ?>" />
							<p><?php echo	__('%URL% replace to URL.', $this->text_domain ).' '.__('(', $this->text_domain ).__('ex.', $this->text_domain ).' '.$pz_url.$this->options['plugin-path'].' '.__(')', $this->text_domain ); ?></p>
							<p><?php _e('ex1.', $this->text_domain ); ?><input name="" type="text" size="70" class="pz-click-all-select" value="https://s.wordpress.com/mshots/v1/%URL%?w=200" readonly="readonly" /></p>
							<p><?php _e('ex2.', $this->text_domain ); ?><input name="" type="text" size="70" class="pz-click-all-select" value="https://capture.heartrails.com/200x200?%URL%" readonly="readonly" /></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>

			<div class="pz-lkc-page" id="pz-lkc-initialize">
				<div class="pz-lkc-submit">
					<?php submit_button(); ?>
				</div>
				
				<h2><?php echo	__('Initialize', $this->text_domain ).$help_open.'initialize'.$help_close; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Initialize Settings', $this->text_domain ); ?></th>
						<td>
							<button type="submit" name="action" class="pz-lkc-button-sure" value="init-settings" onclick="return confirm('<?php _e('Are you sure?', $this->text_domain ); ?>');"><?php _e('Run', $this->text_domain ); ?></button>
							&ensp;<span><?php _e('Reset the "Settings" to the initial value.', $this->text_domain ); ?></span>
						</td>
					</tr>
					<tr class="pz-lkc-admin-only">
						<th scope="row"><?php _e('Initialization Exception', $this->text_domain ); ?></th>
						<td><label><input name="properties[initialize-exception]" type="checkbox" value="1" <?php checked($this->options['initialize-exception'] ); ?> /><?php echo	__('Do not initialize "Survey Mode" and "Administrator Mode".', $this->text_domain ); ?></label></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</div>

		</form>
	</div>
	<div class="pz-button-top" title="<?php _e('Scroll to the top', $this->text_domain ); ?>"><?php _e('^<br>Top', $this->text_domain ); ?></div>
</div>
<div id="pz-lkc-overlay-proc"></div>

<?php
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
			if	($file != '..' && $file != '.' ) {
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
