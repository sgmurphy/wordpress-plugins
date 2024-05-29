<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// WP-CRONスケジュール（存在チェック）
	if (!$this->options['flg-alive'] ) {
		wp_clear_scheduled_hook('pz_linkcard_alive' );
		return	null;
	}

	// DBの宣言
	global	$wpdb;

	// 次回生存確認日時を越えているものを抽出
	$proc_datas	=	$wpdb->get_results($wpdb->prepare("SELECT url,alive_time FROM $this->db_name WHERE alive_nexttime < %d ORDER BY alive_time ASC, id ASC", $this->now ) );

	// 実行ログ
	$message	=	'There were '.count($proc_datas ).' links that passed the next "Link Alive Check" confirmation date and time.';
	$log		=	$message.PHP_EOL;
	$this->pz_OutputLog($message );

	// 生存確認
	$proc_count	=	0;
	if (isset($proc_datas ) && is_array($proc_datas ) && count($proc_datas) > 0) {
		foreach($proc_datas as $data ) {
			$proc_count++;

			// 5件を超えたら、1時間後に続きを処理する
			if ($proc_count > 5) {
				wp_schedule_single_event(time() + 3600, 'pz_linkcard_alive');
				break;
			}

			// リンク先を取得
			if (isset($data ) && isset($data->url ) ) {
				$before	=	$this->pz_GetCache( array( 'url' => $data->url ) );
				$after	=	$this->pz_GetCURL( $before );
				if	($before['title']   == $after['title'] ) {
					$before['mod_title']	=	false;
				} else {
					$before['mod_title']	=	true;
				}
				if	($before['excerpt'] == $after['excerpt'] ) {
					$before['mod_excerpt']	=	false;
				} else {
					$before['mod_excerpt']	=	true;
				}
				$before['alive_result']		=	$after['alive_result'];
				$before['alive_time']		=	$this->now;
				$before['alive_nexttime']	=	$this->now + WEEK_IN_SECONDS * 4 + rand(0, DAY_IN_SECONDS);		// 次回チェックは1か月後
				if	(!$before['thumbnail'] ) {
					$before['thumbnail']	=	$after['thumbnail'];
				}
				if	(!$before['favicon'] ) {
					$before['favicon']		=	$after['favicon'];
				}
				$result		=	$this->pz_SetCache($before );

				// 実行ログ
				$message	=	'['.$proc_count.'] '.'Confirmed the "Link Alive Check". (NextTime='.date('Y-m-d H:i:s', $result['alive_nexttime'] ).' Result='.$result['alive_result'].' URL='.$result['url'].')';
				$log		.=	$message.PHP_EOL;
				$this->pz_OutputLog($message );
			}
		}
	}
