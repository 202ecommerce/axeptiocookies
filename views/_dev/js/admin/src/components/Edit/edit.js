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

import Multiselect from 'vue-multiselect';
import Loader from '../Common/Loader';
import {configurationEmitter} from '../../events/emitters';
import {CONFIGURATION_EDITED} from '../../events/EventType';
import AxeptioExample from "./AxpetioExample";

const TAB_ITEM = {
  GENERAL: 'general',
  MODULES: 'modules'
};

export default {
  name: "Edit",
  data() {
    return {
      selectedTab: TAB_ITEM.GENERAL,
      tabs: TAB_ITEM
    };
  },
  computed: {
    translations() {
      return window.axeptiocookies.translations;
    },
    shops() {
      return Object.values(window.axeptiocookies.data.shops);
    },
    languages() {
      return Object.values(window.axeptiocookies.data.languages);
    },
    loading() {
      return this.$store.getters.loading;
    },
    editConfiguration() {
      return this.$store.getters.getEditConfiguration;
    },
    nbModules() {
      if (!this.editConfiguration) {
        return 0;
      }

      return this.editConfiguration.modules.filter(module => {
        return module.checked;
      }).length;
    },
    image() {
      return window.axeptiocookies.images.create;
    },
  },
  methods: {
    handleSave() {
      this.$store.dispatch('editConfiguration', this.editConfiguration);
    },
    handleModuleClick(index) {
      this.editConfiguration.modules[index].checked = !this.editConfiguration.modules[index].checked;
    }
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.$store.dispatch('setError', false);
      vm.$store.dispatch('setSuccess', false);
      vm.$store.dispatch('clearEditConfiguration');
      vm.$store.dispatch('getEditConfiguration', vm.$route.params.id);
      next();
    })
  },
  components: {
    Multiselect,
    Loader,
    AxeptioExample
  },
  created() {
    const self = this;

    configurationEmitter.$on(CONFIGURATION_EDITED, () => {
      self.$router.push({name: 'list'});
    });
  }
}