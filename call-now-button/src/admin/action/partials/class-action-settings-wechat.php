<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class ActionSettingsWeChat {

	private $action_name = 'WECHAT';

	/**
	 * Options: CHAT (web link) and WEIXIN_CHAT (mobile native)
	 * @var string
	 */
	private $wechat_link_type = 'CHAT';

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
		if ( isset( $action->properties ) && isset( $action->properties->{'wechat-link-type'} ) ) {
			$this->wechat_link_type = $action->properties->{'wechat-link-type'};
		}
		?>
		<section class="cnb-action-properties cnb-action-properties-<?php echo esc_attr($this->action_name) ?>">
			<hr class="cnb-bottom-spacing" /> 
			<div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
				<div class="cnb-section-info cnb-top-spacing">
					<h3 class="top-0">WeChat settings</h3>
				</div>
				<div class="cnb-section-data cnb-top-spacing">

					<div class="cnb-input-item">
						<label for="cnb-action-properties-wechat-link-type">Button type</label>
						<select id="cnb-action-properties-wechat-link-type"
								name="actions[<?php echo esc_attr( $action->id ) ?>][properties][wechat-link-type]">
							<option value="CHAT" <?php selected( $this->wechat_link_type, 'CHAT' ); ?>>
								Chat
							</option>
							<option value="WEIXIN_CHAT" <?php selected( $this->wechat_link_type, 'WEIXIN_CHAT' ); ?>>
								Weixin Chat (mobile only)
							</option>
						</select>
					</div>
				</div><!-- END .cnb-section-data -->
			</div><!-- END .cnb-flex -->
		</section>
		<?php
	}
}
