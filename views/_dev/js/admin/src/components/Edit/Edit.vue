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
  <div class="d-flex justify-content-center mt-2 edit-wrapper">
    <div class="col-12">
      <div class="card">
        <loader v-if="loading"></loader>
        <div class="row p-3">
          <div class="col-7 d-flex align-items-center">
            <div class="d-flex align-items-center">
              <div class="img-wrapper">
                <img :src="image" class="img-fluid" alt="Edit">
              </div>
              <div class="d-flex flex-column">
                <div class="h2" v-text="translations.edit.title"></div>
                <div v-text="translations.edit.subtitle"></div>
              </div>
            </div>
          </div>
          <div class="col-5">
            <div class="form-wrapper"
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
            </div>
          </div>
        </div>
        <div class="card-block p-3"
             v-if="editConfiguration">
          <ul class="nav nav-pills">
            <li class="nav-item"
                @click.prevent.stop="selectedTab = tabs.GENERAL"
            >
              <a class="nav-link"
                 :class="{'active': selectedTab === tabs.GENERAL}"
                 v-text="translations.edit.tabs.general"></a>
            </li>
            <li class="nav-item"
                @click.prevent.stop="selectedTab = tabs.MODULES">
              <a class="nav-link"
                 :class="{'active': selectedTab === tabs.MODULES}"
                 v-text="translations.edit.tabs.modules + ' (' + nbModules + ')'"></a>
            </li>
          </ul>
          <div class="tab-content">
            <div
                class="tab-pane fade"
                :class="{'show active': selectedTab === tabs.GENERAL}"
            >
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="form-control-label"
                           v-text="translations.edit.step_title"></label>
                    <input type="text"
                           v-model="editConfiguration.title"
                           :placeholder="translations.edit.step_title"
                           class="form-control"/>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label"
                           v-text="translations.edit.step_subtitle"></label>
                    <input type="text"
                           :placeholder="translations.edit.step_subtitle"
                           v-model="editConfiguration.subtitle"
                           class="form-control"/>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label"
                           v-text="translations.edit.step_message"></label>
                    <input type="text"
                           :placeholder="translations.edit.step_message"
                           v-model="editConfiguration.message"
                           class="form-control"/>
                  </div>
                </div>
                <div class="col-6 d-flex justify-content-center">
                  <axeptio-example
                      :title="editConfiguration.title ? editConfiguration.title : translations.edit.step_title"
                      :subtitle="editConfiguration.subtitle ? editConfiguration.subtitle : translations.edit.step_subtitle"
                      :message="editConfiguration.message ? editConfiguration.message : translations.edit.step_message"></axeptio-example>
                </div>
              </div>
            </div>
            <div
                class="tab-pane fade"
                :class="{'show active': selectedTab === tabs.MODULES}"
            >
              <div class="form-group">
                <div class="modules-wrapper">
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
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-between">
            <button class="btn btn-lg btn-default"
                    v-text="translations.edit.back"
                    type="button"
                    @click="$router.push({ name: 'list'})">
            </button>

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