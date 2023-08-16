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

<template>
  <tr class="list-configuration-card">
    <td class="widget-case">
      <div class="d-flex align-items-center">
        <div class="img-wrapper">
          <img :src="image" alt="List">
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
                  v-text="translations.list.configuration_unavailable"></span>
          </div>
        </div>
      </div>
    </td>
    <td class="summary-case">
      <div class="d-flex flex-column justify-content-center">
        <div class="d-flex flex-column mb-2">
          <div>
            <div class="case-text" v-text="translations.list.project_id + ' : ' + configuration.idProject"></div>
            <div>
              <span class="case-text" v-text="translations.list.shop + ' : '"></span>
              <span v-for="(shop, index) in getShops"
                    :key="shop.id_shop"
                    class="badge badge-warning"
                    :class="{'ml-2': index > 0}"
                    v-text="shop.name"></span>
            </div>
            <div class="case-text" v-text="translations.list.language + ' : ' + (getLanguage ? getLanguage.name : '')">
            </div>
          </div>
        </div>
      </div>
    </td>
    <td class="edit-case text-center">
      <button class="btn btn-outline-warning text-nowrap"
              v-text="translations.list.edit"
              type="button"
              @click="$router.push({name: 'edit', params: {'id': configuration.idObject}})"
      ></button>
    </td>
    <td class="delete-case text-center">
      <a class="btn btn-outline-danger text-nowrap"
         href="#"
         @click.prevent="handleDelete"
         v-text="translations.list.delete"></a>
    </td>
  </tr>
</template>

<script src="./simpleCard.js">

</script>

<style scoped>

</style>