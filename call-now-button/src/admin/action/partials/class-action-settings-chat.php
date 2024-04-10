<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\utils\CnbUtils;

class ActionSettingsChat {
    /**
     * @param CnbAction $action
     *
     * @return void
     */
    function render( $action ) {
	    wp_enqueue_script(CNB_SLUG . '-action-edit-chat');
        $this->render_header();
        $this->render_options( $action );
        $this->render_chat_options( $action );
        $this->render_close_header();
    }
    
    /**
     * NOTE: This function does NOT close its opened tags - that is done via "render_close_header"
     * @return void
     */
    function render_header() {
        ?>
        <section class="cnb-action-properties cnb-action-properties-CHAT cnb-settings-section cnb-settings-section-chat">
            <hr class="cnb-bottom-spacing" />
            <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                <div class="cnb-section-info cnb-top-spacing">
                    <h3 class="top-0">Chat settings</h3>
                </div>
                <div class="cnb-section-data cnb-top-spacing cnb-settings-section-table cnb-settings-section-chat">
        <?php
    }    

    /**
     * This function closes the tags opened in render_header
     * @return void
     */
    function render_close_header() {
        ?>          
            </section>
        <?php
    }

    /**
     * @param CnbAction $action
     *
     * @return void
     */
    function render_options( $action ) {
        ?>
            <div class="cnb-input-item cnb-action-properties cnb-action-properties-CHAT cnb-action-properties-chatmodal">
                <label for="actionChatmodalWelcomeMessage">Welcome message</label>
                <textarea id="actionChatmodalWelcomeMessage" rows="3"
                                name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chatmodal-welcome-message]"
                                placeholder="How can we help?"><?php if ( isset( $action->properties ) && isset( $action->properties->{'chatmodal-welcome-message'} ) ) {
                                echo esc_textarea( $action->properties->{'chatmodal-welcome-message'} );
                            } ?></textarea>
                <p class="description">Start a new line by pressing the <code>Enter</code> key. Every line will
                            become its own speech bubble. Speech bubbles appear in sequence with a short pause between them.
                        </p>
            </div>

