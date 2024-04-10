<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class ActionSettingsLine {

	private $action_name = 'LINE';

	/**
	 * Options: MESSAGE or PROFILE
	 * @var string
	 */
	private $line_link_type = 'MESSAGE';

	/**
	 * Only valid for $line_link_type == MESSAGE
	 * @var string
	 */
	private $line_message = '';

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
		if ( isset( $action->properties ) && isset( $action->properties->{'line-link-type'} ) ) {
			$this->line_link_type = $action->properties->{'line-link-type'};
		}
		if ( isset( $action->properties ) && isset( $action->properties->{'line-message'} ) ) {
			$this->line_message = $action->properties->{'line-message'};
		}
        ?>
		<section class="cnb_advanced_view cnb-action-properties cnb-action-properties-<?php echo esc_attr($this->action_name) ?>">
			<hr class="cnb-bottom-spacing" /> 
			<div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
				<div class="cnb-section-info cnb-top-spacing">
					<h3 class="top-0">Line settings</h3>
				</div>
				<div class="cnb-section-data cnb-top-spacing">

					<div class="cnb-input-item">
						<label for="cnb-action-properties-line-link-type">Button type</label>
						<select id="cnb-action-properties-line-link-type"
								name="actions[<?php echo esc_attr( $action->id ) ?>][properties][line-link-type]">
							<option value="MESSAGE" <?php selected( $this->line_link_type, 'MESSAGE' ); ?>>
								Chat
							</option>
							<option value="PROFILE" <?php selected( $this->line_link_type, 'PROFILE' ); ?>>
								Profile info
							</option>
						</select>
					</div>
					
					<div class="cnb-input-item cnb-action-properties cnb-action-properties-<?php echo esc_attr($this->action_name) ?>">
						<label for="cnb-action-properties-line-message">Message</label>
						<input placeholder="Optional" type="text" id="cnb-action-properties-line-message"
							name="actions[<?php echo esc_attr( $action->id ) ?>][properties][line-message]"
							value="<?php echo esc_attr( $this->line_message ) ?>"/>
					</div>
				</div><!-- END .cnb-section-data -->
			</div><!-- END .cnb-flex -->
		</section>
		<?php
	}
}
