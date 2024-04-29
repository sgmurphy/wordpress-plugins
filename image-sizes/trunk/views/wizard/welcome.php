<?php

// make sure it doesn't take to the wizard page again
update_option( 'image-sizes_setup_done', 1 );

$user = wp_get_current_user();
$user_name = $user->display_name;
echo '
<div class="step-one">
	<h1 class="cx-welcome">' . sprintf( __( 'Welcome to ThumbPress Family! 🎉', 'image-sizes' ) ).'</h1>
	<p class="cx-wizard-sub">' . __( 'Thanks for installing ThumbPress, your one-stop solution for all things image and thumbnail management on the WordPress site.
    ', 'image-sizes' ) . '</p>
	<p class="cx-wizard-sub">' . __( 'Please take a minute to complete the initial setup to get the best out of ThumbPress.', 'image-sizes' ) . '</p>
</div>';