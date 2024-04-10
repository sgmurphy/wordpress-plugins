<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class ActionSettingsTally {
    /**
     * @param CnbAction $action
     *
     * @return void
     */
    function render( $action ) {
        $this->render_header();
        $this->render_options( $action );
        $this->render_close_header();
    }

    /**
     * NOTE: This function does NOT close its opened tags - that is done via "render_close_header"
     * @return void
     */
    function render_header() { ?>
        <section class="cnb-action-properties cnb-action-properties-TALLY cnb-settings-section cnb-settings-section-tally">
            <hr class="cnb-bottom-spacing" /> 
            <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                <div class="cnb-section-info">
                    <h3 class="top-0">Tally settings</h3>
                    <p class="description">Change the presentation of the Tally form inside your window.</p>
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
                    </div>
                </div>
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


        <div class="cnb-input-item cnb-action-properties cnb-action-properties-TALLY">
            <label for="cnb-action-properties-tally-hide-title">Form title</label>
            <?php
            $value = '1';
            if ( isset( $action->properties ) && isset( $action->properties->{'tally-hide-title'} ) ) {
                $value = $action->properties->{'tally-hide-title'};
            }
            ?>
            <select id="cnb-action-properties-tally-hide-title"
                    name="actions[<?php echo esc_attr( $action->id ) ?>][properties][tally-hide-title]">
                <option value="" <?php selected( $value, '' ); ?>>
                    Show
                </option>
                <option value="1" <?php selected( $value, '1' ); ?>>
                    Hide
                </option>
            </select>
        </div>

        <div class="cnb-input-item cnb-action-properties cnb-action-properties-TALLY cnb_advanced_view">
            <label for="cnb-action-properties-tally-transparent-background">Form background</label>
            <?php
            $value = '';
            if ( isset( $action->properties ) && isset( $action->properties->{'tally-transparent-background'} ) ) {
                $value = $action->properties->{'tally-transparent-background'};
            }
            ?>
            <select id="cnb-action-properties-tally-transparent-background"
                    name="actions[<?php echo esc_attr( $action->id ) ?>][properties][tally-transparent-background]">
                <option value="" <?php selected( $value, '' ); ?>>
                    Default background
                </option>
                <option value="1" <?php selected( $value, '1' ); ?>>
                    Transparent background (recommended)
                </option>
            </select>
        </div>

        <div class="cnb-input-item cnb-action-properties cnb-action-properties-TALLY">
            <label for="cnb-action-properties-tally-align-left">Content alignment</label>
            <?php
            $value = '1';
            if ( isset( $action->properties ) && isset( $action->properties->{'tally-align-left'} ) ) {
                $value = $action->properties->{'tally-align-left'};
            }
            ?>
            <select id="cnb-action-properties-tally-align-left"
                    name="actions[<?php echo esc_attr( $action->id ) ?>][properties][tally-align-left]">
                <option value="" <?php selected( $value, '' ); ?>>
                    Tally default
                </option>
                <option value="1" <?php selected( $value, '1' ); ?>>
                    Left
                </option>
            </select>
        </div> 
        <?php
    }
}
