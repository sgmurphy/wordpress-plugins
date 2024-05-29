<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	// 出力を抑制
	$this->suppression		=	true;

	// WP-CRONの割り込みを停止
	if	(wp_next_scheduled($this->defaults['cron-check'] ) ) {
		wp_clear_scheduled_hook($this->defaults['cron-check'] );
	}
	if	(wp_next_scheduled($this->defaults['cron-alive'] ) ) {
		wp_clear_scheduled_hook($this->defaults['cron-alive'] );
	}

	// オプション取得
	$result			=	$this->pz_GetOption();

	// 開発環境用ログ
	if	($this->options['develop-mode'] ) {
		$result		=	$this->pz_OutputLOG('[Init] Start Plugin Activate Process' );
		$result		=	$this->pz_OutputLOG(print_r($this->options, true ) );
	}

	// 暫定措置
	if	(version_compare($this->options['plugin-version'], '2.1.1', '<' ) ) {
		$this->options['flg-edit-insert']		=	true;			// ビジュアル エディタに挿入ボタンを追加
		$this->options['flg-edit-qtag']			=	true;			// テキスト エディタにクイックタグを追加
	}
	if	(version_compare($this->options['plugin-version'], '2.1.7', '<' ) ) {
		$this->options['flg-anker']				=	true;			// 全体リンク（Anchorのスペルミス）
	}
	if	(version_compare($this->options['plugin-version'], '2.1.8', '<' ) ) {
		if	($this->options['sns-tw'] && $this->options['sns-fb'] && $this->options['sns-hb'] ) {
			$this->options['sns-po']			=	true;			// SNSカウントにPocketを追加したため
		}
	}
	if	(version_compare($this->options['plugin-version'], '2.2.7', '<' ) ) {
		$this->options['trim-url']				=	400;
		$this->options['nowrap-url']			=	true;
	}
	if	(version_compare($this->options['plugin-version'], '2.4.2', '<' ) ) {
		$this->options['flg-do-shortcode']		=	true;			// 設定漏れによる不具合が多発しているため、初期設定値を変更
	}
	if	(version_compare($this->options['plugin-version'], '2.4.2.4', '<' ) ) {
		$this->options['plugin-path']			=	$this->defaults['plugin-path'];
		$this->options['author-url']			=	$this->defaults['author-url'];
		$this->options['author-name']			=	$this->defaults['author-name'];
		$this->options['noopener']				=	$this->defaults['noopener'];
	}
	if	(version_compare($this->options['plugin-version'], '2.4.3', '<' ) ) {
		$this->options['plugin-abbreviation']	=	$this->defaults['plugin-abbreviation'];	// 略称
		$this->options['flg-compress']			=	$this->defaults['flg-compress'];		// CSS圧縮
		$this->options['in-thumbnail-size']		=	$this->defaults['in-thumbnail-size'];	// 内部サムネイルサイズ
		$this->options['ex-thumbnail-size']		=	$this->defaults['ex-thumbnail-size'];	// 外部サムネイルサイズ
		if	(isset($this->options['cache-image-size'] ) ) {
			$temp				=	$this->options['cache-image-size'];
			if			($temp	<=	240 ) {
				$size			=	'thumbnail';
			} elseif	($temp	<=	520 ) {
				$size			=	'medium';
			} elseif	($temp	<=	1240 ) {
				$size			=	'large';
			} else {
				$size			=	'full';
			}
			$this->options['ex-thumbnail-size']	=	$size;
		}
	}

	// 項目名称変更
	$rename_key	=	array(
		'old_key_name'		=>	'new_key_name',
		'opacity'			=>	'hover',				// パラメータ名変更のため
		'border-color'		=>	'ex-border-color',		// パラメータ細分化のため
		'border-color'		=>	'in-border-color',		// パラメータ細分化のため
		'border-color'		=>	'th-border-color',		// パラメータ細分化のため
		'flg-invalid'		=>	'error-mode',			// Ver.2.4.4 パラメータ名変更のため：エラー状態
		'invalid-url'		=>	'error-url',			// Ver.2.4.4 パラメータ名変更のため：エラーURL
		'invalid-time'		=>	'error-time',			// Ver.2.4.4 パラメータ名変更のため：エラー発生日時
	);
	foreach ($rename_key as $old => $new ) {
		if	(isset($this->options[$old] ) && !isset($this->options[$new] ) ) {
			$this->options[$new]	=	$this->options[$old];
		}
	}
	foreach ($rename_key as $old => $new ) {
		if	(isset($this->options[$old] ) ) {
			unset($this->options[$old] );
		}
	}

	// DBテーブル作成＆メンテナンス
	require_once ('pz-linkcard-init-db.php');

	// テンプレート側でMCEプラグイン一覧を上書きする場合があるため、実行優先度を下げる
	if	(empty($this->options['mce-priority'] ) && (get_template() == 'jin' ) ) {
		$this->options['mce-priority']	=	11;
	}

	// オプションの更新
	$overwrite					=	array('plugin-name', 'plugin-abbreviation', 'plugin-version', 'plugin-path', 'author-url', 'author-name', 'author-twitter' );
	foreach ($overwrite as $key ) {
		$this->options[$key]	=	$this->defaults[$key];
	}
	$result						=	$this->pz_UpdateOption();

	// スタイルシート生成
	$this->pz_SetStyle();
