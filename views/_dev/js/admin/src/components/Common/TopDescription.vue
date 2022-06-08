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
  <div class="card">
    <div class="card-header d-flex align-items-center">
      <img class="img-fluid" :src="logo" :alt="translations.common.description.title">
      <div class="col-sm-12"
           v-text="translations.common.description.title">
      </div>
    </div>
    <div class="card-block py-3">
      <div class="col-12">
        <p v-html="translations.common.description.desc1"></p>
        <p v-html="translations.common.description.desc2"></p>
        <p v-html="translations.common.description.desc3"></p>
        <router-link tag="button"
                     :to="{name: 'create'}"
                     v-text="translations.list.new"
                     class="btn btn-primary text-nowrap">
        </router-link>
      </div>
    </div>
  </div>
</template>

<script src="./topDescription.js">

</script>

<style scoped>

</style>