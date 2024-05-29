<?php

namespace AA_SEO_Pack_TenWeb;

class Library {
  public static function simple_ai_button(){
    static $cache = null;
    if ( $cache === NULL ) {
      $cache = TRUE;
    }
    else {
      return;
    }
    ?>
      <script id="twai-simple-button-template" type="text/html">
          <div class="twai-button-cont twai-simple-button-cont twai-inline">
              <button type="button"
                      class="button button-primary button-large twai-button twai-simple-button twai-button-disabled twai-button-green">
                  <span class="twai-button-text"></span>
                  <div class="twai-loader"></div>
                  <div class="twai-empty twai-tooltip taa-hidden">
                    <p><?php echo esc_html__( 'To fix with 10Web AI you need to:', 'ai-assistant-tenweb' ); ?></p>
                    <ul>
                      <li id="twai_keyphrase" class="taa-hidden"><?php echo sprintf( __('Add %s', 'ai-assistant-tenweb' ), '<a data-scrollto="#focus-keyword-input-metabox">' . __('Focus keyphrase', 'ai-assistant-tenweb') . '</a>' ); ?></li>
                      <li id="twai_title" class="taa-hidden"><?php echo sprintf( __('Add %s', 'ai-assistant-tenweb' ), '<a data-scrollto="#yoast-google-preview-title-metabox">' . __('SEO Title', 'ai-assistant-tenweb') . '</a>' ); ?></li>
                      <li id="twai_subheadings" class="taa-hidden"><?php echo sprintf( __('Add %s in your text (h2,h3)', 'ai-assistant-tenweb' ), '<a data-scrollto="block">' . __('subheadings', 'ai-assistant-tenweb') . '</a>' ); ?></li>
                      <li id="twai_text" class="taa-hidden"><?php echo sprintf( __('Add %s', 'ai-assistant-tenweb' ), '<a data-scrollto="#yoast-google-preview-description-metabox">' . __('Meta description', 'ai-assistant-tenweb') . '</a>' ); ?></li>
                      <li id="twai_intro" class="taa-hidden"><?php echo sprintf( __('Add %s', 'ai-assistant-tenweb' ), '<a data-scrollto="block">' . __('Intro', 'ai-assistant-tenweb') . '</a>' ); ?></li>
                      <li id="twai_short_keyphrase" class="taa-hidden"><?php echo sprintf( __('Short %s is required', 'ai-assistant-tenweb' ), '<a data-scrollto="#focus-keyword-input-metabox">' . __('Keyphrase', 'ai-assistant-tenweb') . '</a>' ); ?></li>
                    </ul>
                  </div>
              </button>
          </div>
      </script>
    <?php
  }
}