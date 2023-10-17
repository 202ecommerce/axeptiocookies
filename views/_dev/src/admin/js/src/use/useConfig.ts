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

import type {Configuration, Language, Shop} from "../types/types.ts";

export function useConfig(): {
  links: {
    [key: string]: string;
  },
  shops: Shop[],
  languages: Language[],
  defaultConfigurations: Configuration[],
  images: {
    create: string,
    list: string,
    people: string,
    sky: string
  }
} {
  const links: { [key: string]: string; } = window.axeptiocookies.links;
  const images = window.axeptiocookies.images;
  const defaultConfigurations: Configuration[] = window.axeptiocookies.data.configurations;
  const languages: Language[] = window.axeptiocookies.data.languages;
  const shops: Shop[] = Object.values(window.axeptiocookies.data.shops);

  return {
    links,
    images,
    shops,
    languages,
    defaultConfigurations
  };
}