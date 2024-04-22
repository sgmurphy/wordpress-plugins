<template>
  <AmSelect
    v-model="timeZoneSelection"
    :filterable="true"
    :placeholder="useCurrentTimeZone()"
    :clearable="true"
    :size="props.size"
    custom-class="am-ctz"
    prefix-icon="globe-watch"
    @clear="returnToDefault"
    @change="timeZoneChanged"
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
  computed,
  inject,
  onBeforeMount
} from 'vue'

// * Component properties
let props = defineProps({
  size: {
    type: String,
    default: 'default'
  }
})

// * Import from Libraries
import { useCookies } from 'vue3-cookies'

// * Vars
const vueCookies = useCookies()['cookies']

// * Composables
import { useCurrentTimeZone } from "../../../../../assets/js/common/helper";

// * _components
import AmOption from "../../../../_components/select/AmOption.vue";
import AmSelect from "../../../../_components/select/AmSelect.vue";

// * Root Settings
const amSettings = inject('settings')

let cabinetType = inject('cabinetType')

let { bookingsCounterChanger } = inject('bookingsCounterChanger', {
  bookingsCounterChanger: () => {}
})

// * import from Vuex
import { useStore } from 'vuex'

// * Define store
const store = useStore()

let timeZoneSelection = computed({
  get: () => store.getters['cabinet/getTimeZone'],
  set: (val) => {
    store.commit('cabinet/setTimeZone', val ? val : '')
  }
})

const adminTimeZone = inject('timeZone')

const timeZones = inject('timeZones')

function returnToDefault () {
  store.commit('cabinet/setTimeZone', useCurrentTimeZone())
}

function timeZoneChanged (selection) {
  vueCookies.set(
    'ameliaUserTimeZone',
    selection,
    amSettings.roles[cabinetType.value + 'Cabinet']['tokenValidTime']
  )

  bookingsCounterChanger()
}

onBeforeMount(() => {
  if (!amSettings.general.showClientTimeZone) {
    let initialTimeZone = adminTimeZone.value

    if (vueCookies.get('ameliaUserTimeZone')) {
      initialTimeZone = vueCookies.get('ameliaUserTimeZone')
    }

    store.commit('cabinet/setTimeZone', initialTimeZone)
  }

  if (!store.getters['cabinet/getTimeZone']) store.commit('cabinet/setTimeZone', useCurrentTimeZone())
})
</script>

<style lang="scss">
@mixin am-cabinet-time-zone {
  // ctz - customer time zone
  .am-ctz {
    .el-input {
      &__inner {
        padding: 8px 24px 8px 36px !important;
      }

      &__prefix {
        left: 4px;
        font-size: 30px;
        color: var(--am-c-select-text);
      }
    }
  }
}


// public
.amelia-v2-booking #amelia-container {
  @include am-cabinet-time-zone;
}
</style>