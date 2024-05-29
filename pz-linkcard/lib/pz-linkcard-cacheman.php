<?php defined('ABSPATH' ) || wp_die; ?>
<?php /* 開発者モード */ if ($this->options['develop-mode'] ) { echo '<style>#wpadminbar { background-color: #0a8 !important; }</style><div class="pz-lkc-develop-message">'.__('Currently working in a development environment.', $this->text_domain ).'</div>'; } ?>
<div class="pz-lkc-dashboard pz-lkc-cacheman wrap">
	<div class="pz-header">
		<a class="pz-header-switch" href="<?php echo esc_url($this->settings_url ); ?>">
			<span class="pz-header-switch-icon"><?php _e('&#x2699;&#xfe0f;', $this->text_domain ); ?></span>
			<span class="pz-header-switch-label"><?php _e('Settings', $this->text_domain ); ?></span>
		</a>
		<h1 class="pz-header-title">
			<span class="pz-header-title-icon"><?php echo __('&#x1f5c3;&#xfe0f;', $this->text_domain ); ?></span>
			<span class="pz-header-title-text"><?php _e('LinkCard Cache Manager', $this->text_domain ); ?></span>
			<a class="pz-header-title-text" href="<?php echo $this->author['website']; ?>/pz-linkcard-manager" rel="external noopener help" target="_blank">
				<img src="<?php echo $this->plugin_dir_url.'img/help.png'; ?>" width="16" height="16" title="<?php _e('Help', $this->text_domain ); ?>" alt="help">
			</a>
		</h1>
	</div>

	<form method="post">
