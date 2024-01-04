<template>
  <el-form-item
    v-if="props.visible"
    ref="formFieldRef"
    class="am-ff__item"
    :prop="props.itemName"
    :label-position="props.labelPosition"
  >
    <template #label>
      <span class="am-ff__item-label" v-html="props.label" />
    </template>
    <AmInput
      v-model="model"
      :name="props.itemName"
      :type="props.itemType"
      :placeholder="props.placeholder"
      :disabled="props.disabled"
    ></AmInput>
  </el-form-item>
</template>

<script setup>
// * _components
import AmInput from'../../_components/input/AmInput.vue'

// * Import from Vue
import {
  computed,
  ref,
  toRefs
} from "vue";

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
  itemType: {
    type: String,
    default: 'text'
  },
  label: {
    type: String
  },
  labelPosition: {
    type: String,
    default: 'top'
  },
  placeholder: {
    type: String
  },
  visible: {
    type: Boolean,
    default: true
  },
  disabled: {
    type: Boolean,
    default: false
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
</script>

<script>
export default {
  name: "FirstNameFormField"
}
</script>
