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
import {useTrans} from "../../use/useTrans.ts";
import {useCacheStore} from "../../stores/cacheStore.ts";

const {trans} = useTrans();
const cacheStore = useCacheStore();

const handleClearCache = async () => {
  return await cacheStore.clearCache();
};

</script>

<template>
  <div class="card mt-2">
    <div class="card-header">
      <div class="col-sm-12"
           v-text="trans('common.cache_title')">
      </div>
    </div>
    <div class="card-block pt-3">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pb-3">
          <div v-html="trans('common.cache_description')" class="pr-3"></div>
          <button type="button"
                  class="btn btn-primary text-nowrap"
                  @click="handleClearCache"
                  v-text="trans('common.clear_cache')"
                  :disabled="cacheStore.loading"
          ></button>
        </div>
      </div>
    </div>
  </div>
</template>
