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

import type {Router} from "vue-router";
import Routes from "./Routes.ts";

export default class RouteDispatcher {
  private router: Router;

  constructor(router: Router) {
    this.router = router;
  }

  dispatch(page: string | unknown, params: { id?: number } = {}) {

    if (!page) {
      const configurations = window.axeptiocookies.data.configurations;
      if (configurations.length > 0) {
        page = Routes.LIST;
      } else {
        page = Routes.CREATE;
      }
    }

    switch (page) {
      case Routes.CREATE:
        this.router.replace({name: Routes.CREATE});
        return;
      case Routes.EDIT:
        this.router.replace({name: Routes.EDIT, params: {'id': params.id ? params.id : 0}});
        return;
      case Routes.LIST:
        this.router.replace({name: Routes.LIST});
        return;
    }
  }
};