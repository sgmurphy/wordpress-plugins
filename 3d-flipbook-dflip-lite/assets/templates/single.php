<?php

get_header();

do_action( "before_dflip_single_content" );

do_action( "dflip_single_content" );

do_action( "after_dflip_single_content" );

get_footer();
