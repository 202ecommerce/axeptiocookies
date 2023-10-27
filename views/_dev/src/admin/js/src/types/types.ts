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

export interface DefaultResponse {
  message: string;
  success: boolean;
  type: 'success' | 'error';
}

export interface Configuration {
  idConfiguration: string;
  idLanguage: number;
  idObject: number;
  idProject: string;
  idShops: string[];
  configuration: ConfigurationData;
}

export interface ConfigurationData {
  id: string;
  language: string; // iso code
  name: string;
  title: string;
}

export interface Shop {
  active: boolean;
  domain: string;
  domain_ssl: string;
  id_category: number;
  id_shop: number | string;
  id_shop_group: number;
  name: string;
  theme_name: string;
  uri: string;
}

export interface Language {
  id_lang: number;
  name: string;
  active: boolean;
  iso_code: string;
  language_code: string;
  locale: string;
  date_format_lite: string;
  date_format_full: string;
  is_rtl: boolean;
  id_shop: number;
  shops: {
    [key: number]: boolean;
  }
}

export interface CreatableConfiguration {
  idProject: string;
  idConfiguration?: string;
  idShops?: number[];
  idLanguage?: number;
  message?: string;
  title?: string;
  subtitle?: string;
  configurations?: ConfigurationData[];
}
export interface EditableConfiguration {
  idObject: number;
  configuration: ConfigurationData;
  idProject: string;
  language: Language;
  message: string;
  modules: Module[];
  project: {
    configurations: ConfigurationData[];
    idProject: string;
  };
  shops: Shop[];
  subtitle: string;
  title: string;
}

export interface Module {
  active: boolean;
  authorUri: boolean | string;
  checked: boolean;
  description: string;
  id_module: number;
  image: string | null;
  name: string;
  displayName: string | null;
  recommended: false | RecommendedModule;
  tab: string;
  version: string;
}

export interface RecommendedModule {
  id: string;
  isRequired: boolean;
  name: string;
  state: string;
  url: string;
}