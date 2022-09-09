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
            <div class="col-5 d-flex justify-content-end">
              <iframe width="560" height="315"
                      src="https://www.youtube.com/embed/TPWdnNa3Ki8"
                      title="Axeptio" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
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