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
import AxeptioExample from "../AxeptioExample.vue";
import {ref} from "vue";

const {trans} = useTrans();
const configurationStore = useConfigurationStore();

const illustrationFileName = ref('');

const uploadIllustration = async (event: Event) => {
  if ((<HTMLInputElement>event.target).files && (<HTMLInputElement>event.target).files?.length) {
    const files = (<HTMLInputElement>event.target).files as File[] | null;
    if (!files?.length) {
      return;
    }
    const file = files[0];
    const imagesType = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/svg+xml', 'image/avif'];
    if (!imagesType.includes(file.type)) {
      return;
    }
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      if (configurationStore.editConfiguration) {
        configurationStore.editConfiguration.illustration = reader.result as string;
        illustrationFileName.value = file.name as string;
      }
    };
  }
}
</script>

<template>
  <div class="row" v-if="configurationStore.editConfiguration">
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
      <div class="form-group">
        <span class="ps-switch">
          <input
              type="radio"
              :value="false"
              v-model="configurationStore.editConfiguration.has_illustration"
          />
          <input
              type="radio"
              :value="true"
              v-model="configurationStore.editConfiguration.has_illustration"
          />
          <span class="slide-button"></span>
          <label v-text="trans('edit.illustration_active')">
          </label>
        </span>
      </div>
      <div class="form-group" v-if="configurationStore.editConfiguration.has_illustration">
        <span class="ps-switch">
          <input
              type="radio"
              :value="false"
              v-model="configurationStore.editConfiguration.has_personalized_illustration"
          />
          <input
              type="radio"
              :value="true"
              v-model="configurationStore.editConfiguration.has_personalized_illustration"
          />
          <span class="slide-button"></span>
          <label v-text="trans('edit.illustration_perso')">
          </label>
        </span>
      </div>
      <div class="form-group" v-if="configurationStore.editConfiguration.has_illustration && configurationStore.editConfiguration.has_personalized_illustration">
        <div class="custom-file">
          <input
              type="file"
              class="custom-file-input"
              accept="image/png, image/gif, image/jpeg, image/webp, image/svg+xml, image/avif"
              @change="uploadIllustration"
          />
          <label class="custom-file-label" v-text="illustrationFileName && configurationStore.editConfiguration.illustration ? illustrationFileName : trans('edit.illustration_perso')"></label>
        </div>
      </div>
      <div class="form-group">
        <span class="ps-switch">
          <input
              type="radio"
              :value="false"
              v-model="configurationStore.editConfiguration.paint"
          />
          <input
              type="radio"
              :value="true"
              v-model="configurationStore.editConfiguration.paint"
          />
          <span class="slide-button"></span>
          <label v-text="trans('edit.paint')"></label>
        </span>
      </div>
    </div>
    <div class="col-6 d-flex justify-content-center">
      <axeptio-example
          :title="configurationStore.editConfiguration?.title ? configurationStore.editConfiguration.title : trans('edit.step_title')"
          :subtitle="configurationStore.editConfiguration?.subtitle ? configurationStore.editConfiguration.subtitle : trans('edit.step_subtitle')"
          :message="configurationStore.editConfiguration?.message ? configurationStore.editConfiguration.message : trans('edit.step_message')"
          :has_illustration="!!configurationStore.editConfiguration?.has_illustration"
          :illustration="configurationStore.editConfiguration?.illustration && configurationStore.editConfiguration?.has_illustration && configurationStore.editConfiguration?.has_personalized_illustration ? configurationStore.editConfiguration.illustration : null"
          :paint="configurationStore.editConfiguration?.paint ? configurationStore.editConfiguration.paint : false"
      />
    </div>
  </div>
</template>