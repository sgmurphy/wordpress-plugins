<?php
/** @noinspection SpellCheckingInspection */

namespace cnb\admin\button;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\action\CnbAction;
use cnb\admin\action\CnbActionView;
use cnb\admin\action\CnbActionViewEdit;
use cnb\admin\condition\CnbConditionView;
use cnb\admin\domain\CnbDomain;
use cnb\utils\CnbUtils;

class Button_Edit_Table {

    /**
     * @param CnbButton $button
     * @param CnbDomain $default_domain
     *
     * @return void
     */
    function render_tab_basic_options( $button, $default_domain ) {
        global $cnb_domains;

        $url             = admin_url( 'admin.php' );
        $new_action_link =
            add_query_arg(
                array(
                    'page'   => 'call-now-button-actions',
                    'action' => 'new',
                    'id'     => 'new',
                    'tabName'    => 'basic_options',
                    'tabGroup' => 'buttons',
                    'bid'    => $button->id
                ),
                $url );

        $upgrade_link =
            add_query_arg( array(
                'page'   => 'call-now-button-domains',
                'action' => 'upgrade',
                'id'     => $default_domain->id
            ),
                $url );

	    $action = $this->get_action( $button );
        ?>
            <section class="form-table" data-tab-name="basic_options" data-tab-group="buttons">
                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                    <div class="cnb-section-info cnb-top-spacing">
                        <h3 class="top-0">Button settings</h3>
                    </div>
                    <div class="cnb-section-data cnb-top-spacing">
                        <div class="cnb-input-item">
                            <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">                    
                                <input type="hidden" name="button[active]" value="0"/>
                                <input id="cnb-enable" class="cnb_toggle_checkbox" type="checkbox" name="button[active]"
                                    value="1" <?php checked( true, $button->active ); ?> />
                                <label for="cnb-enable" class="cnb_toggle_label">Toggle</label>
                                <span data-cnb_toggle_state_label="cnb-enable"
                                    class="cnb_toggle_state cnb_toggle_false">Published</span>
                                <span data-cnb_toggle_state_label="cnb-enable"
                                    class="cnb_toggle_state cnb_toggle_true">Published</span>
                            </div>
                        </div><!-- END .cnb-input-item -->
                        <div class="cnb-input-item cnb_button_name">
                            <label for="button_name">Name</label>
                            <input type="text" name="button[name]" id="button_name" required="required"
                                    value="<?php echo esc_attr( $button->name ); ?>" placeholder="My new button"/>
                        </div><!-- END .cnb-input-item -->

                        <div class="cnb-input-item cnb_advanced_view">
                            <label for="button_domain">Domain</label>
                            <select name="button[domain]" id="button_domain">
                                <?php
                                // In case the domain list fails, fall back to just the current domain
                                if (! $cnb_domains || is_wp_error( $cnb_domains ) && $default_domain && is_wp_error( $default_domain ) ) { ?>
                                    <option
                                        value="<?php echo esc_attr( $default_domain->id ) ?>">
                                        <?php echo esc_html( $default_domain->name ) ?>
                                        (current WordPress domain)
                                    </option>
                                <?php }
                                if ( is_array( $cnb_domains ) ) {
                                foreach ( $cnb_domains as $domain ) { ?>
                                    <option
                                        <?php selected( $domain->id, $button->domain->id ) ?>
                                            value="<?php echo esc_attr( $domain->id ) ?>">
                                        <?php echo esc_html( $domain->name ) ?>
                                        <?php if ( $domain->id == $default_domain->id ) {
                                            echo ' (current WordPress domain)';
                                        } ?>
                                    </option>
                                <?php } } ?>
                            </select>
                        </div><!-- END .cnb-input-item -->
                    </div><!-- END .cnb-section-data -->
                </div><!-- END .cnb-flex -->

        <?php if ( $button->type !== 'SINGLE' ) { ?>
            <section class="form-table">
                <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                    <div class="cnb-section-info cnb-top-spacing">
                        <h3 class="top-0">Button actions</h3>
                        <?php
                            if ($default_domain->type === 'STARTER' && $button->type === 'FULL' && count($button->actions)) {
                                echo '<p class="description" style="font-weight:400;">
                                    Add up to 5 actions to a single Buttonbar with <span class="cnb-pro-badge">Pro</span>. <a href="' . esc_url( $upgrade_link ) . '">Upgrade</a>
                                </p>';
                            }
                            ?>
                    </div><!-- END .cnb-section-info -->
                    <div class="cnb-section-data cnb-top-spacing">

                        <div class="cnb-input-item">
                            <?php
                                if ($default_domain->type === 'STARTER' && $button->type === 'FULL' && count($button->actions)) {
                                    echo '<a href="#" class="page-title-action button-disabled" title="Upgrade to PRO to add more actions">Add Action</a>';
                                } else {
                                    echo '<a href="' . esc_url( $new_action_link ) . '" class="page-title-action">Add Action</a>';
                                }
                                ?>
                        </div><!-- END .cnb-input-item -->

                    </div><!-- END .cnb-section-data -->
                </div><!-- END .cnb-flex -->
            </section>
        <?php } // $button->type !== 'SINGLE'

        if ( $button->type === 'SINGLE' ) {
	        ( new CnbActionViewEdit() )->render_tab_action_options( $action, $button, $default_domain );
            if ($action->id !== 'new') {
             ?>
                <input type="hidden" name="actions[<?php echo esc_attr( $action->id ) ?>][id]" value="<?php echo esc_attr( $action->id ) ?>"/>
            <?php
            }
        } // $button->type === 'SINGLE'

        if ( $button->type !== 'SINGLE' ) { ?>
            <section class="cnb-button-edit-action-table">
            <?php ( new CnbActionView() )->renderTable( $button ); ?>
            </section>
        <?php } // $button->type !== 'SINGLE' ?>

        <script>
            let cnb_actions = <?php echo wp_json_encode( $button->actions ) ?>;
            let cnb_domain = <?php echo wp_json_encode( $button->domain ) ?>;
        </script>
        </section>
        <?php
    } // function render_tab_basic_options()

