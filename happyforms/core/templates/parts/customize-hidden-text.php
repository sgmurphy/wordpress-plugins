<script type="text/template" id="customize-happyforms-hidden-text-template">
	<?php include( happyforms_get_core_folder() . '/templates/customize-form-part-header.php' ); ?>
	<div class="label-field-group">
		<label for="<%= instance.id %>_title"><?php _e( 'Label', 'happyforms' ); ?></label>
		<div class="label-group">
			<input type="text" id="<%= instance.id %>_title" class="widefat title hidden_text" value="<%- instance.label %>" data-bind="label" />
		</div>
	</div>
	<p class="happyforms-default-value-option">
		<label for="<%= instance.id %>_default_value"><?php _e( 'Value', 'happyforms' ); ?></label>
		<input type="text" id="<%= instance.id %>_default_value" class="widefat title default_value" value="<%- instance.default_value %>" data-bind="default_value" />
	</p>

	<?php do_action( 'happyforms_part_customize_hidden_text_before_options' ); ?>

	<?php do_action( 'happyforms_part_customize_hidden_text_after_options' ); ?>

	<?php do_action( 'happyforms_part_customize_hidden_text_before_advanced_options' ); ?>

	<?php do_action( 'happyforms_part_customize_hidden_text_after_advanced_options' ); ?>

	<p>
		<label for="<%= instance.id %>_css_class"><?php _e( 'Additional CSS class(es)', 'happyforms' ); ?></label>
		<input type="text" id="<%= instance.id %>_css_class" class="widefat title" value="<%- instance.css_class %>" data-bind="css_class" />
	</p>

	<div class="happyforms-part-logic-wrap">
		<div class="happyforms-logic-view">
			<?php happyforms_customize_part_logic(); ?>
		</div>
	</div>

	<?php happyforms_customize_part_footer(); ?>
</script>
