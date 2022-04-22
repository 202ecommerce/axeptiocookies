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

export default {
  state: {
    loading: false,
    success: false,
    error: false,
  },
  mutations: {
    setLoading(state, payload) {
      state.loading = payload;
    },
    setSuccess(state, payload) {
      state.success = payload;
    },
    setError(state, payload) {
      state.error = payload;
    },

  },
  actions: {
    setLoading({commit}, payload) {
      commit('setLoading', payload);
    },
    setSuccess({commit}, payload) {
      commit('setSuccess', payload);
    },
    setError({commit}, payload) {
      commit('setError', payload);
    }
  },
  getters: {
    loading(state) {
      return state.loading;
    },
    success(state) {
      return state.success;
    },
    error(state) {
      return state.error;
    }
  }
};