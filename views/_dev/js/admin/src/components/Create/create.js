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
import {configurationEmitter} from '../../events/emitters';
import {CONFIGURATION_CREATED} from '../../events/EventType';
import Loader from '../Common/Loader';
import Routes from "../../custom/constants/Routes";

export default {
  name: 'Create',
  data() {
    return {
      idProject: '',
      configuration: null,
      idShops: [],
      language: null,
      message: '',
      title: '',
      subtitle: '',
      hasBack: false,
      commonFieldsHighlited: false,
      searchTimer: null
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
    createConfiguration() {
      return this.$store.getters.getCreateConfiguration;
    },
    loading() {
      return this.$store.getters.loading;
    },
    configurations() {
      if (this.createConfiguration) {
        return this.createConfiguration.configurations;
      }

      return [];
    },
    isSavable() {
      return this.idProject && this.configuration && this.idShops.length > 0 && this.language;
    },
    isCommonFieldEditable() {
      return this.idProject && this.createConfiguration !== null && this.createConfiguration.idProject;
    },
    showBackButton() {
      return this.hasBack || window.axeptiocookies.data.configurations.length > 0;
    },
    getCookiesByProjectIdLoading() {
      return this.$store.getters.getCookiesByProjectIdLoading;
    }
  },
  methods: {
    handleSave() {
      if (!this.isSavable) {
        return;
      }

      const configuration = {
        idProject: this.idProject,
        idConfiguration: this.configuration.id,
        idShops: this.idShops.map(shop => shop.id_shop),
        idLanguage: this.language.id_lang,
        message: this.message,
        title: this.title,
        subtitle: this.subtitle,
      };

      this.$store.dispatch('createConfiguration', configuration);
    },
    async handleInputProjectId() {
      const self = this;
      if (this.createConfiguration !== null && this.idProject === this.createConfiguration.idProject) {
        return;
      }

      await this.$store.dispatch('clearCreateConfiguration');
      this.configuration = null;
      if (this.idProject === '') {
        return;
      }
      await this.$store.dispatch('getCookiesByProjectId', this.idProject);
      if (this.isCommonFieldEditable) {
        this.commonFieldsHighlited = true;
        setTimeout(function () {
          self.commonFieldsHighlited = false;
        }, 1000);
      }
    },
    onSearchProject() {
      const self = this;
      if (this.searchTimer) {
        clearTimeout(this.searchTimer);
        this.searchTimer = null;
      }
      this.searchTimer = setTimeout(async() => {
        await self.handleInputProjectId();
      }, 500);
    },
    handleSelectConfiguration(configuration) {
      if (!(this.createConfiguration !== null && this.idProject === this.createConfiguration.idProject)) {
        return;
      }

      if (this.language) {
        return;
      }

      const languageToSelect = this.languages.find(lang => {
        return lang.iso_code === configuration.language;
      });

      if (!languageToSelect) {
        return;
      }

      this.language = languageToSelect;
    }
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.hasBack = from.name === Routes.LIST;
      vm.$store.dispatch('setError', false);
      vm.$store.dispatch('setSuccess', false);
      vm.$store.dispatch('clearCreateConfiguration');
      vm.idConfiguration = null;
      next();
    })
  },
  components: {
    Multiselect,
    Loader
  },
  created() {
    const self = this;

    configurationEmitter.$on(CONFIGURATION_CREATED, (idConfiguration) => {
      self.$router.push({name: 'edit', params: {id: idConfiguration}});
    });
  }
}