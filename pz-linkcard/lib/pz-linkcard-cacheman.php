<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// DB使用
	global		$wpdb;
	
	// デバグモード・管理モード
	$debug_mode		=	isset($this->options['debug-mode'] )	?	intval($this->options['debug-mode'] )	:	0;
	$admin_mode		=	isset($this->options['admin-mode'] )	?	intval($this->options['admin-mode'] )	:	0;
	$develop_mode	=	isset($this->options['develop-mode'] )	?	intval($this->options['develop-mode'] )	:	0;

	// 引数・変数の設定
	$page			=	'pz-linkcard-cacheman';			// ツール画面のページ
	$action			=	isset($_POST['action'] )		?	esc_attr($_POST['action'] )					:	null;
	$select_id		=	isset($_POST['select_id'] )		?	esc_attr($_POST['select_id'] )				:	null;
	$bulk_action	=	isset($_POST['bulk_action'] )	?	esc_attr($_POST['bulk_action'] )			:	null;
	$data			=	isset($_POST['data'] ) && is_array($_POST['data'] )		?	$_POST['data']		:	null;
	$param_refine	=	isset($_POST['refine'] )		?	esc_attr($_POST['refine'] )					:	null;
	$keyword		=	isset($_POST['keyword'] )		?	stripslashes($_POST['keyword'] )			:	null;
	$filter			=	isset($_POST['filter'] )		?	esc_attr($_POST['filter'] )					:	'all';
	$header			=	isset($_POST['header'] )		?	esc_attr(strtolower($_POST['header'] ) )	:	null;
	$orderby		=	isset($_POST['orderby'] )		?	esc_attr(strtolower($_POST['orderby'] ) )	:	'id';
	$order			=	isset($_POST['order'] )			?	esc_attr(strtolower($_POST['order'] ) )		:	'desc';
	$page_now		=	(isset($_POST['page_button'] )	?	intval($_POST['page_button'] )				:	
						(isset($_POST['page_trans'] )	?	intval($_POST['page_trans'] )				:	
						(isset($_POST['page_now'] )		?	intval($_POST['page_now'] )					:	0 ) ) );
	$param_url		=	isset($_POST['url'] )			?	esc_attr($_POST['url'] )					:	null;
	$cache_id		=	isset($_POST['cache_id'] )		?	esc_attr($_POST['cache_id'] )				:	null;
	$confirm		=	isset($_POST['confirm'] )		?	esc_attr($_POST['confirm'] )				:	null;
	$update_result	=	isset($_POST['update_result'] )	?	esc_attr($_POST['update_result'] )			:	null;
	$alive_result	=	isset($_POST['alive_result'] )	?	esc_attr($_POST['alive_result'] )			:	null;

	// インラインメニュー
	$single_edit	=	isset($_POST['single-edit'] )	?	esc_attr($_POST['single-edit'] )			:	null;
	$single_renew	=	isset($_POST['single-renew'] )	?	esc_attr($_POST['single-renew'] )			:	null;
	$single_delete	=	isset($_POST['single-delete'] )	?	esc_attr($_POST['single-delete'] )			:	null;
	if			($single_edit ) {
		$action		=	'edit';
		$select_id	=	array(intval($single_edit ) );
	} elseif	($single_renew ) {
		$action		=	'renew';
		$select_id	=	array(intval($single_renew ) );
	} elseif	($single_delete ) {
		$action		=	'delete';
		$select_id	=	array(intval($single_delete ) );
	}

	// 表示されている項目名がクリックされたら並び順を逆にする
	if	($header ) {
		if	($orderby	===	$header ) {
			$order		=	($order	=== 'desc') ? 'asc' : 'desc' ;
		} else {
			$orderby	=	$header;
			$order		=	'desc';
		}
	}

	// インラインメニュー（編集・再取得・削除）
	if		 (isset($_POST['single-edit'] ) ) {
		$action		=	'edit';
		$select_id	=	array( intval($_POST['single-edit'] ) );
	} elseif (isset($_POST['single-renew'] ) ) {
		$action		=	'renew';
		$select_id	=	array(intval($_POST['single-renew'] ) );
	} elseif (isset($_POST['single-delete'] ) ) {
		$action		=	'delete';
		$select_id	=	array(intval($_POST['single-delete'] ) );
	}

	// 処理する連番
	if	(!is_array($select_id ) ) {
		$select_id	=	$select_id	?	array($select_id ) : null ;
	} else {
		foreach	($select_id			as	$key => $value ) {
			$select_id[$key]		=	intval($value );
		}
	}

	// バッチ処理
	if	($action === 'exec-batch' ) {
		$action			=	$bulk_action;
	}

	// 出力するHTML
	$html_develop	=	'';
	$html_style		=	'';
	$html_title		=	'';
	$html_input		=	'';
	$html_notice	=	'';

	// リスト表示の有無
	$show_list		=	true;

	// 開発者モードの表示
	if ($develop_mode ) {
		$html_develop	=	'<style>#wpadminbar { background-color: #0a8 !important; }</style><div class="pz-lkc-develop-message">'.__('Currently working in a development environment.', $this->text_domain ).'</div>';
	}

	// ページの見出し表示（設定）
	$page_class	=	' pz-lkc-cacheman';
	$switch_link	=	esc_url($this->settings_url );
	$switch_icon	=	__('&#x2699;&#xfe0f;', $this->text_domain );
	$switch_label	=	__('Settings', $this->text_domain );
	$title_icon		=	__('&#x1f5c3;&#xfe0f;', $this->text_domain );
	$title_label	=	__('Pz-LinkCard Manager', $this->text_domain );
	$help_page		=	self::AUTHOR_URL.'/pz-linkcard-manager';
	$html_title		=	'<div class="pz-lkc-plugin">'.self::PLUGIN_NAME.' ver.'.PLUGIN_VERSION.'</div><div class="pz-lkc-dashboard'.$page_class.' wrap"><div class="pz-header"><a class="pz-header-switch" href="'.$switch_link.'"><span class="pz-header-switch-icon">'.$switch_icon.'</span><span class="pz-header-switch-label">'.$switch_label.'</span></a><h1><span class="pz-header-title"><span class="pz-header-title-icon">'.$title_icon.'</span><span class="pz-header-title-text">'.$title_label.'</span><a class="pz-help-icon" href="'.$help_page.'" rel="external noopener help" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain ).'" alt="help"></a></h1></div>';

	// POSTする値 INPUT要素
	$temp_param		=
		array(
			'page'				=>		$page,
			'page_now'			=>		intval($page_now ),
			'refine'			=>		$param_refine,
			'filter'			=>		$filter,
			'header'			=>		$header,
			'orderby'			=>		$orderby,
			'order'				=>		$order,
			'debug-mode'		=>		$debug_mode,
			'admin-mode'		=>		$admin_mode,
			'develop-mode'		=>		$develop_mode,
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

	// インポートメニューを表示
	if	($action ==	'show-import' ) {
		require_once ('pz-linkcard-file-import-menu.php');
	}

	echo	'<form action="" method="post">';
	wp_nonce_field('pz-lkc-cacheman' );			// nonce

	// 記述エラー
	if	($this->options['error-mode'] ) {
		if	(!$this->options['error-mode-hide'] ) {
			$html_notice	.=	'<div class="notice notice-error is-dismissible"><p><strong>'.self::PLUGIN_NAME.': '.__('Invalid URL parameter in ', $this->text_domain ).'<a href="'.$this->options['error-url'].'#lkc-error" target="_blank">'.$this->options['error-url'].'</a></strong><br>'.__('*', $this->text_domain ).' '.__('You can cancel this message from <a href="./options-general.php?page=pz-linkcard-settings">the setting screen</a>.', $this->text_domain ).'</p></div>';
		}
	}

	// アクションの指示があったとき
	if	($action ) {
		check_admin_referer('pz-lkc-cacheman' );

		switch	($action ) {
		case	'search':					// 検索ボタン
			break;
		
		case	'select-domain':			// 絞り込み検索
			break;
		
		case	'cancel':					// 編集画面キャンセル
			break;

		case	'edit':						// 編集画面
			$data					=	$this->pz_GetCache(array('id' => $select_id[0] ) );
			if	(isset($data ) && is_array($data ) ) {
				require_once ('pz-linkcard-cacheman-edit.php');
			}
			$show_list				=	false;		// リストを表示しない
			break;

		case	'update':
			$success_count			=	0;
			$skip_count				=	0;
			if	(!isset($data ) || !is_array($data ) || !isset($data['id'] ) ) {
				$html_notice		.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($data			as	$key => $value ) {
				$data[$key]			=	stripslashes($value );
			}
			$data['mod_title']		=	($data['title']   <> $data['regist_title'] );
			$data['mod_excerpt']	=	($data['excerpt'] <> $data['regist_excerpt'] );
			$data	=	$this->pz_SetCache($data );
			if	(isset($data ) && is_array($data ) && isset($data['id'] ) ) {
				$success_count++;
			}
			$html_notice			.=	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Update Cache', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'renew':					// 記事内容の再取得
			$success_count			=	0;
			$skip_count				=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				$html_notice		.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
				$data		= $this->pz_GetCache(array('id' => $data_id ) );
				if	(isset($data ) && is_array($data ) ) {
					$data			=	$this->pz_GetHTML( array('url' => $data['url'], 'force' => true ) );
					$data			=	$this->pz_SetCache( $data );
					$success_count++;
				} else {
					$skip_count++;
				}
			}
			$html_notice			.=	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Renew Cache', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'renew_thumbnail':			// サムネイルの再取得
			$success_count			=	0;
			$skip_count				=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				$html_notice		.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			$success_count			=	0;
			$skip_count				=	0;
			foreach	($select_id as $data_id ) {
				$data				=	$this->pz_GetCache(array('id' => $data_id ) );
				if	(isset($data ) && is_array($data ) ) {
					$data			=	$this->pz_GetThumbnail($data['thumbnail'] , true );
					$success_count++;
				} else {
					$skip_count++;
				}
				$html_notice		.=	'..';
			}
			$html_notice			.=	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Renew Thumbnail Image', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'renew_sns':				// ソーシャルカウントの再取得
			$success_count			=	0;
			$skip_count				=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				$html_notice		.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
				$data				=	$this->pz_GetCache(array('id' => $data_id ) );
				if	(isset($data ) && is_array($data ) ) {
					$data['sns_nexttime']	=	0;
					$data			=	$this->pz_SetCache($data );
					$data			=	$this->pz_RenewSNSCount($data );
					$success_count++;
				} else {
					$skip_count++;
				}
			}
			$html_notice			.=	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Renew SNS Count', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'renew_postid':				// 記事IDの再取得
			$success_count			=	0;
			$skip_count				=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				$html_notice		.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
				$data				=	$this->pz_GetCache(array('id' => $data_id ) );
				$result				=	null;
				if	(isset($data ) && is_array($data ) ) {
					$result			=	$this->pz_SetCache($data );
				}
				if	($result ) {
					$success_count++;
				} else {
					$skip_count++;
				}
			}
			$html_notice			.=	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Renew Post Id', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'alive':
			$success_count			=	0;
			$skip_count				=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				$html_notice		.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
				$data				=	$this->pz_GetCache(array('id' => $data_id ) );
				if	(isset($data ) && is_array($data ) ) {
					$data						=	$this->pz_GetCache($data );
					$after						=	$this->pz_GetCURL($data );
					$data['alive_result']		=	$after['update_result'];
					$data['alive_time']			=	$this->now;
					$data['alive_nexttime']		=	$this->now + WEEK_IN_SECONDS * 4;
					if	($data['title']			==	$after['title'] ) {
						$data['mod_title']		=	false;
					} else {
						$data['mod_title']		=	true;
					}
					if	($data['excerpt']		==	$after['excerpt'] ) {
						$data['mod_excerpt']	=	false;
					} else {
						$data['mod_excerpt']	=	true;
					}
					$data						=	$this->pz_SetCache($data );
					if	($data ) {
						$success_count++;
					} else {
						$skip_count++;
					}
				}
			}
			$html_notice			.=	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Alive check', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'delete':
			$success_count			=	0;
			$skip_count				=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				$html_notice		.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
 				$result				=	$this->pz_DelCache(array('id' => $data_id ) );
 				if	($result ) {
 					$success_count++;
 				} else {
 					$skip_count++;
 				}
			}
			$html_notice			.=	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Delete Cache', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'exec-import':			// インポート実行
			require_once ('pz-linkcard-file-import.php');	
			break;

		case	'show-import':			// ファイルのインポートボタンを表示
			break;

		case	'show-export':			// ファイルのエクスポートボタンを表示
			require_once ('pz-linkcard-file-export.php');
			break;

		default:
			$html_notice			.=	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Undefined process chosen.', $this->text_domain ).'</strong></p></div>';
		}
	}

	// 画面描画
	echo	$html_notice;
	echo	$html_input;

	// キャッシュ一覧
	if	(!$show_list ) {
		echo	'<div style="display: none;">';
	}
	require_once ('pz-linkcard-cacheman-list.php');
	if	(!$show_list ) {
		echo	'</div>';
	}

	echo	'</form>';
	echo	'</div>';
	// echo	'<div id="pz-lkc-overlay-proc"></div>';
