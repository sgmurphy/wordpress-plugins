<?php
/**
 * Get Excerpt data
 *
 * @package ThePlus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div class="entry-content">
	<p><?php echo l_theplus_excerpt( $post_excerpt_count ); ?></p>
</div>