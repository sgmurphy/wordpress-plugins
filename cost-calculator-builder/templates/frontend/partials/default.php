<?php $get_date_format = get_option( 'date_format' ); ?>

<div class="calc-list-inner">
	<div class="calc-item-title">
		<div class="ccb-calc-heading" v-text="getTheTitle"></div>
	</div>
	<div v-if="calc_data" class="calc-fields-container">
		<template v-for="field in calc_data.fields">
			<template v-if="field && field.alias && field.type !== 'Total' && !field.alias.includes( 'group' )">
				<component
						format="<?php esc_attr( $get_date_format ); ?>"
						text-days="<?php esc_attr_e( 'days', 'cost-calculator-builder' ); ?>"
						v-if="fields[field.alias] && !field.group_id"
						:is="field._tag"
						:id="calc_data.id"
						:field="field"
						:converter="currencyFormat"
						:disabled="fields[field.alias].disabled"
						v-model="fields[field.alias].value"
						v-on:change="change"
						v-on:[field._event]="change"
						v-on:condition-apply="renderCondition"
						@delete-repeater="deleteRepeater"
						@add-repeater="deleteRepeater"
						:key="!field.hasNextTick ? field.alias : field.alias + '_' + fields[field.alias].nextTickCount"
				>
				</component>
			</template>
			<template v-if="field.alias && field.alias.includes('group')">
				<component
						format="<?php esc_attr( $get_date_format ); ?>"
						text-days="<?php esc_attr_e( 'days', 'cost-calculator-builder' ); ?>"
						v-if="fields[field.alias] && !field.group_id"
						:is="field._tag"
						:id="calc_data.id"
						:field="field"
						:converter="currencyFormat"
						:disabled="fields[field.alias].disabled"
						v-model="fields[field.alias].value"
						v-on:change="change"
						v-on:[field._event]="change"
						v-on:condition-apply="renderCondition"
						@delete-repeater="deleteRepeater"
						@add-repeater="deleteRepeater"
						:key="!field.hasNextTick ? field.alias : field.alias + '_' + fields[field.alias].nextTickCount"
				>
					<slot>
						<template v-for="element in calc_data.fields">
							<component
									format="<?php esc_attr( $get_date_format ); ?>"
									text-days="<?php esc_attr_e( 'days', 'cost-calculator-builder' ); ?>"
									v-if="fields[element.alias] && element.group_id === field.alias"
									:is="element._tag"
									:id="calc_data.id"
									:field="element"
									:converter="currencyFormat"
									:disabled="fields[element.alias].disabled"
									v-model="fields[element.alias].value"
									v-on:change="change"
									v-on:[element._event]="change"
									v-on:condition-apply="renderCondition"
									@delete-repeater="deleteRepeater"
									@add-repeater="deleteRepeater"
									:key="!element.hasNextTick ? element.alias : element.alias + '_' + fields[element.alias].nextTickCount"
							>
							</component>
						</template>
					</slot>
				</component>
			</template>
			<template v-else-if="field && !field.alias && field.type !== 'Total'">
				<component
						:id="calc_data.id"
						style="boxStyle"
						:is="field._tag"
						:field="field"
				>
				</component>
			</template>
		</template>
	</div>
</div>
