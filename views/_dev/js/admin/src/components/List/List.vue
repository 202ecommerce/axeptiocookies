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
  <div class="d-flex flex-column">

    <div class="row">
      <div class="col-12">
        <top-description></top-description>
      </div>
    </div>

    <div class="row list-wrapper" v-if="configurations.length">
      <div class="col-12">
        <loader v-if="loading"></loader>

        <table class="table mt-2 mb-0">
          <thead>
          <tr>
            <th class="text-center" v-text="translations.list.table.widget"></th>
            <th v-text="translations.list.table.summary"></th>
            <th class="text-center" v-text="translations.list.table.modification"></th>
            <th class="text-center" v-text="translations.list.table.deletion"></th>
          </tr>
          </thead>
          <tbody>
          <simple-card v-for="(config) in configurations"
                       :key="config.idObject"
                       :configuration="config"></simple-card>
          </tbody>
        </table>
        <delete-modal v-for="(config) in configurations"
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

<script src="./list.js">
</script>

<style scoped>

</style>