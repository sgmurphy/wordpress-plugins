<?php

namespace SmartCrawl;

$action_url = \SmartCrawl\Admin\Settings\Sitemap::crawl_url();

$this->render_view(
	'disabled-component-inner',
	array(
		'content'         => sprintf(
			'%s<br/>%s',
			esc_html__( 'Have SmartCrawl check for broken URLs, 404s, multiple redirections and other harmful', 'smartcrawl-seo' ),
			esc_html__( 'issues that can reduce your ability to rank in search engines.', 'smartcrawl-seo' )
		),
		'button_text'     => esc_html__( 'Begin Crawl', 'smartcrawl-seo' ),
		'button_url'      => $action_url,
		'upgrade_tag'     => 'smartcrawl_sitemap_crawler_upgrade_button',
		'premium_feature' => true,
	)
);
