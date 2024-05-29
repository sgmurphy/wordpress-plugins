<?php
/**
 * @file
 * Cost-quantity component's template
 */

	$lang = get_bloginfo( 'language' );
?>
<div :style="additionalCss" class="calc-item ccb-field" :class="{rtl: rtlClass('<?php echo esc_attr( $lang ); ?>'), required: $store.getters.isUnused(rangeField), [rangeField.additionalStyles]: rangeField.additionalStyles}" :data-id="rangeField.alias" >
	<div class="calc-range" :class="['calc_' + rangeField.alias]">
		<div class="calc-item__title ccb-range-field">
			<span>
				{{ rangeField.label }}
				<span class="ccb-required-mark" v-if="rangeField.required">*</span>
				<span v-if="rangeField.required" class="calc-required-field">
					<div class="ccb-field-required-tooltip">
						<span class="ccb-field-required-tooltip-text" :class="{active: $store.getters.isUnused(rangeField)}" style="display: none;">
							{{ $store.getters.getSettings.texts.required_msg }}
						</span>
					</div>
				</span>
			</span>
			<span> {{ getFormatedValue }}</span>
		</div>

		<div class="calc-item__description before">
			<span v-html="rangeField.description"></span>
		</div>

		<div :class="['range_' + rangeField.alias]" class="calc-range-slider" :style="getStyles">
			<input type="range" :min="min" :max="max" :step="step" v-model="rangeValue" @input="change">
			<output class="cost-calc-range-output-free"></output>
			<div class='calc-range-slider__progress'></div>
		</div>

		<div class="calc-range-slider-min-max">
			<span>{{ min }}</span>
			<span>{{ max }}</span>
		</div>

		<div class="calc-item__description after" >
			<span v-html="rangeField.description"></span>
		</div>
	</div>
</div>