            <div class="cnb-input-item cnb-action-properties cnb-action-properties-CHAT cnb-action-properties-chatmodal-modal">
                <label for="actionChatmodalPlaceholderMessage">Placeholder visitor input</label>
                <input id="actionChatmodalPlaceholderMessage" type="text"
                           name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chatmodal-placeholder-message]"
                           value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'chatmodal-placeholder-message'} ) ) {
                               echo esc_attr( $action->properties->{'chatmodal-placeholder-message'} );
                           } ?>" placeholder="Type your message"/>
            </div>
        <?php
    }

        /**
         * @param CnbAction $action
         *
         * @return void
         */
        function render_chat_options( $action ) {
        ?>
        
        
            <div class="cnb-input-item cnb-action-properties cnb-action-properties-CHAT">
                <label for="cnb-action-properties-chat-agent-message">Average response time</label>
                <input placeholder="Optional" id="cnb-action-properties-chat-agent-message"
                        name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-agent-message]" type="text"
                        value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'chat-agent-message'} ) ) {
                            echo esc_attr( $action->properties->{'chat-agent-message'} );
                        } ?>"/>
                <p class="description">Inform your users about your average response times.</p>    
            </div>

            <div class="cnb-input-item">
                <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                    <label for="cnb-enable-legal">Require legal consent</label>
                    <?php
                    $chat_legal_enabled = isset( $action->properties->{'chat-legal-enabled'} )
                        ? $action->properties->{'chat-legal-enabled'} === 'true'
                        : false;
                    ?>
                    <input type="hidden"
                            name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-enabled]"
                            value=""/>
                    <input id="cnb-action-chat-legal-enabled" class="cnb_toggle_checkbox" type="checkbox"
                            name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-enabled]"
                            value="true" <?php checked( true, $chat_legal_enabled ); ?>>
                    <label for="cnb-action-chat-legal-enabled" class="cnb_toggle_label">Toggle</label>
                </div>
            </div>
        </div><!-- close .cnb-section-data -->
    </div><!-- close .cnb-flex -->
    <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap cnb-chat-legal-input cnb-full-width" style="display:none;">
        <div class="cnb-section-info">
            <h3 class="top-0">Legal settings</h3>
            <p class="description">Here you can add your legal consent message if you require this.</p>
            <p class="description">Any links can be inserted via tokens. Use the <em>Add link token</em> button to create them.</p>
        </div>
        <div class="cnb-section-data">           

            <div class="cnb-input-item cnb-relative">
                <label for="cnb_legal_notice">Legal consent message</label>
                <?php
                $legal_notice = 'I agree to the {link1}, {link2} and {link3} of COMPANY.';
                if ( isset( $action->properties->{'chat-legal-notice'} ) ) {
                    $legal_notice = $action->properties->{'chat-legal-notice'};
                }
                ?>
                <textarea
                    id="cnb_legal_consent_message"
                    rows="3"
                    name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-notice]"
                        placeholder="How can we help?"><?php  echo esc_textarea( $legal_notice ); ?></textarea>
                <div id="cnb-Tooltip" style="display:none">Token added!</div>
            </div>
        </div>
    </div>

    <div class="cnb-chat-legal-input cnb-full-width" style="display:none;">
        <div class="cnb-section-data cnb-relative">            
            <div id="cnb-legal-link01" class="cnb-input-item " style="display: none;">
                <div class="cnb-flex cnb-flex-gap">
                    <textarea rows="1" cols="6" class="cnb-legal-token code" readonly>{link1}</textarea>
                    <input placeholder="Page name"
                        id="cnb-action-properties-chat-legal-link1-text"
                        type="text"
                        name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-link1-text]"
                        value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'chat-legal-link1-text'} ) ) {
                            echo esc_attr( $action->properties->{'chat-legal-link1-text'} );
                        } ?>"/>
                    <input placeholder="Page URL"
                        id="cnb-action-properties-chat-legal-link1-link"
                        type="url"
                        name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-link1-link]"
                        value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'chat-legal-link1-link'} ) ) {
                            echo esc_attr( $action->properties->{'chat-legal-link1-link'} );
                        } ?>"/>
                </div>            
            </div>
            <div id="cnb-legal-link02" class="cnb-input-item " style="display: none;">                
                <div class="cnb-flex cnb-flex-gap">
                    <textarea rows="1" class="cnb-legal-token code" readonly>{link2}</textarea>
                    <input placeholder="Page name"
                        id="cnb-action-properties-chat-legal-link2-text"
                        type="text"
                        name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-link2-text]"
                        value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'chat-legal-link2-text'} ) ) {
                            echo esc_attr( $action->properties->{'chat-legal-link2-text'} );
                        } ?>"/>
                    <input placeholder="Page URL"
                        id="cnb-action-properties-chat-legal-link2-link"
                        type="url"
                        name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-link2-link]"
                        value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'chat-legal-link2-link'} ) ) {
                            echo esc_attr( $action->properties->{'chat-legal-link2-link'} );
                        } ?>"/>
                </div>            
            </div>

            <div id="cnb-legal-link03" class="cnb-input-item " style="display: none;">                
                <div class="cnb-flex cnb-flex-gap">
                    <textarea rows="1" class="cnb-legal-token code" readonly>{link3}</textarea>
                    <input placeholder="Page name"
                        id="cnb-action-properties-chat-legal-link3-text"
                        type="text"
                        name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-link3-text]"
                        value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'chat-legal-link3-text'} ) ) {
                            echo esc_attr( $action->properties->{'chat-legal-link3-text'} );
                        } ?>"/>
                    <input placeholder="Page URL"
                        id="cnb-action-properties-chat-legal-link3-link"
                        type="url"
                        name="actions[<?php echo esc_attr( $action->id ) ?>][properties][chat-legal-link3-link]"
                        value="<?php if ( isset( $action->properties ) && isset( $action->properties->{'chat-legal-link3-link'} ) ) {
                            echo esc_attr( $action->properties->{'chat-legal-link3-link'} );
                        } ?>"/>
                </div>            
            </div>

            <div class="cnb-input-item cnb_align_right">
                <div id="toggleButton" class="button-secondary button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="heroicon w-5 h-5"><path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" /></svg> Add link token
                </div>
            </div>
        </div>
    </div>       
    <?php
    }
}
