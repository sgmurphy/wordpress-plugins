<?php
if ( $atts['html'] === 'true' ) :

	$title = $atts['headline_open_tag'] . esc_attr( $atts['question'] ) . $atts['headline_close_tag'];

	?>
    <section class="sc_fs_faq sc_card <?php echo esc_attr( $atts['css_class'] ); ?>">
        <div>
			<?php echo wp_kses_post( $title ); ?>
            <div>
				<?php if ( ! empty( $atts['img'] ) ) : ?>
                    <figure class="sc_fs_faq__figure">
                        <a href="<?php echo esc_url( $atts['img_url'] ); ?>"
                           title="<?php echo esc_attr( $atts['img_alt'] ); ?>">
                            <img src="<?php echo esc_url( $atts['thumbnail_url'] ); ?>"
                                 alt="<?php echo esc_attr( $atts['img_alt'] ); ?>"/>
                        </a>
                        <meta content="<?php echo esc_url( $atts['img_url'] ); ?>">
                        <meta content="<?php echo esc_attr( $atts['img_size'][0] ); ?>">
                        <meta content="<?php echo esc_attr( $atts['img_size'][1] ); ?>">
                    </figure>
				<?php endif; ?>
                <p>
					<?php echo wp_kses_post(htmlspecialchars_decode( do_shortcode( $content ) )); ?>
                </p>
            </div>
        </div>
    </section>
<?php endif; ?>

<script type="application/ld+json">
    {
		"@context": "https://schema.org",
		"@type": "FAQPage",
		"mainEntity": [
			{
				"@type": "Question",
				"name": "<?php echo wpsc_esc_jsonld( $atts['question'] ); ?>",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "<?php echo wpsc_esc_jsonld( wpsc_esc_strip_content( $content ) ); ?>"
	                <?php if ( ! empty( $atts['img'] ) ) : ?>
					,
					"image" : {
						"@type" : "ImageObject",
						"contentUrl" : "<?php echo wpsc_esc_jsonld( $atts['img_url'] ); ?>"
					}
					<?php endif; ?>
                }
          }
        ]
    }
</script>
