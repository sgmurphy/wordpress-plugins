<?php
wp_enqueue_style(AA_SEO_Pack_TenWeb()::PREFIX . '-main');
wp_enqueue_script(AA_SEO_Pack_TenWeb()::PREFIX . '-main');
?>
<div class="taa-header taa-flex-center">
  <img src="<?php echo esc_url(AA_SEO_Pack_TenWeb()->plugin_url . '/assets/images/10web_logo.svg'); ?>" alt="10Web" class="taa-flex-center"/>
</div>
  <div class="taa-flex-center">
    <div class="taa-main-container taa-flex-space-between">
      <div class="taa-info-section">
        <div class="taa-greeting">
          <img src="<?php echo esc_url(AA_SEO_Pack_TenWeb()->plugin_url . '/assets/images/waving_hand.png'); ?>" alt="Hey"
               class="taa-waving-hand"/>
          <?php esc_html_e('Hello!', 'ai-assistant-tenweb'); ?>
        </div>
        <div class="taa-main-title">
          <?php echo esc_html(AA_SEO_Pack_TenWeb()->main_page['title']); ?>
        </div>
        <div class="taa-main-text">
          <?php esc_html_e('Follow these steps to get started:', 'ai-assistant-tenweb'); ?>
        </div>
        <div class="taa-steps taa-flex-center">
          <div class="taa-step taa-step-1 taa-flex-start">
            <div class="taa-step-check">
              <div class="taa-step-check-inner taa-check"></div>
            </div>
            <div class="taa-step-title">
              <?php esc_html_e('Step 1', 'ai-assistant-tenweb'); ?>
            </div>
            <div class="taa-step-body">
              <div class="taa-step-header">
                <?php esc_html_e('Install AI assistant main plugin', 'ai-assistant-tenweb'); ?>
              </div>
              <div class="taa-step-description">
                <?php esc_html_e('Add-on requires the installation of 10Web AI Assistant plugin.', 'ai-assistant-tenweb'); ?>
              </div>
            </div>
          </div>
          <div class="taa-step taa-step-2 taa-flex-start">
            <div class="taa-step-check">
              <div class="taa-step-check-inner taa-check"></div>
            </div>
            <div class="taa-step-title">
              <?php esc_html_e('Step 2', 'ai-assistant-tenweb'); ?>
            </div>
            <div class="taa-step-body">
              <div class="taa-step-header">
                <?php esc_html_e('Connect your website to 10Web', 'ai-assistant-tenweb'); ?>
              </div>
              <div class="taa-step-description">
                <?php esc_html_e('Sign up and connect your website to 10Web to enable 10Web AI Assistant service.', 'ai-assistant-tenweb'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="taa-button-container taa-flex-center">
          <a class="taa-blue-button" onclick="taa_install_main_plugin( this )">
            <?php esc_html_e('INSTALL MAIN PLUGIN', 'ai-assistant-tenweb'); ?>
          </a>
          <p class="taa-button-description">
            <?php echo sprintf(__('10Web AI Assistant main plugin will be automatically installed from the %s repository.', 'ai-assistant-tenweb'), '<a href="https://wordpress.org/plugins/ai-assistant-by-10web/">WP.org</a>'); ?>
          </p>
        </div>
      </div>
      <div class="taa-image-container taa-flex-center">
        <img src="<?php echo esc_url(AA_SEO_Pack_TenWeb()->plugin_url . '/assets/images/welcome_image.png'); ?>" alt="Welcome"
             class="taa-welcome-image"/>
        <div class="taa-image-description">
          <div class="taa-image-description-header">
            <?php echo esc_html(AA_SEO_Pack_TenWeb()->main_page['desc']); ?>
          </div>
          <ul class="taa-image-description-list">
            <?php
            foreach ( AA_SEO_Pack_TenWeb()->main_page['features'] as $item ) {
              ?>
              <li><?php echo esc_html($item); ?></li>
              <?php
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>