    /**
     * @param $button CnbButton
     *
     * @return void
     */
    function render_tab_presentation( $button ) {
        $cnb_utils      = new CnbUtils();
        $action         = $this->get_action( $button );

        // For the image selector
        wp_enqueue_media();

        $upgrade_link =
            add_query_arg( array(
                'page'   => 'call-now-button-domains',
                'action' => 'upgrade',
                'id'     => $button->domain->id
            ),
                admin_url( 'admin.php' ) );

        ?>
        <section class="form-table" data-tab-name="presentation" data-tab-group="buttons">
            <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                <div class="cnb-section-info cnb-top-spacing">
                    <h3 class="top-0">Color & style</h3>
                </div>
                <div class="cnb-section-data cnb-top-spacing">

            <?php if ( $button->type === 'FULL' ) { ?>

                <div class="cnb-input-item cnb_advanced_view">
                    <h2>Colors for the Buttonbar are defined via the individual Action(s).</h2>
                    <input name="button[options][iconBackgroundColor]" type="hidden"
                            value="<?php echo esc_attr( $button->options->iconBackgroundColor ); ?>"/>
                    <input name="button[options][iconColor]" type="hidden"
                            value="<?php echo esc_attr( $button->options->iconColor ); ?>"/>
                </div><!-- END .cnb-input-item -->

                
            <?php } else if ( $button->type === 'SINGLE' ) {
                // Migration note:
                //- we move from button.options.iconBackgroundColor to action.backgroundColor
                //- we move from button.options.iconColor to action.iconColor
                // So for now, "button" take priority, but once the new value is saved, we blank the button options
                $backgroundColor = ( $button && $button->options && $button->options->iconBackgroundColor ) ? $button->options->iconBackgroundColor : ( $action->backgroundColor ?: '#009900' );
                $iconColor       = ( $button && $button->options && $button->options->iconColor ) ? $button->options->iconColor : ( $action->iconColor ?: '#FFFFFF' );
                ?>

                
                <div class="cnb-input-item">
                    <input name="button[options][iconBackgroundColor]" type="hidden" value=""/>
                    <input name="button[options][iconColor]" type="hidden" value=""/>
                    <!-- We always enable the icon when the type if SINGLE, original value is "<?php echo esc_attr( $action->iconEnabled ) ?>" -->
                    <input name="actions[<?php echo esc_attr( $action->id ) ?>][iconEnabled]" type="hidden"
                               value="1"/>
                </div><!-- END .cnb-input-item -->
                
                <div class="cnb-input-item">
                    <label for="actions-options-iconBackgroundColor">Button color</label>
                    <input name="actions[<?php echo esc_attr( $action->id ) ?>][backgroundColor]"
                        id="actions-options-iconBackgroundColor" type="text"
                        value="<?php echo esc_attr( $backgroundColor ); ?>" class="cnb-color-field"
                        data-default-color="#009900"/>
                </div><!-- END .cnb-input-item -->
                
                <div class="cnb-input-item">
                    <label for="actions-options-iconColor">Icon color</label>
                    <input name="actions[<?php echo esc_attr( $action->id ) ?>][iconColor]"
                        id="actions-options-iconColor" type="text"
                        value="<?php echo esc_attr( $iconColor ); ?>" class="cnb-color-field"
                        data-default-color="#FFFFFF"/>
                </div><!-- END .cnb-input-item -->

            <?php } else if ( $button->type === 'MULTI' ) {
                ?>

                <?php
                $icon_picker = new Button_Icon_Picker();
                $icon_picker->render($button);
                $label_editor = new Button_Label();
                $label_editor->render($button);
            } ?>
                <div class="cnb-input-item appearance">
                    <label>Position</label>
                    <div class="appearance-options">
                        <div class="cnb-positions">
                            <?php if ( $button->type === 'FULL' ) { ?>
                                <div class="cnb-buttonbar cnb-small-screen cnb-block-radius cnb-block-shade">                            
                                        <label for="appearance1" class="cnb-radio-item">
                                            <input type="radio" id="appearance1" name="button[options][placement]"
                                                value="TOP_CENTER" <?php checked( 'TOP_CENTER', $button->options->placement ); ?>>
                                            <span class="checkmark"></span>
                                        </label>

                                        <label for="appearance2" class="cnb-radio-item">
                                            <input type="radio" id="appearance2" name="button[options][placement]"
                                                value="BOTTOM_CENTER" <?php checked( 'BOTTOM_CENTER', $button->options->placement ); ?>>
                                            <span class="checkmark"></span>
                                        </label>                
                                </div>
                            <?php } else { ?>
                                <div class="cnb-buttons cnb-small-screen cnb-block-radius cnb-block-shade">
                                    <label for="appearance8" class="cnb-radio-item">
                                        <input type="radio" id="appearance8" name="button[options][placement]"
                                        value="TOP_LEFT" <?php checked( 'TOP_LEFT', $button->options->placement ); ?>>
                                        <span class="checkmark"></span>
                                    </label>                                    
                                
                                    <label for="appearance9" class="cnb-radio-item">
                                        <input type="radio" id="appearance9" name="button[options][placement]"
                                        value="TOP_CENTER" <?php checked( 'TOP_CENTER', $button->options->placement ); ?>>
                                        <span class="checkmark"></span>
                                    </label>

                                    <label for="appearance7" class="cnb-radio-item">
                                        <input type="radio" id="appearance7" name="button[options][placement]"
                                        value="TOP_RIGHT" <?php checked( 'TOP_RIGHT', $button->options->placement ); ?>>
                                        <span class="checkmark"></span>
                                    </label>

                                    <label for="appearance6" class="cnb-middle-position cnb-radio-item">
                                        <input type="radio" id="appearance6" name="button[options][placement]"
                                            value="MIDDLE_LEFT" <?php checked( 'MIDDLE_LEFT', $button->options->placement ); ?>>
                                        <span class="checkmark"></span>
                                    </label>

                                    <span class="cnb-middle-position cnb-radio-item"></span>

                                    <label for="appearance5" class="cnb-middle-position cnb-radio-item">
                                        <input type="radio" id="appearance5" name="button[options][placement]"
                                            value="MIDDLE_RIGHT" <?php checked( 'MIDDLE_RIGHT', $button->options->placement ); ?>>
                                        <span class="checkmark"></span>
                                    </label>                                          

                                    <label for="appearance2" class="cnb-radio-item">
                                        <input type="radio" id="appearance2" name="button[options][placement]"
                                            value="BOTTOM_LEFT" <?php checked( 'BOTTOM_LEFT', $button->options->placement ); ?>>
                                        <span class="checkmark"></span>
                                    </label>        

                                    <label for="appearance3" class="cnb-radio-item">
                                        <input type="radio" id="appearance3" name="button[options][placement]"
                                        value="BOTTOM_CENTER" <?php checked( 'BOTTOM_CENTER', $button->options->placement ); ?>>
                                        <span class="checkmark"></span>
                                    </label>

                                    <label for="appearance1" class="cnb-radio-item">
                                        <input type="radio" id="appearance1" name="button[options][placement]"
                                            value="BOTTOM_RIGHT" <?php checked( 'BOTTOM_RIGHT', $button->options->placement ); ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>     
                            <?php } ?>
                        </div>
                    </div>
                </div><!-- END .cnb-input-item -->
            <?php if ( $button->type !== 'FULL' ) { ?>

                <div class="cnb-input-item">
                    <label for="button_options_animation">Button animation <?php if ( $button->domain->type !== 'STARTER' ) { ?><a
                                href="<?php echo esc_url( $cnb_utils->get_support_url( 'wordpress/buttons/button-animations/', 'question-mark', 'button-animation' ) ) ?>"
                                target="_blank" class="cnb-nounderscore">
                            <span class="dashicons dashicons-editor-help"></span>
                        </a><?php } ?>
                    </label>
                    <?php if ( $button->domain->type === 'STARTER' ) { ?>
                        <a href="<?php echo esc_url( $upgrade_link ) ?>"><span class="cnb-pro-badge">Pro</span></a>
                    <?php } ?>
                    <select
                        name="button[options][animation]"
                        id="button_options_animation"
                        <?php if ( $button->domain->type === 'STARTER' ) { ?>disabled="disabled"<?php } ?>
                    >
                        <?php foreach ( CnbButtonOptions::getAnimationTypes() as $animation_type_key => $animation_type_value ) {?>
                            <option value="<?php echo esc_attr( $animation_type_key ) ?>"<?php selected( $animation_type_key, $button->options->animation ) ?>><?php echo esc_html( $animation_type_value ) ?></option>
                        <?php } ?>
                    </select>
                </div><!-- END .cnb-input-item -->
                
            <?php } ?>

                <div class="cnb-input-item cnb_advanced_view">
                    <label for="button_options_css_classes">CSS Classes</label>
                    <?php if ( $button->domain->type !== 'PRO' ) { ?>
                        <a href="<?php echo esc_url( $upgrade_link ) ?>"><span class="cnb-pro-badge">Pro</span></a>
			        <?php } ?>
                    <input
                        name="button[options][cssClasses]"
                        id="button_options_css_classes"
                        type="text" <?php if ( $button->domain->type !== 'PRO' ) { ?>disabled="disabled"<?php } ?>
                        value="<?php echo esc_attr($button->options->cssClasses) ?>" />
                </div><!-- END .cnb-input-item -->
            </div><!-- END .cnb-section-data -->
        </div><!-- END .cnb-flex -->
    </section>
        <?php
    }

