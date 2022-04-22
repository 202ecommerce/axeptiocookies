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
    <router-link tag="div"
                 :to="{ name: 'create'}"
                 class="list-configuration-card-wrapper list-configuration-card-wrapper-create">
      <div class="card list-configuration-card flex-row px-4 py-3">
        <div class="img-wrapper">
          <img :src="image" alt="Create">
        </div>
        <div class="d-flex flex-column justify-content-center pl-2">
          <div class="font-weight-bold card-text"
               v-text="translations.list.new"></div>
          <div class="card-text"
               v-text="translations.list.new_description"></div>
        </div>
      </div>
    </router-link>
  </div>
</template>

<script src="./createCard.js">

</script>

<style scoped>

</style>