/*
 * NOTICE OF LICENSE
 *
 * This source file is subject to a commercial license from SARL 202 ecommerce
 * Use, copy, modification or distribution of this source file without written
 * license agreement from the SARL 202 ecommerce is strictly forbidden.
 * In order to obtain a license, please contact us: tech@202-ecommerce.com
 * ...........................................................................
 * INFORMATION SUR LA LICENCE D'UTILISATION
 *
 * L'utilisation de ce fichier source est soumise a une licence commerciale
 * concedee par la societe 202 ecommerce
 * Toute utilisation, reproduction, modification ou distribution du present
 * fichier source sans contrat de licence ecrit de la part de la SARL 202 ecommerce est
 * expressement interdite.
 * Pour obtenir une licence, veuillez contacter 202-ecommerce <tech@202-ecommerce.com>
 * ...........................................................................
 *
 * @author    202-ecommerce <tech@202-ecommerce.com>
 * @copyright Copyright (c) 202-ecommerce
 * @license   Commercial license
 */
'use strict';

import Client from '../custom/Client';
import {configurationEmitter} from '../events/emitters';
import {
  CONFIGURATION_CREATED,
  CONFIGURATION_DELETED,
  CONFIGURATION_EDIT_LOADED,
  CONFIGURATION_EDITED
} from '../events/EventType';

export default {
  state: {
    configurations: [],
    createConfiguration: null,
    editConfiguration: null,
    getCookiesByProjectIdLoading: false,
  },
  mutations: {
    setCreateConfiguration(state, payload) {
      state.createConfiguration = payload;
    },

    setEditConfiguration(state, payload) {
      state.editConfiguration = payload;
    },

    setConfigurations(state, payload) {
      state.configurations = payload;
    },

    clearCreateConfiguration(state, payload) {
      state.createConfiguration = null;
    },

    clearEditConfiguration(state, payload) {
      state.editConfiguration = null;
    },

    setGetCookiesByProjectIdLoading(state, payload) {
      state.getCookiesByProjectIdLoading = payload;
    }
  },
  actions: {
    async getCookiesByProjectId({commit, getters}, payload) {
      const client = new Client();
      commit('setGetCookiesByProjectIdLoading', true);
      const response = await client.getCookiesByProjectId(payload);

      if (response.success) {
        commit('setSuccess', false);
        commit('setError', false);
        commit('setCreateConfiguration', response.data);
      } else {
        commit('setSuccess', false);
        commit('setError', response);
      }

      commit('setGetCookiesByProjectIdLoading', false);
    },

    async createConfiguration({commit, getters}, payload) {
      const client = new Client();
      commit('setLoading', true);
      const response = await client.createConfiguration(payload);
      if (response.success) {
        commit('setSuccess', response);
        commit('setError', false);
        configurationEmitter.$emit(CONFIGURATION_CREATED, response.data);
      } else {
        commit('setSuccess', false);
        commit('setError', response);
      }
      commit('setLoading', false);
    },

    async editConfiguration({commit, getters}, payload) {
      const client = new Client();
      commit('setLoading', true);
      const response = await client.editConfiguration(payload);

      if (response.success) {
        commit('setSuccess', response);
        commit('setError', false);
        configurationEmitter.$emit(CONFIGURATION_EDITED);
      } else {
        commit('setSuccess', false);
        commit('setError', response);
      }

      commit('setLoading', false);
    },

    async deleteConfiguration({commit, getters}, payload) {
      const client = new Client();
      commit('setLoading', true);
      const response = await client.deleteConfiguration(payload);

      if (response.success) {
        commit('setSuccess', response);
        commit('setError', false);
        configurationEmitter.$emit(CONFIGURATION_DELETED);
      } else {
        commit('setSuccess', false);
        commit('setError', response);
      }

      commit('setLoading', false);
    },

    clearCreateConfiguration({commit}) {
      commit('clearCreateConfiguration');
    },

    clearEditConfiguration({commit}) {
      commit('clearEditConfiguration');
    },

    async getListConfigurations({commit, getters}) {
      const client = new Client();
      commit('setLoading', true);
      const response = await client.getListConfigurations();

      if (response.success) {
        commit('setConfigurations', response.data);
      } else {
        commit('setSuccess', false);
        commit('setError', response);
      }

      commit('setLoading', false);
    },

    async getEditConfiguration({commit, getters}, payload) {
      const client = new Client();
      commit('setLoading', true);
      const response = await client.getEditConfiguration(payload);

      if (response.success) {
        commit('setSuccess', false);
        commit('setError', false);
        commit('setEditConfiguration', response.data);
        configurationEmitter.$emit(CONFIGURATION_EDIT_LOADED);
      } else {
        commit('setSuccess', false);
        commit('setError', response);
      }

      commit('setLoading', false);
    },
  },
  getters: {
    getCreateConfiguration(state) {
      return state.createConfiguration;
    },
    getEditConfiguration(state) {
      return state.editConfiguration;
    },
    getConfigurations(state) {
      return state.configurations;
    },
    getCookiesByProjectIdLoading(state) {
      return state.getCookiesByProjectIdLoading;
    }
  }
};