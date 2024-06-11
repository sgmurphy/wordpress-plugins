(function($) {

	// $('#pz-lkc-overlay-proc').show();
	$('input').css('pointer-events', 'none');

	// 画面表示された時に実行
	$(window).load(function() {
		$('input').css('pointer-events', 'auto');

		// エラーモード・調査モード・管理者モード・開発者モードの切り替え
		var rs = switch_mode();

		// Pz-LinkCard画面
		if	($('.pz-lkc-dashboard').is('*') != false) {

			// 最後に開いていたタブを開く
			var rs = tab_open_last();

			// 項目の有効化／無効化
			var rs = switch_enabled();

			// イベント：キーによる操作（タブ移動）
			$(window).on('keydown', key_down);

			// 一番上に行くボタンをクリック
			$('.pz-button-top').on('click', button_top_click);

			// 一番上に行くボタンをスクロール位置で「TOP」ボタンを表示／非表示
			$(window).scroll(top_button_scroll);

			// イベント：タブが切り替わった
			$('.pz-lkc-tab').on('click', tab_open);

			// イベント：ショートコードをコピーする
			$('.pz-lkc-shortcode-1').on('keyup', copy_shortcode);

			// イベント：ショートコードの入力チェック
			$('input[name="properties[code1]"]:text').on('keydown', check_shortcode_key);
			$('input[name="properties[code2]"]:text').on('keydown', check_shortcode_key);
			$('input[name="properties[code3]"]:text').on('keydown', check_shortcode_key);
			$('input[name="properties[code4]"]:text').on('keydown', check_shortcode_key);

			// イベント：カラーピッカーとテキストボックスの同期
			$('.pz-lkc-sync-text').on('keyup change', sync_color);

			// イベント：すべてのWP-Cronスケジュールを表示する
			$('.pz-lkc-cron-all').on('change', show_all_cron);

			// submitをクリックしたら
			$('form').submit( function() {
				$('#pz-lkc-overlay-proc').show();
			});

			// クリックしたらテキスト全選択
			$('.pz-click-all-select').on('click', all_select);

			// イベント：ReadOnlyになったチェックボックスを動作させなくする
			$('input:checkbox').on('click', checkbox_readonly);

			// 自動変換のチェックが入っているときだけ、オプション設定を有効化
			$('.pz-lkc-sync-check,.pz-lkc-show').on('change', switch_enabled);

			// エラータブ
			$('input[name="properties[error-mode]"]:checkbox').on('change', switch_mode);

			// マルチサイトタブ
			$('input[name="properties[multi-mode]"]:checkbox').on('change', switch_mode);

			// 初期化タブ
			$('input[name="properties[flg-initialize]"]:checkbox').on('change', switch_mode);

			// デバグモード（調査モード）
			$('input[name="properties[debug-mode]"]:checkbox').on('change', switch_mode);

			// 管理者モード
			$('input[name="properties[admin-mode]"]:checkbox').on('change', switch_mode);

			// 開発者モード
			$('input[name="properties[develop-mode]"]:checkbox').on('change', switch_mode);

			// デバグモード（調査モード）
			$('input[name="debug-mode"]').on('change', switch_mode);

			// 管理者モード
			$('input[name="admin-mode"]').on('change', switch_mode);

			// 開発者モード
			$('input[name="develop-mode"]').on('change', switch_mode);

			// 設定画面＆管理画面
			if	($('.pz-lkc-man-count-list').is('*') != false) {
				// イベント：カラーピッカーとテキストボックスの同期
				$('.pz-lkc-sync-text').on('keyup change', sync_color);
			}

			// 画面表示する
			$('.pz-lkc-dashboard').show();
			$('#pz-lkc-overlay-proc').hide();
		}
	});

	// 最後に開いていたタブを開く
	function tab_open_last() {
		var name = $('input[name="tab-now"]').val();
		if	(($(`a[name="${name}"]`).is('*') == false) || ($(`a[name="${name}"]`).css('display') == 'none')) {
			$('.pz-lkc-tab').each(function() {
				if	($(this).css('display') != 'none') {
					name = $(this).attr('name');
					return false;
				}
			})
		}
		$(`a[name="${name}"]`).addClass('pz-lkc-tab-active');
		$(`#${name}`).addClass('pz-lkc-page-active');
	}

	// タブの切り替え
	function tab_open() {
		$('.pz-lkc-page').removeClass('pz-lkc-page-active');
		$('.pz-lkc-tab').removeClass('pz-lkc-tab-active');
		$(this).addClass('pz-lkc-tab-active');
		$($(this).attr('href')).addClass('pz-lkc-page-active');
		$('input[name="tab-now"]').val($(this).attr('name'));
		return false;
	}

	// イベント：キー操作でタブを移動
	function key_down(e) {
		switch (true) {
		case	e.shiftKey:
			break;
		case	e.ctrlKey:
			switch (e.keyCode) {
			case 37:						// [Ctrl] + [←]
				tab_select(-1);
				return	false;
			case 39:						// [Ctrl] + [→]
				tab_select(+1);
				return	false;
			case 83:						// [Ctrl] + [S]
				$('#submit').trigger('click');
				return	false;
			}
		case	e.altKey:
			break;
		default:
			if	($('.pz-lkc-tab-active').is(':focus')) {
				switch (e.keyCode) {
				case 37:					// [←]
					tab_select(-1);
					$('.pz-lkc-tab-active').focus();
					return	false;
				case 39:					// [→]
					tab_select(+1);
					$('.pz-lkc-tab-active').focus();
					return	false;
				}
			}
		}
	}

	// イベント：タブを移動
	function tab_select(m) {
		var scrollNow = $(window).scrollTop();
		var tabNow    = $('.pz-lkc-tab-active')[0];
		$('.pz-lkc-tab').each(function() {
			if	($(this).css('display') != 'none') {
				$(this).addClass('pz-lkc-show');
			}
		})
		var tabList   = $('.pz-lkc-tab.pz-lkc-show');

		for (var i = 0; i < tabList.length; i++) {
			if	(tabList[i] === tabNow) {
				break;
			}
		}

		$(tabList[i]).removeClass('pz-lkc-tab-active');

		$($(tabList[i]).attr('href')).removeClass('pz-lkc-page-active');
		if	((m === -1) && (i > 0)) {
			i--;
		}
		if	((m === +1) && (i < (tabList.length - 1))) {
			i++;
		}
		$(tabList[i]).addClass('pz-lkc-tab-active');
		$($(tabList[i]).attr('href')).addClass('pz-lkc-page-active');
		$('input[name="tab-now"]').val($(tabList[i]).attr('name'));
	}

	// textarea で Tab 入力
	function textarea_ex(e) {
		if	(e.key == 'Tab' && !e.shiftKey && !e.ctrlKey && !e.altKey) {
			e.preventDefault();
			document.execCommand('insertText', false, '\t');
		}
	}

	// 一番上へ行くボタンをクリック
	function button_top_click() {
		$('body, html').animate({ scrollTop: 0 }, 200);
		return false;
	}

	// 一番上へ行くボタンの表示・非表示
	function top_button_scroll() {
		if	($(window).scrollTop() > 80) {
			$('.pz-button-top').fadeIn('slow');
		} else {
			$('.pz-button-top').fadeOut('slow');
		}
	}

	// 調査モード・管理者モード・開発者モードの切り替え
	function switch_mode() {

		if	($('.pz-lkc-settings').is('*') != false) {

			// エラータブの表示
			if	($('input[name="properties[error-mode]"]:checkbox').prop('checked') == true) {
				$('a[name="pz-lkc-error"]').show();
				$('a[name="pz-lkc-error"]').removeClass('pz-lkc-hide');
				$('a[name="pz-lkc-error"]').addClass('pz-lkc-show');
			} else {
				$('a[name="pz-lkc-error"]').hide();
				$('a[name="pz-lkc-error"]').removeClass('pz-lkc-show');
				$('a[name="pz-lkc-error"]').addClass('pz-lkc-hide');
			}

			// 初期化タブの表示
			if	($('input[name="properties[flg-initialize]"]:checkbox').prop('checked') == true) {
				$('a[name="pz-lkc-initialize"]').show();
				$('a[name="pz-lkc-initialize"]').removeClass('pz-lkc-hide');
				$('a[name="pz-lkc-initialize"]').addClass('pz-lkc-show');
			} else {
				$('a[name="pz-lkc-initialize"]').hide();
				$('a[name="pz-lkc-initialize"]').removeClass('pz-lkc-show');
				$('a[name="pz-lkc-initialize"]').addClass('pz-lkc-hide');
			}

			// タブのマルチサイトタブの表示
			if	($('input[name="properties[multi-mode]"]:checkbox').prop('checked') == true) {
				$('a[name="pz-lkc-multisite"]').show();
				$('a[name="pz-lkc-multisite"]').removeClass('pz-lkc-hide');
				$('a[name="pz-lkc-multisite"]').addClass('pz-lkc-show');
			} else {
				$('a[name="pz-lkc-multisite"]').hide();
				$('a[name="pz-lkc-multisite"]').removeClass('pz-lkc-show');
				$('a[name="pz-lkc-multisite"]').addClass('pz-lkc-hide');
			}

			// デバグモード（調査モード）
			if	($('input[name="properties[debug-mode]"]:checkbox').prop('checked') == true) {
				$('input[name="debug-mode"]').val(1 );
				$('.pz-lkc-debug-only').show;
				$('.pz-lkc-admin-only').show;
			} else {
				$('input[name="debug-mode"]').val(0 );
				$('.pz-lkc-debug-only').hide;
				$('input[name="properties[admin-mode]"]:checkbox').prop('checked', false);
			}

			// 管理者モード
			if	($('input[name="properties[admin-mode]"]:checkbox').prop('checked') == true) {
				$('input[name="admin-mode"]').val(1 );
			} else {
				$('input[name="admin-mode"]').val(0 );
				$('input[name="properties[multi-mode]"]:checkbox').prop('checked', false);
			}

			// 開発者モード
			if	($('input[name="properties[develop-mode]"]:checkbox').prop('checked') == true) {
				$('input[name="develop-mode"]').val(1 );
			} else {
				$('input[name="develop-mode"]').val(0 );
			}
		}

		// デバグモード（調査モード）
		if	($('input[name="debug-mode"]').val() == '1' ) {
			$('.pz-lkc-debug-only').show();
			$('.pz-lkc-debug-only').removeClass('pz-lkc-hide');
			$('.pz-lkc-debug-only').addClass('pz-lkc-show');
		} else {
			$('.pz-lkc-debug-only').hide();
			$('.pz-lkc-debug-only').removeClass('pz-lkc-show');
			$('.pz-lkc-debug-only').addClass('pz-lkc-hide');
		}

		// 管理者モード
		if	($('input[name="admin-mode"]').val() == '1' ) {
			$('a[name="pz-lkc-admin"]').show();
			$('a[name="pz-lkc-admin"]').removeClass('pz-lkc-hide');
			$('a[name="pz-lkc-admin"]').addClass('pz-lkc-show');
			$('.pz-lkc-admin-only').show();
			$('.pz-lkc-admin-only').removeClass('pz-lkc-hide');
			$('.pz-lkc-admin-only').removeClass('pz-lkc-show');
		} else {
			$('a[name="pz-lkc-admin"]').hide();
			$('a[name="pz-lkc-admin"]').removeClass('pz-lkc-show');
			$('a[name="pz-lkc-admin"]').addClass('pz-lkc-hide');
			$('.pz-lkc-admin-only').hide();
			$('.pz-lkc-admin-only').removeClass('pz-lkc-show');
			$('.pz-lkc-admin-only').removeClass('pz-lkc-hide');
		}

		// 開発者モード
		if	($('input[name="develop-mode"]').val() == '1' ) {
			$('.pz-lkc-develop-only').show();
			$('.pz-lkc-develop-only').removeClass('pz-lkc-hide');
			$('.pz-lkc-develop-only').addClass('pz-lkc-show');
		} else {
			$('.pz-lkc-develop-only').hide();
			$('.pz-lkc-develop-only').removeClass('pz-lkc-show');
			$('.pz-lkc-develop-only').addClass('pz-lkc-hide');
		}
	}

	// 特定の項目の値によって、連動する項目を有効化／無効化する
	function switch_enabled() {

		// 外部サイト・サムネイル選択によって、サムネイルサイズを有効／無効
		if	($('select[name="properties[ex-thumbnail]"]').val() == 1 || $('select[name="properties[ex-thumbnail]"]').val() == 13) {
			var flags = false;
		} else {
			var flags = true;
		}
		$('select[name="properties[ex-thumbnail-size]"]').prop('disabled', flags);
		
		// 内部サイト・サムネイル選択によって、サムネイルサイズを有効／無効
		if	($('select[name="properties[in-thumbnail]"]').val() == 1 || $('select[name="properties[in-thumbnail]"]').val() == 13) {
			var flags = false;
		} else {
			var flags = true;
		}
		$('select[name="properties[in-thumbnail-size]"]').prop('disabled', flags);
		
		// リンク検査：ユーザーエージェント使用選択によってユーザーエージェント文字列を有効／無効
		if	($('input[name="properties[flg-agent]"]:checkbox').prop('checked') == true) {
			var flags = false;
		} else {
			var flags = true;
		}
		$('input[name="properties[user-agent]"]').prop('readonly', flags);
		
		// エディタまたは自動変換選択によって、外部のみとショートコード実行を有効／無効
		if	($('input[name="properties[auto-atag]"]:checkbox').prop('checked') == true  || $('input[name="properties[auto-url]"]:checkbox').prop('checked') == true) {
			var readonly = false;
			var color = '#444';
		} else {
			var readonly = true;
			var color = '#ddd';
		}
		$('input[name="properties[auto-external]"]').prop('readonly', readonly);
		$('input[name="properties[flg-do-shortcode]"]').prop('readonly', readonly);
		$('input[name="properties[auto-external]"]').parent().css('color', color);
		$('input[name="properties[flg-do-shortcode]"]').parent().css('color', color);
	}

	// ショートコードをコピーする
	function copy_shortcode() {
		var t = $(this).val();
		$('.pz-lkc-shortcode-copy').each(function() {
			$(this).text(t);
			if	(t.length == 0) {
				$('.pz-lkc-shortcode-enabled').prop('disabled', true);
			} else {
				$('.pz-lkc-shortcode-enabled').prop('disabled', false);
			}
		})
	}

	// ショートコードの入力チェック
	function check_shortcode_key(e) {
		switch (e.keyCode) {
		case 32:						// [Space]
			return	false;
		}
	}

	// すべてのWP-Cronスケジュールを表示する
	function show_all_cron() {
		if	($(this).prop('checked') == true) {
			$('.pz-lkc-cron-list-other').show();
			$('.pz-lkc-cron-list-other').removeClass('pz-lkc-hide');
			$('.pz-lkc-cron-list-other').addClass('pz-lkc-show');
		} else {
			$('.pz-lkc-cron-list-other').hide();
			$('.pz-lkc-cron-list-other').removeClass('pz-lkc-show');
			$('.pz-lkc-cron-list-other').addClass('pz-lkc-hide');
		}
	}

	// カラーピッカーとテキストボックスの同期
	function sync_color() {
		var name = $(this).attr('name');
		var value = $(this).val();
		$('input[name="' + name + '"]').each(function() {$(this).val(value);});
	}

	// readonlyのチェックボックスを動作させない
	function checkbox_readonly() {
		if	($(this).prop('readonly') == true) {
			return false;
		}
	}

	// テキストを全選択
	function all_select() {
		switch ($(this).prop('tagName')) {
		case 'INPUT':
			$(this).select();
			break;
		case 'DIV':
			var range = document.createRange();
			range.selectNodeContents(this);
			var selection = window.getSelection();
			selection.removeAllRanges();
			selection.addRange(range);
			break;
		}
	}


}) ( jQuery);
