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