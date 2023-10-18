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
  import {useRouter} from "vue-router";

  const {trans} = useTrans();
  const router = useRouter();
  const logoUrl = window.axeptiocookies.links.logo;
</script>

<template>
  <div class="card">
    <div class="card-header d-flex align-items-center">
      <img class="img-fluid" :src="logoUrl" :alt="trans('common.description.title')">
      <div class="col-sm-12"
           v-text="trans('common.description.title')">
      </div>
    </div>
    <div class="card-block py-3">
      <div class="col-12">
        <p v-html="trans('common.description.desc1')"></p>
        <p v-html="trans('common.description.desc2')"></p>
        <p v-html="trans('common.description.desc3')"></p>
        <button type="button"
                @click="router.push({name: 'create'})"
                v-text="trans('list.new')"
                class="btn btn-primary text-nowrap">
        </button>
      </div>
    </div>
  </div>
</template>
