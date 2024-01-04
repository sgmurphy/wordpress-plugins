<?php
/*
 * By copying and modifying this in your theme (parent or child) folder within plugins/events-manager/templates/search/advanced.php, or alternatively (recommended) in plugin-templates/events-manager/templates/search/advanced.php, you can change the way the search form will look.
 * To ensure compatability, it is strongly recommended you maintain class, id and form name attributes, unless you know what you're doing.
 * You also have an $args array available to you with search options passed on by your EM settings or shortcode
 */
/* @var array $args */
?>
<section class="em-search-main em-search-advanced-main-sections">
	<?php
	// main three searches on top
	if( !empty($args['search_term_advanced']) ) em_locate_template('templates/search/search.php',true,array('args'=>$args));
	if( !empty($args['search_scope_advanced']) ) em_locate_template('templates/search/scope.php',true,array('args'=>$args));
	if( !empty($args['search_geo_advanced']) ) em_locate_template('templates/search/geo.php',true,array('args'=>$args));
	?>
</section>
<section class="em-search-advanced-sections input">
	<section class="em-search-section-location em-search-advanced-section">
		<header>Location Options</header>
		<div class="em-search-section-content">
			<?php
			em_locate_template('templates/search/location.php', true, array('args'=>$args));
			if( !empty($args['search_geo_units']) ) em_locate_template('templates/search/geo-units.php',true, array('args'=>$args));
			if( !empty($args['search_eventful']) ) em_locate_template('templates/search/eventful-locations.php',true,array('args'=>$args));
			?>
		</div>
	</section>
	<?php if( get_option('dbem_categories_enabled') && !empty($args['search_categories']) ): ?>
		<section class="em-search-section-categories em-search-advanced-section">
			<header><?php echo esc_html($args['category_label']); ?></header>
			<div class="em-search-section-content">
				<?php em_locate_template('templates/search/categories.php',true,array('args'=>$args)); ?>
			</div>
		</section>
	<?php endif; ?>
	<?php if( get_option('dbem_tags_enabled') && !empty($args['search_tags']) ): ?>
		<section  class="em-search-section-tags em-search-advanced-section">
			<header><?php echo esc_html($args['tag_label']); ?></header>
			<div class="em-search-section-content">
				<?php em_locate_template('templates/search/tags.php',true,array('args'=>$args)); ?>
			</div>
		</section>
	<?php endif; ?>
</section>