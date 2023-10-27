<!--
  - Copyright since 2022 Axeptio
  -
  - NOTICE OF LICENSE
  -
  - This source file is subject to the Academic Free License (AFL 3.0)
  - that is bundled with this package in the file LICENSE.md.
  - It is also available through the world-wide-web at this URL:
  - https://opensource.org/licenses/AFL-3.0
  - If you did not receive a copy of the license and are unable to
  - obtain it through the world-wide-web, please send an email
  - to tech@202-ecommerce.com so we can send you a copy immediately.
  -
  - @author    202 ecommerce <tech@202-ecommerce.com>
  - @copyright 2022 Axeptio
  - @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
  -->

<script setup lang="ts">
  import {useTrans} from "../../use/useTrans.ts";
  import {ref} from "vue";
  import type {Configuration} from "../../types/types.ts";
  import {useConfigurationStore} from "../../stores/configurationStore.ts";

  const {trans} = useTrans();
  const configurationStore = useConfigurationStore();

  const isShown = ref(false);

  const props = defineProps<{
    configuration: Configuration
  }>();

  const handleDelete = () => {
    configurationStore.deleteConfiguration(props.configuration.idObject);
  };

  $(document).on('show.bs.modal', '#deleteModal_' + props.configuration.idObject, () => {
    isShown.value = true;
  });
  $(document).on('hidden.bs.modal', '#deleteModal_' + props.configuration.idObject, () => {
    isShown.value = false;
  });
</script>

<template>
  <div
      class="modal fade"
      :class="{'show': isShown}"
      :id="'deleteModal_' + configuration.idObject"
      tabindex="-1"
      aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" v-text="trans('list.delete')"></h5>
          <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p v-text="trans('list.delete_confirmation')"></p>
        </div>
        <div class="modal-footer">
          <button
              type="button"
              class="btn btn-default"
              data-dismiss="modal"
              v-text="trans('list.delete_no')"
          >
          </button>
          <button type="button"
                  class="btn btn-primary mb-1"
                  @click="handleDelete"
                  data-dismiss="modal"
                  v-text="trans('list.delete_yes')"></button>
        </div>
      </div>
    </div>
  </div>
</template>
