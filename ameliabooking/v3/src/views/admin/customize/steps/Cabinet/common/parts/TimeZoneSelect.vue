<template>
  <AmSelect
    v-model="timeZoneSelection"
    :filterable="true"
    :placeholder="useCurrentTimeZone()"
  >
    <AmOption
      v-for="(timeZone, index) in timeZones"
      :key="index"
      :value="timeZone"
      :label="timeZone"
    >
      {{ timeZone }}
    </AmOption>
  </AmSelect>
</template>

<script setup>
// * Import from Vue
import {
  ref
} from 'vue'

// * Composables
import { useCurrentTimeZone } from "../../../../../../../assets/js/common/helper";

// * _components
import AmOption from "../../../../../../_components/select/AmOption.vue";
import AmSelect from "../../../../../../_components/select/AmSelect.vue";

let timeZoneSelection = ref(useCurrentTimeZone())

const timeZones = ref([])
</script>

<style lang="scss">

</style>