<?php
	global	$wpdb;

	// nonce
	wp_nonce_field('pz-lkc-cacheman' );

	$page			=	'pz-linkcard-cache';	// ツール画面のページ
	$action			=	isset($_REQUEST['action'] )			?	esc_attr($_REQUEST['action'] )					:	null ;
	$select_id		=	isset($_REQUEST['select_id'] )		?	$_REQUEST['select_id']							:	null ;
	$bulk_action	=	isset($_REQUEST['bulk_action'] )	?	stripslashes($_REQUEST['bulk_action'] )			:	null ;
	$data			=	isset($_REQUEST['data'] ) && is_array($_REQUEST['data'] ) ? $_REQUEST['data']			:	null ;
	$param_refine	=	isset($_REQUEST['refine'] )			?	esc_attr($_REQUEST['refine'] )					:	null ;
	$keyword		=	isset($_REQUEST['keyword'] )		?	stripslashes($_REQUEST['keyword'] )				:	null ;
	$filter			=	isset($_REQUEST['filter'] )			?	esc_attr($_REQUEST['filter'] )					:	'all' ;
	$orderby		=	isset($_REQUEST['orderby'] )		?	esc_attr(strtolower($_REQUEST['orderby'] ) )	:	null ;
	$order			=	isset($_REQUEST['order'] )			?	esc_attr(strtolower($_REQUEST['order'] ) )		:	null ;
	$page_now		=	(isset($_REQUEST['page_button'] )	?	intval($_REQUEST['page_button'] )				:	
						(isset($_REQUEST['page_trans'] )	?	intval($_REQUEST['page_trans'] )				:	
						(isset($_REQUEST['page_now'] )		?	intval($_REQUEST['page_now'] )					:	0 ) ) );
	$param_url		=	isset($_REQUEST['url'] )			?	esc_attr($_REQUEST['url'] )						:	null;
	$cache_id		=	isset($_REQUEST['cache_id'] )		?	esc_attr($_REQUEST['cache_id'] )				:	null;
	$confirm		=	isset($_REQUEST['confirm'] )		?	esc_attr($_REQUEST['confirm'] )					:	null;
	$update_result	=	isset($_REQUEST['update_result'] )	?	esc_attr($_REQUEST['update_result'] )			:	null;
	$alive_result	=	isset($_REQUEST['alive_result'] )	?	esc_attr($_REQUEST['alive_result'] )			:	null;

	// インラインメニュー（編集・再取得・削除）
	if		 (isset($_REQUEST['single-edit'] ) ) {
		$action		=	'edit';
		$select_id	=	array( intval($_REQUEST['single-edit'] ) );
	} elseif (isset($_REQUEST['single-renew'] ) ) {
		$action		=	'renew';
		$select_id	=	array(intval($_REQUEST['single-renew'] ) );
	} elseif (isset($_REQUEST['single-delete'] ) ) {
		$action		=	'delete';
		$select_id	=	array(intval($_REQUEST['single-delete'] ) );
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
	if	($bulk_action ) {
		switch	($bulk_action ) {
		case	'renew':
		case	'renew_thumbnail':
		case	'renew_sns':
		case	'renew_postid':
		case	'alive':
		case	'delete':
			$action		=	$bulk_action;
		}
	}

	// POSTする値 INPUT要素
	$temp_param		=
		array(
			'page'				=>		$page,
			'page_now'			=>		intval($page_now ),
			'refine'			=>		$param_refine,
			'orderby'			=>		$orderby,
			'order'				=>		$order,
			'filter'			=>		$filter,
			'pz-lkc-debug'		=>		$this->options['debug-mode'],
			'pz-lkc-admin'		=>		$this->options['admin-mode'],
			'pz-lkc-develop'	=>		$this->options['develop-mode'],
		);
	foreach		($temp_param		as	$temp_name => $temp_value ) {
		echo	'<input type="hidden" name="'.$temp_name.'" value="'.$temp_value.'" />';
	}

	$show_list		=	true;				// リストを表示する（エディタのときは表示させなくするため）

	// アクションの指示があったとき
	if	($action ) {
		check_admin_referer('pz-lkc-cacheman' );

		switch	($action ) {
		case	'edit':						// 編集画面
			$data			=	$this->pz_GetCache(array('id' => $select_id[0] ) );
			if	(isset($data ) && is_array($data ) ) {
				require_once ('pz-linkcard-cacheman-edit.php');
			}
			$show_list		=	false;		// リストを表示しない
			break;

		case	'update':
			$success_count			=	0;
			$skip_count				=	0;
			if	(!isset($data ) || !is_array($data ) || !isset($data['id'] ) ) {
				echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
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
			echo	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Update Cache', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'cancel':					// 編集画面キャンセル
			break;

		case	'renew':					// 記事内容の再取得
			$success_count	=	0;
			$skip_count		=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
				$data		= $this->pz_GetCache(array('id' => $data_id ) );
				if	(isset($data ) && is_array($data ) ) {
					$data		=	$this->pz_GetHTML( array('url' => $data['url'], 'force' => true ) );
					$data		=	$this->pz_SetCache( $data );
					$success_count++;
				} else {
					$skip_count++;
				}
			}
			echo	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Renew Cache', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'renew_thumbnail':			// サムネイルの再取得
			$success_count	=	0;
			$skip_count		=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			$success_count	=	0;
			$skip_count		=	0;
			foreach	($select_id as $data_id ) {
				$data		=	$this->pz_GetCache(array('id' => $data_id ) );
				if	(isset($data ) && is_array($data ) ) {
					$data	=	$this->pz_GetThumbnail($data['thumbnail'] , true );
					$success_count++;
				} else {
					$skip_count++;
				}
				echo '..';
			}
			echo	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Renew Thumbnail Image', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'renew_sns':				// ソーシャルカウントの再取得
			$success_count	=	0;
			$skip_count		=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
				$data		=	$this->pz_GetCache(array('id' => $data_id ) );
				if	(isset($data ) && is_array($data ) ) {
					$data['sns_nexttime']	=	0;
					$data	=	$this->pz_SetCache($data );
					$data	=	$this->pz_RenewSNSCount($data );
					$success_count++;
				} else {
					$skip_count++;
				}
			}
			echo	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Renew SNS Count', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'renew_postid':				// 記事IDの再取得
			$success_count	=	0;
			$skip_count		=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
				$data		=	$this->pz_GetCache(array('id' => $data_id ) );
				$result		=	null;
				if	(isset($data ) && is_array($data ) ) {
					$result	=	$this->pz_SetCache($data );
				}
				if	($result ) {
					$success_count++;
				} else {
					$skip_count++;
				}
			}
			echo	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Renew Post Id', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'alive':
			$success_count	=	0;
			$skip_count		=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
				$data		=	$this->pz_GetCache(array('id' => $data_id ) );
				if	(isset($data ) && is_array($data ) ) {
					$data					=	$this->pz_GetCache($data );
					$after					=	$this->pz_GetCURL($data );
					$data['alive_result']	=	$after['update_result'];
					$data['alive_time']		=	$this->now;
					$data['alive_nexttime']	=	$this->now + WEEK_IN_SECONDS * 4;
					if	($data['title']		==	$after['title'] ) {
						$data['mod_title']	=	false;
					} else {
						$data['mod_title']	=	true;
					}
					if	($data['excerpt']		==	$after['excerpt'] ) {
						$data['mod_excerpt']	=	false;
					} else {
						$data['mod_excerpt']	=	true;
					}
					$data					=	$this->pz_SetCache($data );
					if	($data ) {
						$success_count++;
					} else {
						$skip_count++;
					}
				}
			}
			echo	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Alive check', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'delete':
			$success_count	=	0;
			$skip_count		=	0;
			if	(!isset($select_id ) || !is_array($select_id ) ) {
				echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Not selected', $this->text_domain ).'</strong></p></div>';
				break;
			}
			foreach	($select_id as $data_id ) {
 				$result	=	$this->pz_DelCache(array('id' => $data_id ) );
 				if	($result ) {
 					$success_count++;
 				} else {
 					$skip_count++;
 				}
			}
			echo	'<div class="notice '.($success_count ? 'notice-success' : 'notice-error' ).' is-dismissible"><p><strong>'.__('Delete Cache', $this->text_domain ).__('...', $this->text_domain ).__('(', $this->text_domain ).__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
			break;

		case	'menu-import':			// ファイルのインポートメニュー
			require_once ('pz-linkcard-file-import-menu.php');	
			break;

		case	'exec-import':			// インポート実行
			require_once ('pz-linkcard-file-import.php');
			break;

		case	'export-file':			// エクスポートファイル作成
			require_once ('pz-linkcard-file-export.php');
			break;

		default:
			echo	'<div class="notice notice-info is-dismissible"><p><strong>'.__('Undefined process chosen.', $this->text_domain ).'</strong></p></div>';
		}
	}

	// ドメイン一覧
	$mydomain			=	null;
	if	(preg_match('{https?://(.*)/}i', $this->home_url.'/',$m ) ) {
		$mydomain_url	=	$m[0];
		$mydomain		=	$m[1];
	}

	// キャッシュ一覧
	if	($show_list ) {
		require_once ('pz-linkcard-cacheman-list.php');
	}
?>
</div>
