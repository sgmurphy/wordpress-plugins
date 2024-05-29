<?php

namespace SmartCrawl;

use SmartCrawl\Schema\Type_Constants;

$option_name    = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
$options        = empty( $options ) ? array() : $options;
$social_options = empty( $social_options ) ? array() : $social_options;
$pages          = empty( $pages ) ? array() : $pages; // phpcs:ignore

$sitename             = (string) \smartcrawl_get_array_value( $social_options, 'sitename' );
$schema_website_logo  = (string) \smartcrawl_get_array_value( $options, 'schema_website_logo' );
$schema_type          = (string) \smartcrawl_get_array_value( $social_options, 'schema_type' );
$schema_output_page   = (int) \smartcrawl_get_array_value( $options, 'schema_output_page' );
$sitelinks_search_box = (bool) \smartcrawl_get_array_value( $options, 'sitelinks_search_box' );
?>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<label class="sui-settings-label">
			<?php esc_html_e( 'Website Details', 'smartcrawl-seo' ); ?>
		</label>
		<p class="sui-description">
			<?php esc_html_e( "Specify your website's name and logo. In some cases, this information may be different from your Person/Organization information.", 'smartcrawl-seo' ); ?>
		</p>
	</div>

	<div class="sui-box-settings-col-2">
		<div class="sui-form-field">
			<label for="sitename" class="sui-label">
				<?php esc_html_e( 'Website Name', 'smartcrawl-seo' ); ?>
			</label>
			<input
				id="sitename"
				class="sui-form-control"
				type="text"
				name="<?php echo esc_attr( "{$option_name}[sitename]" ); ?>"
				value="<?php echo esc_attr( $sitename ); ?>"
				placeholder="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>"
			>
			<span class="sui-description">
				<?php esc_html_e( 'Please add the site name you would like to appear in the schema markup.', 'smartcrawl-seo' ); ?>
			</span>
		</div>

		<div class="sui-form-field">
			<label for="schema_website_logo" class="sui-label">
				<?php esc_html_e( 'Website Logo', 'smartcrawl-seo' ); ?>
			</label>

			<?php
			$this->render_view(
				'media-item-selector',
				array(
					'id'    => 'schema_website_logo',
					'value' => $schema_website_logo,
					'field' => 'id',
				)
			);
			?>
			<p class="sui-description">
				<?php esc_html_e( 'Specify the image of your website’s logo.', 'smartcrawl-seo' ); ?>
			</p>
		</div>
	</div>
</div>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<label class="sui-settings-label">
			<?php esc_html_e( 'Person or Organization', 'smartcrawl-seo' ); ?>
		</label>
		<p class="sui-description">
			<?php esc_html_e( "Specify if your site represents a Person or an Organization. This information will be used in Google's Knowledge Graph Card, the block you can see on the right side of the search results.", 'smartcrawl-seo' ); ?>
		</p>
	</div>

	<div class="sui-box-settings-col-2">
		<div id="wds-site-type">
			<?php
			$this->render_view(
				'side-tabs',
				array(
					'id'    => 'wds-site-type-tabs',
					'name'  => "{$option_name}[schema_type]",
					'value' => ! empty( $schema_type ) ? $schema_type : Type_Constants::TYPE_ORGANIZATION,
					'tabs'  => array(
						array(
							'value'         => Type_Constants::TYPE_PERSON,
							'label'         => esc_html__( 'Person', 'smartcrawl-seo' ),
							'template'      => 'schema/schema-person-settings',
							'template_args' => array(
								'options'        => $options,
								'social_options' => $social_options,
								'pages'          => $pages,
							),
						),
						array(
							'value'         => Type_Constants::TYPE_ORGANIZATION,
							'label'         => esc_html__( 'Organization', 'smartcrawl-seo' ),
							'template'      => 'schema/schema-organization-settings',
							'template_args' => array(
								'options'        => $options,
								'social_options' => $social_options,
								'pages'          => $pages,
							),
						),
					),
				)
			);
			?>
		</div>
	</div>
</div>

<?php
$this->render_view(
	'schema/schema-social-accounts',
	array(
		'options'        => $options,
		'social_options' => $social_options,
	)
);
?>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<label class="sui-settings-label">
			<?php esc_html_e( 'Sitelinks Searchbox', 'smartcrawl-seo' ); ?>
		</label>
		<p class="sui-description">
			<?php esc_html_e( 'When someone searches for your name or brand name in Google, you can enable a mini search box under the main result for users to search your website directly.', 'smartcrawl-seo' ); ?>
		</p>
	</div>

	<div class="sui-box-settings-col-2">
		<?php
		$this->render_view(
			'toggle-item',
			array(
				'field_name'       => $option_name . '[sitelinks_search_box]',
				'checked'          => $sitelinks_search_box,
				'item_label'       => esc_html__( 'Enable Google Sitelinks Searchbox', 'smartcrawl-seo' ),
				'item_description' => esc_html__( 'Note: WordPress comes with a search component built-in so we just need to link to it to enable this feature.', 'smartcrawl-seo' ),
			)
		);
		?>
	</div>
</div>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<label class="sui-settings-label">
			<?php esc_html_e( 'Output Page', 'smartcrawl-seo' ); ?>
		</label>
		<p class="sui-description">
			<?php esc_html_e( "It's recommended that your base person or organization schema output is put on the page that most reflects information related to your brand/company.", 'smartcrawl-seo' ); ?>
		</p>
	</div>

	<div class="sui-box-settings-col-2">
		<?php
		$this->render_view(
			'post-search-dropdown-form-field',
			array(
				'field_name'       => 'schema_output_page',
				'field_label'      => esc_html__( 'Output Page', 'smartcrawl-seo' ),
				'first_option'     => esc_html__( 'Homepage', 'smartcrawl-seo' ),
				'selected_post_id' => $schema_output_page,
				'pages'            => $pages,
			)
		);
		?>
	</div>
</div>
