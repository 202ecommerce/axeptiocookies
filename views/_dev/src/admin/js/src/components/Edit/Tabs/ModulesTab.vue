<!--
  - Copyright since 2022 Axeptio
  -
  - NOTICE OF LICENSE
  -
  - This source file is subject to the Academic Free License (AFL 3.0)
  - that is bundled with this package in the file LICENSE.md.
  - It is also available through the world-wide-web at this URL:
  - https://opensource.org/licenses/AFL-3.0
  - If you did not receive a copy of the license and are unable to
  - obtain it through the world-wide-web, please send an email
  - to tech@202-ecommerce.com so we can send you a copy immediately.
  -
  - @author    202 ecommerce <tech@202-ecommerce.com>
  - @copyright 2022 Axeptio
  - @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
  -->
<script setup lang="ts">
import {useTrans} from "../../../use/useTrans.ts";
import {useConfigurationStore} from "../../../stores/configurationStore.ts";
import {computed} from "vue";
import {useConfig} from "../../../use/useConfig.ts";

const {trans} = useTrans();
const configurationStore = useConfigurationStore();
const {images} = useConfig();

const isResetBtnVisible = computed(() => {
  if (!configurationStore.editConfiguration?.modules) {
    return false;
  }

  return configurationStore.editConfiguration.modules.filter(module => {
    return (!(module.recommended !== false && module.recommended.isRequired) && module.checked)
        || module.recommended !== false && module.recommended.isRequired && !module.checked;
  }).length > 0;
});

const handleResetToRecommendedModules = () => {
  if (!isResetBtnVisible.value) {
    return;
  }
  if (!configurationStore.editConfiguration?.modules) {
    return false;
  }
  configurationStore.editConfiguration.modules.forEach(module => {
    module.checked = module.recommended !== false && module.recommended.isRequired;
  });
};

const getPrettyModuleName = (name: string) => {
  const areaElement = document.createElement('textarea');
  areaElement.innerHTML = name;
  const text = areaElement.value;
  areaElement.remove();

  return text;
};

const handleModuleClick = (index: number) => {
  if (!configurationStore.editConfiguration?.modules?.[index]) {
    return;
  }
  configurationStore.editConfiguration.modules[index].checked = !configurationStore.editConfiguration.modules[index].checked;
};

</script>

<template>
  <div class="d-flex flex-column">
    <div class="d-inline-flex justify-content-end mb-3 module-tab-actions" v-if="isResetBtnVisible">
      <button class="btn btn-lg btn-outline-info"
              v-if="isResetBtnVisible"
              v-text="trans('edit.recommended.reset')"
              type="button"
              @click="handleResetToRecommendedModules">
      </button>
    </div>
    <div class="form-group" v-if="configurationStore.editConfiguration">
      <div class="modules-wrapper">
        <div class="d-flex flex-wrap">
          <div v-for="(module, index) of configurationStore.editConfiguration.modules"
               :key="module.id_module"
               @click="handleModuleClick(index)"
               class="md-checkbox col-4 module-item">
            <div class="d-flex" v-if="configurationStore.editConfiguration.modules">
              <input type="checkbox" v-model="configurationStore.editConfiguration.modules[index].checked"/>
              <i class="md-checkbox-control"></i>
              <div class="d-flex ml-3">
                <div class="img-wrapper img-fluid" v-if="module.image">
                  <img :src="module.image" :alt="module.name">
                </div>
                <div class="d-flex flex-column ml-2">
                  <div class="font-weight-bold"
                       v-text="module.displayName ? getPrettyModuleName(module.displayName) : module.name"></div>
                  <div class="small-text"
                       v-text="module.name"></div>
                </div>
              </div>
              <div class="ml-2"
                   v-if="module.recommended !== false && module.recommended.isRequired">
                <img :src="images.recommended"
                     class="img-fluid"
                     v-tooltip="trans('edit.recommended.description')"
                     :alt="trans('edit.recommended.description')">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
