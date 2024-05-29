<?php
$access_token = \AIAssistantTenWeb\Utils::get_access_token();
if(!empty($access_token)){
  \AIAssistantTenWeb\TenWebApi::get_instance()->get_limitations();
}
$connect_url = \AIAssistantTenWeb\Utils::get_tenweb_connection_link();
$limitation = \AIAssistantTenWeb\Utils::get_limitation();
$reset_date = !empty ($limitation['resetDate']) ? gmdate('d.m.Y', strtotime($limitation['resetDate'])) : '';
$words_used = !empty ($limitation['alreadyUsed']) ? $limitation['alreadyUsed'] : 0;
$total_allowed_words = !empty ($limitation['planLimit']) ? intval($limitation['planLimit']) : 5000;
$plan_title = __('Free', 'ai-assistant-tenweb');
$used_percent = round(($words_used * 100) / $total_allowed_words);
$used_percent = min($used_percent, 100);
$taa_disconnect_link = get_admin_url() . 'admin.php?page=ai_assistant_tenweb&taa_disconnect=1&nonce=' . wp_create_nonce(AIAssistantTenWeb::NONCE_ACTION);
$wp_plugin_url = 'https://wordpress.org/support/plugin/ai-assistant-by-10web/';

$taa_connection_error_msg = get_site_transient('taa_auth_error_logs');
$is_hosted_website = \Tenweb_Authorization\Helper::check_if_manager_mu();
?>
<div class="taa-header taa-flex-center">
  <img src="<?php echo esc_url(TAA_URL . '/assets/images/10web_logo.svg'); ?>" alt="10Web" class="taa-flex-center"/>
