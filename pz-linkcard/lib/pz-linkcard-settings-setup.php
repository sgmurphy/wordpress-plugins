<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// 開発環境のチェック
	$develop_url	=	self::AUTHOR_DEBUG_URL;
	if	(isset($this->home_url ) && (mb_substr($this->home_url.'/', 0, mb_strlen($develop_url ) ) == $develop_url ) ) {
		$this->options['develop-mode']	=	1;
	} else {
		$this->options['develop-mode']	=	0;
	}

	// ログのディレクトリの用意
	$dir			=	$this->upload_dir_path.'debug/';
	$dir_url		=	$this->upload_dir_url .'debug/';
	if	(!is_dir($dir ) ) {
		if	(!wp_mkdir_p($dir ) ) {
			$dir	=	null;
			$url	=	null;
		}
	}
	if	($dir ) {
		$dir_url						=	preg_replace('/.*(\/\/.*)/', '$1', $dir_url );	// スキームを外す
		$this->options['debug-dir']		=	$dir;
		$this->options['debug-url']		=	$dir_url;
	}

	// スタイルシートのパスを用意
	$dir			=	$this->upload_dir_path;
	$dir_url		=	$this->upload_dir_url ;
	if	(!is_dir($dir ) ) {
		if	(!wp_mkdir_p($dir ) ) {
			$dir	=	null;
			$url	=	null;
		}
	}
	if	($dir ) {
		$dir_url						=	preg_replace('/.*(\/\/.*)/', '$1', $dir_url );	// スキームを外す
		$this->options['css-path']		=	$dir    .'style.css';
		$this->options['css-url']		=	$dir_url.'style.css';
	}
	$this->options['css-templete']	=	$this->plugin_dir_path.'templete/pz-linkcard-templete.css';		// 元となるテンプレート

	// サムネイルのキャッシュディレクトリの用意
	$dir			=	$this->upload_dir_path.'cache/';
	$dir_url		=	$this->upload_dir_url .'cache/';
	if	(!is_dir($dir ) ) {
		if	(!wp_mkdir_p($dir ) ) {
			$dir	=	null;
			$url	=	null;
		}
	}
	if	($dir ) {
		$dir_url						=	preg_replace('/.*(\/\/.*)/', '$1', $dir_url );	// スキームを外す
		$this->options['thumbnail-dir']	=	$dir;
		$this->options['thumbnail-url']	=	$dir_url;
	}

	// ユーザーエージェントの設定
	$crawler	=	'Pz-LinkCard-Crawler/';
	if	(!$this->options['user-agent'] || mb_substr($this->options['user-agent'], 0, mb_strlen($crawler ) ) == $crawler ) {
		$this->options['user-agent']	=	$crawler.PLUGIN_VERSION;
	}

	// 管理者モード解除
	if ($this->options['admin-mode'] && !$this->options['debug-mode'] ) {
		$this->options['admin-mode']	=	0;
	}
