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

import axios from 'axios'
import qs from 'qs';

const CancelToken = axios.CancelToken;

axios.interceptors.response.use(function (response) {
  if (response.data === '') {
    response.data = {
      success: false,
      message: window.axeptiocookies.translations.common.error_occurred,
    };
  }

  return response;
}, function (error) {
  return Promise.reject(error);
});

export default class Client {
  constructor() {
    this.getProjectIdCancelToken = false;
  }

  async getCookiesByProjectId(idProject) {
    try {
      const self = this;
      const url = window.axeptiocookies.links.ajax;

      if (this.getProjectIdCancelToken) {
        this.getProjectIdCancelToken();
      }

      const response = await axios.post(url, qs.stringify({
          ajax: true,
          action: 'GetCookiesByProjectId',
          idProject: idProject
        }),
        {
          cancelToken: new CancelToken((c) => {
            self.getProjectIdCancelToken = c;
          })
        });

      return response.data;
    } catch (e) {
      console.log(e);
    }
  }

  async deleteConfiguration(idObject) {
    try {
      const url = window.axeptiocookies.links.ajax;

      const response = await axios.post(url, qs.stringify({
        ajax: true,
        action: 'DeleteConfiguration',
        idObject: idObject
      }));

      return response.data;
    } catch (e) {
      console.log(e);
    }
  }

  async getListConfigurations() {
    try {
      const url = window.axeptiocookies.links.ajax;

      const response = await axios.post(url, qs.stringify({
        ajax: true,
        action: 'GetListConfigurations',
      }));

      return response.data;
    } catch (e) {
      console.log(e);
    }
  }

  async createConfiguration(configuration) {
    try {
      const url = window.axeptiocookies.links.ajax;

      const response = await axios.post(url, qs.stringify({
        ajax: true,
        action: 'CreateConfiguration',
        configuration: configuration
      }));

      return response.data;
    } catch (e) {
      console.log(e);
    }
  }

  async editConfiguration(configuration) {
    try {
      const url = window.axeptiocookies.links.ajax;

      const response = await axios.post(url, qs.stringify({
        ajax: true,
        action: 'EditConfiguration',
        configuration: configuration
      }));

      return response.data;
    } catch (e) {
      console.log(e);
    }
  }

  async getEditConfiguration(idObject) {
    try {
      const url = window.axeptiocookies.links.ajax;

      const response = await axios.post(url, qs.stringify({
        ajax: true,
        action: 'GetEditConfiguration',
        idObject: idObject
      }));

      return response.data;
    } catch (e) {
      console.log(e);
    }
  }

  async clearCache() {
    try {
      const url = window.axeptiocookies.links.ajax;

      const response = await axios.post(url, qs.stringify({
        ajax: true,
        action: 'ClearCache',
      }));

      return response.data;
    } catch (e) {
      console.log(e);
    }
  }
}