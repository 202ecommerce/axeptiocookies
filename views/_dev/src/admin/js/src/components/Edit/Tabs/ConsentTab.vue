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

const {trans} = useTrans();
const configurationStore = useConfigurationStore();
</script>

<template>
  <div class="row">
    <div class="ml-3 mt-4 col-lg-4">
      <div class="form-group">
        <span class="ps-switch ps-switch-lg">
          <input
              type="radio"
              :value="false"
              v-model="configurationStore.editConfiguration.is_consent_v2"
          />
          <input
              type="radio"
              :value="true"
              v-model="configurationStore.editConfiguration.is_consent_v2"
          />
          <span class="slide-button"></span>
          <label class="font-weight-bold"
                 v-text="trans('edit.consent.enable')"></label>
        </span>
      </div>
      <div v-if="configurationStore.editConfiguration.is_consent_v2" class="mt-3">
        <div class="font-weight-bold"
             v-text="trans('edit.consent.default')"></div>
        <div class="mt-1 mb-2" v-text="trans('edit.consent.description')"></div>

        <div class="form-group my-2">
          <span class="ps-switch">
            <input type="radio"
                   :value="false"
                   v-model="configurationStore.editConfiguration.analytics_storage"
            />
            <input type="radio"
                   :value="true"
                   v-model="configurationStore.editConfiguration.analytics_storage"
            />
            <span class="slide-button"></span>
            <label class="d-flex flex-column">
              <span class="font-weight-bold" v-text="trans('edit.consent.analytics_storage')"></span>
              <span class="" v-text="trans('edit.consent.analytics_storage_desc')"></span>
            </label>
          </span>
        </div>
        <div class="form-group my-2">
          <span class="ps-switch">
            <input
                type="radio"
                :value="false"
                v-model="configurationStore.editConfiguration.ad_storage"
            />
            <input
                type="radio"
                :value="true"
                v-model="configurationStore.editConfiguration.ad_storage"
            />
            <span class="slide-button"></span>
            <label class="d-flex flex-column">
              <span class="font-weight-bold" v-text="trans('edit.consent.ad_storage')"></span>
              <span class="" v-text="trans('edit.consent.ad_storage_desc')"></span>
            </label>
          </span>
        </div>
        <div class="form-group my-2">
          <span class="ps-switch">
            <input
                type="radio"
                :value="false"
                v-model="configurationStore.editConfiguration.ad_user_data"
            />
            <input
                type="radio"
                :value="true"
                v-model="configurationStore.editConfiguration.ad_user_data"
            />
            <span class="slide-button"></span>
            <label class="d-flex flex-column">
              <span class="font-weight-bold" v-text="trans('edit.consent.ad_user_data')"></span>
              <span class="" v-text="trans('edit.consent.ad_user_data_desc')"></span>
            </label>
          </span>
        </div>
        <div class="form-group my-2">
          <span class="ps-switch">
            <input
                type="radio"
                :value="false"
                v-model="configurationStore.editConfiguration.ad_personalization"
            />
            <input
                type="radio"
                :value="true"
                v-model="configurationStore.editConfiguration.ad_personalization"
            />
            <span class="slide-button"></span>
            <label class="d-flex flex-column">
              <span class="font-weight-bold" v-text="trans('edit.consent.ad_personalization')"></span>
              <span class="" v-text="trans('edit.consent.ad_personalization_desc')"></span>
            </label>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>