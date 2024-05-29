<?php

namespace AIAssistantTenWeb;

class Library {
  public static function ai_button() {
    static $cache = null;

    if($cache === null) {
      $cache = true;
    } else {
      return;
    }
    ?>
    <div id="twai-button-cont" class="twai-button-cont twai-inline">
      <button id="twai-button" type="button" class="button button-primary button-large twai-button twai-button-disabled twai-button-green">
        <span class="twai-button-text"><?php echo esc_html__( '10Web AI', 'ai-assistant-tenweb' ); ?></span>
        <div class="twai-loader"></div>
        <div class="twai-list-container">
          <div class="twai-list-container-content">
            <div class="twai-list-header">
              <p class="twai-list-header-title"><?php echo esc_html__( 'Ask 10Web AI to:', 'ai-assistant-tenweb' ); ?></p>
              <span class="twai-how_to_use-button"><?php echo esc_html__( 'How to use', 'ai-assistant-tenweb' ); ?></span>
            </div>
            <div class="twai-list-empty-info">
              <p><?php echo esc_html__( 'Please select a text/tittle to use AI Assistant.', 'ai-assistant-tenweb' ); ?></p>
            </div>
            <div class="twai-list-item-content">
              <div class="twai-list-item-content-layout"></div>
              <?php
              foreach ( self::actions_list() as $key => $item ) {
                ?>
              <div class="twai-list-item" data-value="<?php echo esc_attr($key); ?>">
                <span class="twai-list-item-title"><?php echo esc_html($item['title']); ?></span>
                <span class="twai-list-item-description"><?php echo esc_html($item['description']); ?></span>
              </div>
                <?php
              }
              ?>
            </div>
            <?php self::word_usage(); ?>
          </div>
        </div>
      </button>
    </div>
    <?php
    $args = array(
      'use_list' => array(
        __('Ask AI to create an outline for your article based on the title.', 'ai-assistant-tenweb'),
        __('Compose an opening paragraph for your article based on title.', 'ai-assistant-tenweb'),
        __('Create a new paragraph from the title or select a paragraph to prolong it.', 'ai-assistant-tenweb'),
        __('Let AI rewrite the selected paragraph of your article to improve it.', 'ai-assistant-tenweb'),
        __('Select a paragraph to generate a conclusion paragraph for your article.', 'ai-assistant-tenweb'),
      ),
    );
    self::how_to_use( $args );
  }

  /**
   * Word usage container.
   *
   * @return void
   */
  public static function word_usage() {
    $limitation = \AIAssistantTenWeb\Utils::get_limitation();
    if ( !empty($limitation) && !empty($limitation['planLimit']) )  {
      if ( empty($limitation['alreadyUsed']) ) {
        $limitation['alreadyUsed'] = 0;
      }
      ?>
      <div class="twai-list-footer">
        <div class="twai-list-footer-part">
          <?php echo sprintf( __('<b>Word usage</b> %s of %s', 'ai-assistant-tenweb' ), '<span id="twai_alreadyUsed">' . $limitation['alreadyUsed'] . '</span>', '<span id="twai_planLimit">' . $limitation['planLimit'] . '</span>' ); ?>
        </div>
        <div class="twai-list-footer-part">
          <a target="_blank" href="<?php echo esc_url(TENWEB_DASHBOARD . '/ai-assistant?open=livechat'); ?>"><?php echo esc_html__( 'Upgrade', 'ai-assistant-tenweb' ); ?></a>
        </div>
      </div>
      <?php
    }
  }

  public static function simple_ai_button(){
    // button without action list
    static $cache = null;

    if($cache === null) {
      $cache = true;
    } else {
      return;
    }
    ?>
      <script id="twai-simple-button-template" type="text/html">
          <div class="twai-button-cont twai-simple-button-cont twai-inline">
              <button type="button"
                      class="button button-primary button-large twai-button twai-simple-button twai-button-disabled twai-button-green">
                  <span class="twai-button-text"></span>
                  <div class="twai-loader"></div>
                  <div class="twai-empty"></div>
              </button>
          </div>
      </script>
    <?php
  }

