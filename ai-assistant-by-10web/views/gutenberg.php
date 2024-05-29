<?php

/**
 * Class AIAssistantGutenberg
 */
class AIAssistantGutenberg {
  private $obj;
  function __construct($obj) {
    $this->obj = $obj;
    add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_assets' ) );
    add_action( 'admin_footer', array( $this, 'button_template' ) );
  }

  /**
   * Include scripts and styles.
   *
   * @return void
   */
  public function enqueue_assets() {
    wp_enqueue_script(AIAssistantTenWeb::PREFIX . '-gutenberg', $this->obj->plugin_url . '/assets/js/gutenberg.js', array(
      'wp-plugins',
      'wp-edit-post'
    ), TAA_VERSION);
    wp_enqueue_style(AIAssistantTenWeb::PREFIX . '-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800&display=swap');
    wp_enqueue_style(AIAssistantTenWeb::PREFIX . '-gutenberg', $this->obj->plugin_url . '/assets/css/gutenberg.css', array(AIAssistantTenWeb::PREFIX . '-open-sans'), TAA_VERSION);
  }

  /**
   * Print the button template.
   *
   * @return void
   */
  public function button_template() {
    if ( !class_exists('\AIAssistantTenWeb\Library') ) {
      include_once TAA_DIR . 'includes/Library.php';
    }
    if ( method_exists('\AIAssistantTenWeb\Library', 'popup_template') ) {
      \AIAssistantTenWeb\Library::popup_template();
    }
    if ( isset($_GET['taa_intro']) ) {
      \AIAssistantTenWeb\Library::tooltip_onboarding();
    }

    if ( method_exists('\AIAssistantTenWeb\Library', 'ai_button') ) {
      ?>
      <script id="gutenberg-twai-button" type="text/html">
        <?php
        \AIAssistantTenWeb\Library::ai_button();
        ?>
      </script>
      <?php
    }
  }
}
