<!--
  - NOTICE OF LICENSE
  -
  - This source file is subject to a commercial license from SARL 202 ecommerce
  - Use, copy, modification or distribution of this source file without written
  - license agreement from the SARL 202 ecommerce is strictly forbidden.
  - In order to obtain a license, please contact us: tech@202-ecommerce.com
  - ...........................................................................
  - INFORMATION SUR LA LICENCE D'UTILISATION
  -
  - L'utilisation de ce fichier source est soumise a une licence commerciale
  - concedee par la societe 202 ecommerce
  - Toute utilisation, reproduction, modification ou distribution du present
  - fichier source sans contrat de licence ecrit de la part de la SARL 202 ecommerce est
  - expressement interdite.
  - Pour obtenir une licence, veuillez contacter 202-ecommerce <tech@202-ecommerce.com>
  - ...........................................................................
  -
  - @author    202-ecommerce <tech@202-ecommerce.com>
  - @copyright Copyright (c) 202-ecommerce
  - @license   Commercial license
  -->

<script setup lang="ts">
import {useTrans} from "../../../use/useTrans.ts";
import {useConfigurationStore} from "../../../stores/configurationStore.ts";
import VueMultiselect from "vue-multiselect";
import {Reactive, reactive, Ref, ref, watch} from "vue";

const {trans} = useTrans();
const configurationStore = useConfigurationStore();
const triggerGtmEventsTypes: Reactive<{
  name: string;
  value: number;
}[]> = reactive([
  {
    name: trans('edit.advanced.send_all_events'),
    value: 0
  },
  {
    name: trans('edit.advanced.no_send_events'),
    value: 1
  },
  {
    name: trans('edit.advanced.send_update_events'),
    value: 2
  },
]);
const triggerGtmEventType: Ref<{
  name: string;
  value: number;
} | null | undefined> = ref(null);

triggerGtmEventType.value = triggerGtmEventsTypes.find(item => {
  return item.value === configurationStore.editConfiguration?.trigger_gtm_events;
});
watch(triggerGtmEventType, (newValue: {name: string; value: number} | null | undefined) => {
  if (configurationStore.editConfiguration && newValue) {
    configurationStore.editConfiguration.trigger_gtm_events = newValue.value;
  }
})

</script>

<template>
  <div class="row" v-if="configurationStore.editConfiguration">
    <div class="col-6">
      <div class="form-group">
        <div class="form-group">
          <label class="form-control-label"
                 v-text="trans('edit.advanced.event_in_datalayer')"></label>
          <VueMultiselect v-model="triggerGtmEventType"
                          tag-placeholder=""
                          placeholder=""
                          label="name"
                          track-by="value"
                          :searchable="false"
                          :select-label="''"
                          :selected-label="''"
                          :deselect-label="''"
                          :options="triggerGtmEventsTypes"
                          :multiple="false"
                          :allow-empty="false"></VueMultiselect>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>