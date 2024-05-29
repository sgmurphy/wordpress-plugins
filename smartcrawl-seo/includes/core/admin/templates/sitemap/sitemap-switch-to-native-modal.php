<?php

$this->render_view(
	'modal',
	array(
		'id'            => 'wds-switch-to-native-modal',
		'title'         => esc_html__( 'Are you sure?', 'smartcrawl-seo' ),
		'description'   => esc_html__( 'The powerful SmartCrawl sitemap ensures search engines index all of your posts and pages. Are you sure you wish to switch to the WordPress core sitemap?', 'smartcrawl-seo' ),
		'body_template' => 'sitemap/sitemap-switch-to-native-modal-body',
		'small'         => true,
	)
);