    function render_tab_visibility( $button ) {
        $url                = admin_url( 'admin.php' );
        $new_condition_link =
            add_query_arg(
                array(
                    'page'   => 'call-now-button-conditions',
                    'action' => 'new',
                    'id'     => 'new',
                    'bid'    => $button->id
                ),
                $url );

        ?>
        <section class="form-table" data-tab-name="visibility" data-tab-group="buttons">
                    <div id="cnb_form_table_visibility">
                        <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                            <div class="cnb-section-info cnb-top-spacing">
                                <h3 class="top-0">Visibility settings</h3>
                            </div>
                            <div class="cnb-section-data cnb-top-spacing">

                                <div class="cnb-input-item appearance">
                                    <label for="button_options_displaymode">Display on </label>
                                    <select name="button[options][displayMode]" id="button_options_displaymode">
                                        <option value="MOBILE_ONLY"<?php selected( 'MOBILE_ONLY', $button->options->displayMode ) ?>>
                                            Mobile only
                                        </option>
                                        <option value="DESKTOP_ONLY"<?php selected( 'DESKTOP_ONLY', $button->options->displayMode ) ?>>
                                            Desktop only
                                        </option>
                                        <option value="ALWAYS"<?php selected( 'ALWAYS', $button->options->displayMode ) ?>>All
                                            screens
                                        </option>
                                    </select>
                                </div>
            
                        <?php $this->render_scroll_options( $button ); ?>
                            </div><!-- END .cnb-section-data -->
                        </div><!-- END .cnb-flex -->
                        <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                            <div class="cnb-section-info cnb-top-spacing">
                                <h3 class="top-0">Display rules</h3>
                            </div>
                            <div class="cnb-section-data cnb-top-spacing">

                                <div class="cnb-input-item">
                                    <?php echo '<a href="' . esc_url( $new_condition_link ) . '" class="button">Add display rule</a>'; ?>
                                </div>
                            </div><!-- END .cnb-section-data -->
                        </div><!-- END .cnb-flex -->
                    </div><!-- END .cnb_form_table_visibility -->
            <?php (new CnbConditionView())->renderTable( $button ) ?>
            </section>
        <?php
    }

