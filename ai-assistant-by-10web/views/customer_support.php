<div class="taa-customer-support-main">
  <div class="taa-contact-care-popup">
    <div class="taa-contact-care-content-section">
      <div class="taa-contact-care-wp-section">
        <div class="taa-contact-care-title">
          <?php esc_html_e('Get free and fast support', 'ai-assistant-tenweb' );?>
          <br>
          <?php esc_html_e(' on WordPress.org', 'ai-assistant-tenweb' );?>
        </div>
        <div class="taa-contact-care-description">
          <p class="taa-contact-care-content-text">
            <?php echo sprintf(__('If you’re having issues or need help with your website,
                          the fastest way to get assistance is by creating a topic<br> on %s.', 'ai-assistant-tenweb'), '<a href="' . esc_url('https://wordpress.org/support/plugin/ai-assistant-by-10web/') . '">WordPress.org</a>'); ?>

          </p>
          <p class="taa-contact-care-content-text">
            <?php esc_html_e('Our support team constantly monitors and resolves topics within 24 hours 
to provide users with a smooth optimization process.', 'ai-assistant-tenweb' ); ?>
          </p>
        </div>
        <a target="_blank" class="taa-contact-care-green-button"
           href="<?php echo esc_url('https://wordpress.org/support/plugin/ai-assistant-by-10web/');?>">
          <?php esc_html_e('CREATE A TOPIC', 'ai-assistant-tenweb' ); ?>
        </a>
      </div>
      <div class="taa-contact-care-pro-section">
        <div class="taa-contact-care-booster-pro">
          <p class="taa-contact-care-content-text taa-option-diamond">
            <?php echo sprintf(__('Priority support is available to %s users:', 'ai-assistant-tenweb'), '<a href="' . esc_url(TENWEB_DASHBOARD . '/ai-assistant/upgrade-plan') . '">' . __('Pro', 'ai-assistant-tenweb') . '</a>'); ?>
          </p>
          <p class="taa-contact-care-content-text taa-option-point">
            <?php esc_html_e(' 24/7 live chat support', 'ai-assistant-tenweb' ); ?>
          </p>
        </div>
      </div>
    </div>
    <div class="taa-contact-care-video-section">
      <video width="470" height="585" controls>
        <source src="<?php echo esc_url(TAA_URL . '/assets/images/AI_Assistant.mp4');?> " type="video/mp4">
        <?php esc_html_e('Your browser does not support the video tag.', 'ai-assistant-tenweb' );?>
      </video>
    </div>
  </div>
</div>