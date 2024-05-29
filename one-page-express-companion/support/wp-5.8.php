<?php
add_action(
	'cloudpress\companion\activated\one-page-express',
	function () {
		$sidebars_widgets = wp_get_sidebars_widgets();

		$sidebar_data   = array();
		$sidebar_widget = null;

		if ( isset( $sidebars_widgets['sidebar-1'] ) ) {
			$sidebar_data = $sidebars_widgets['sidebar-1'];
		}

		if ( isset( $sidebar_data[0] ) ) {
			$sidebar_widget = $sidebar_data[0];
		}

		if ( $sidebar_widget === 'block-2' ) {
			$widget_block_option = get_option( 'widget_block', array() );

			if ( isset( $widget_block_option[2] ) ) {
				$widget_block_option[2] = array(
					'content' => '<!-- wp:search {"showLabel":false,"buttonUseIcon":true} /-->',
				);
				update_option( 'widget_block', $widget_block_option );
			}
		}
	}
);
