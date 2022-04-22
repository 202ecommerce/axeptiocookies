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
  <div class="my-2">
    <div class="list-configuration-card-wrapper list-configuration-card-wrapper-edit">
      <div class="card list-configuration-card flex-row px-4 py-3">
        <div class="img-wrapper">
          <img :src="image" alt="List">
        </div>
        <div class="d-flex flex-column justify-content-center pl-2">
          <div class="d-flex flex-column mb-2">
            <div class="d-flex">
              <div class="font-weight-bold"
                   v-if="configuration.configuration"
                   v-text="configuration.configuration.title"></div>
              <div v-else
                   class="font-weight-bold"
                   v-text="configuration.idConfiguration"
              ></div>
              <div class="pl-2 d-flex align-items-center configuration-warning" v-if="!configuration.configuration">
                <i class="material-icons brand-danger">warning</i>
                <span class="ml-2"
                      v-text="translations.list.configuration_unavailable"></span>
              </div>
            </div>
            <div>
              <div v-text="translations.list.project_id + ' : ' + configuration.idProject"></div>
              <div>
                <span v-text="translations.list.shop + ' : '"></span>
                <span v-for="(shop, index) in getShops"
                      :key="shop.id_shop"
                      class="badge badge-warning"
                      :class="{'ml-2': index > 0}"
                      v-text="shop.name"></span>
              </div>
              <div v-text="translations.list.language + ' : ' + (getLanguage ? getLanguage.name : '')">
              </div>
            </div>
          </div>
          <router-link tag="a"
                       :to="{name: 'edit', params: {'id': configuration.idObject}}"
                       class="card-text"
                       v-text="translations.list.edit"></router-link>
          <a class="card-text"
             href="#"
             @click.prevent="handleDelete"
             v-text="translations.list.delete"></a>
        </div>
      </div>
    </div>
    <delete-modal :configuration="configuration"></delete-modal>
  </div>
</template>

<script src="./simpleCard.js">

</script>

<style scoped>

</style>