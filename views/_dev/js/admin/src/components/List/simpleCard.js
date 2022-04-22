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