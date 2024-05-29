<?php

namespace POCHIPP;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Setting {

	/**
	 * テキストフィールドを出力する
	 */
	public static function output_text_field( $args ) {
		$key         = $args['key'] ?? '';
		$size        = $args['size'] ?? '40';
		$description = $args['description'] ?? '';
		$val         = $args['val'] ?? '';
		$name        = $args['name'] ?? \POCHIPP::DB_NAME;

		$name = $name . '[' . $key . ']';
		$val  = $val ?: \POCHIPP::get_setting( $key );
		?>
			<div class="pchpp-setting__field -text">
				<div class="pchpp-setting__item">
					<input type="text" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $val ); ?>" size="<?php echo esc_attr( $size ); ?>" />
				</div>
			</div>
			<?php if ( $description ) : ?>
				<p class="pchpp-setting__desc"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		<?php
	}


	/**
	 * テキストエリアを出力する
	 */
	public static function output_textarea( $args ) {
		$key  = $args['key'] ?? '';
		$rows = $args['rows'] ?? '4';

		$name = \POCHIPP::DB_NAME . '[' . $key . ']';
		$val  = \POCHIPP::get_setting( $key );

		?>
			<div class="pchpp-setting__field -textarea">
				<div class="pchpp-setting__item">
					<?php //phpcs:ignore ?>
					<textarea id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $name ); ?>" rows="<?php echo esc_attr($rows); ?>"><?php echo $val; ?></textarea>
				</div>
			</div>
		<?php
	}

	/**
	 * hiddenタグを出力する
	 */
	public static function output_hidden( $args ) {
		$key        = $args['key'] ?? '';
		$nested_key = $args['nested_key'] ?? '';
		$val        = $args['val'] ?? \POCHIPP::get_setting( $key );

		$name = \POCHIPP::DB_NAME . '[' . $key . ']' . ( $nested_key ? '[' . $nested_key . ']' : '' );

		?>
		<div class="pchpp-setting__field">
			<div class="pchpp-setting__item">
				<input type="hidden" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $val ); ?>" >
			</div>
		</div>
		<?php
	}

	/**
	 * 固定テキストを出力する
	 * memo: Pochipp Proで利用しているため削除禁止
	 */
	public static function output_hiddentext( $args ) {
		$key  = $args['key'] ?? '';
		$name = $args['name'] ?? \POCHIPP::DB_NAME;
		$val  = $args['val'] ?: \POCHIPP::get_setting( $key );
		$text = $args['text'] ?? $val;

		$name = $name . '[' . $key . ']';

		?>
			<div class="pchpp-setting__field">
				<div class="pchpp-setting__item">
				<?php //phpcs:ignore ?>
					<p><span><?php echo $text; ?></span></p>
					<input type="hidden" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $val ); ?>" >
				</div>
			</div>
		<?php
	}

	/**
	 * ラジオボタンを出力する
	 */
	public static function output_radio( $args ) {

		$key     = $args['key'] ?? '';
		$choices = $args['choices'] ?? '';
		$class   = $args['class'] ?? '';
		$name    = $args['name'] ?? \POCHIPP::DB_NAME;

		$name = $name . '[' . $key . ']';
		$val  = \POCHIPP::get_setting( $key );

		?>
		<div class="pchpp-setting__field -radio <?php echo esc_attr( $class ); ?>">
			<?php
				foreach ( $choices as $value => $label ) :
				$radio_id = $key . '_' . $value;
				$checked  = checked( $val, $value, false );
			?>
					<label for="<?php echo esc_attr( $radio_id ); ?>">
						<input type="radio" id="<?php echo esc_attr( $radio_id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo $checked; ?> >
						<span><?php echo wp_kses_post( $label ); ?></span>
					</label>
			<?php endforeach; ?>
		</div>
		<?php
	}


	/**
	 * チェックボックスを出力する
	 */
	public static function output_checkbox( $args ) {

		$label = $args['label'] ?? '';
		$key   = $args['key'] ?? '';

		$name = \POCHIPP::DB_NAME . '[' . $key . ']';
		$val  = \POCHIPP::get_setting( $key );

		$checked = checked( (string) $val, '1', false );

		?>
		<div class="pchpp-setting__field -checkbox">
			<input type="hidden" name="<?php echo esc_attr( $name ); ?>" value="">
			<input type="checkbox" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo $checked; ?> />
			<label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $label ); ?></label>
		</div>
		<?php
	}


	/**
	 * 配列形式のチェックボックスを出力する
	 */
	public static function output_checkbox_list( $args ) {

		$label     = $args['label'] ?? '';
		$key       = $args['key'] ?? '';
		$id        = $args['id'] ?? '';
		$image_url = $args['image_url'] ?? '';

		$name      = \POCHIPP::DB_NAME . '[' . $key . ']' . '[' . $id . ']';
		$array_val = \POCHIPP::get_setting( $key );
		$val       = $array_val !== '' ? $array_val[ $id ] ?? '' : '';

		$checked = checked( (string) $val, '1', false );

		?>
			<div class="pchpp-setting__field -checkbox">
				<input type="checkbox" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo $checked; ?> />
				<?php if ( $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $label ); ?>">
				<?php endif; ?>
				<label for="<?php echo esc_attr( $name ); ?>">
					<?php echo wp_kses_post( $label ); ?>
				</label>
			</div>
		<?php
	}


	/**
	 * カラーピッカーを出力する
	 */
	public static function output_colorpicker( $args ) {
		$key         = $args['key'] ?? '';
		$default     = $args['default'] ?? '';
		$description = $args['description'] ?? '';

		$name = \POCHIPP::DB_NAME . '[' . $key . ']';
		$val  = \POCHIPP::get_setting( $key );
		?>
			<div class="pchpp-setting__field -color">
				<div class="pchpp-setting__item">
					<input type="text" class="pochipp-colorpicker __icon_color"
						id="<?php echo esc_attr( $key ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						value="<?php echo esc_attr( $val ); ?>"
						data-default-color="<?php echo esc_attr( $default ); ?>"
					/>
				</div>
			</div>
			<?php if ( $description ) : ?>
				<p class="pchpp-setting__desc"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		<?php
	}


	/**
	 * デートピッカーフィールドを出力する
	 */
	public static function output_datepicker( $args ) {
		$key           = $args['key'] ?? '';
		$size          = $args['size'] ?? '20';
		$name          = $args['name'] ?? \POCHIPP::DB_NAME;
		$val_startline = $args['val_startline'] ?? '';
		$val_deadline  = $args['val_deadline'] ?? '';

		$key_start     = $key . 'startline';
		$key_end       = $key . 'deadline';
		$name_start    = $name . '[' . $key_start . ']';
		$name_end      = $name . '[' . $key_end . ']';
		$val_startline = $val_startline ?: \POCHIPP::get_setting( $key_start );
		$val_deadline  = $val_deadline ?: \POCHIPP::get_setting( $key_end );
		?>
			<div class="pchpp-setting__field -date">
				<div class="pchpp-setting__item">
					<input type="text" id="<?php echo esc_attr( $key_start ); ?>" class="pochipp-datepicker--start" name="<?php echo esc_attr( $name_start ); ?>" value="<?php echo esc_attr( $val_startline ); ?>" size="<?php echo esc_attr( $size ); ?>" autocomplete="off"/>
					<span class="__nami">~</span>
					<input type="text" id="<?php echo esc_attr( $key_end ); ?>" class="pochipp-datepicker--end" name="<?php echo esc_attr( $name_end ); ?>" value="<?php echo esc_attr( $val_deadline ); ?>" size="<?php echo esc_attr( $size ); ?>" autocomplete="off"/>
				</div>
			</div>
		<?php
	}
}
