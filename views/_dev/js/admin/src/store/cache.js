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

export default {
  state: {
    cacheLoading: false,
  },
  mutations: {
    setCacheLoading(state, payload) {
      state.cacheLoading = payload;
    },

  },
  actions: {
    async clearCache({commit, getters}) {
      const client = new Client();
      commit('setCacheLoading', true);
      const response = await client.clearCache();

      if (response.success) {
        commit('setSuccess', response);
        commit('setError', false);
      } else {
        commit('setSuccess', false);
        commit('setError', response);
      }

      commit('setCacheLoading', false);
    },
  },
  getters: {
    cacheLoading(state) {
      return state.cacheLoading;
    },
  }
};