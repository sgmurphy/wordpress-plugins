<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// パラメータ準備
	$slug				=	basename(dirname(__FILE__ ) );
	$wp_upload_dir		=	wp_upload_dir();
	$upload_dir_path	=	$wp_upload_dir['basedir'].'/'.$slug;

	// 設定の削除
	delete_option('Pz_LinkCard_options' );

	// DBの削除
	global			$wpdb;
	$db_name	=	$wpdb->prefix.'pz_linkcard';
	$sql		=	"DROP TABLE ".$db_name;
	$wpdb->query($sql );

	// ディレクトリの削除（画像キャッシュ、スタイルシート）
	$result		=	remove_directory($upload_dir_path );

	// ディレクトリの削除
	function remove_directory($dir ) {
		if	(mb_substr($dir, -1, 1) <> '/' ) {
			$dir	=	$dir.'/';
		}
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file ) {
			if (is_dir($dir.$file ) ) {
				remove_directory($dir.$file);
			} else {
				unlink($dir.$file );
			}
		}
		return rmdir($dir );
	}
