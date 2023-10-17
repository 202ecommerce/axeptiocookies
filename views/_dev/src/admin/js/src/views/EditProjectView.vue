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
import Loader from "../components/Shared/Loader.vue";
import {useTrans} from "../use/useTrans.ts";
import {useCommonStore} from "../stores/commonStore.ts";
import {useConfigurationStore} from "../stores/configurationStore.ts";
import {useConfig} from "../use/useConfig.ts";
import AxeptioExample from "../components/Edit/AxeptioExample.vue";
import Routes from "../custom/Router/Routes.ts";
import {useRouter} from "vue-router";
import {computed, ref} from "vue";
import TabItem from "../custom/Project/TabItem.ts";
import {useEventBus} from "@vueuse/core";
import ConfigurationEventType from "../custom/Configuration/ConfigurationEventType.ts";
import type {EditableConfiguration} from "../types/types.ts";
import VueMultiselect from 'vue-multiselect';

const {trans} = useTrans();
const {images, shops, languages} = useConfig();
const configurationBus = useEventBus('configuration');

const router = useRouter();
const commonStore = useCommonStore();
const configurationStore = useConfigurationStore();

const selectedTab = ref(TabItem.GENERAL);

const nbModules = computed(() => {
  if (!configurationStore.editConfiguration || !configurationStore.editConfiguration?.modules) {
    return 0;
  }

  return configurationStore.editConfiguration.modules.filter(module => {
    return module.checked;
  }).length;
});

const getPrettyModuleName = (name: string) => {
  const areaElement = document.createElement('textarea');
  areaElement.innerHTML = name;
  const text = areaElement.value;
  areaElement.remove();

  return text;
};

const handleSave = () => {
  configurationStore.handleEditConfiguration(configurationStore.editConfiguration as EditableConfiguration);
};

const handleModuleClick = (index: number) => {
  if (!configurationStore.editConfiguration?.modules?.[index]) {
    return;
  }
  configurationStore.editConfiguration.modules[index].checked = !configurationStore.editConfiguration.modules[index].checked;
};

configurationBus.on((event) => {
  if (event === ConfigurationEventType.CONFIGURATION_EDITED) {
    router.push({name: Routes.LIST});
  }
});

