<?php

if ( $atts['visible'] ) {
	$title_ID = $atts['generateTitleId'] ? sanitize_title( $atts['title'] ) : '';

	$title = '<' . $atts['titleTag'] . ( $atts['generateTitleId'] ? ' id="' . $title_ID . '"' : '' ) . '>' . esc_attr( $atts['title'] ) . '</' . $atts['titleTag'] . '>';

	?>

    <section class="sc_recipe sc_card <?php echo esc_attr( $atts['className'] ); ?>"
             id="<?php echo esc_attr( $atts["identifier"] ); ?>"
    >

        <div class="sc_recipe__head">
            <div class="sc_recipe__head--text">
	            <?php echo wp_kses_post($title); ?>
                <?php if ( $atts['description'] != '' ) { ?>
				<p class="sc_recipe__head--description">
					<?php echo wpsc_esc_jsonld( do_shortcode( $atts['description'] ) ); ?>
                </p>
			<?php } ?>
        </div>

		<?php if ( ! empty( $atts['thumbnailImageUrl'] ) ) { ?>
            <figure class="sc_recipe__head--figure">
                <img src="<?php echo esc_url( $atts['thumbnailImageUrl'] ); ?>"
                     alt="<?php echo esc_attr( $atts['title'] ); ?>"/>
            </figure>
		<?php } ?>

        </div>

		<?php if ( $atts['showPrintButton'] ) { ?>
            <div class="sc_recipe__print no-print">
                <button class="sc_recipe__printButton" data-target="<?php echo esc_attr( $atts["identifier"] ); ?>">
					<?php echo esc_html( $atts['printButtonText'] ); ?>
                </button>
            </div>
		<?php } ?>

		<?php if ( ! empty( $atts['prepTimeReadable'] ) || ! empty( $atts['cookTimeReadable'] ) || ! empty( $atts['totalTimeReadable'] ) ) { ?>
            <hr class="sc_recipe__divider"/>
            <div class="sc_recipe__times">
				<?php if ( ! empty( $atts['prepTimeReadable'] ) ) { ?>
                    <div class="sc_recipe__times--prepTime">
                        <span class="sc_recipe__times--label"><?php echo _x( 'Prep Time:', 'Recipe', 'structured-content' ); ?></span>
                        <span class="sc_recipe__times--value"><?php echo esc_html( $atts['prepTimeReadable'] ); ?></span>
                    </div>
				<?php } ?>
				<?php if ( ! empty( $atts['cookTimeReadable'] ) ) { ?>
                    <div class="sc_recipe__times--cookTime">
                        <span class="sc_recipe__times--label"><?php echo _x( 'Cook Time:', 'Recipe', 'structured-content' ); ?></span>
                        <span class="sc_recipe__times--value"><?php echo esc_html( $atts['cookTimeReadable'] ); ?></span>
                    </div>
				<?php } ?>
				<?php if ( ! empty( $atts['totalTimeReadable'] ) ) { ?>
                    <div class="sc_recipe__times--totalTime">
                        <span class="sc_recipe__times--label"><?php echo _x( 'Total Time:', 'Recipe', 'structured-content' ); ?></span>
                        <span class="sc_recipe__times--value"><?php echo esc_html( $atts['totalTimeReadable'] ); ?></span>
                    </div>
				<?php } ?>
            </div>
            <hr class="sc_recipe__divider"/>
		<?php } else { ?>
            <hr class="sc_recipe__divider"/>
		<?php } ?>

		<?php if ( ! empty( $atts['recipeCategory'] ) || ! empty( $atts['recipeCuisine'] ) || ! empty( $atts['recipeYield'] ) ) { ?>
            <div class="sc_recipe__meta">
				<?php if ( ! empty( $atts['recipeCategory'] ) ) { ?>
                    <div class="sc_recipe__meta--category">
                        <span class="sc_recipe__meta--label"><?php echo _x( 'Category:', 'Recipe', 'structured-content' ); ?></span>
                        <span class="sc_recipe__meta--value"><?php echo esc_html( $atts['recipeCategory'] ); ?></span>
                    </div>
				<?php } ?>
				<?php if ( ! empty( $atts['recipeCuisine'] ) ) { ?>
                    <div class="sc_recipe__meta--cuisine">
                        <span class="sc_recipe__meta--label"><?php echo _x( 'Cuisine:', 'Recipe', 'structured-content' ); ?></span>
                        <span class="sc_recipe__meta--value"><?php echo esc_html( $atts['recipeCuisine'] ); ?></span>
                    </div>
				<?php } ?>
				<?php if ( ! empty( $atts['recipeYield'] ) ) { ?>
                    <div class="sc_recipe__meta--yield">
                        <span class="sc_recipe__meta--label"><?php echo _x( 'Yield:', 'Recipe', 'structured-content' ); ?></span>
                        <span class="sc_recipe__meta--value"><?php echo esc_html( $atts['recipeYield'] ); ?></span>
                    </div>
				<?php } ?>
            </div>
            <hr class="sc_recipe__divider"/>
		<?php } ?>

		<?php if ( ! empty( $atts['recipeIngredient'] ) ) { ?>
            <div class="sc_recipe__ingredients avoid-break-inside">
                <div class="sc_recipe__ingredients--heading"><?php echo _x( 'Ingredients:', 'Recipe', 'structured-content' ); ?></div>
				<?php if ( ! $atts['ingredientsAsChecklist'] ) { ?>
                    <ul>
						<?php foreach ( $atts['recipeIngredient'] as $ingredient ) { ?>
							<?php if ( esc_html( $ingredient ) === '' ) {
								continue;
							} ?>
                            <li><?php echo esc_html( $ingredient ); ?></li>
						<?php } ?>
                    </ul>
				<?php } else { ?>
                    <ul class="sc_recipe__ingredients--checklist">
						<?php foreach ( $atts['recipeIngredient'] as $ingredient ) { ?>
							<?php if ( esc_html( $ingredient ) === '' ) {
								continue;
							} ?>

                            <li>
                                <input type="checkbox" id="<?php echo sanitize_title( $ingredient ); ?>"
                                       name="<?php echo sanitize_title( $ingredient ); ?>"
                                       value="<?php echo sanitize_title( $ingredient ); ?>">
                                <label for="<?php echo sanitize_title( $ingredient ); ?>"><?php echo esc_html( $ingredient ); ?></label>
                            </li>
						<?php } ?>
                    </ul>
				<?php } ?>
            </div>
            <hr class="sc_recipe__divider"/>
		<?php } ?>

		<?php if ( ! empty( $atts['recipeInstructions'] ) ) { ?>
            <div class="sc_recipe__instructions">
                <div class="sc_recipe__instructions--heading"><?php echo _x( 'Instructions:', 'Recipe', 'structured-content' ); ?></div>
                <ol>
					<?php foreach ( $atts['recipeInstructions'] as $instructionIndex => $instruction ) { ?>
                        <li>
	                        <?php if ( esc_html( $instruction['text'] ) === '' ) {
		                        continue;
	                        } ?>

                            <span class="sc_recipe__instructions--text"><?php echo esc_html( $instruction['text'] ); ?></span>
							<?php if ( isset( $instruction['image'] ) ) { ?>
                                <figure class="sc_recipe__instructions--figure <?php echo $atts["instructionImageLightbox"] ? 'has-wpsc-lightbox lightbox-wpsc-' . esc_attr( $atts["identifier"] ) : ''; ?>"
                                        data-image-url="<?php echo esc_url( $instruction['image']['url'] ); ?>"
                                >
                                    <img src="<?php echo esc_url( $instruction['image']['sizes'][ $atts['instructionImageSize'] ]['url'] ?? $instruction['image']['url'] ); ?>"
                                         alt="<?php echo esc_attr( $instruction['image']['alt'] ?? esc_attr( $instruction['text'] ) ); ?>"
                                    />
                                </figure>
							<?php } ?>
                        </li>
					<?php } ?>
                </ol>
            </div>
		<?php } ?>

		<?php if ( ! empty( $atts['hasVideo'] === true ) ) { ?>
            <hr class="sc_recipe__divider no-print"/>
            <div class="sc_recipe__video no-print">
				<?php if ( ! empty( $atts['video']['name'] ) ) { ?>
                    <div class="sc_recipe__video--heading"><?php echo esc_html( $atts['video']['name'] ); ?></div>
				<?php } else { ?>
                    <div class="sc_recipe__video--heading"><?php echo _x( 'Video:', 'Recipe', 'structured-content' ); ?></div>
				<?php } ?>
				<?php if ( ! empty( $atts['video']['description'] ) ) { ?>
                    <p class="sc_recipe__video--description"><?php echo esc_html( $atts['video']['description'] ); ?></p>
				<?php } ?>
				<?php if ( ! empty( $atts['video']['contentUrl'] ) ) { ?>
					<?php if ( $atts['video']['provider'] === 'local' ) { ?>
                        <video controls poster="<?php echo esc_attr( $atts['video']['thumbnailUrl'] ) ?? ''; ?>">
                            <source src="<?php echo esc_url( $atts['video']['contentUrl'] ); ?>">
							<?php echo _x( 'Your browser does not support the video tag.', 'Recipe', 'structured-content' ); ?>
                        </video>
					<?php } elseif ( $atts['video']['provider'] === 'oembed' ) { ?>
                        <div class="sc_recipe__video--oembed">
							<?php echo $atts['video']['oembed']; ?>
                        </div>
					<?php } ?>
				<?php } ?>
				<?php if ( empty( $atts['video']['contentUrl'] ) && ! empty( $atts['video']['mediaVideo'] ) ) { ?>
                    <video <?php echo esc_attr( $atts['video']['settings'] ) ?>>
                        <source src="<?php echo esc_url( $atts['video']['mediaVideo']['url'] ); ?>">
						<?php echo _x( 'Your browser does not support the video tag.', 'Recipe', 'structured-content' ); ?>
                    </video>
				<?php } ?>
            </div>
		<?php } ?>

		<?php if ( ! empty( $atts['nutrition'] ) ) { ?>
            <hr class="sc_recipe__divider"/>
            <div class="sc_recipe__nutrition">
                <div class="sc_recipe__nutrition--heading"><?php echo _x( 'Nutritions:', 'Recipe', 'structured-content' ); ?></div>
                <ul>
					<?php foreach ( $atts['nutrition'] as $nutrition ) { ?>
                        <li><?php echo esc_html( $nutritions[ $nutrition['type'] ]['label'] ); ?>
                            : <?php echo esc_html( $nutrition['value'] ); ?> <?php echo esc_html( $nutritions[ $nutrition['type'] ]['abbreviation'] ); ?></li>
					<?php } ?>
                </ul>
            </div>
		<?php } ?>
    </section>
<?php } ?>

