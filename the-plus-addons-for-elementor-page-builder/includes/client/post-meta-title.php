<?php
/**
 * Client Post meta title
 *
 * @package ThePlus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! isset( $post_title_tag ) && empty( $post_title_tag ) ) {
	$post_title_tag = 'h3';
}

if ( 'clrepeater' === $content_from ) {
	$client_url = $clientlink;
} else {
	$client_url = get_post_meta( get_the_id(), 'theplus_clients_url', true );
}

?>

<<?php echo l_theplus_validate_html_tag( $post_title_tag ); ?> class="post-title">	
	<a href="<?php echo esc_url( $client_url ); ?>" target="_blank" rel="noopener noreferrer">
		<?php
		if ( 'clrepeater' === $content_from ) {
			echo esc_html( $client_lml );
		} else {
			echo esc_html( get_the_title() );
		}
		?>
	</a>
</<?php echo l_theplus_validate_html_tag( $post_title_tag ); ?>>