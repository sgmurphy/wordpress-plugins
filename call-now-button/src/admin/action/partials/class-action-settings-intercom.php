<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class ActionSettingsIntercom {
    /**
     * @param CnbAction $action
     *
     * @return void
     */
    function render( $action ) {
        $this->render_options( $action );
    }

    /**
     * @param CnbAction $action
     *
     * @return void
     */
    function render_options( $action ) {
        $alignment          = '';
        $horizontal_padding = 0;
        $vertical_padding   = 0;

        if ( isset( $action->properties ) && isset( $action->properties->{'intercom-alignment'} ) ) {
            $alignment = $action->properties->{'intercom-alignment'};
        }
        if ( isset( $action->properties ) && isset( $action->properties->{'intercom-horizontal-padding'} ) ) {
            $horizontal_padding = $action->properties->{'intercom-horizontal-padding'};
        }
        if ( isset( $action->properties ) && isset( $action->properties->{'intercom-vertical-padding'} ) ) {
            $vertical_padding = $action->properties->{'intercom-vertical-padding'};
        }
        ?>
        <section class="cnb-action-properties cnb-action-properties-INTERCOM">
            <hr class="cnb-bottom-spacing" /> 
            <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                <div class="cnb-section-info">
                    <h3 class="top-0">Intercom settings</h3>
                </div>
                <div class="cnb-section-data">
                    <div class="cnb-input-item">
                        <select id="cnb-action-properties-intercom-alignment"
                                name="actions[<?php echo esc_attr( $action->id ) ?>][properties][intercom-alignment]">
                            <option value="right" <?php selected( $alignment, 'right' ); ?>>
                                Right side
                            </option>
                            <option value="left" <?php selected( $alignment, 'left' ); ?>>
                                Left side
                            </option>
                        </select>
                    </div>
                    
                    <div class="cnb-input-item cnb-action-properties cnb-action-properties-INTERCOM cnb_advanced_view">
                        <label for="cnb-action-properties-intercom-horizontal-padding">Horizontal padding</label>
                        <input placeholder="Optional" id="cnb-action-properties-intercom-horizontal-padding"
                            name="actions[<?php echo esc_attr( $action->id ) ?>][properties][intercom-horizontal-padding]"
                            type="number" min="0"
                            value="<?php echo esc_attr( $horizontal_padding ) ?>"/>
                        <p class="description">Horizontal padding (in whole numbers (<code>px</code>), defaults to
                            <code>0</code>.</p>
                    </div>


                    <div class="cnb-input-item cnb-action-properties cnb-action-properties-INTERCOM cnb_advanced_view">
                        <label for="cnb-action-properties-intercom-vertical-padding">Vertical padding</label>
                        <input placeholder="Optional" id="cnb-action-properties-intercom-vertical-padding"
                            name="actions[<?php echo esc_attr( $action->id ) ?>][properties][intercom-vertical-padding]"
                            type="number" min="0"
                            value="<?php echo esc_attr( $vertical_padding ) ?>"/>
                        <p class="description">Vertical padding (in whole numbers (<code>px</code>)), defaults to <code>0</code>.
                        </p>
                    </div>
                </div><!-- END .cnb-section-data -->
            </div><!-- END .cnb-flex -->
        </section>
        <?php
    }
}