</div>
<?php
if ( !empty($access_token) ) {

  $taa_how_to_use_intro = get_option("taa_how_to_use_intro", 0);
  if ( !$taa_how_to_use_intro ) {
    update_option("taa_how_to_use_intro", 1);
    $args = array(
      'use_list' => array(
        __('Create an outline for your article based on the title.', 'ai-assistant-tenweb'),
        __('Compose an opening paragraph for your article based on the title.', 'ai-assistant-tenweb'),
        __('Create a new paragraph from the title or select a paragraph to prolong it.', 'ai-assistant-tenweb'),
        __('Rewrite the selected paragraph of your article to improve it.', 'ai-assistant-tenweb'),
        __('Generate a conclusion paragraph for your article.', 'ai-assistant-tenweb'),
      ),
      'use_type' => 'intro'
    );
    \AIAssistantTenWeb\Library::how_to_use( $args );
  }

  $ai_plugins = array();
  $ai_plugins['active'] = array();
  $ai_plugins['deactive'] = array();

  $ai_plugins['active']  =  array(
    array(
      'plugin_file' =>  '',
      'zip_name' => '',
      'title' => esc_html__('Gutenberg', 'ai-assistant-tenweb'),
      'description' => __('Reap the benefits of AI Assistant within <br> the Gutenberg editor by generating content effortlessly.', 'ai-assistant-tenweb'),
      'video_url' => TAA_URL . '/assets/images/AI_Plugin.mp4',
      'poster_url' => TAA_URL . '/assets/images/AI_Plugin_poster.jpg',
    ),
    array(
      'plugin_file' =>  '',
      'zip_name' => '',
      'title' => esc_html__('Classic Editor', 'ai-assistant-tenweb'),
      'description' => __('Leverage the power of AI Assistant to help<br> you generate content directly in your favorite Classic Editor.', 'ai-assistant-tenweb'),
      'video_url' => TAA_URL . '/assets/images/Classic_Editor_add-on.mp4',
      'poster_url' => TAA_URL . '/assets/images/Classic_Editor_poster.jpg',
      )
  );

  $add_ons  =  array(
    'ai-assistant-by-10web-seo-pack/ai-assistant-by-10web-seo-pack.php' => array(
        'plugin_file' =>  'ai-assistant-by-10web-seo-pack/ai-assistant-by-10web-seo-pack.php',
        'zip_name' => 'ai-assistant-by-10web-seo-pack',
        'title' => esc_html__('SEO pack', 'ai-assistant-tenweb'),
        'description' => __('Generate Meta title and descriptions directly in Yoast SEO.<br> Automatically fix SEO and Readability errors with one click.', 'ai-assistant-tenweb'),
        'video_url' => TAA_URL . '/assets/images/Yoast_SEO_add-on.mp4',
        'poster_url' => TAA_URL . '/assets/images/Yoast_SEO_poster.jpg',
    )
  );
  foreach ( $add_ons as $key => $add_on ) {
    if ( is_plugin_active( $key ) ) {
        $ai_plugins['active'][]  = $add_on;
    } else {
        $ai_plugins['deactive'][]  = $add_on;
    }
  }
  ?>
  <div class="taa-flex-center">
    <?php if( !get_option("taa_how_to_use_intro_finished", 0) ) { ?>
    <div class="taa-howto-sidebar taa-main-container taa-conncected">
      <div>
        <span class="taa-section-title"><?php esc_html_e("Lets learn how to use 10Web AI", "ai-assistant-tenweb"); ?></span>
        <span class="taa-section-description"><?php esc_html_e("Learn how to leverage the power of 10Web AI to write & edit content.", "ai-assistant-tenweb"); ?></span>
      </div>
      <a href="<?php echo esc_url(admin_url('post-new.php?taa_intro=1')); ?>" target="_blank" class="taa-howto-sidebar-button"><?php esc_html_e("LET'S START", "ai-assistant-tenweb"); ?></a>
    </div>
    <?php } ?>
    <div class="taa-main-container taa-conncected taa-connected-data">
      <div class="taa-section-title">
        <?php esc_html_e('10Web AI Assistant is Active', 'ai-assistant-tenweb'); ?>
      </div>
      <div class="taa-section-description taa-section-main-desc">
        <?php _e('Experience the range of benefits of our AI Assistant – generate<br/>premium content in seconds.', 'ai-assistant-tenweb'); ?>
      </div>
      <div class="taa-light-blue-bg taa-used-data taa-flex-space-between">
        <?php if ( \AIAssistantTenWeb\Utils::is_free( $total_allowed_words ) ) { ?>
        <span class="taa-plan-title taa-section-text taa-section-text-semi"><?php echo esc_html(sprintf(__('%s Plan', 'ai-assistant-tenweb'), $plan_title));; ?></span>
        <?php } ?>
        <div class="taa-data-numbers">
          <p class="taa-section-text taa-section-text-semi"><?php esc_html_e('Words used', 'ai-assistant-tenweb'); ?></p>
          <p class="taa-section-description">
            <span class="taa-used-words"><?php echo esc_html($words_used); ?></span><?php echo esc_html(' of ' . $total_allowed_words); ?>
          </p>
        </div>
        <div class="taa-data-percentage">
          <div class="taa-score-circle" data-score="<?php echo esc_attr($used_percent); ?>" data-size="70" data-thickness="4">
            <span class="taa-score-circle-animated taa-section-text taa-section-text-bold"></span>
          </div>
        </div>
      </div>
      <?php
      if ( $reset_date ) {
        ?>
          <p class="taa-section-text taa-reset-text">
            <?php esc_html_e('Your word count will reset on ' . $reset_date, 'ai-assistant-tenweb'); ?>
          </p>
        <?php
      }
      ?>
    </div>
    <div class="taa-main-container taa-conncected taa-availability">
      <div class="taa-section-title">
        <?php esc_html_e('AI Assist available on:', 'ai-assistant-tenweb'); ?>
      </div>
      <div class="taa-active-container">
        <?php
        foreach ( $ai_plugins['active'] as $addon ) { ?>
        <div class="taa-row taa-flex-space-between">
          <div class="taa-light-blue-bg taa-plugin-active">
            <p class="taa-section-text taa-section-text-bold">
              <?php echo esc_html($addon['title']); ?>
            </p>
            <p class="taa-section-description">
                <?php echo wp_kses($addon['description'], array('br'=>array())); ?>
            </p>
            <p class="taa-section-text taa-section-text-semi">
              <?php esc_html_e('Active', 'ai-assistant-tenweb'); ?>
            </p>
          </div>
          <div class="taa-video-container">
              <span class="taa-expand"></span>
              <video width="224" height="125" poster="<?php echo esc_url($addon['poster_url']); ?>" muted loop>
                  <source src="<?php echo esc_url($addon['video_url']); ?>" type="video/mp4">
              </video>
          </div>
        </div>
        <?php } ?>
      </div>
      <?php if ( !empty($ai_plugins['deactive']) ) { ?>
        <div class="taa-not-active-container">
          <p class="taa-not-active-container-descr"><?php echo sprintf(esc_html__('Free available Add-ons on %s', 'ai-assistant-tenweb'), '<a target="_blank" href="'.esc_url('https://wordpress.org/plugins/ai-assistant-by-10web-seo-pack/').'">'.esc_html__('WP.org','ai-assistant-tenweb').'</a>'); ?></p>
          <?php foreach ( $ai_plugins['deactive'] as $addon ) { ?>
            <div class="taa-row taa-flex-space-between">
              <div class="taa-light-blue-bg taa-plugin-not-active">
                <p class="taa-section-text taa-section-text-bold">
                  <?php echo esc_html($addon['title']); ?>
                </p>
                <p class="taa-section-description">
                  <?php echo wp_kses($addon['description'], array('br'=>array())); ?>
                </p>
                <span class="taa-download-plugin-link" data-zip_name="<?php echo esc_attr($addon['zip_name']); ?>" data-file="<?php echo esc_attr($addon['plugin_file']); ?>">
                  <i class="taa-loader"></i><?php esc_html_e('Download & activate', 'ai-assistant-tenweb'); ?>
                </span>
              </div>
              <div class="taa-video-container">
                <span class="taa-expand"></span>
                <video width="224" height="125" muted loop>
                  <source src="<?php echo esc_url($addon['video_url']); ?>" type="video/mp4">
                </video>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>

    </div>
    <div class="taa-conncected taa-flex-space-between">
      <div class="taa-disconnect-link taa-plugin-active">
        <span
          class="taa-section-text taa-section-text-bold"><?php _e('Site is connected', 'ai-assistant-tenweb'); ?></span>
        <?php if( !$is_hosted_website ) { ?>
        <a class="taa-section-text taa-section-text-semi" href="<?php echo esc_url($taa_disconnect_link); ?>">
          <?php esc_html_e('Disconnect from 10Web', 'ai-assistant-tenweb'); ?>
        </a>
        <?php } ?>
      </div>
      <div class="taa-wp-link">
        <span class="taa-section-text taa-section-text-bold"><?php _e('Have a question?', 'ai-assistant-tenweb'); ?></span>
        <span class="taa-section-text"><?php _e('Please create a topic in', 'ai-assistant-tenweb'); ?>
            <a class="taa-section-text taa-section-text-semi" href="<?php echo esc_url($wp_plugin_url); ?>" target="_blank">
                <?php _e('WordPress.org', 'ai-assistant-tenweb'); ?>
            </a>
        </span>
      </div>
    </div>
  </div>
  <div class="taa-video-popup-layout taa-hidden"></div>
  <div class="taa-video-popup taa-hidden">
      <video width="945" height="530" muted loop autoplay>
          <source src="" type="video/mp4">
      </video>
  </div>
  <?php
}
else {
  ?>
  <div class="taa-flex-center">
    <?php
    if ( !empty($taa_connection_error_msg) ) {
        ?>
        <div class="taa-error">
            <img src="<?php echo TAA_URL; ?>/assets/images/error.svg" alt="Error" class="taa-error-img" />
            <b><?php echo esc_html__('Trouble connecting your website to 10Web:', 'ai-assistant-tenweb') ?></b> <?php echo esc_html__( 'This domain already used', 'ai-assistant-tenweb' ); ?>
        </div>
        <?php
    }
    ?>
    <div class="taa-main-container taa-flex-space-between">
      <div class="taa-info-section">
        <div class="taa-greeting">
          <img src="<?php echo esc_url(TAA_URL . '/assets/images/waving_hand.png'); ?>" alt="Hey"
               class="taa-waving-hand"/>
          <?php esc_html_e('Hello!', 'ai-assistant-tenweb'); ?>
        </div>
        <div class="taa-main-title">
          <?php esc_html_e('Welcome to 10Web AI Assistant', 'ai-assistant-tenweb'); ?>
        </div>
        <div class="taa-main-text">
          <?php esc_html_e('Get started with these easy steps:', 'ai-assistant-tenweb'); ?>
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
                <?php esc_html_e('Connect your website to 10Web', 'ai-assistant-tenweb'); ?>
              </div>
              <div class="taa-step-description">
                <?php esc_html_e('Sign up and connect your website to 10Web to enable the AI Assistant service.', 'ai-assistant-tenweb'); ?>
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
                <?php esc_html_e('Leverage the power of AI', 'ai-assistant-tenweb'); ?>
              </div>
              <div class="taa-step-description">
                <?php esc_html_e('Experience the benefits of our AI Assistant – generate premium content in seconds.', 'ai-assistant-tenweb'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="taa-button-container taa-flex-center">
          <a class="taa-blue-button" href="<?php echo esc_url($connect_url); ?>">
            <?php esc_html_e('SIGN UP & CONNECT', 'ai-assistant-tenweb'); ?>
          </a>
        </div>
      </div>
      <div class="taa-image-container taa-flex-center">
        <img src="<?php echo esc_url(TAA_URL . '/assets/images/welcome_image.png'); ?>" alt="Welcome"
             class="taa-welcome-image"/>
        <div class="taa-image-description">
          <div class="taa-image-description-header">
            <?php esc_html_e('Access the benefits of 10Web AI Assistant', 'ai-assistant-tenweb'); ?>
          </div>
          <ul class="taa-image-description-list">
            <li><?php esc_html_e('Generate outlines', 'ai-assistant-tenweb'); ?></li>
            <li><?php esc_html_e('Paraphrase a text', 'ai-assistant-tenweb'); ?></li>
            <li><?php esc_html_e('Generate introductions', 'ai-assistant-tenweb'); ?></li>
            <li><?php esc_html_e('Generate conclusions', 'ai-assistant-tenweb'); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php
  }
