<?php

/**
 * Class AIAssistantClassic
 */
class AIAssistantClassic {
  private $obj;
  function __construct($obj) {
    $this->obj = $obj;
    $this->enqueue_assets();
    add_action('media_buttons', array( $this, 'button_template' ));
  }

  /**
   * Include scripts and styles.
   *
   * @return void
   */
  private function enqueue_assets() {
    wp_enqueue_script(AIAssistantTenWeb::PREFIX . '-button', $this->obj->plugin_url . '/assets/js/classic.js', array( AIAssistantTenWeb::PREFIX . '_main_js' ), TAA_VERSION);
    wp_enqueue_style(AIAssistantTenWeb::PREFIX . '_button_css');
  }

  /**
   * Print the button.
   *
   * @return void
   */
  public function button_template() {
    if ( !class_exists('\AIAssistantTenWeb\Library') ) {
      include_once TAA_DIR . 'includes/Library.php';
    }

    if ( method_exists('\AIAssistantTenWeb\Library', 'ai_button') ) {
      \AIAssistantTenWeb\Library::ai_button();
    }
  }
}
