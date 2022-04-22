/**
 * Copyright Bridge
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
 * @copyright Bridge
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
 */

import Vue from 'vue';
import router from '../router';
import store from '../store';

export class AbstractComponentInitializer {
  constructor(markerClass) {
    this.markerClass = markerClass;
  }

  callComponent() {
    if ($(this.getMarkerClass()).length > 0) {
      this.initComponent();
    }
  }

  initComponent() {
    const self = this;
    if ($(this.getElement()).length > 0) {
      new Vue({
        el: self.getElement(),
        store,
        router,
        render: (h) => h(self.getComponent()),
        name: self.getComponent().name
      });
    }
  }

  getElement() {
    throw new Error('Not implemented');
  }

  getComponent() {
    throw new Error('Not implemented');
  }

  getMarkerClass() {
    return this.markerClass;
  }
}