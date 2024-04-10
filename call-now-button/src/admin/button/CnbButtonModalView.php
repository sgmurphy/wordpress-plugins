<?php

namespace cnb\admin\button;

use cnb\utils\CnbAdminFunctions;
use cnb\utils\CnbUtils;

class CnbButtonModalView {

	function render() {
		$this->render_thickbox();
		$this->render_thickbox_quick_action();
	}

	/**
	 * @return void
	 */
	private function render_thickbox( ) {
		global $cnb_domain;

		if ( ! $cnb_domain || is_wp_error( $cnb_domain ) ) return;

		add_thickbox();
		echo '<div id="cnb-add-new-modal" style="display:none;"><div>';

		$button = CnbButton::getDefaultButton( $cnb_domain );

		$this->render_form( $button );
		echo '</div></div>';
	}

	function render_form( $button ) {
		global $wp_version;

		$adminFunctions = new CnbAdminFunctions();

		$cnb_single_image_url       = plugins_url( 'resources/images/button-new-single.png', CNB_PLUGINS_URL_BASE );
		$cnb_multi_image_url        = plugins_url( 'resources/images/button-new-multibutton.gif', CNB_PLUGINS_URL_BASE );
		$cnb_multi_flower_image_url = plugins_url( 'resources/images/button-new-flower.gif', CNB_PLUGINS_URL_BASE );
		$cnb_full_image_url         = plugins_url( 'resources/images/button-new-buttonbar.png', CNB_PLUGINS_URL_BASE );
		$cnb_full_single_image_url  = plugins_url( 'resources/images/button-new-full.png', CNB_PLUGINS_URL_BASE );
		$cnb_dots_image_url         = plugins_url( 'resources/images/button-new-dots.png', CNB_PLUGINS_URL_BASE );

		// Only for WordPress 5.2 and higher (Gutenberg + React 16.8)
		$has_gutenberg = version_compare( $wp_version, '5.2.0', '>=' );

		$upgrade_link =
			add_query_arg( array(
				'page'   => 'call-now-button-domains',
				'action' => 'upgrade',
				'id'     => $button->domain->id
			),
				admin_url( 'admin.php' ) );

		$templates_link   =
			add_query_arg( array(
                'page'    => 'call-now-button-templates',
            ),
				admin_url( 'admin.php' ) );
		?>
		<form class="cnb-container cnb-validation" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>" method="post">
			<input type="hidden" name="page" value="call-now-button"/>
			<input type="hidden" name="action"
			       value="<?php echo 'cnb_create_' . esc_attr( strtolower( $button->type ) ) . '_button' ?>"/>
			<input type="hidden" name="_wpnonce_button"
			       value="<?php echo esc_attr( wp_create_nonce( 'cnb-button-edit' ) ) ?>"/>
            <input type="hidden" name="tabName" value="<?php echo esc_attr( $adminFunctions->get_active_tab_name() ) ?>"/>
            <input type="hidden" name="tabGroup" value="<?php echo esc_attr( $adminFunctions->get_active_tab_group() ) ?>"/>

            <input type="hidden" name="button[type]" value="<?php echo esc_attr( $button->type ) ?>" id="button_type"/>
            <input type="hidden" name="button[active]" value="<?php echo esc_attr( $button->active ) ?>"/>
			<input type="hidden" name="button[domain]" value="<?php echo esc_attr( $button->domain->id ) ?>"/>
            <!-- TODO add button icon -->
<!--            <input type="hidden" name="actions[new][iconType]" value="FONT" id="cnb_action_icon_type">-->
<!--            <input type="hidden" name="actions[new][iconText]" value="call" id="cnb_action_icon_text">-->
            <!-- add position -->
            <input type="hidden" name="button[options][placement]" value="<?php echo esc_attr( $button->options->placement ) ?>"/>
            <!-- add always visible -->
            <input type="hidden" name="button[options][displayMode]" value="<?php echo esc_attr( $button->options->displayMode ) ?>"/>
            <!-- allow flower to work -->
            <input type="hidden" name="button[options][cssClasses]" value="" id="button_options_css_classes"/>

            <div class="cnb-flex cnb-flex-col-mob cnb-flex-gap">
				<div class="cnb-section-data cnb-top-spacing">
                    <div class="cnb-input-item cnb_button_name">
                        <label for="button_name">Name</label>
                        <input type="text" name="button[name]" id="button_name" required="required"
                               placeholder="My new button"/>
                    </div>
                    <div class="cnb-input-item cnb_button_type">
						<label>Select button type <?php if ($has_gutenberg) { ?><span class="cnb-smaller-text-in-heading">(or start with a <a class="cnb-green cnb_font_bold" href="<?php echo esc_url( $templates_link ); ?>">template</a>)<?php } ?></span></th></label>
						<div class="cnb_type_selector cnb_type_selector_container">
							<div class="cnb_type_selector cnb_type_selector_item cnb_type_selector_single cnb_type_selector_active" data-cnb-selection="single">
								<div class="cnb-phone-outside">
									<div class="cnb-phone-inside">
										<img style="max-width:100%;" alt="Select the Single button" src="<?php echo esc_url( $cnb_single_image_url ) ?>">
									</div>
								</div>

								<div style="text-align:center">Single<span class="cnb-hide-on-mobile"> button</span></div>
							</div>

							<?php
							// Only show this tot non-PRO domains, since the button bar is available for PRO domains
							// And FULL is basically (and technically) the same as the FULL WIDTH
							if ( $button->domain->type !== 'PRO' ) { ?>
								<div class="cnb_type_selector cnb_type_selector_item cnb_type_selector_full"
								     data-cnb-selection="full">
									<div class="cnb-phone-outside">
										<div class="cnb-phone-inside">
											<img style="max-width:100%;" alt="Select the Full width button"
											     src="<?php echo esc_url( $cnb_full_single_image_url ) ?>">
										</div>
									</div>

									<div style="text-align:center">
										Full width<span class="cnb-hide-on-mobile"> button</span>
									</div>
								</div>
							<?php } ?>

							<div class="cnb_type_selector <?php if ( $button->domain->type !== 'STARTER' ) { ?>cnb_type_selector_item<?php } else { ?>cnb_type_only_pro<?php } ?> cnb_type_selector_multi"
							     data-cnb-selection="multi">
								<div class="cnb-phone-outside">
									<div class="cnb-phone-inside">
										<img style="max-width:100%;" alt="Select the Multibutton"
										     src="<?php echo esc_url( $cnb_multi_image_url ) ?>">
									</div>
								</div>

								<div style="text-align:center">
									Multibutton
									<?php if ( $button->domain->type === 'STARTER' ) { ?><span
										class="cnb-pro-badge">Pro</span><?php } ?>
								</div>
								<?php if ( $button->domain->type === 'STARTER' ) { ?>
									<div class="cnb-pro-overlay">
										<p class="description">
											Multibutton is a <span class="cnb-pro-badge">Pro</span> feature.
											<a href="<?php echo esc_url( $upgrade_link ) ?>">Upgrade</a> here.
										</p>
									</div>
								<?php } ?>
							</div>

							<div class="cnb_type_selector <?php if ( $button->domain->type === 'PRO' ) { ?>cnb_type_selector_item<?php } else { ?>cnb_type_only_pro<?php } ?> cnb_type_selector_multi_flower"
							     data-cnb-selection="multi">

								<div class="cnb-phone-outside">
									<div class="cnb-phone-inside">
										<img style="max-width:100%;" alt="Select Flower"
										     src="<?php echo esc_url( $cnb_multi_flower_image_url ) ?>">
									</div>
								</div>

								<div style="text-align:center">
									Flower<span class="cnb-hide-on-mobile"> button</span>
									<?php if ( $button->domain->type !== 'PRO' ) { ?><span
										class="cnb-pro-badge">Pro</span><?php } ?>
								</div>
								<?php if ( $button->domain->type !== 'PRO' ) { ?>
									<div class="cnb-pro-overlay">
										<p class="description">
											Flower is a <span class="cnb-pro-badge">Pro</span> feature.
											<a href="<?php echo esc_url( $upgrade_link ) ?>">Upgrade</a> here.
										</p>
									</div>
								<?php } ?>
							</div>

							<div class="cnb_type_selector <?php if ( $button->domain->type === 'PRO' ) { ?>cnb_type_selector_item<?php } else { ?>cnb_type_only_pro<?php } ?> cnb_type_selector_full"
							     data-cnb-selection="full">
								<div class="cnb-phone-outside">
									<div class="cnb-phone-inside">
										<img style="max-width:100%;" alt="Select the Buttonbar"
										     src="<?php echo esc_url( $cnb_full_image_url ) ?>">
									</div>
								</div>

								<div style="text-align:center">
									Buttonbar
									<?php if ( $button->domain->type !== 'PRO' ) { ?><span
										class="cnb-pro-badge">Pro</span><?php } ?>
								</div>
								<?php if ( $button->domain->type !== 'PRO' ) { ?>
									<div class="cnb-pro-overlay">
										<p class="description">
											Buttonbar is a <span class="cnb-pro-badge">Pro</span> feature.
											<a href="<?php echo esc_url( $upgrade_link ) ?>">Upgrade</a> here.
										</p>
									</div>
								<?php } ?>
							</div>

							<div class="cnb_type_selector <?php if ( $button->domain->type === 'PRO' ) { ?>cnb_type_selector_item<?php } else { ?>cnb_type_only_pro<?php } ?> cnb_type_selector_dots"
							     data-cnb-selection="dots">

								<div class="cnb-phone-outside">
									<div class="cnb-phone-inside">
										<img style="max-width:100%;" alt="Select Dots"
										     src="<?php echo esc_url( $cnb_dots_image_url ) ?>">
									</div>
								</div>

								<div style="text-align:center">
									Dots
									<?php if ( $button->domain->type !== 'PRO' ) { ?><span
										class="cnb-pro-badge">Pro</span><?php } ?>
								</div>
								<?php if ( $button->domain->type !== 'PRO' ) { ?>
									<div class="cnb-pro-overlay">
										<p class="description">
											Dots is a <span class="cnb-pro-badge">Pro</span> feature.
											<a href="<?php echo esc_url( $upgrade_link ) ?>">Upgrade</a> here.
										</p>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php submit_button( 'Next' ); ?>
		</form>
		<?php
	}

	private function render_thickbox_quick_action() {
		$cnb_utils = new CnbUtils();
		$action    = $cnb_utils->get_query_val( 'action', null );
		if ( $action === 'new' ) {
			?>
			<script>jQuery(function () {
                    setTimeout(cnb_button_overview_add_new_click);
                });</script>
			<?php
		}

		// Change the click into an actual "onClick" event
		// But only on the button-overview page and Action is not set or to "new"
		if ( $action === 'new' || $action === null ) {
			?>
			<script>jQuery(function () {
                    const ele = jQuery("li.toplevel_page_call-now-button li:contains('Add New') a");
                    ele.attr('href', '#');
                    ele.on("click", cnb_button_overview_add_new_click)
                });</script>
			<?php
		}
	}
}