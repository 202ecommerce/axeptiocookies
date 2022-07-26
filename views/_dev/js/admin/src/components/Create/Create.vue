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
  <div class="row create-wrapper">
    <div class="col-12">
      <div class="card mb-3">
        <div class="card-block">
          <div class="row p-3">
            <div class="col-7 d-flex align-items-center">
              <div class="d-flex align-items-center">
                <div class="img-wrapper">
                  <img :src="image" class="img-fluid" alt="Create">
                </div>
                <div class="d-flex flex-column">
                  <div class="h2 font-weight-bold" v-text="translations.create.title"></div>
                  <div v-text="translations.create.subtitle"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <loader v-if="loading"></loader>
        <div class="card-block">
          <div class="form-wrapper justify-content-center col-xl-12 mt-3">
            <div class="row">
              <div class="col-6">
                <div class="h4" v-text="translations.create.info_axeptio"></div>
                <div class="form-group">
                  <label class="form-control-label"
                         v-text="translations.create.project_title"></label>
                  <div class="d-flex position-relative">
                    <div class="w-100">
                      <input type="text"
                             :class="{'is-invalid': createConfiguration && createConfiguration.idProject === null}"
                             v-model="idProject"
                             @input="onSearchProject"
                             class="form-control"/>
                      <div class="invalid-feedback"
                           v-text="translations.create.project_invalid"
                           v-if="createConfiguration && createConfiguration.idProject === null"></div>
                    </div>
                    <loader v-if="getCookiesByProjectIdLoading"></loader>
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-control-label"
                         v-text="translations.create.configuration_title"></label>
                  <multiselect v-model="configuration"
                               @select="handleSelectConfiguration"
                               :disabled="!isCommonFieldEditable"
                               tag-placeholder=""
                               placeholder=""
                               label="title"
                               track-by="id"
                               :options="configurations"
                               :searchable="false"
                               :select-label="''"
                               :selected-label="''"
                               :deselect-label="''"
                               :class="{'is-highlited': commonFieldsHighlited}"
                               :multiple="false"
                               :allow-empty="false"></multiselect>
                </div>
              </div>
              <div class="col-6">
                <div class="h4" v-text="translations.create.info_ps"></div>
                <div class="form-group">
                  <label class="form-control-label"
                         v-text="translations.create.shop_title"></label>
                  <multiselect v-model="idShops"
                               :disabled="!isCommonFieldEditable"
                               tag-placeholder=""
                               placeholder=""
                               label="name"
                               track-by="id_shop"
                               :searchable="false"
                               :select-label="''"
                               :selected-label="''"
                               :deselect-label="''"
                               :class="{'is-highlited': commonFieldsHighlited}"
                               :options="shops"
                               :multiple="true"
                               :taggable="true"></multiselect>

                </div>
                <div class="form-group">
                  <label class="form-control-label"
                         v-text="translations.create.language_title"></label>
                  <multiselect v-model="language"
                               :disabled="!isCommonFieldEditable"
                               tag-placeholder=""
                               placeholder=""
                               label="name"
                               track-by="id_lang"
                               :searchable="false"
                               :select-label="''"
                               :selected-label="''"
                               :deselect-label="''"
                               :class="{'is-highlited': commonFieldsHighlited}"
                               :options="languages"
                               :multiple="false"
                               :allow-empty="false"></multiselect>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="d-flex"
               :class="{'justify-content-end': !showBackButton, 'justify-content-between': showBackButton}">
            <router-link class="btn btn-lg btn-default"
                         tag="button"
                         v-if="showBackButton"
                         v-text="translations.create.back"
                         :to="{ name: 'list'}">
            </router-link>

            <button class="btn btn-lg btn-primary"
                    :disabled="!isSavable"
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

<script src="./create.js">

</script>

<style scoped>

</style>