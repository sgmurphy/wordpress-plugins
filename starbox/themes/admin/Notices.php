<?php defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $type ) || ! isset( $message ) || ! isset( $id ) ) {
	exit();
}

if ( $type == 'errors_count' ) {
	/* for the Menu counter */
	?>
    <span class='awaiting-mod count-<?php echo esc_attr($message); ?>'>
        <span class='sq_count pending-count'><?php echo esc_html($message); ?></span>
    </span>
<?php } else { ?>
    <div id="<?php echo esc_attr( $id ) ?>" class="<?php echo esc_attr($type); ?> sq_message">

        <p>
            <strong><?php echo wp_kses_post($message); ?></strong>
        </p>

    </div>
<?php }
