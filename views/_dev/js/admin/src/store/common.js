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