<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// DBの宣言
	global	$wpdb;

	// DBの列名取得
	$col_name	=	$wpdb->get_col("DESC $this->db_name" );
	if	(!$col_name || $wpdb->last_error ) {
		echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('DB Access Error.', $this->text_domain ).__('(', $this->text_domain ).$wpdb->last_error.__(')', $this->text_domain ).'</strong></p></div>';
		return	null;
	}

	// アップロードされたファイル名を取得
	$import_path	=	isset($_FILES['import_file']['name'] )		? $_FILES['import_file']['name'].'_'.date("YmdHis" ) : null;
	$temp_path		=	isset($_FILES['import_file']['tmp_name'] )	? $_FILES['import_file']['tmp_name'] : null;

	// キャッシュDBクリア
	$clear			=	isset($_POST['import_clear'] ) ? $_POST['import_clear'] : false;

	// カウンター
	$read_count		=	0;
	$skip_count		=	0;
	$success_count	=	0;

	// アップロードされたファイルの存在チェック
	if	(!is_uploaded_file($temp_path ) ) {
		echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Import File Not Found.', $this->text_domain ).'</strong></p></div>';
		return	null;
	}

	// ファイルを開く（読み込み）
	$handle			=	fopen($temp_path, 'r');
	if	(!$handle ) {
		echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Import File Open Error.', $this->text_domain ).'</strong></p></div>';
		return	null;
	}

	// ヘッダー行入力
	if	(($csv_header = fgetcsv($handle ) ) == false ) {
		echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Import File Read Error.', $this->text_domain ).'</strong></p></div>';
		return	null;
	}

	// 項目数
	$item_count	=	count($csv_header );

	// DBの削除
	if	($clear ) {
		// DBクリア
		$result	=	$wpdb->query("DELETE FROM $this->db_name" );
		if	($wpdb->last_error ) {
			echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('DB Access Error.', $this->text_domain ).__('(', $this->text_domain ).$wpdb->last_error.__(')', $this->text_domain ).'</strong></p></div>';
			return	null;
		}

		// AUTO INCLIMENTのリセット
		$result	=	$wpdb->query("ALTER TABLE $this->db_name AUTO_INCREMENT=1;" );
		if	($wpdb->last_error ) {
			echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('DB Access Error.', $this->text_domain ).__('(', $this->text_domain ).$wpdb->last_error.__(')', $this->text_domain ).'</strong></p></div>';
			return	null;
		}
	}

	$csv_header_nouse	=	array();
	foreach ($csv_header as $key => $value ) {
		if (!in_array($value, $col_name ) ) {
			$csv_header_nouse[$key]	=	$value;
			unset($csv_header[$key] );
		}
	}

	// データ行入力
	while	(($record = fgetcsv($handle ) ) !== false ) {
		$read_count++;
		if (count($record ) == $item_count) {
			unset($import );
			foreach ($csv_header as $key => $value ) {
				$import[$value]	=	$record[$key];
			}

			// DB更新
			unset($import['id'] );
			unset($import['url_key'] );
			$result			=	$this->pz_SetCache($import );
			if	(!isset($result['url'] ) || $result['url'] <> $import['url'] ) {
				$skip_count++;
			} else {
				$success_count++;
			}
		} else {
			$skip_count++;
		}
	}
	// ファイルを閉じる
	fclose($handle );

	if	($success_count ) {
		echo	'<div class="notice notice-success is-dismissible"><p><strong>'.__('Import Successful.', $this->text_domain ).__('(', $this->text_domain ).__('Read:', $this->text_domain ).$read_count.' '.__('Success:', $this->text_domain ).$success_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
	} else {
		echo	'<div class="notice notice-error is-dismissible"><p><strong>'.__('Import Failure.', $this->text_domain ).__('(', $this->text_domain ).__('Read:', $this->text_domain ).$read_count.' '.__('Skip:', $this->text_domain ).$skip_count.__(')', $this->text_domain ).'</strong></p></div>';
	}
