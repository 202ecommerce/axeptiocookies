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