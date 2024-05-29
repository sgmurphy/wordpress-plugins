<?php
namespace POCHIPP;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="pchpp-setting__section_help">
	<p>
		※ ご利用前にAmazonの公式ドキュメントをご確認ください。<br>
		<a href="https://affiliate.amazon.co.jp/help/operating/paapilicenseagreement" target="_blank" rel="noopener noreferrer">Amazon.co.jp Product Advertising API ライセンス契約</a>
		/
		<a href="https://affiliate.amazon.co.jp/help/operating/agreement" target="_blank" rel="noopener noreferrer">Amazonアソシエイト・プログラム運営規約</a>
		/
		<a href="https://affiliate.amazon.co.jp/help/node" target="_blank" rel="noopener noreferrer">Amazonアソシエイトに関するヘルプページ</a>
	</p>
	<div class="__helpLink">
		PA-APIの認証キーやトラッキングIDの設定方法は<a href="https://pochipp.com/200/" target="_blank" rel="noopener noreferrer" class="dashicons-before dashicons-book-alt">こちらのページ</a>で解説しています。
	</div>
</div>
<h3 class="pchpp-setting__h3">検索設定</h3>
<p class="pchpp-setting__p">
	AmazonのAPIを使って商品検索をするためには、「<a href="https://affiliate.amazon.co.jp/assoc_credentials/home" target="_blank" rel="noopener noreferrer">Amazon Product Advertising API</a>」の「認証キー」が必要です。
	<br>
	認証キーを取得後、「アクセスキー」と「シークレットキー」を設定してください。
</p>
<div class="pchpp-setting__div amazon-search">
	<dl class="pchpp-setting__dl">
		<dt>アクセスキー</dt>
		<dd>
			<?php
				\POCHIPP::output_text_field([
					'key'   => 'amazon_access_key',
				]);
			?>
			<span class="errMessage"></span>
		</dd>
	</dl>
	<dl class="pchpp-setting__dl">
		<dt>シークレットキー</dt>
		<dd>
			<?php
				\POCHIPP::output_text_field([
					'key'   => 'amazon_secret_key',
				]);
			?>
			<span class="errMessage"></span>
		</dd>
	</dl>
</div>


<h3 class="pchpp-setting__h3">アフィリエイト設定</h3>
<p class="pchpp-setting__p">
	Amazonアソシエイトの「トラッキングID」を設定することで、商品リンクがアフィリエイトリンクに自動変換されます。
	<br>
	利用できるIDは<a href="https://affiliate.amazon.co.jp/home/account/tag/manage" target="_blank" rel="noopener noreferrer">トラッキングIDの管理</a>から確認できます。
</p>
<div class="pchpp-setting__div amazon-affiliate">
	<dl class="pchpp-setting__dl">
		<dt>トラッキングID</dt>
		<dd>
			<?php
				\POCHIPP::output_text_field([
					'key'         => 'amazon_traccking_id',
				]);
			?>
			<span class="errMessage"></span>
		</dd>
	</dl>
</div>
