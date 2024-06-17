<?php
class Fpm_Sidebar extends WP_Widget {

	function __construct() {
		parent::__construct(
			'fpm_sidebar',
			'Flat PM',
			array( 'description' => __( 'Select a FlatPM block to display it in the sidebar', 'flatpm_l10n' ) )
		);
	}


	function widget( $args, $instance ) {
		$fpm_title = apply_filters( 'widget_title', $instance['fpm_title'] );
		$fpm_block_id = esc_html( $instance['fpm_block_id'] );

		echo $args['before_widget'];

		if( ! empty( $title ) ){
			echo $args['before_title'] . $fpm_title . $args['after_title'];
		}

		if( isset( $fpm_block_id ) && ! empty( $fpm_block_id ) ){
			echo do_shortcode( '[flat_pm id="' . $fpm_block_id . '"]' );
		}

		echo $args['after_widget'];
	}


	function form( $instance ) {
		$fpm_title = @ $instance['fpm_title'] ?: '';
		$fpm_block_id = @ $instance['fpm_block_id'] ?: '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'fpm_title' ); ?>">
				<?php _e( 'Title:', 'flatpm_l10n' ); ?>
			</label>

			<input class="widefat" type="text"
				id="<?php echo $this->get_field_id( 'fpm_title' ); ?>"
				name="<?php echo $this->get_field_name( 'fpm_title' ); ?>"
				value="<?php echo esc_attr( $fpm_title ); ?>"
			>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'fpm_block_id' ); ?>">
				<?php _e( 'FlatPM block:', 'flatpm_l10n' ); ?>
			</label>

			<select
				id="<?php echo $this->get_field_id( 'fpm_block_id' ); ?>"
				name="<?php echo $this->get_field_name( 'fpm_block_id' ); ?>"
			>
				<option value=""><?php _e( 'Select a block', 'flatpm_l10n' ); ?></option>
				<?php
				$fpm_query = new WP_Query;

				$fpm_ids = $fpm_query->query( [
					'posts_per_page' => -1,
					'post_type'      => 'flat_pm_block',
					'order'          => 'ASC',
					'orderby'        => 'meta_value_num',
					'meta_key'       => 'order',
					'no_found_rows'  => true,
					'post_status'    => 'publish',
					'fields'         => 'ids'
				] );

				foreach( $fpm_ids as $id ){
				?>
					<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $id, $fpm_block_id ); ?> >
						<?php echo esc_html( get_the_title( $id ) ) ?>
					</option>
				<?php } ?>
			</select>
		</p>
		<?php
	}


	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['fpm_title'] = ( ! empty( $new_instance['fpm_title'] ) ) ? strip_tags( $new_instance['fpm_title'] ) : '';
		$instance['fpm_block_id'] = ( ! empty( $new_instance['fpm_block_id'] ) ) ? strip_tags( $new_instance['fpm_block_id'] ) : '';

		return $instance;
	}

}