<script type="application/ld+json">
    {
		"@context": "http://schema.org/",
		"@type": "Recipe",
		"name": "<?php echo wpsc_esc_jsonld( $atts['title'] ); ?>"
	<?php if ( ! empty( $atts['description'] ) ) { ?>
        ,"description": "<?php echo wpsc_esc_jsonld( $atts['description'] ); ?>"
<?php } ?>
<?php if ( ! empty( $atts['thumbnailImageUrl'] ) ) { ?>
        ,"image": "<?php echo esc_url( $atts['thumbnailImageUrl'] ); ?>"
<?php } ?>
<?php if ( ! empty( $atts['prepTimeReadable'] ) ) { ?>
        ,"prepTime": "<?php echo esc_js( $atts['prepTime'] ); ?>"
<?php } ?>
<?php if ( ! empty( $atts['cookTimeReadable'] ) ) { ?>
        ,"cookTime": "<?php echo esc_js( $atts['cookTime'] ); ?>"
<?php } ?>
<?php if ( ! empty( $atts['totalTimeReadable'] ) ) { ?>
        ,"totalTime": "<?php echo esc_js( $atts['totalTime'] ); ?>"
<?php } ?>
<?php if ( ! empty( $atts['recipeCategory'] ) ) { ?>
        ,"recipeCategory": "<?php echo esc_js( $atts['recipeCategory'] ); ?>"
<?php } ?>
<?php if ( ! empty( $atts['recipeCuisine'] ) ) { ?>
        ,"recipeCuisine": "<?php echo esc_js( $atts['recipeCuisine'] ); ?>"
<?php } ?>
<?php if ( ! empty( $atts['recipeYield'] ) ) { ?>
        ,"recipeYield": "<?php echo esc_js( $atts['recipeYield'] ); ?>"
<?php } ?>
<?php if ( ! empty( $atts['recipeIngredient'] ) ) { ?>
        ,"recipeIngredient": <?php echo json_encode( $atts['recipeIngredient'] ); ?>
	<?php } ?>
<?php if ( ! empty( $atts['recipeInstructions'] ) ) { ?>
        ,"recipeInstructions": <?php echo json_encode( $atts['recipeInstructionsJson'] ); ?>
	<?php } ?>
<?php if ( ! empty( $atts['keywords'] ) ) { ?>
        ,"keywords": "<?php echo esc_js( implode( ', ', $atts['keywords'] ) ); ?>"
<?php } ?>
<?php if ( isset( $atts['nutritionJson'] ) ) { ?>
        ,"nutrition": <?php echo json_encode( $atts['nutritionJson'] ); ?>
	<?php } ?>
<?php if ( ! empty( $atts['hasVideo'] === true ) ) { ?>
        ,"video": <?php echo json_encode( $atts['videoJson'] ); ?>
	<?php } ?>
    }
</script>
