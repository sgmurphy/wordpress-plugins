<template>
  <el-form-item
    ref="formFieldRef"
    class="am-ff__item"
    :prop="props.itemName"
    :label-position="props.labelPosition"
  >
    <template #label>
      <span class="am-ff__item-label" v-html="props.label" />
    </template>
    <AmDatePickerFull
      :existing-date="model"
      :persistent="false"
      :disabled="false"
      :week-starts-from-day="props.weekStartsFromDay"
      @selected-date="(dateString) => { selectedDatePickerValue(dateString) }"
    />
  </el-form-item>
</template>

<script setup>
// * _components
import AmDatePickerFull from '../../_components/date-picker-full/AmDatePickerFull.vue'

// * Import from Vue
import {
  computed,
  ref,
  toRefs
} from "vue";

// * Moment
import moment from "moment";

// * Form Item Props
let props = defineProps({
  modelValue: {
    type: [String, Array, Object, Number],
    required: true
  },
  itemName: {
    type: String,
    required: true
  },
  label: {
    type: String
  },
  labelPosition: {
    type: String,
    default: 'top'
  },
  weekStartsFromDay: {
    type: [String, Number],
    default: 1
  }
})

// * Define Emits
const emits = defineEmits(['update:modelValue'])

// * Component model
let { modelValue } = toRefs(props)
let model = computed({
  get: () => modelValue.value,
  set: (val) => {
    emits('update:modelValue', val)
  }
})

// * Form Item Reference
let formFieldRef = ref(null)

defineExpose({
  formFieldRef
})

function selectedDatePickerValue (dateString) {
  emits('update:modelValue', moment(dateString, 'YYYY-MM-DD').toDate())
}
</script>

<script>
export default {
  name: "DatePickerFormField"
}
</script>