const isResetBtnVisible = computed(() => {
  if (!configurationStore.editConfiguration || !configurationStore.editConfiguration.modules) {
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
  if (!configurationStore.editConfiguration || !configurationStore.editConfiguration.modules) {
    return false;
  }
  configurationStore.editConfiguration.modules.forEach(module => {
    module.checked = module.recommended !== false && module.recommended.isRequired;
  });
};

</script>

<template>
  <div class="d-flex justify-content-center mt-2 edit-wrapper">
    <div class="col-12">
      <div class="card">
        <loader v-if="commonStore.loading"></loader>
        <div class="row p-3">
          <div class="col-7 d-flex align-items-center">
            <div class="d-flex align-items-center">
              <div class="img-wrapper">
                <img :src="images.create" class="img-fluid" alt="Edit">
              </div>
              <div class="d-flex flex-column">
                <div class="h2" v-text="trans('edit.title')"></div>
                <div v-text="trans('edit.subtitle')"></div>
              </div>
            </div>
          </div>
          <div class="col-5">
            <div class="form-wrapper"
                 v-if="configurationStore.editConfiguration">
              <div class="form-group">
                <label class="form-control-label"
                       v-text="trans('edit.project_title')"></label>
                <input type="text"
                       v-model="configurationStore.editConfiguration.idProject"
                       readonly
                       class="form-control"/>
              </div>
              <div class="form-group">
                <label class="form-control-label"
                       v-text="trans('edit.configuration_title')"></label>
                <VueMultiselect v-model="configurationStore.editConfiguration.configuration"
                                tag-placeholder=""
                                placeholder=""
                                label="title"
                                track-by="id"
                                :searchable="false"
                                :select-label="''"
                                :selected-label="''"
                                :deselect-label="''"
                                :options="configurationStore.editConfiguration.project.configurations"
                                :multiple="false"
                                :allow-empty="false"></VueMultiselect>
              </div>
              <div class="form-group">
                <label class="form-control-label"
                       v-text="trans('edit.shop_title')"></label>
                <VueMultiselect v-model="configurationStore.editConfiguration.shops"
                                tag-placeholder=""
                                placeholder=""
                                label="name"
                                :searchable="false"
                                :select-label="''"
                                :selected-label="''"
                                :deselect-label="''"
                                track-by="id_shop"
                                :options="shops"
                                :multiple="true"
                                :taggable="true"></VueMultiselect>
              </div>
              <div class="form-group">
                <label class="form-control-label"
                       v-text="trans('edit.language_title')"></label>
                <VueMultiselect v-model="configurationStore.editConfiguration.language"
                                tag-placeholder=""
                                placeholder=""
                                label="name"
                                :searchable="false"
                                :select-label="''"
                                :selected-label="''"
                                :deselect-label="''"
                                track-by="id_lang"
                                :options="languages"
                                :multiple="false"
                                :allow-empty="false"></VueMultiselect>
              </div>
            </div>
          </div>
        </div>
        <div class="card-block p-3"
             v-if="configurationStore.editConfiguration">
          <ul class="nav nav-pills">
            <li class="nav-item"
                @click.prevent.stop="selectedTab = TabItem.GENERAL"
            >
              <a class="nav-link"
                 :class="{'active': selectedTab === TabItem.GENERAL}"
                 v-text="trans('edit.tabs.general')"></a>
            </li>
            <li class="nav-item"
                @click.prevent.stop="selectedTab = TabItem.MODULES">
              <a class="nav-link"
                 :class="{'active': selectedTab === TabItem.MODULES}"
                 v-text="trans('edit.tabs.modules') + ' (' + nbModules + ')'"></a>
            </li>
          </ul>
          <div class="tab-content">
            <div
                class="tab-pane fade"
                :class="{'show active': selectedTab === TabItem.GENERAL}"
            >
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="form-control-label"
                           v-text="trans('edit.step_title')"></label>
                    <input type="text"
                           v-model="configurationStore.editConfiguration.title"
                           :placeholder="trans('edit.step_title')"
                           class="form-control"/>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label"
                           v-text="trans('edit.step_subtitle')"></label>
                    <input type="text"
                           :placeholder="trans('edit.step_subtitle')"
                           v-model="configurationStore.editConfiguration.subtitle"
                           class="form-control"/>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label"
                           v-text="trans('edit.step_message')"></label>
                    <input type="text"
                           :placeholder="trans('edit.step_message')"
                           v-model="configurationStore.editConfiguration.message"
                           class="form-control"/>
                  </div>
                </div>
                <div class="col-6 d-flex justify-content-center">
                  <axeptio-example
                      :title="configurationStore.editConfiguration.title ? configurationStore.editConfiguration.title : trans('edit.step_title')"
                      :subtitle="configurationStore.editConfiguration.subtitle ? configurationStore.editConfiguration.subtitle : trans('edit.step_subtitle')"
                      :message="configurationStore.editConfiguration.message ? configurationStore.editConfiguration.message : trans('edit.step_message')"
                  />
                </div>
              </div>
            </div>
            <div
                class="tab-pane fade"
                :class="{'show active': selectedTab === TabItem.MODULES}"
            >
              <div class="d-inline-flex float-right mb-2" v-if="isResetBtnVisible">
                <button class="btn btn-lg btn-outline-info"
                        v-text="trans('edit.recommended.reset')"
                        type="button"
                        @click="handleResetToRecommendedModules">
                </button>
              </div>
              <div class="form-group">
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
                          <i class="material-icons text-danger"
                             v-tooltip="trans('edit.recommended.description')">close</i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-between">
            <button class="btn btn-lg btn-default"
                    v-text="trans('edit.back')"
                    type="button"
                    @click="router.push({ name: Routes.LIST})">
            </button>

            <button class="btn btn-lg btn-primary"
                    v-text="trans('common.save')"
                    @click="handleSave"
                    type="button">
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>