<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class ActionSettingsMap {

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
        ?>
        <section class="cnb-action-properties cnb-action-properties-MAP">
            <hr class="cnb-bottom-spacing" /> 
            <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
                <div class="cnb-section-info cnb-top-spacing">
                    <h3 class="top-0">Button settings</h3>
                </div>
                <div class="cnb-section-data cnb-top-spacing">

                    <div class="cnb-input-item">
                        <label for="actionMapQueryTypeSelect">Map display</label>
                        <?php $action_map_query_type = isset( $action->properties ) && isset( $action->properties->{'map-query-type'} ) ? $action->properties->{'map-query-type'} : null; ?>
                        <select id="actionMapQueryTypeSelect"
                                name="actions[<?php echo esc_attr( $action->id ) ?>][properties][map-query-type]">
                            <option value="q" <?php selected( 'q', $action_map_query_type ) ?>>Show location</option>
                            <option value="daddr" <?php selected( 'daddr', $action_map_query_type ) ?>>Show travel
                                directions
                            </option>
                        </select>
                    </div>
                </div><!-- END .cnb-section-data -->
            </div><!-- END .cnb-flex -->
        </section>
        <?php
    }
}
