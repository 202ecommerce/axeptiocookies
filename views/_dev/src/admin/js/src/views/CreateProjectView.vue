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
import {useTrans} from "../use/useTrans.ts";
import Loader from "../components/Shared/Loader.vue";
import {useRoute, useRouter} from "vue-router";
import {useCommonStore} from "../stores/commonStore.ts";
import type {ComputedRef, Ref} from "vue";
import {computed, ref} from "vue";
import {useConfig} from "../use/useConfig.ts";
import {useConfigurationStore} from "../stores/configurationStore.ts";
import VueMultiselect from "vue-multiselect";
import type {ConfigurationData, CreatableConfiguration, Language, Shop} from "../types/types.ts";
import {useEventBus} from "@vueuse/core";
import ConfigurationEventType from "../custom/Configuration/ConfigurationEventType.ts";
import Routes from "../custom/Router/Routes.ts";

const imageUrl = window.axeptiocookies.images.create;
const commonStore = useCommonStore();
const configurationStore = useConfigurationStore();
const configurationBus = useEventBus('configuration');
const router = useRouter();
const route = useRoute();
const {trans} = useTrans();
const {shops, languages, defaultConfigurations} = useConfig();

const hasBack: ComputedRef<boolean> = computed((): boolean => {
  return route.meta.hasBack as boolean;
});

const showBackButton: ComputedRef<boolean> = computed((): boolean => {
  return hasBack.value || defaultConfigurations.length > 0;
});

const commonFieldsHighlited = ref(false);
const searchTimer: Ref<NodeJS.Timeout | null> = ref(null);
const idProject = ref('');
const configuration: Ref<ConfigurationData | null> = ref(null);
const idShops: Ref<Shop[]> = ref([]);
const language: Ref<Language | null> = ref(null);
const message = ref('');
const title = ref('');
const subtitle = ref('');

const isCommonFieldEditable = computed(() => {
  return idProject.value && configurationStore.createConfiguration !== null && configurationStore.createConfiguration.idProject;
});

const configurations: ComputedRef<ConfigurationData[]> = computed(() => {
  if (configurationStore.createConfiguration && configurationStore.createConfiguration.configurations) {
    return configurationStore.createConfiguration.configurations;
  }

  return [];
});

const isSavable = computed(() => {
  return idProject.value && configuration.value && idShops.value.length > 0 && language.value;
});

const handleSave = () => {
  if (!isSavable.value) {
    return;
  }

  const creatableConfiguration: CreatableConfiguration = {
    idProject: idProject.value,
    idConfiguration: configuration.value?.id,
    idShops: idShops.value.map(shop => shop.id_shop),
    idLanguage: language.value?.id_lang,
    message: message.value,
    title: title.value,
    subtitle: subtitle.value,
  };

  configurationStore.handleCreateConfiguration(creatableConfiguration);
};

const handleInputProjectId = async () => {
  if (configurationStore.createConfiguration !== null && idProject.value === configurationStore.createConfiguration.idProject) {
    return;
  }

  configurationStore.clearCreateConfiguration();
  configuration.value = null;
  if (idProject.value === '') {
    return;
  }

  await configurationStore.getCookiesByProjectId(idProject.value);
  if (isCommonFieldEditable.value) {
    commonFieldsHighlited.value = true;
    setTimeout(() => {
      commonFieldsHighlited.value = false;
    }, 1000);
  }
};

const onSearchProject = () => {
  if (searchTimer.value) {
    clearTimeout(searchTimer.value);
    searchTimer.value = null;
  }
  searchTimer.value = setTimeout(async () => {
    await handleInputProjectId();
  }, 500);
};

const handleSelectConfiguration = (configuration: ConfigurationData) => {
  if (!(configurationStore.createConfiguration !== null && idProject.value === configurationStore.createConfiguration.idProject)) {
    return;
  }

  if (language.value) {
    return;
  }

  const languageToSelect = languages.find(lang => {
    return lang.iso_code === configuration.language;
  });

  if (!languageToSelect) {
    return;
  }

  language.value = languageToSelect;
}

configurationBus.on((event, data) => {
  if (event === ConfigurationEventType.CONFIGURATION_CREATED) {
    router.push({name: Routes.EDIT, params: {id: data as number}})
  }
})

