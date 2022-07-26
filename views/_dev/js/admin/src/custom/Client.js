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