<?php
/**
 * Blog meta title
 *
 * @package ThePlus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! isset( $post_title_tag ) && empty( $post_title_tag ) ) {
	$post_title_tag = 'h3';
}
$title_text = esc_html( get_the_title() );
?>
<<?php echo l_theplus_validate_html_tag( $post_title_tag ); ?> class="post-title">
	<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo ( wp_kses_post( $title_text ) ); ?></a>
</<?php echo l_theplus_validate_html_tag( $post_title_tag ); ?>>