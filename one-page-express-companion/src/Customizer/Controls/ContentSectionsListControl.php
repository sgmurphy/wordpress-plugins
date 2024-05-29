<?php

namespace OnePageExpress\Customizer\Controls;

class ContentSectionsListControl extends RowsListControl {


	public function init() {
		$this->cpData['type']      = 'mod_changer';
		$this->type                = $this->cpData['type'];
		$this->cpData['selection'] = apply_filters( 'cloudpress\customizer\control\content_sections\multiple', 'check' );
		parent::init();
	}

	public function alterSourceData( $data ) {
		$categorized = array();

		foreach ( $data as $id => $item ) {
			if ( ! isset( $item['category'] ) ) {
				$item['category'] = 'general';
			}

			$category = strtolower( $item['category'] );

			if ( ! isset( $categorized[ $category ] ) ) {
				$categorized[ $category ] = array();
			}

			$categorized[ $category ][] = $item;
		}

		$categorized = apply_filters( 'cloudpress\customizer\control\content_sections\data', $categorized );

		return $categorized;
	}

	public function renderModChanger() {
		$items = $this->getSourceData();
		?>

		<ul <?php $this->dataAttrs(); ?> class="list rows-list">
			<?php foreach ( $items as $category => $data ) : ?>

				<?php $label = apply_filters( 'cloudpress\customizer\control\content_sections\category_label', $category, $category ); ?>

				<li data-category="<?php echo esc_attr( $category ); ?>" class="category-title">
					<span><?php echo esc_html( $label ); ?></span>
				</li>

				<?php foreach ( $data as $item ) : ?>
					<?php $used = ( $item['id'] === $this->value() ) ? 'already-in-page' : ''; ?>
					<?php $proOnly = isset( $item['pro-only'] ) ? 'pro-only' : ''; ?>

					<li class="item available-item <?php echo esc_attr( $used ); ?> <?php echo esc_attr( $proOnly ); ?>" data-id="<?php echo esc_attr( $item['id'] ); ?>">
						<div class="image-holder" style="background-position:center center;">
							<img src="<?php echo esc_attr( $item['thumb'] ); ?>?cloudpress-companion?v=1" />
						</div>

						<?php if ( $proOnly ) : ?>
							<span data-id="<?php echo esc_attr( $item['id'] ); ?>" data-pro-only="true" class="available-item-hover-button" <?php $this->getSettingAttr(); ?>>
								<?php _e( 'Available in PRO', 'cloudpress-companion' ); ?>
							</span>
						<?php else : ?>
							<span data-id="<?php echo esc_attr( $item['id'] ); ?>" class="available-item-hover-button" <?php $this->getSettingAttr(); ?>>
								<?php echo esc_html( $this->cpData['insertText'] ); ?>
							</span>
						<?php endif; ?>

						<div title="Section is already in page" class="checked-icon"></div>
						<div title="Pro Only" class="pro-icon"></div>
						<span class="item-preview" data-preview="<?php echo esc_attr( $item['preview'] ); ?>">
							<i class="icon"></i>
						</span>
						<?php if ( isset( $item['description'] ) ) : ?>
							<span class="description"> <?php echo esc_html( $item['description'] ); ?> </span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</ul>
		<input type="hidden" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />

		<?php
	}
}