</script>

<template>
  <div class="row create-wrapper">
    <div class="col-12">
      <div class="card mb-3">
        <div class="card-block">
          <div class="row p-3">
            <div class="col-7 d-flex align-items-center">
              <div class="d-flex align-items-center">
                <div class="img-wrapper">
                  <img :src="imageUrl" class="img-fluid" alt="Create">
                </div>
                <div class="d-flex flex-column">
                  <div class="h2 font-weight-bold" v-text="trans('create.title')"></div>
                  <div v-text="trans('create.subtitle')"></div>
                </div>
              </div>
            </div>
            <div class="col-5 d-flex justify-content-end">
              <iframe width="560" height="315"
                      src="https://www.youtube.com/embed/TPWdnNa3Ki8"
                      title="Axeptio" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <loader v-if="commonStore.loading"></loader>
        <div class="card-block">
          <div class="form-wrapper justify-content-center col-xl-12 mt-3">
            <div class="row">
              <div class="col-6">
                <div class="h4" v-text="trans('create.info_axeptio')"></div>
                <div class="form-group">
                  <label class="form-control-label"
                         v-text="trans('create.project_title')"></label>
                  <div class="d-flex position-relative">
                    <div class="w-100">
                      <input type="text"
                             :class="{'is-invalid': configurationStore.createConfiguration && configurationStore.createConfiguration.idProject === null}"
                             v-model="idProject"
                             @input="onSearchProject"
                             class="form-control"/>
                      <div class="invalid-feedback"
                           v-text="trans('create.project_invalid')"
                           v-if="configurationStore.createConfiguration && configurationStore.createConfiguration.idProject === null"></div>
                    </div>
                    <loader v-if="configurationStore.getCookiesByProjectIdLoading"></loader>
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-control-label"
                         v-text="trans('create.configuration_title')"></label>
                  <VueMultiselect v-model="configuration"
                                  @select="handleSelectConfiguration"
                                  :disabled="!isCommonFieldEditable"
                                  tag-placeholder=""
                                  placeholder=""
                                  label="title"
                                  track-by="id"
                                  :options="configurations"
                                  :searchable="false"
                                  :select-label="''"
                                  :selected-label="''"
                                  :deselect-label="''"
                                  :class="{'is-highlited': commonFieldsHighlited}"
                                  :multiple="false"
                                  :allow-empty="false"></VueMultiselect>
                </div>
              </div>
              <div class="col-6">
                <div class="h4" v-text="trans('create.info_ps')"></div>
                <div class="form-group">
                  <label class="form-control-label"
                         v-text="trans('create.shop_title')"></label>
                  <VueMultiselect v-model="idShops"
                                  :disabled="!isCommonFieldEditable"
                                  tag-placeholder=""
                                  placeholder=""
                                  label="name"
                                  track-by="id_shop"
                                  :searchable="false"
                                  :select-label="''"
                                  :selected-label="''"
                                  :deselect-label="''"
                                  :class="{'is-highlited': commonFieldsHighlited}"
                                  :options="shops"
                                  :multiple="true"
                                  :taggable="true"></VueMultiselect>
                </div>
                <div class="form-group">
                  <label class="form-control-label"
                         v-text="trans('create.language_title')"></label>
                  <VueMultiselect v-model="language"
                                  :disabled="!isCommonFieldEditable"
                                  tag-placeholder=""
                                  placeholder=""
                                  label="name"
                                  track-by="id_lang"
                                  :searchable="false"
                                  :select-label="''"
                                  :selected-label="''"
                                  :deselect-label="''"
                                  :class="{'is-highlited': commonFieldsHighlited}"
                                  :options="languages"
                                  :multiple="false"
                                  :allow-empty="false"></VueMultiselect>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="d-flex"
               :class="{'justify-content-end': !showBackButton, 'justify-content-between': showBackButton}">
            <button class="btn btn-lg btn-default"
                    v-if="showBackButton"
                    v-text="trans('create.back')"
                    type="button"
                    @click="router.push({ name: 'list'})">
            </button>

            <button class="btn btn-lg btn-primary"
                    :disabled="!isSavable"
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