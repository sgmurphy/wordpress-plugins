<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// 出力除外する項目（カラム名）
	$column_omit	=	array('url_key' );
	
	// テーブルの項目を確認
	global				$wpdb;
	$result			=	$wpdb->get_results("SELECT * FROM $this->db_name LIMIT 1", ARRAY_A );
	if	(!$result ) {
		return;
	}
	$column_all		=	array_keys($result[0] );
	$column_diff	=	array_diff($column_all, $column_omit );
	$column_output	=	implode(',', $column_diff );

	// 出力する項目をDBから取得
	$data_all		=	$wpdb->get_results("SELECT $column_output FROM $this->db_name ORDER BY domain , url", ARRAY_A );

	// ディレクトリ名とファイル名に付ける日時の文字列
	$datetime		=	date('Ymd_His');
	$datetime_hash	=	bin2hex(hash('sha256', $datetime, true ) );

	// ダウンロード用のディレクトリ
	$export_dir		=	$this->upload_dir_path.'export/'.$datetime_hash.'/';
	$export_dir_url	=	$this->upload_dir_url .'export/'.$datetime_hash.'/';

	// エクスポートするファイル名
	$export_file	=	'pz_linkcard_export_utf8_'.$datetime.'.csv';
	
	// エクスポートするファイルのフルパスとURL
	$export_path	=	$export_dir.$export_file;
	$export_path_url=	$export_dir_url.$export_file;

	// ディレクトリが無かったら作成
	wp_mkdir_p($export_dir );

	// エクスポートファイルを開く（書き込み）
	$handle			=	fopen($export_path, 'w');

	// CSVファイル出力
	$record_count	=	0;
	if	($handle ) {

		// ヘッダー行出力
		fputs($handle, $column_output."\n");

		// データ行出力
		foreach($data_all as &$data ) {
			foreach($data as &$item ) {
				$item	=	str_replace(array("\r", "\n", "\t" ), ' ', $item );
			}
			fputcsv($handle, $data, ',', '"' );
			$record_count++;
		}

		// ファイルを閉じる
		fclose($handle );

		// ダウンロード用ボタンを表示
		echo '<div><button type="submit" id="export_button" class="pz-lkc-man-file-button button button-primary" name="action" value="show-export" onclick="window.open('."'".$export_path_url."'".');">'.__('Download Export File', $this->text_domain ).'</button></div>';
	}