  /**
   * Notification popup template.
   *
   * @return void
   */
  public static function popup_template() {
    static $cache = null;

    if($cache === null) {
      $cache = true;
    } else {
      return;
    }

    ?>
    <div class="twai-popup-layout twai-hidden"></div>
    <div class="twai-popup-notif twai-hidden">
      <span class="twai-popup-close"></span>
      <h3 class="twai-popup-notif-title"></h3>
      <p class="twai-popup-notif-text"></p>
      <a class="twai-popup-notif-button"></a>
    </div>
    <?php
  }

  /**
   * Returns the available actions list.
   *
   * @return string[]
   */
  public static function actions_list() {
    return array(
      'outline' => array('title' => 'Generate an outline from a title', 'description' => 'Create an outline for your article based on the title.'),
      'intro' => array('title' => 'Generate an introduction from a title', 'description' => 'Compose an opening paragraph for your article.'),
      'paragraph' => array('title' => 'Generate a paragraph', 'description' => 'Create a paragraph from title or select a paragraph to prolong it.'),
      'conclusion' => array('title' => 'Generate a conclusion paragraph', 'description' => 'Select a paragraph to generate a conclusion for your article.'),
      'paraphrase' => array('title' => 'Paraphrase a paragraph', 'description' => 'Rewrite the selected paragraph of your article to improve it.'),
    );
  }

  public static function how_to_use( $args = array() ) {
    $intro = isset($args['use_type']) ? 1 : 0;
    $use_list = $args['use_list'];
    ?>
    <div class="twai-how_to_use-layout <?php echo !$intro ? 'twai-hidden' : ''; ?>" <?php echo !$intro ? 'style="display: none"' : ''; ?>></div>
    <div class="twai-how_to_use-container <?php echo !$intro ? 'twai-hidden' : 'twai-how_to_use-intro-container'; ?>" <?php echo !$intro ? 'style="display: none"' : ''; ?>>
      <div class="twai-how_to_use-title"><?php echo esc_html__( '10Web AI for writing and editing', 'ai-assistant-tenweb' ); ?></div>
      <?php if ( !$intro ) { ?>
        <div class="twai-how_to_use-steps">
          <div class="twai-how_to_use-steps-item"><span>1</span><?php echo esc_html__( 'Select the title or a specific section.', 'ai-assistant-tenweb' ); ?></div>
          <div class="twai-how_to_use-steps-item"><span>2</span><?php echo esc_html__( 'Press the “10Web AI”', 'ai-assistant-tenweb' ); ?></div>
          <div class="twai-how_to_use-steps-item"><span>3</span><?php echo esc_html__( 'Choose from the available options.', 'ai-assistant-tenweb' ); ?></div>
        </div>
      <?php } else { ?>
        <div class="twai-how_to_use-descr"><?php echo esc_html__( 'Let’s learn how to use AI Assistant to write and edit content 10x faster right in WordPress.', 'ai-assistant-tenweb' ); ?></div>
      <?php } ?>
      <div class="twai-how_to_use-content">
        <div class="twai-how_to_use-content-left">
          <?php
          foreach ( $use_list as $item ) {
          ?>
          <div class="twai-how_to_use-list-item"><?php echo esc_html($item); ?></div>
          <?php
          }
          ?>
        </div>
        <div class="twai-how_to_use-content-right"></div>
      </div>
      <div class="twai-how_to_use-button-row">
        <?php if ( !$intro ) { ?>
        <span class="taa-green-button twai-how_to_use-popup-button"><?php echo esc_html__( 'GOT IT', 'ai-assistant-tenweb' ); ?></span>
        <?php } else { ?>
        <span class="twai-skip"><?php echo esc_html__( 'Skip', 'ai-assistant-tenweb' ); ?></span>
        <a href="<?php echo esc_url(admin_url('post-new.php?taa_intro=1')); ?>" class="taa-howto-sidebar-button"><?php esc_html_e("LET'S START", "ai-assistant-tenweb"); ?></a>
        <?php } ?>
      </div>
    </div>
    <?php
  }

