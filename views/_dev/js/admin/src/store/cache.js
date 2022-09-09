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