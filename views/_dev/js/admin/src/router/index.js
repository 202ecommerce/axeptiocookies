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

import Vue from 'vue';
import VueRouter from 'vue-router';
import Create from '../components/Create/Create';
import List from '../components/List/List';
import Routes from "../custom/constants/Routes";
import RouteDispatcher from "../custom/RouteDispatcher";
import Edit from '../components/Edit/Edit';

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    {
      path: window.axeptiocookies.links.configuration + '&page=create',
      props: true,
      name: Routes.CREATE,
      component: Create,
    },
    {
      path: window.axeptiocookies.links.configuration + '&page=edit&id=:id',
      props: true,
      name: Routes.EDIT,
      component: Edit,
    },
    {
      path: window.axeptiocookies.links.configuration + '&page=list',
      props: true,
      name: Routes.LIST,
      component: List
    },
  ],
  mode: 'history'
});

router.beforeEach((to, from, next) => {
  if (to.name === null) {
    let params = {};
    const urlParams = new URLSearchParams(window.location.search);
    let page = urlParams.get('page');
    params.id = urlParams.get('id');
    const routeDispatcher = new RouteDispatcher(router);
    routeDispatcher.dispatch(page, params);
  }

  next(vm => {
    next();
  });
})

export default router;