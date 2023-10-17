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

import {createRouter, createWebHistory} from 'vue-router'
import Routes from "../custom/Router/Routes.ts";
import CreateProjectView from "../views/CreateProjectView.vue";
import EditProjectView from "../views/EditProjectView.vue";
import ListProjectView from "../views/ListProjectView.vue";
import RouteDispatcher from "../custom/Router/RouteDispatcher.ts";
import {useConfigurationStore} from "../stores/configurationStore.ts";
import {useCommonStore} from "../stores/commonStore.ts";

let router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: window.axeptiocookies.links.configuration + '&page=create',
      props: true,
      name: Routes.CREATE,
      component: CreateProjectView,
      beforeEnter: async (to, from) => {
        to.meta.hasBack = from.name === Routes.LIST;
        const commonStore = useCommonStore();
        const configurationStore = useConfigurationStore();
        commonStore.error = false;
        commonStore.success = false;
        configurationStore.clearCreateConfiguration();
      }
    },
    {
      path: window.axeptiocookies.links.configuration + '&page=edit&id=:id',
      props: true,
      name: Routes.EDIT,
      component: EditProjectView,
      beforeEnter: async (to, from) => {
        to.meta.hasBack = from.name === Routes.LIST;
        const commonStore = useCommonStore();
        const configurationStore = useConfigurationStore();
        commonStore.error = false;
        commonStore.success = false;
        configurationStore.clearEditConfiguration();
        await configurationStore.getEditConfiguration(parseInt(to.params.id as string));
      }
    },
    {
      path: window.axeptiocookies.links.configuration + '&page=list',
      props: true,
      name: Routes.LIST,
      component: ListProjectView,
      beforeEnter: async (_to, _from) => {
        const configurationStore = useConfigurationStore();
        await configurationStore.getListConfigurations();
      }
    },
  ],
});

router.beforeEach((to, _, next) => {
  if (!to.name) {
    let params: { id?: number } = {};
    const urlParams = new URLSearchParams(window.location.search);
    let page = urlParams.get('page');
    let id = urlParams.get('id');
    params.id = id === null ? undefined : parseInt(id);
    const routeDispatcher = new RouteDispatcher(router);
    routeDispatcher.dispatch(page, params);
  }

  next(_ => {
    next();
  });
})

export default router;