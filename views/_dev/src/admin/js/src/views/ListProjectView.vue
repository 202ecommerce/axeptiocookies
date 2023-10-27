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
import TopDescription from "../components/Shared/TopDescription.vue";
import Cache from "../components/Shared/Cache.vue";
import Loader from "../components/Shared/Loader.vue";
import {useTrans} from "../use/useTrans.ts";
import {useCommonStore} from "../stores/commonStore.ts";
import {useConfigurationStore} from "../stores/configurationStore.ts";
import SimpleCard from "../components/List/SimpleCard.vue";
import DeleteModal from "../components/List/DeleteModal.vue";

const {trans} = useTrans();
const commonStore = useCommonStore();
const configurationStore = useConfigurationStore();
</script>

<template>
  <div class="d-flex flex-column">

    <div class="row">
      <div class="col-12">
        <top-description></top-description>
      </div>
    </div>

    <div class="row list-wrapper" v-if="configurationStore.configurations.length">
      <div class="col-12">
        <loader v-if="commonStore.loading"></loader>

        <table class="table mt-2 mb-0" aria-label="Configuration's table">
          <thead>
          <tr>
            <th class="text-center" v-text="trans('list.table.widget')"></th>
            <th v-text="trans('list.table.summary')"></th>
            <th class="text-center" v-text="trans('list.table.modification')"></th>
            <th class="text-center" v-text="trans('list.table.deletion')"></th>
          </tr>
          </thead>
          <tbody>
          <simple-card v-for="(config) in configurationStore.configurations"
                       :key="config.idObject"
                       :configuration="config"></simple-card>
          </tbody>
        </table>
        <delete-modal v-for="(config) in configurationStore.configurations"
                      :key="config.idObject"
                      :configuration="config"></delete-modal>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <cache></cache>
      </div>
    </div>
  </div>
</template>
