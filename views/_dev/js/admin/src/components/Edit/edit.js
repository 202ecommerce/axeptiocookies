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
    },
    getPrettyModuleName(name) {
      const areaElement = document.createElement("textarea");
      areaElement.innerHTML = name;
      const text = areaElement.value;
      areaElement.remove();

      return text;
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