    function render_tab_scheduler( $button, $domain ) {
	    $action = $this->get_action( $button );
	    ( new CnbActionViewEdit() )->render_tab_scheduler( $action, $button, $domain, 'buttons' );
    }

    /**
     * @param $button CnbButton
     *
     * @return void
     */
    private function render_scroll_options( $button ) {
        global $cnb_domain;
        $isPro = $cnb_domain != null && ! is_wp_error( $cnb_domain ) && $cnb_domain->type === 'PRO';
        ?>

        <?php $reveal_at_height = $button->options->scroll ? $button->options->scroll->revealAtHeight : 0 ?>
        <div class="cnb-input-item">
            <label for="cnb-button-options-scroll-revealatheight">Reveal after scrolling</label>
                <?php if ( ! $isPro ) {
                    $upgrade_link =
                        add_query_arg( array(
                            'page'   => 'call-now-button-domains',
                            'action' => 'upgrade',
                            'id'     => $cnb_domain->id
                        ),
                            admin_url( 'admin.php' ) );
                    ?>
                    <a href="<?php echo esc_url( $upgrade_link ) ?>"><span class="cnb-pro-badge">Pro</span></a></th>
                    <?php } ?>
            <input
                name="button[options][scroll][revealAtHeight]"
                id="cnb-button-options-scroll-revealatheight"
                type="number"
                min="0"
                <?php if ( ! $isPro ) { ?>disabled="disabled"<?php } ?>
                style="width: 80px"
                value="<?php echo esc_attr( $reveal_at_height ) ?>"> pixels from the top
        </div><!-- END .cnb-input-item -->

        <?php $hide_at_height = $button->options->scroll ? $button->options->scroll->hideAtHeight : 0 ?>
        <div class="cnb-input-item cnb_advanced_view">
            <label for="cnb-button-options-scroll-hideAtHeight">Hide after scrolling</label>
            <input name="button[options][scroll][hideAtHeight]" id="cnb-button-options-scroll-hideAtHeight"
                    type="number" min="0" style="width: 80px" value="<?php echo esc_attr( $hide_at_height ) ?>">
            pixels from the top
            <p class="description">hideAtHeight</p>
        </div><!-- END .cnb-input-item -->

        
        <?php $never_hide = $button->options->scroll ? $button->options->scroll->neverHide : false ?>
        <div class="cnb-input-item cnb_advanced_view">
            <div class="cnb-flex cnb-flex-gap cnb-flex-align-center">
                <label for="cnb-button-options-scroll-neverhide">Never hide</label>
                <input type="hidden" name="button[options][scroll][neverHide]" value="0"/>
                <input id="cnb-button-options-scroll-neverhide" class="cnb_toggle_checkbox" type="checkbox"
                        name="button[options][scroll][neverHide]"
                        value="1" <?php checked( true, $never_hide ); ?> />
                <label for="cnb-button-options-scroll-neverhide" class="cnb_toggle_label">Toggle</label>
            </div>
            <p class="description">Once this Button is revealed, it will not be hidden again.</p>
        </div><!-- END .cnb-input-item -->
        <?php
    }

    /**
     * @param $button CnbButton
     *
     * @return CnbAction
     */
    private function get_action( $button ) {
	    // If there is a real one, use that one
	    if ( sizeof( $button->actions ) > 0 ) {
		    return $button->actions[0];
	    }

        // If not found, return whatever the current default is
	    return CnbAction::getDefaultAction();
    }
}