  /**
   * Onboarding tooltip template.
   *
   */
  public static function tooltip_onboarding() {
    ?>
    <script id="twai-tooltip-onboarding-template" type="text/html">
        <style>
            .twai-hidden {
                display: none;
            }

            .twai-tooltip-onboarding {
                position: absolute;
                margin-left: 50%;
                margin-top: 0 !important;
                font: normal normal normal 12px/18px Open Sans;
                letter-spacing: 0.1px;
                color: #FFFFFF;
                top: 70px;
                right: 0;
                z-index: 1;
                margin-block-start: 0;
                margin-block-end: 0;
            }

            .twai-tooltip-onboarding::after {
                content: "";
                position: absolute;
                top: 30px;
                left: -10px;
                border-width: 5px;
                border-style: solid;
                border-color: transparent #23282D transparent transparent;
            }
            .twai-tooltip.twai-tooltip-onboarding p {
                background: url(<?php echo esc_url(TAA_URL) ?>/assets/images/logo_grey.svg) 0% 2px no-repeat;
                padding: 0 0 0 22px;
                margin: 0;
                font: normal normal bold 12px/18px Open Sans;
                letter-spacing: 0.1px;
                color: #ABACAC;
            }

            .twai-tooltip-title {
                font-weight: bold;
                margin: 4px 0;
            }

            .twai-tooltip-desc {
                margin: 4px 0;
            }

            .twai-tooltip-button {
                text-align: right;
                margin-top: 16px;
            }

            .twai-tooltip-onboarding .twai-tooltip-button button {
                width: 121px;
                min-height: 26px;
                font-size: 12px;
                line-height: 1;
                color: #fff;
                border-width: 1px;
                border-style: solid;
                -webkit-appearance: none;
                border-radius: 3px;
            }

            .twai-tooltip-button .twai-button-disabled {
                opacity: 0.5;
                cursor: default;
            }

            .twai-tooltip-bg {
                background-color: rgba(34, 179, 57, 0.15);
            }

            .twai-tooltip {
                background: #23282D 0% 0% no-repeat padding-box;
                border: 1px solid #FFFFFF1A;
                border-radius: 6px;
                width: 300px;
                padding: 20px;
                cursor: default;
            }
            #twai-button-cont .button.twai-button-green,
            .twai-simple-button-cont .button.twai-button-green,
            #twai-button-cont .button.twai-button-green:hover,
            .twai-simple-button-cont .button.twai-button-green:hover,
            .button.twai-button-green, .button.twai-button-green:hover {
                background: #22B339;
                border-color: #22B339;
            }
        </style>
      <div class="twai-tooltip twai-tooltip-onboarding twai-hidden" data-step="1">
        <p><?php echo esc_html__( '10Web AI', 'ai-assistant-tenweb' ); ?></p>
        <div class="twai-tooltip-title"></div>
        <div class="twai-tooltip-desc"></div>
        <div class="twai-tooltip-button">
          <button type="button" class="button button-primary twai-simple-button twai-button-disabled twai-button-green"></button>
        </div>
      </div>
    </script>
    <?php
  }

  /**
   * Log the request on error.
   *
   * @param $data
   *
   * @return void
   */
  public static function log($data) {
    $existing_data = get_option('taa_logs', FALSE);
    if ( !empty($existing_data) ) {
      $existing_data = (array) json_decode($existing_data);
    }
    else {
      $existing_data = array();
    }
    array_unshift($existing_data, $data);

    update_option('taa_logs', json_encode($existing_data));
  }

  public static function get_logs($params = array('list' => 1, 'limit' => 20)) {
    $logs = get_option('taa_logs', FALSE);
    if ( empty($logs) ) {
      return array();
    }

    $logs = (array) json_decode($logs);
    $logs = array_slice($logs, ($params['list'] - 1) * $params['limit'], $params['limit'], true);

    return $logs;
  }
}