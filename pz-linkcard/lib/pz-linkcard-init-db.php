<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// DB作成
	global	$wpdb;
	$wpdb->hide_errors();

	// CREATE TABLE
	$sql = "CREATE TABLE $this->db_name (
				id				BIGINT			UNSIGNED	NOT NULL	AUTO_INCREMENT,
				url				VARCHAR(4096)							DEFAULT NULL,
				url_key			VARBINARY(255)				NOT NULL,
				url_redir		VARCHAR(4096)							DEFAULT NULL,
				scheme			VARCHAR(16)								DEFAULT NULL,
				domain			VARCHAR(253)							DEFAULT NULL,
				site_name		VARCHAR(100)							DEFAULT NULL,
				title			VARCHAR(200)							DEFAULT NULL,
				excerpt			VARCHAR(500)							DEFAULT NULL,
				charset			VARCHAR(32)								DEFAULT NULL,
				thumbnail		VARCHAR(2048)							DEFAULT NULL,
				favicon			VARCHAR(2048)							DEFAULT NULL,
				post_date		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
				post_modified	BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
				no_failure		INT				UNSIGNED				DEFAULT 0,
				alive_result	INT										DEFAULT -1,
				alive_time		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
				alive_nexttime	BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
				sns_twitter		INT										DEFAULT -1,
				sns_facebook	INT										DEFAULT -1,
				sns_hatena		INT										DEFAULT -1,
				sns_pocket		INT										DEFAULT -1,
				sns_time		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
				sns_nexttime	BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
				use_post_id1	INT				UNSIGNED,
				use_post_id2	INT				UNSIGNED,
				use_post_id3	INT				UNSIGNED,
				use_post_id4	INT				UNSIGNED,
				use_post_id5	INT				UNSIGNED,
				use_post_id6	INT				UNSIGNED,
				regist_title	VARCHAR(200)							DEFAULT NULL,
				regist_excerpt	VARCHAR(500)							DEFAULT NULL,
				regist_charset	VARCHAR(32)								DEFAULT NULL,
				regist_result 	INT										DEFAULT 0,
				regist_time		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
				mod_title		INT				UNSIGNED	NOT NULL	DEFAULT 0,
				mod_excerpt		INT				UNSIGNED	NOT NULL	DEFAULT 0,
				update_result	INT										DEFAULT 0,
				update_time		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
				PRIMARY KEY		(id),
				UNIQUE KEY		(url_key)
			) ".$wpdb->get_charset_collate()." ;";

	$db_version		=	md5($sql, false );
	if	($this->options['db-version']	<>	$db_version	) {
		$this->options['db-version']	=	$db_version;

		require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
		dbDelta($sql, true );
		// フィールドを追加したらエクスポート項目も見直す

////////////////////////////////////////////////////////////////////////////////

		// バグデータのメンテナンス（重複URLの削除）
		$result_datas	=	(array) $wpdb->get_results("SELECT url,id FROM $this->db_name ORDER BY url,id" );
		$last_url		=	null;
		$last_id		=	null;
		if	(isset($result_datas ) && is_array($result_datas ) && count($result_datas ) > 0 ) {
			foreach($result_datas as $data ) {
				if ($data->url == $last_url && $data->id <> $last_id ) {
					$result		=	$wpdb->delete($this->db_name, array('id' => $data->id ), array('%d' ) );
				}
				$last_url		=	$data->url;
				$last_id		=	$data->id;
			}
		}

		// バグデータのメンテナンス（ハッシュURLの再生成）
		$result_datas	=	(array) $wpdb->get_results("SELECT id,url,url_key FROM $this->db_name ORDER BY id" );
		if	(isset($result_datas ) && is_array($result_datas ) && count($result_datas ) > 0 ) {
			foreach($result_datas as $data ) {
				$new_url_key	=	hash('sha256', esc_url($data->url ), true );
				if ($data->url_key <> $new_url_key ) {
					$result		=	$wpdb->update($this->db_name, array('url_key' => $new_url_key ) , array('id' => $data->id ) );
				}
			}
		}

		// バグデータのメンテナンス（ドメイン名が空欄のもの）
		$result_datas	=	(array) $wpdb->get_results("SELECT id,url,url_key,domain FROM $this->db_name WHERE domain = '' ORDER BY id" );
		if	(isset($result_datas ) && is_array($result_datas ) && count($result_datas ) > 0 ) {
			foreach($result_datas as $data ) {
				$domain		=	'(Unknown)';
				$result		=	$wpdb->update($this->db_name, array('domain' => $domain ) , array('id' => $data->id ) );
			}
		}

		// 文字コードの表記ぶれを修正
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET charset = 'UTF-8'      WHERE charset like 'UTF-8%'" );
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET charset = 'EUC-JP'     WHERE charset like 'EUC-JP%'" );
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET charset = 'ISO-8859-1' WHERE charset like 'ISO-8859-1%'" );
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET charset = 'JIS'        WHERE charset like 'JIS%'" );
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET charset = 'Shift_JIS'  WHERE charset like 'SJIS%'" );
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET charset = 'Shift_JIS'  WHERE charset like 'Shift_JIS%'" );
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET charset = 'US-ASCII'   WHERE charset like 'US-ASCII%'" );
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET charset = 'Unknown'    WHERE charset IS NULL" );
	}
