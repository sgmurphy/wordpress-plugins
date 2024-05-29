<?php

/**
 * <p>ThrowsSpamAway</p> hostbyipページ
 * WordPress's Plugin
 * @author Takeshi Satoh@GTI Inc. 2023
 * @version 3.5.1
 */

function tsa_get_hostbyip_html()
{
    $spam_ip = sanitize_text_field($_POST['hostbyip']);
    tsa_echo_hostbyip($spam_ip);
    die();
}

add_action("wp_ajax_getHostbyIp", "tsa_get_hostbyip_html");
add_action("wp_ajax_nopriv_getHostbyIp", "tsa_get_hostbyip_html");

function tsa_echo_hostbyip($spam_ip = '', $echo = true)
{
    if ($spam_ip === '') {
        echo "IP指定がありません";
        die();
    }
    /**
     * ホスト検索
     */
    $newThrowsSpamAway        = new ThrowsSpamAway();
    $last_spam_comment_result = $newThrowsSpamAway->get_last_spam_comment($spam_ip);

    // 最終投稿日
    $last_meta_id = $last_spam_comment_result->meta_id;
    $last_comment_date       = $last_spam_comment_result->post_date;
    $last_comment_post       = get_permalink($last_spam_comment_result->post_id);
    $last_comment_post_title = get_the_title(get_post($last_spam_comment_result->post_id));
    $is_spam_champuru        = ($newThrowsSpamAway->reject_spam_ip($spam_ip) ? false : true);  // スパムIPフィルターでの排除かどうか
    $spam_author             = $last_spam_comment_result->spam_author;
    $spam_author_email       = $last_spam_comment_result->spam_author_email;
    $spam_author_url         = $last_spam_comment_result->spam_author_url;
    $spam_comment            = esc_attr($last_spam_comment_result->spam_comment);
    $comment_agent		   = esc_attr($last_spam_comment_result->comment_agent);

    ob_start();
    ?>
	<h2><?php esc_attr_e($spam_ip); ?></h2>
	<?php
        $spam_host = gethostbyaddr(htmlspecialchars($spam_ip));
    if ($spam_host !== $spam_ip) {
        ?>
		<p class="tsa_spam_host_found"><?php _e("特定のホスト情報が見つかりました。", 'throws-spam-away'); ?></p>

		<p><strong><?php esc_attr_e($spam_host); ?></strong></p>
		<p>
			Whois: <a href="https://whois.arin.net/rest/ip/<?php esc_attr_e($spam_ip); ?>" target="_blank"><?php esc_attr_e($spam_ip); ?></a>
		</p>
		<p>
			<strong><?php _e("* Whois information uses Whois database of ARIN. The link is to https://www.arin.net/.", 'throws-spam-away'); ?></strong>
		</p>
	<?php
    } else {
        ?>
		<p class="tsa_spam_host_found"><?php _e("このIPアドレスから特定のホスト情報は見つかりませんでした。", 'throws-spam-away'); ?></p>
	<?php
    }
    ?>
	<?php if (!empty($last_spam_comment_result)) { ?>
		<p class="tsa_hostbyip_text"><?php _e("このIPからの最終投稿日時", 'throws-spam-away'); ?></p>
		<p><?php esc_attr_e($last_comment_date); ?></p>
		<p class="tsa_hostbyip_text"><?php _e("このIPからスパム投稿対象となったページ", 'throws-spam-away'); ?></p>
		<p>
			<a href="<?php esc_attr_e($last_comment_post); ?>" target="_blank"><?php esc_attr_e($last_comment_post_title); ?></a>
		</p>
	<?php }
	if ($is_spam_champuru) {
	    ?>
		<!-- // スパムフィルター廃止予定 -->
		<p class="tsa_spam_host_found"><?php _e("スパムフィルター：", 'throws-spam-away'); ?><?php echo($is_spam_champuru ? __("スパム拒否リスト存在IPアドレス", 'throws-spam-away') : __("未検出", 'throws-spam-away')); ?></p>
	<?php
	}
    ?>
	<p class="tsa_hostbyip_text"><?php _e("最新コメント内容", 'throws-spam-away'); ?></p>
	<p>
		<?php if (!empty($spam_author) && !empty($spam_comment)) {
		    ?>
			IP: <?php esc_attr_e($spam_ip); ?><br />
			User-Agent: <?php esc_attr_e($comment_agent); ?><br />
			名前：<?php esc_attr_e($spam_author); ?><br />
			投稿者メール: <?php esc_attr_e($spam_author_email); ?><br />
			投稿者URL: <?php esc_attr_e($spam_author_url); ?><br />
			内容：<?php echo nl2br(esc_attr($spam_comment)); ?><?php
		} ?>
	</p>
	<?php
    $tsa_hostbyip_html = ob_get_contents();
    ob_end_clean();

    if ($echo === true) {
        ?>
		<div id="tsa_spam_host">
			<?php
                echo wp_kses_post($tsa_hostbyip_html);
        ?>
			<hr>
			<p>このコメントがスパムではない場合</p>
			<form method="post" id="restore">
				<input type="hidden" name="meta_id" id="meta_id" value="<?php echo $last_meta_id; ?>">
				<input type="hidden" name="act" value="restore_comment">
				<input type="submit" value="スパム判定を解除">
				<?php wp_nonce_field('tsa_action', 'tsa_nonce') ?>
			</form>
			<hr>
			<p>閉じるには画面外をクリックしてください</p>
		</div>
<?php
        die();
    }

    return wp_kses_post($tsa_hostbyip_html);
}
