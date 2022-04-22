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
  <div class="d-flex justify-content-center mt-2 edit-wrapper">
    <div class="col-xl-8">
      <div class="card">
        <loader v-if="loading"></loader>
        <div class="card-header">
          <div class="col-sm-12"
               v-text="translations.edit.title"></div>
        </div>
        <div class="card-block">
          <div class="form-wrapper justify-content-center col-xl-12 pt-3"
               v-if="editConfiguration">
            <div class="form-group">
              <label class="form-control-label"
                     v-text="translations.edit.project_title"></label>
              <input type="text"
                     v-model="editConfiguration.idProject"
                     readonly
                     class="form-control"/>
            </div>
            <div class="form-group">
              <label class="form-control-label"
                     v-text="translations.edit.configuration_title"></label>
              <multiselect v-model="editConfiguration.configuration"
                           tag-placeholder=""
                           placeholder=""
                           label="title"
                           track-by="id"
                           :searchable="false"
                           :select-label="''"
                           :selected-label="''"
                           :deselect-label="''"
                           :options="editConfiguration.project.configurations"
                           :multiple="false"
                           :allow-empty="false"></multiselect>
            </div>
            <div class="form-group">
              <label class="form-control-label"
                     v-text="translations.edit.shop_title"></label>
              <multiselect v-model="editConfiguration.shops"
                           tag-placeholder=""
                           placeholder=""
                           label="name"
                           :searchable="false"
                           :select-label="''"
                           :selected-label="''"
                           :deselect-label="''"
                           track-by="id_shop"
                           :options="shops"
                           :multiple="true"
                           :taggable="true"></multiselect>
            </div>
            <div class="form-group">
              <label class="form-control-label"
                     v-text="translations.edit.language_title"></label>
              <multiselect v-model="editConfiguration.language"
                           tag-placeholder=""
                           placeholder=""
                           label="name"
                           :searchable="false"
                           :select-label="''"
                           :selected-label="''"
                           :deselect-label="''"
                           track-by="id_lang"
                           :options="languages"
                           :multiple="false"
                           :allow-empty="false"></multiselect>
            </div>
            <div class="form-group">
              <label class="form-control-label"
                     v-text="translations.edit.step_message"></label>
              <input type="text"
                     v-model="editConfiguration.message"
                     class="form-control"/>
            </div>
            <div class="form-group">
              <label class="form-control-label"
                     v-text="translations.edit.step_title"></label>
              <input type="text"
                     v-model="editConfiguration.title"
                     class="form-control"/>
            </div>
            <div class="form-group">
              <label class="form-control-label"
                     v-text="translations.edit.step_subtitle"></label>
              <input type="text"
                     v-model="editConfiguration.subtitle"
                     class="form-control"/>
            </div>
            <div class="form-group">
              <div class="modules-wrapper">
                <label class="form-control-label"
                       v-text="translations.edit.modules_title"></label>
                <div class="d-flex flex-wrap">
                  <div v-for="(module, index) of editConfiguration.modules"
                       :key="module.id_module"
                       @click="handleModuleClick(index)"
                       class="md-checkbox col-4 module-item">
                    <div class="d-flex">
                      <input type="checkbox" v-model="editConfiguration.modules[index].checked"/>
                      <i class="md-checkbox-control"></i>
                      <div class="d-flex ml-3">
                        <div class="img-wrapper img-fluid" v-if="module.image">
                          <img :src="module.image" :alt="module.name">
                        </div>
                        <div class="d-flex flex-column ml-2">
                          <div class="font-weight-bold"
                               v-text="module.displayName ? module.displayName : module.name"></div>
                          <div class="small-text"
                               v-text="module.name"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-between">
            <router-link class="btn btn-lg btn-default"
                         tag="button"
                         v-text="translations.edit.back"
                         :to="{ name: 'list'}">
            </router-link>

            <button class="btn btn-lg btn-primary"
                    v-text="translations.common.save"
                    @click="handleSave"
                    type="button">
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="./edit.js">

</script>

<style scoped>

</style>