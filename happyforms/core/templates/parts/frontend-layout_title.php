<div class="<?php happyforms_the_part_class( $part, $form ); ?>" id="<?php happyforms_the_part_id( $part, $form ); ?>-part" <?php happyforms_the_part_data_attributes( $part, $form ); ?>>
	<div class="happyforms-part-wrap">
		<?php
			$allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p', 'strong', 'em');
			$tag = in_array($part['level'], $allowed_tags) ? $part['level'] : 'div';
		?>
		<<?php echo esc_html($tag); ?> class="happyforms-layout-title"><?php echo esc_html($part['label']); ?></<?php echo esc_html($tag); ?>>
	</div>
</div>
