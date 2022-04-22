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
  <div
      class="modal fade"
      :class="{'show': isShown}"
      :id="'deleteModal_' + configuration.idObject"
      tabindex="-1"
      aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" v-text="translations.list.delete"></h5>
          <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p v-text="translations.list.delete_confirmation"></p>
        </div>
        <div class="modal-footer">
          <button
              type="button"
              class="btn btn-default"
              data-dismiss="modal"
              v-text="translations.list.delete_no"
          >
            Close
          </button>
          <button type="button"
                  class="btn btn-primary"
                  @click="handleDelete"
                  data-dismiss="modal"
                  v-text="translations.list.delete_yes"></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="./deleteModal.js">

</script>

<style scoped>

</style>