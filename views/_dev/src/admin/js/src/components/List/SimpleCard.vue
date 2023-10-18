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
import type {Configuration, Shop, Language} from "../../types/types.ts";
import 'jquery';
import {useConfig} from "../../use/useConfig.ts";
import {computed, ComputedRef} from "vue";

const props = defineProps<{
  configuration: Configuration
}>();

const {trans} = useTrans();
const {shops, images} = useConfig();
const router = useRouter();
const imageUrl = images.list;

const getShops: ComputedRef<Shop[]> = computed((): Shop[] => {
  if (props.configuration) {
    const fetchedShops = props.configuration.idShops.map(idShop => {
      return shops.find(shop => {
        return parseInt(shop.id_shop as string) === parseInt(idShop);
      }) as Shop;
    });

    return fetchedShops.filter(shop => {
      return isShop(shop);
    });
  }

  return [];
});

const getLanguage = computed(() => {
  const languages: Language[] = window.axeptiocookies.data.languages;

  if (props.configuration) {
    return languages.find(lang => {
      return props.configuration.idLanguage === lang.id_lang;
    });
  }

  return null;
});

const handleDelete = () => {
  $('#deleteModal_' + props.configuration.idObject).modal('show');
};

const isShop = (shop: any): shop is Shop => {
  return shop && 'id_shop' in shop;
};

</script>

<template>
  <tr class="list-configuration-card">
    <td class="widget-case">
      <div class="d-flex align-items-center">
        <div class="img-wrapper">
          <img :src="imageUrl" alt="List">
        </div>
        <div class="d-flex flex-column">
          <div class="font-weight-bold case-text"
               v-if="configuration.configuration"
               v-text="configuration.configuration.title"></div>
          <div v-else
               class="font-weight-bold case-text"
               v-text="configuration.idConfiguration"
          ></div>
          <div class="d-flex align-items-center configuration-warning" v-if="!configuration.configuration">
            <i class="material-icons brand-danger">warning</i>
            <span class="ml-1"
                  v-text="trans('list.configuration_unavailable')"></span>
          </div>
        </div>
      </div>
    </td>
    <td class="summary-case">
      <div class="d-flex flex-column justify-content-center">
        <div class="d-flex flex-column mb-2">
          <div>
            <div class="case-text" v-text="trans('list.project_id') + ' : ' + configuration.idProject"></div>
            <div v-if="getShops">
              <span class="case-text" v-text="trans('list.shop') + ' : '"></span>
              <span v-for="(shopItem, index) in getShops"
                    :key="shopItem.id_shop"
                    class="badge badge-warning"
                    :class="{'ml-2': index > 0}"
                    v-text="shopItem.name"></span>
            </div>
            <div class="case-text" v-text="trans('list.language') + ' : ' + (getLanguage ? getLanguage.name : '')">
            </div>
          </div>
        </div>
      </div>
    </td>
    <td class="edit-case text-center">
      <button class="btn btn-outline-warning text-nowrap"
              v-text="trans('list.edit')"
              type="button"
              @click="router.push({name: 'edit', params: {'id': configuration.idObject}})"
      ></button>
    </td>
    <td class="delete-case text-center">
      <a class="btn btn-outline-danger text-nowrap"
         href="#"
         @click.prevent="handleDelete"
         v-text="trans('list.delete')"></a>
    </td>
  </tr>

</template>
