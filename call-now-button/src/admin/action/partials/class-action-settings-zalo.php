<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class ActionSettingsZalo {

	private $action_name = 'ZALO';

	/**
	 * Options: PERSONAL and GROUP
	 * @var string
	 */
	private $zalo_link_type = 'PERSONAL';

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
		if ( isset( $action->properties ) && isset( $action->properties->{'zalo-link-type'} ) ) {
			$this->zalo_link_type = $action->properties->{'zalo-link-type'};
		}
		?>
		<section class="cnb-action-properties cnb-action-properties-<?php echo esc_attr($this->action_name) ?>">
			<hr class="cnb-bottom-spacing" /> 
			<div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
				<div class="cnb-section-info cnb-top-spacing">
					<h3 class="top-0">Zalo settings</h3>
				</div>
				<div class="cnb-section-data cnb-top-spacing">

					<div class="cnb-input-item">
						<label for="cnb-action-properties-zalo-link-type">Button type</label>
						<select id="cnb-action-properties-zalo-link-type"
								name="actions[<?php echo esc_attr( $action->id ) ?>][properties][zalo-link-type]">
							<option value="PERSONAL" <?php selected( $this->zalo_link_type, 'PERSONAL' ); ?>>
								Personal (use your phone number above)
							</option>
							<option value="INVITE" <?php selected( $this->zalo_link_type, 'GROUP' ); ?>>
								Group (use your group or username above)
							</option>
						</select>
					</div>

				</div><!-- END .cnb-section-data -->
			</div><!-- END .cnb-flex -->
		</section>
		<?php
	}
}
