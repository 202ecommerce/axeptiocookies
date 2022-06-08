<!--
  - NOTICE OF LICENSE
  -
  - This source file is subject to a commercial license from SARL 202 ecommerce
  - Use, copy, modification or distribution of this source file without written
  - license agreement from the SARL 202 ecommerce is strictly forbidden.
  - In order to obtain a license, please contact us: tech@202-ecommerce.com
  - ...........................................................................
  - INFORMATION SUR LA LICENCE D'UTILISATION
  -
  - L'utilisation de ce fichier source est soumise a une licence commerciale
  - concedee par la societe 202 ecommerce
  - Toute utilisation, reproduction, modification ou distribution du present
  - fichier source sans contrat de licence ecrit de la part de la SARL 202 ecommerce est
  - expressement interdite.
  - Pour obtenir une licence, veuillez contacter 202-ecommerce <tech@202-ecommerce.com>
  - ...........................................................................
  -
  - @author    202-ecommerce <tech@202-ecommerce.com>
  - @copyright Copyright (c) 202-ecommerce
  - @license   Commercial license
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
      <router-link tag="button"
                   :to="{name: 'edit', params: {'id': configuration.idObject}}"
                   class="btn btn-outline-warning text-nowrap"
                   v-text="translations.list.edit"></router-link>
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