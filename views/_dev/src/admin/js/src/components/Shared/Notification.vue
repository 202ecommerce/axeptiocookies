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
import {useCommonStore} from "../../stores/commonStore.ts";
import {computed} from "vue";
import type {ComputedRef} from 'vue';
import type {DefaultResponse} from "../../types/types.ts";

const commonStore = useCommonStore();

const success: ComputedRef<boolean | DefaultResponse> = computed((): boolean | DefaultResponse => commonStore.success);
const error: ComputedRef<boolean | DefaultResponse> = computed((): boolean | DefaultResponse => commonStore.error);

const isDefaultResponse = (response: any): response is DefaultResponse => {
  return 'message' in response && 'success' in response;
};

</script>

<template>
  <div class="w-100" v-if="success || error">
    <div class="alert alert-success"
         role="alert"
         v-if="success && isDefaultResponse(success)">
      <p class="alert-text"
         v-html="success.message"></p>
    </div>
    <div class="alert alert-danger"
         role="alert"
         v-if="error && isDefaultResponse(error)">
      <p class="alert-text"
         v-html="error.message"></p>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>