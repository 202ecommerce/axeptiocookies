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

import DeleteModal from './DeleteModal';

export default {
  name: "SimpleCard",
  props: {
    configuration:{
      type: Object
    }
  },
  computed: {
    image() {
      return window.axeptiocookies.images.list;
    },
    translations() {
      return window.axeptiocookies.translations;
    },
    getShops() {
      const shops = window.axeptiocookies.data.shops;

      if (this.configuration) {
        return this.configuration.idShops.map(idShop => {
          return Object.values(shops).find(shop => {
            return shop.id_shop === idShop;
          });
        })
      }

      return [];
    },
    getLanguage() {
      const self = this;
      const languages = window.axeptiocookies.data.languages;

      if (this.configuration) {
        return languages.find(lang => {
          return self.configuration.idLanguage === lang.id_lang;
        })
      }

      return null;
    }
  },
  methods: {
    handleDelete() {
      $('#deleteModal_' + this.configuration.idObject).modal('show');
    }
  },
  components: {
    DeleteModal
  }
}