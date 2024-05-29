<?php

if ( $atts['html'] === 'true' ) :
	foreach ( $atts['elements'] as $item ) {
		$title = '<' . $item['headline'] . '>' . esc_attr( $item['question'] ) . '</' . $item['headline'] . '>'; ?>
        <section class="sc_fs_faq sc_card <?php echo esc_attr( $atts['css_class'] ); ?>">
            <div>
				<?php echo wp_kses_post( $title ); ?>
                <div>
					<?php if ( ! empty( $item['image'] ) ) : ?>
                        <figure>
                            <a href="<?php echo esc_url( $item['img_url'] ); ?>"
                               title="<?php echo esc_attr( $item['img_alt'] ); ?>">
                                <img class="sc_fs_faq__image" src="<?php echo esc_url( $item['thumbnail_url'] ); ?>"
                                     alt="<?php echo esc_attr( $item['img_alt'] ); ?>"/>
                            </a>
                        </figure>
					<?php endif; ?>
                    <p>
						<?php echo wp_kses_post(htmlspecialchars_decode( do_shortcode( $item['answer'] ) )); ?>
                    </p>
                </div>
            </div>
        </section>
		<?php
	}
endif;
?>

<script type="application/ld+json">
    {
		"@context": "https://schema.org",
		"@type": "FAQPage",
		"mainEntity": [
	<?php foreach ( $atts['elements'] as $elementIndex => $element ) { ?>
			{
				"@type": "Question",
				"name": "<?php echo wpsc_esc_jsonld( $element['question'] ); ?>",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "<?php echo wpsc_esc_jsonld( wpsc_esc_strip_content( $element['answer'] ) ); ?>"
					<?php if ( ! empty( $element['image'] ) ) : ?>
					,
					"image" : {
						"@type" : "ImageObject",
						"contentUrl" : "<?php echo wpsc_esc_jsonld( $element['img_url'] ); ?>"
					}
					<?php endif; ?>
				}
			}
			<?php if ( $elementIndex < count( $atts['elements'] ) - 1 ) {
		echo ',';
	} ?>
	<?php } ?>
    ]
}
</script>
