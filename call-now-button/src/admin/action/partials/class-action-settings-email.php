<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\utils\CnbUtils;

class ActionSettingsEmail {

    /**
     * @param CnbAction $action
     *
     * @return void
     */
    function render( $action ) {
        $cnb_utils = new CnbUtils();

        ?>
            <section class="cnb-action-properties cnb-action-properties-EMAIL cnb-settings-section cnb-settings-section-email">
                <hr class="cnb-bottom-spacing" /> 
                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                    <div class="cnb-section-info">
                        <h3 class="top-0">Email settings</h3>
                        <p class="description">All email fields are optional.</p>
                        <p class="description">It can be used to preset information in the visitor's email client.</p>
                    </div>
                    <div class="cnb-section-data">
                        <div class="cnb-input-item">
                            <label for="action-properties-subject">Subject</label>
                            <input placeholder="Optional" id="action-properties-subject"
                                   name="actions[<?php echo esc_attr( $action->id ) ?>][properties][subject]"
                                   type="text"
                                   value="<?php if ( isset( $action->properties ) && isset( $action->properties->subject ) ) {
                                       echo esc_attr( $action->properties->subject );
                                   } ?>"/>
                        </div>
                        <div class="cnb-input-item">
                            <label for="action-properties-body">
                                Message template 
                                <a
                                        href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress/buttons/message-template/', 'question-mark', 'message-template' ) ) ?>"
                                        target="_blank" class="cnb-nounderscore">
                                    <span class="dashicons dashicons-editor-help"></span></a>
                            </label>
                            <textarea placeholder="Optional" id="action-properties-body"
                                      name="actions[<?php echo esc_attr( $action->id ) ?>][properties][body]"
                                      class="large-text code"
                                      rows="3"><?php if ( isset( $action->properties ) && isset( $action->properties->body ) ) {
                                    echo esc_textarea( $action->properties->body );
                                } ?></textarea>
                        </div>
                        <div class="cnb-input-item">
                            <label for="action-properties-cc">CC</label>
                            <input placeholder="Optional" id="action-properties-cc"
                                   name="actions[<?php echo esc_attr( $action->id ) ?>][properties][cc]" type="text"
                                   value="<?php if ( isset( $action->properties ) && isset( $action->properties->cc ) ) {
                                       echo esc_attr( $action->properties->cc );
                                   } ?>"/>
                        </div>
                        <div class="cnb-input-item">
                            <label for="action-properties-bcc">BCC</label>
                            <input placeholder="Optional" id="action-properties-bcc"
                                   name="actions[<?php echo esc_attr( $action->id ) ?>][properties][bcc]" type="text"
                                   value="<?php if ( isset( $action->properties ) && isset( $action->properties->bcc ) ) {
                                       echo esc_attr( $action->properties->bcc );
                                   } ?>"/>
                        </div>
                    </div>
                </div>
            </section>
        <?php
    }
}
