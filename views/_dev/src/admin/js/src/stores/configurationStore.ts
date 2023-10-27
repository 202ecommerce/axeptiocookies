/**
 * Copyright since 2022 Axeptio
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to tech@202-ecommerce.com so we can send you a copy immediately.
 *
 * @author    202 ecommerce <tech@202-ecommerce.com>
 * @copyright 2022 Axeptio
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
 */

import {defineStore} from "pinia";
import ClientAPI from "../api/ClientAPI.ts";
import {useCommonStore} from "./commonStore.ts";
import type {Configuration, CreatableConfiguration, EditableConfiguration} from "../types/types.ts";
import {useEventBus} from "@vueuse/core";
import ConfigurationEventType from "../custom/Configuration/ConfigurationEventType.ts";

const configurationBus = useEventBus('configuration');

export const useConfigurationStore = defineStore('configurationStore', {
  state: () => {
    return {
      configurations: [] as Configuration[],
      createConfiguration: null as CreatableConfiguration | null,
      editConfiguration: null as EditableConfiguration | null,
      getCookiesByProjectIdLoading: false as boolean,
    };
  },
  actions: {
    async getCookiesByProjectId(projectId: string) {
      const client = new ClientAPI();
      const commonStore = useCommonStore();
      this.getCookiesByProjectIdLoading = true;
      const response = await client.getCookiesByProjectId(projectId);

      if (response.success) {
        commonStore.success = false;
        commonStore.error = false;
        this.createConfiguration = response.data;
      } else {
        commonStore.success = false;
        commonStore.error = response;
      }

      this.getCookiesByProjectIdLoading = false;
    },

    async handleCreateConfiguration(creatableConfiguration: CreatableConfiguration) {
      const client = new ClientAPI();
      const commonStore = useCommonStore();
      commonStore.loading = true;
      const response = await client.createConfiguration(creatableConfiguration);
      if (response.success) {
        commonStore.success = response;
        commonStore.error = false;
        configurationBus.emit(ConfigurationEventType.CONFIGURATION_CREATED, response.data);
      } else {
        commonStore.success = false;
        commonStore.error = response;
      }
      commonStore.loading = false;
    },

    async handleEditConfiguration(editableConfiguration: EditableConfiguration) {
      const client = new ClientAPI();
      const commonStore = useCommonStore();
      commonStore.loading = true;
      const response = await client.editConfiguration(editableConfiguration);

      if (response.success) {
        commonStore.success = response;
        commonStore.error = false;
        configurationBus.emit(ConfigurationEventType.CONFIGURATION_EDITED);
      } else {
        commonStore.success = false;
        commonStore.error = response;
      }

      commonStore.loading = false;
    },

    async deleteConfiguration(idObject: number) {
      const client = new ClientAPI();
      const commonStore = useCommonStore();
      commonStore.loading = true;
      const response = await client.deleteConfiguration(idObject);

      if (response.success) {
        commonStore.success = response;
        commonStore.error = false;
        configurationBus.emit(ConfigurationEventType.CONFIGURATION_DELETED);
      } else {
        commonStore.success = false;
        commonStore.error = response;
      }

      commonStore.loading = false;
    },

    async getEditConfiguration(idObject: number) {
      const client = new ClientAPI();
      const commonStore = useCommonStore();
      commonStore.loading = true;
      const response = await client.getEditConfiguration(idObject);

      if (response.success) {
        commonStore.success = false;
        commonStore.error = false;
        this.editConfiguration = response.data;
        configurationBus.emit(ConfigurationEventType.CONFIGURATION_EDIT_LOADED);
      } else {
        commonStore.success = false;
        commonStore.error = response;
      }

      commonStore.loading = false;
    },

    clearCreateConfiguration() {
      this.createConfiguration = null;
    },

    clearEditConfiguration() {
      this.editConfiguration = null;
    },

    async getListConfigurations() {
      const commonStore = useCommonStore();
      const client = new ClientAPI();

      commonStore.loading = true;
      const response = await client.getListConfigurations();

      if (response.success) {
        this.configurations = response.data;
      } else {
        commonStore.success = false;
        commonStore.error = response;
      }

      commonStore.loading = false;
    },
  }
});