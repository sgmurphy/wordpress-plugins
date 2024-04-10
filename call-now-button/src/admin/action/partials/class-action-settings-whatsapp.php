<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\button\CnbButton;
use cnb\utils\CnbUtils;

class ActionSettingsWhatsapp {
    /**
     * @param CnbAction $action
     * @param CnbButton $button
     *
     * @return void
     */
    function render( $action, $button ) {
        $this->render_header();
        $this->render_options( $action, $button );
        $this->render_close_header();
    }

    /**
     * NOTE: This function does NOT close its opened tags - that is done via "render_close_header"
     * @return void
     */
    function render_header() {
        ?>
            </div><!-- END .cnb-section-data -->
        </div><!-- END .cnb-flex -->
            
        <section class="cnb-action-properties cnb-action-properties-WHATSAPP">
            <hr class="cnb-bottom-spacing" />
            <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                <div class="cnb-section-info">
                    <h3 class="top-0">WhatsApp settings</h3>
                    <p class="description">These options give you extra control over WhatsApp.</p>
                    <p class="description">The widget allows you to start the converation on the website before opening the WhatsApp application.</p>
                </div>
                <div class="cnb-section-data">
        <?php
    }

    /**
     * This function closes the tags opened in render_header
     * @return void
     */
    function render_close_header() {
        ?>
                    </div><!-- END .cnb-section-data -->
                </div><!-- END .cnb-flex -->
            </section>
        <?php
    }

    /**
     * @param CnbAction $action
     * @param CnbButton $button
     *
     * @return void
     */
    function render_options( $action, $button ) {
        $cnb_utils = new CnbUtils();

        $upgrade_link =
            add_query_arg( array(
                'page'   => 'call-now-button-domains',
                'action' => 'upgrade',
                'id'     => $button->domain->id
            ),
                admin_url( 'admin.php' ) );

        ?>

        <div class="cnb-input-item cnb-action-properties cnb-action-properties-WHATSAPP">
            <label for="action-properties-subject">Opens</label>
                <?php $value = isset( $action->properties ) && isset( $action->properties->{'whatsapp-dialog-type'} ) && $action->properties->{'whatsapp-dialog-type'} ? $action->properties->{'whatsapp-dialog-type'} : ''; ?>
                <select id="cnb-action-modal"                           
                        name="actions[<?php echo esc_attr( $action->id ) ?>][properties][whatsapp-dialog-type]">
                    <option value="" <?php selected( $value, '' ); ?>>WhatsApp app</option>
                    <option <?php if ( $button->domain->type === 'STARTER' ) { ?>disabled="disabled"<?php } ?> value="popout" <?php selected( $value, 'popout' ); ?>>WhatsApp widget
                    </option>
                </select>
                <?php if ( $button->domain->type === 'STARTER' ) { ?>
                    <p class="description">
                        WhatsApp chat widget is a <span class="cnb-pro-badge">Pro</span> feature.
                        <a href="<?php echo esc_url( $upgrade_link ) ?>">Upgrade</a>.
                    </p>

                <?php } ?>
        </div>
        <div id="action-properties-message-row" class="cnb-input-item cnb-action-properties cnb-action-properties-WHATSAPP">
            <label for="action-properties-message-whatsapp">
                Message template 
                <a
                    href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress/buttons/actions/message-template/', 'question-mark', 'message-template' ) ) ?>"
                    target="_blank" class="cnb-nounderscore">
                    <span class="dashicons dashicons-editor-help"></span>
                </a>
            </label>
            <textarea id="action-properties-message-whatsapp"
                              name="actions[<?php echo esc_attr( $action->id ) ?>][properties][message]" class="code"
                              rows="3"
                              placeholder="Optional"><?php if ( isset( $action->properties ) && isset( $action->properties->message ) ) {
                            echo esc_textarea( $action->properties->message );
                        } ?></textarea>
        </div>

        <div class="cnb-input-item cnb-action-properties cnb-action-properties-WHATSAPP cnb-action-properties-whatsapp-modal">
            <label for="actionWhatsappTitle">Widget title</label>
            <input id="actionWhatsappTitle" type="text"
                           name="actions[<?php echo esc_attr( $action->id ) ?>][properties][whatsapp-title]"
                           value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'whatsapp-title'} ) ) {
                               echo esc_attr( $action->properties->{'whatsapp-title'} );
                           } ?>" maxlength="30" placeholder="Optional"/>
        </div>

        <div class="cnb-input-item cnb-action-properties cnb-action-properties-WHATSAPP cnb-action-properties-whatsapp-modal">
            <label for="actionWhatsappWelcomeMessage">Welcome message</label>
            <textarea id="actionWhatsappWelcomeMessage" rows="3" placeholder="👋 How can we help?" name="actions[<?php echo esc_attr( $action->id ) ?>][properties][whatsapp-welcomeMessage]"><?php if ( isset( $action->properties ) && isset( $action->properties->{'whatsapp-welcomeMessage'} ) ) {
                            echo esc_textarea( $action->properties->{'whatsapp-welcomeMessage'} );
                        } else {
                            echo '👋 How can we help?';
                        } ?></textarea>
            <p class="description">Start a new line by pressing the <code>Enter</code> key. Every line will
                        become its own speech bubble. Speech bubbles appear in sequence with a short pause between them.</p>
        </div>

        <div class="cnb-flex cnb-flex-align-center cnb-flex-gap cnb-input-item cnb-action-properties cnb-action-properties-WHATSAPP cnb-action-properties-whatsapp-modal">
            <label for="cnb-action-show-notification-count">Show notification badge</label>
            <input type="hidden"
                           name="actions[<?php echo esc_attr( $action->id ) ?>][properties][show-notification-count]"
                           value=""/>
            <input id="cnb-action-show-notification-count" class="cnb_toggle_checkbox" type="checkbox"
                    name="actions[<?php echo esc_attr( $action->id ) ?>][properties][show-notification-count]"
                    value="true"
                <?php checked( true, isset( $action->properties ) && isset( $action->properties->{'show-notification-count'} ) && $action->properties->{'show-notification-count'} ); ?> />
            <label for="cnb-action-show-notification-count" class="cnb_toggle_label">Toggle</label>
            
        </div>

        <div class="cnb-input-item cnb-action-properties cnb-action-properties-WHATSAPP cnb-action-properties-whatsapp-modal">
            <label for="actionWhatsappPlaceholderMessage">Placeholder visitor input</label>
            <input id="actionWhatsappPlaceholderMessage" type="text"
                           name="actions[<?php echo esc_attr( $action->id ) ?>][properties][whatsapp-placeholderMessage]"
                           value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'whatsapp-placeholderMessage'} ) ) {
                               echo esc_attr( $action->properties->{'whatsapp-placeholderMessage'} );
                           } ?>" placeholder="Type your message"/>
        </div>
        <?php
    }
}
