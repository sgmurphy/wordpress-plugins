<div class="modal-header condition" v-if="$store.getters.getConditionData">
	<div class="modal-header__title">
		<div class="modal-title">
			<div class="add-condition-link-header">
				<span class="ccb-heading-5">
					<?php esc_html_e( 'Edit Link', 'cost-calculator-builder' ); ?>:
				</span>
				<span class="link-fields">
					<span class="ccb-heading-5" style="color: #00b163;"> {{ getByAlias($store.getters.getConditionData.optionFrom)?.label || 'Element From' }}</span>
					<i class="field-arrow" style="color: #333333"></i>
					<span class="ccb-heading-5" style="color: #00b163;"> {{ getByAlias($store.getters.getConditionData.optionTo)?.label || 'Element To' }}</span>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="modal-body condition ccb-custom-scrollbar">
	<div class="condition-item" v-for="(model, index) in $store.getters.getConditionModel" v-if="$store.getters.getConditionModel.length > 0">
		<div class="conditions">
			<div class="condition-list" v-for="( additionalCondition, additionalConditionIndex ) in model.conditions">
				<div class="condition">
					<div class="select-with-label">
						<div class="select-label">
							<?php esc_html_e( 'Condition', 'cost-calculator-builder' ); ?>
						</div>
						<select @change="checkCorrectForAdditionalAnd(index)" v-model="additionalCondition.condition" style="padding-right: 0; width: 100%; text-overflow: ellipsis; white-space: nowrap;">
							<option value=""><?php esc_html_e( 'Select condition', 'cost-calculator-builder' ); ?></option>
							<option v-for="(conditionState, key) in  $store.getters.getStaticConditionStatesByField( $store.getters.getConditionData.optionFrom )" :value="conditionState.value">
								{{ conditionState.title }}
							</option>
						</select>
					</div>
					<div class="select-with-label" v-if="!['in', 'not in', 'contains'].includes(additionalCondition.condition)">
						<div class="select-label">
							<?php esc_html_e( 'Value', 'cost-calculator-builder' ); ?>
						</div>
						<select v-model="additionalCondition.key" v-if="$store.getters.getConditionData.type === 'select' && !['>=', '<=', '== & distance', '<= & distance', '>= & distance', '!= & distance'].includes(additionalCondition.condition)">
							<option value=""><?php esc_html_e( 'Select option', 'cost-calculator-builder' ); ?></option>
							<option value="any"><?php esc_html_e( 'Select any', 'cost-calculator-builder' ); ?></option>
							<template v-if="$store.getters.getConditionData.optionFrom.includes('geolocation')">
								<option v-for="(item, key) in $store.getters.getFieldOptionsByFieldId($store.getters.getConditionData.optionFrom)" :value="key">
									{{ item.label }}
								</option>
							</template>
							<template v-else>
								<option v-for="(item, key) in $store.getters.getConditionOptions" :value="key">
									{{ item.optionText }}
								</option>
							</template>
						</select>
						<input v-else type="number" v-model="additionalCondition.value" placeholder="<?php esc_html_e( 'Set value', 'cost-calculator-builder' ); ?>"/>
					</div>
					<div class="select-with-label" v-else-if="additionalCondition.condition === 'contains'">
						<div class="select-label">
							<?php esc_html_e( 'Value', 'cost-calculator-builder' ); ?>
						</div>
						<select v-model="additionalCondition.key">
							<option value=""><?php esc_html_e( 'Select option', 'cost-calculator-builder' ); ?></option>
							<option value="any"><?php esc_html_e( 'Select any', 'cost-calculator-builder' ); ?></option>
							<option v-for="(item, key) in $store.getters.getFieldOptionsByFieldId($store.getters.getConditionData.optionFrom)" :value="key">
								{{ item.optionText }}
							</option>
						</select>
					</div>
					<div class="select-with-label" v-else>
						<div class="select-label">
							<?php esc_html_e( 'Option', 'cost-calculator-builder' ); ?>
						</div>

						<div class="multiselect" tabindex="100" style="min-height: 38px; height: 38px; border-radius: 0 4px 4px 0; border: 0;">
							<span v-if="model.setVal.length > 0" class="anchor" @click.prevent="multiselectShow(event)">
								{{ model.setVal.split(',').length }} <?php esc_html_e( 'options selected', 'cost-calculator-builder' ); ?>
							</span>
							<span v-else class="anchor" style="padding-left: 0;" @click.prevent="multiselectShow(event)">
								<template v-if="additionalCondition.checkedValues && additionalCondition.checkedValues.length > 0">
									{{ additionalCondition.checkedValues.length }} <?php esc_html_e( 'option(s) selected', 'cost-calculator-builder' ); ?>
								</template>
								<template v-else>
									<?php esc_html_e( 'Select option', 'cost-calculator-builder' ); ?>
								</template>
							</span>
							<ul class="items custom-items" style="padding-top: 8px; border-top: 1px solid #dddddd; top: 38px">
								<li class="option-item" v-for="(item, optionIndex) in $store.getters.getFieldOptionsByFieldId($store.getters.getConditionData.optionFrom)" style="margin-bottom: 10px">
									<label class="ccb-checkboxes" :key="optionIndex" style="display: flex; align-items: center">
										<input type="checkbox" v-model="additionalCondition.checkedValues" :data-idx="optionIndex" :value="optionIndex" style="margin-right: 0;">
										<span class="ccb-checkboxes-label">{{ item.optionText }}</span>
									</label>
								</li>
							</ul>
						</div>
					</div>
					<i class="remove-condition" @click.prevent="removeConditionAction(index, additionalConditionIndex)"></i>
				</div>
				<div class="add-condition-border">
					<span class="ccb-options-tooltip" v-if="(+additionalConditionIndex + 1) === model.conditions.length" @click.prevent="addRowForOrAndCondition(index)">
						<i class="add-condition"></i>
						<span class="ccb-options-tooltip__text"><?php esc_html_e( 'Add a condition/s if you want two or more conditions to show one action.', 'cost-calculator-builder' ); ?></span>
					</span>

					<select v-else v-model="additionalCondition.logicalOperator" class="additional-condition-operator">
						<option v-if="checkIsCanAddMultipleConditionInRow($store.getters.getConditionData.optionFrom, additionalCondition.condition)" value="&&"><?php esc_html_e( 'And', 'cost-calculator-builder' ); ?></option>
						<option value="||"><?php esc_html_e( 'Or', 'cost-calculator-builder' ); ?></option>
					</select>
				</div>
			</div>
		</div>
		<div class="action" style="flex: 1">
			<div class="select-with-label">
				<div class="select-label">
					<?php esc_html_e( 'Action', 'cost-calculator-builder' ); ?>
				</div>
				<select name="conditionAction" @change="cleanSetVal(index)" v-model="model.action">
					<option value=""><?php esc_html_e( 'Select action', 'cost-calculator-builder' ); ?></option>

					<option v-for="conditionActions in $store.getters.getStaticConditionActionsByField($store.getters.getConditionData.optionTo)" v-if="model.optionFrom.indexOf('total_field') !== -1 && !['hide', 'unset', 'set_value', 'set_value_and_disable'].includes(conditionActions.value)" :value="conditionActions.value">
						{{ conditionActions.title }}
					</option>

					<option v-for="conditionActions in $store.getters.getStaticConditionActionsByField($store.getters.getConditionData.optionTo)" v-if="model.optionFrom.indexOf('total_field') === -1" :value="conditionActions.value">
						{{ conditionActions.title }}
					</option>
				</select>
			</div>

			<!--        SET VALUE START-->
			<div class="select-with-label" v-if="model.action === 'set_value' || model.action === 'set_value_and_disable'">
				<div class="select-label">
					<?php esc_html_e( 'Value', 'cost-calculator-builder' ); ?>
				</div>
				<input type="number" v-model="model.setVal">
			</div>
			<!--        SET VALUE END-->
			<!--        SET TIME START-->
			<div class="select-with-label" v-if="!$store.getters.getFieldFormatByFieldAlias($store.getters.getConditionData.optionTo).range && (model.action === 'set_time' || model.action === 'set_time_and_disable')">
				<div class="select-label">
					<?php esc_html_e( 'Basic', 'cost-calculator-builder' ); ?>
				</div>
				<div class="custom-input-date">
					<div class="basic-time-picker">
						<vue-timepicker
							:minute-interval="5"
							manual-input
							fixed-dropdown-button
							close-on-complete
							v-model="model.setVal"
							:format="$store.getters.getFieldFormatByFieldAlias($store.getters.getConditionData.optionTo).format ? 'hh:mm' : 'hh:mm a' "
							@input="setTime($event, index,'basic')"
						>
						</vue-timepicker>
					</div>
				</div>
			</div>
			<div class="select-with-label" v-if="$store.getters.getFieldFormatByFieldAlias($store.getters.getConditionData.optionTo).range && (model.action === 'set_time' || model.action === 'set_time_and_disable')">
				<div class="select-label">
					<?php esc_html_e( 'Start', 'cost-calculator-builder' ); ?>
				</div>
				<div class="custom-input-date">
					<div class="start-time-picker">
						<vue-timepicker
							:minute-interval="5"
							manual-input
							close-on-complete
							fixed-dropdown-button
							@change="setTime($event, index, 'start')"
							:value = "( model.setVal.length > 0 && JSON.parse(model.setVal).hasOwnProperty('start')) ? JSON.parse(model.setVal)['start']: ''"
							:format="$store.getters.getFieldFormatByFieldAlias($store.getters.getConditionData.optionTo).format ? 'hh:mm' : 'hh:mm a'"
						></vue-timepicker>

						<template v-slot:dropdownButton>
								<img src="<?php echo esc_url( CALC_URL . '/images/time_picker.svg' ); ?>" alt="">
							</template>
						</vue-timepicker>
					</div>
				</div>
			</div>
			<div class="select-with-label" v-if="$store.getters.getFieldFormatByFieldAlias($store.getters.getConditionData.optionTo).range && (model.action === 'set_time' || model.action === 'set_time_and_disable')">
				<div class="select-label">
					<?php esc_html_e( 'End', 'cost-calculator-builder' ); ?>
				</div>
				<div class="custom-input-date">
					<div class="end-time-picker">
						<vue-timepicker
							:minute-interval="5"
							manual-input
							close-on-complete
							fixed-dropdown-button
							@change="setTime($event, index, 'end')"
							:value="(model.setVal.length > 0 && JSON.parse(model.setVal).hasOwnProperty('end')) ? JSON.parse(model.setVal)['end']: ''"
							:placeholder="$store.getters.getFieldFormatByFieldAlias($store.getters.getConditionData.optionTo).format ? '' : 'hh:mm a' "
							:format="$store.getters.getFieldFormatByFieldAlias($store.getters.getConditionData.optionTo).format ? '' : 'hh:mm a' "
						>
							<template v-slot:dropdownButton>
								<img src="<?php echo esc_url( CALC_URL . '/images/time_picker.svg' ); ?>" alt="">
							</template>
						</vue-timepicker>
					</div>
				</div>
			</div>
			<!--        SET TIME END-->


			<!--        SET DATE START-->
			<div class="select-with-label" v-if="model.action === 'set_date' || model.action === 'set_date_and_disable'">
				<div class="select-label">
					<?php esc_html_e( 'Date', 'cost-calculator-builder' ); ?>
				</div>
				<custom-date-calendar :class="{'ccb-date-required': errors[index]}" @set-date="setDate" @clean="cleanSetVal" :index="index" :field="$store.getters.getFieldByFieldId($store.getters.getConditionData.optionTo)"></custom-date-calendar>
			</div>
			<!--        SET DATE END-->

			<!--        SET PERIOD FOR DATE WITH RANGE START-->
			<div class="select-with-label" v-if="$store.getters.getFieldNameByFieldId($store.getters.getConditionData.optionTo) == 'datePicker' && ( model.action === 'set_period' || model.action === 'set_period_and_disable') ">
				<div class="select-label">
					<?php esc_html_e( 'Period', 'cost-calculator-builder' ); ?>
				</div>
				<custom-date-calendar :class="{'ccb-date-required': errors[index]}" @set-date="setRangeDate" @clean="cleanSetVal" :index="index" :field="$store.getters.getFieldByFieldId($store.getters.getConditionData.optionTo)"></custom-date-calendar>
				<span class="error-tip" v-if="errors.range_date_error != null" v-html="errors.range_date_error"></span>
			</div>
			<!--        SET PERIOD FOR DATE WITH RANGE END-->

			<!--        SET PERIOD FOR MULTI RANGE START-->
			<div class="select-with-label" v-if="$store.getters.getFieldNameByFieldId($store.getters.getConditionData.optionTo) == 'multi_range' && ( model.action === 'set_period' || model.action === 'set_period_and_disable') ">
				<div class="select-label">
					<?php esc_html_e( 'From', 'cost-calculator-builder' ); ?>
				</div>
				<input @change="setMultiRange(event, index)" type="number" name="start" :value="( model.setVal.length > 0 && JSON.parse(model.setVal).hasOwnProperty('start')) ? JSON.parse(model.setVal)['start']: ''">
				<span class="error-tip" v-if="errors.multi_range_error != null" v-html="errors.multi_range_error"></span>
			</div>
			<div class="select-with-label" v-if="$store.getters.getFieldNameByFieldId($store.getters.getConditionData.optionTo) == 'multi_range' && ( model.action === 'set_period' || model.action === 'set_period_and_disable') ">
				<div class="select-label">
					<?php esc_html_e( 'To', 'cost-calculator-builder' ); ?>
				</div>
				<input @change="setMultiRange(event, index)" type="number" name="end" :value="( model.setVal.length > 0 && JSON.parse(model.setVal).hasOwnProperty('end')) ? JSON.parse(model.setVal)['end']: ''">
			</div>
			<!--        SET PERIOD FOR MULTI RANGE END-->

			<!--        SET LOCATION  START-->
			<div class="select-with-label" v-if="['geolocation'].includes($store.getters.getFieldNameByFieldId($store.getters.getConditionData.optionTo)) && (model.action === 'set_location' || model.action === 'set_location_and_disable')">
				<div class="select-label">
					<?php esc_html_e( 'Option', 'cost-calculator-builder' ); ?>
				</div>
				<select v-if name="setLocations[]" v-model="model.setVal" >
					<option v-for="(item, optionIndex) in $store.getters.getFieldOptionsByFieldId($store.getters.getConditionData.optionTo)"
							:value="optionIndex">
						{{ item.label }}
					</option>
				</select>
			</div>
			<!--        SET LOCATION  END-->

			<!--        SET OPTION  START-->
			<div class="select-with-label" v-if="model.action === 'select_option' || model.action === 'select_option_and_disable'">
				<div class="select-label">
					<?php esc_html_e( 'Option', 'cost-calculator-builder' ); ?>
				</div>
				<!--        FOR multiple items (checkbox, toggle) -->
				<div v-if="['checkbox', 'toggle', 'checkbox_with_img'].includes( $store.getters.getFieldNameByFieldId($store.getters.getConditionData.optionTo))" class="multiselect" tabindex="100">
					<span v-if="model.setVal.length > 0" class="anchor" @click.prevent="multiselectShow(event)">
						{{ model.setVal.split(',').length }} <?php esc_html_e( 'options selected', 'cost-calculator-builder' ); ?>
					</span>
					<span v-else class="anchor" @click.prevent="multiselectShow(event)">
						<?php esc_html_e( 'Select option', 'cost-calculator-builder' ); ?>
					</span>
					<ul class="items">
						<li class="option-item" @click="multiselectChoose(event, optionIndex, index)"
							v-for="(item, optionIndex) in $store.getters.getFieldOptionsByFieldId($store.getters.getConditionData.optionTo)">
							<input :checked="( model.setVal.length > 0 && model.setVal.split(',').map(Number).includes(optionIndex))" @change="multiselectChoose(event, optionIndex);" :class="['index',optionIndex].join('_')" type="checkbox"/>
							<span class="option-item-text">{{ item.optionText }}</span>
						</li>
					</ul>
					<input v-model="model.setVal" name="options" type="hidden" :class="$store.getters.getConditionData.optionTo"/>
				</div>

				<!--        FOR one value (radio, dropDown) -->
				<select v-else name="setOptions[]" v-model="model.setVal">
					<option v-for="(item, optionIndex) in $store.getters.getFieldOptionsByFieldId($store.getters.getConditionData.optionTo)"
							:value="optionIndex">
						{{ item.optionText }}
					</option>
				</select>

			</div>
			<!--        SET OPTION END-->
		</div>
		<div class="remove-full-condition" @click.prevent="removeRow(index)">
			<i class="remove-icon"></i>
		</div>
	</div>


	<div v-if="!$store.getters.getConditionModel.length" class="modal-body">
		<p class="ccb-heading-4" style="width: 100%; text-align: center; padding: 5px;">
			<?php esc_html_e( 'No Conditions Yet', 'cost-calculator-builder' ); ?>
		</p>
	</div>
</div>
<div class="modal-footer">
	<div class="condition">
		<div class="left">
			<button @click.prevent="addModel" type="button" class="modal-btn ccb-default-description ccb-normal dark">
				<i class="ccb-icon-Path-3453"></i>
				<span><?php esc_html_e( 'Add condition', 'cost-calculator-builder' ); ?></span>
			</button>
		</div>

		<div class="right">
			<button type="button" class="modal-btn ccb-default-description ccb-normal delete dark" @click.prevent="removeLink">
				<span><?php esc_html_e( 'Delete', 'cost-calculator-builder' ); ?></span>
			</button>
			<button type="button" class="modal-btn ccb-default-description ccb-normal green" @click.prevent="saveLink">
				<span><?php esc_html_e( 'Save', 'cost-calculator-builder' ); ?></span>
			</button>
		</div>
	</div>
</div>
