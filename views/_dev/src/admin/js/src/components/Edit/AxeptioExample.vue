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
import {useConfig} from "../../use/useConfig.ts";

const {trans} = useTrans();
const {images} = useConfig();

const props = defineProps<{
  title: string,
  subtitle: string,
  message: string,
  illustration: string | null,
  paint: boolean
}>();
</script>

<template>
  <div class="axeptio-example-wrapper">
    <div class="axeptio-card">
      <div class="axeptio-card-header">
        <div class="axeptio-card-header-top">
          <div class="axeptio-card-header-top-image-wrapper">
            <img
                :src="props.illustration ? props.illustration : images.people"
                width="140" alt="People" loading="lazy" class="axeptio-header-image">
            <div class="axeptio-card-header-top-image-wrapper-second">
              <img v-if="props.paint"
                  :src="images.sky"
                  width="200" height="134" alt="Sky"></div>
          </div>
          <div offset="320" class="axeptio-card-header-top-block">
            <div class="axeptio-card-header-top-block-title">
              <div class="d-flex justify-content-center align-items-center flex-column">
                <span class="text-center"
                      v-text="title"></span>
                <small class="text-center"
                       v-text="subtitle"></small>
              </div>
            </div>
            <div class="axeptio-card-header-top-block-message"
                 v-text="message"></div>
            <div>
              <div class="axeptio-card-header-top-block-modules-wrapper">
                <div>
                  <div class="axeptio-card-header-top-block-check-all-wrapper">
                    <strong v-text="trans('example.toggle_all')"></strong>
                    <label for="normal-switch mb-0"
                           class="sc-gTgzoy etzlvs">
                      <div
                          style="position: relative; display: inline-flex; text-align: left; opacity: 1; border-radius: 12px; transition: opacity 0.25s ease 0s; touch-action: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;">
                        <div class="react-switch-bg"
                             style="height: 24px; width: 50px; margin: 2px; position: relative; background: rgb(173, 173, 173); border-radius: 12px; cursor: pointer; transition: background 0.25s ease 0s;"></div>
                        <div class="react-switch-handle" role="checkbox" tabindex="0" id="normal-switch"
                             aria-checked="false" aria-disabled="false"
                             style="height: 28px; width: 28px; background: rgb(255, 255, 255); cursor: pointer; display: inline-block; border-radius: 50%; position: absolute; transform: translateX(0px); top: 0px; left: 0px; outline: 0px; box-shadow: rgba(0, 0, 0, 0.15) 0px 3px 12px; border: 0px; transition: background-color 0.25s ease 0s, transform 0.25s ease 0s, box-shadow 0.15s ease 0s;">
                          <div
                              style="position: absolute; top: 50%; left: 50%; transform: translate3d(-50%, -50%, 0px); margin-top: 1.5px; margin-left: 3px; height: 24px; width: 28px; opacity: 0; pointer-events: none; transition: opacity 0.25s ease 0s;">
                          <span class="sc-bdfBQB cfGuAk"><span color="#ffc823" class="sc-gsTEea iPbyrd svgr"><svg
                              xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path
                              d="M9,16.17L4.83,12l-1.42,1.41L9,19L21,7l-1.41-1.41L9,16.17z"></path></svg></span></span>
                          </div>
                          <div
                              style="position: absolute; top: 50%; left: 50%; transform: translate3d(-50%, -50%, 0px); margin-top: 1.5px; margin-left: 3px; height: 24px; width: 28px; opacity: 1; pointer-events: none; transition: opacity 0.25s ease 0s;">
                          <span class="sc-bdfBQB cfGuAk"><span color="#ADADAD" class="sc-gsTEea jMnjtR svgr"><svg
                              xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g><path
                              d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41z"></path></g></svg></span></span>
                          </div>
                        </div>
                      </div>
                    </label>
                  </div>
                  <div class="axeptio-card-header-top-block-module-item-wrapper"
                       v-for="item of [1, 2, 3]">
                    <div class="axeptio-card-header-top-block-module-item">
                      <div class="axeptio-card-header-top-block-module-vendor">
                        <div class="axeptio-card-header-top-block-module-brand">
                          <div class="axeptio-card-header-top-block-module-favicon">
                            <img alt=""
                                 src="https://www.google.com/s2/favicons?domain=https://prestashop.com">
                          </div>
                          <a href="#" :title="trans('example.title') + ' ' + item"
                             class="axeptio-card-header-top-block-module-policy"
                             rel="noopener nofollower noreferrer">?</a></div>
                        <div>
                          <div v-text="trans('example.title') + ' ' + item"></div>
                          <div class="axeptio-card-header-top-block-module-description"
                               v-text="trans('example.description') + ' ' + item"></div>
                        </div>
                      </div>
                      <label for="_jsuid-normal-switch" class="switch-wrapper">
                        <div
                            style="position: relative; display: inline-flex; text-align: left; opacity: 1; border-radius: 9px; transition: opacity 0.25s ease 0s; touch-action: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;">
                          <div class="react-switch-bg"
                               style="height: 18px; width: 32px; margin: 2px; position: relative; background: rgb(255, 200, 35); border-radius: 9px; cursor: pointer; transition: background 0.25s ease 0s;"></div>
                          <div class="react-switch-handle" role="checkbox" tabindex="0" id="_jsuid-normal-switch"
                               aria-checked="true" aria-disabled="false"
                               style="height: 22px; width: 22px; background: rgb(255, 255, 255); cursor: pointer; display: inline-block; border-radius: 50%; position: absolute; transform: translateX(14px); top: 0px; left: 0px; outline: 0px; box-shadow: rgba(0, 0, 0, 0.15) 0px 3px 12px; border: 0px; transition: background-color 0.25s ease 0s, transform 0.25s ease 0s, box-shadow 0.15s ease 0s;">
                            <div
                                style="position: absolute; top: 50%; left: 50%; transform: translate3d(-50%, -50%, 0px); margin-top: 0px; margin-left: 3px; height: 18px; width: 22px; opacity: 1; pointer-events: none; transition: opacity 0.25s ease 0s;">
                              <span class="sc-bdfBQB cfGuAk"><span color="#ffc823" class="sc-gsTEea lRmtB svgr"><svg
                                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path
                                  d="M9,16.17L4.83,12l-1.42,1.41L9,19L21,7l-1.41-1.41L9,16.17z"></path></svg></span></span>
                            </div>
                            <div
                                style="position: absolute; top: 50%; left: 50%; transform: translate3d(-50%, -50%, 0px); margin-top: 0px; margin-left: 3px; height: 18px; width: 22px; opacity: 0; pointer-events: none; transition: opacity 0.25s ease 0s;">
                              <span class="sc-bdfBQB cfGuAk"><span color="#ADADAD" class="sc-gsTEea eoYeeh svgr"><svg
                                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g><path
                                  d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41z"></path></g></svg></span></span>
                            </div>
                          </div>
                        </div>
                      </label></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <span class="axeptio-card-header-center">
          <button>
            <span v-text="trans('example.certified') + ' '"></span>
            <span
                class="sc-kEjbQP fsvoJQ"><span class="sc-bdfBQB cfGuAk"><span class="sc-gsTEea kCMjsF svgr"><svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FFC823"
                                                                                                    d="M6.122 9.379c-.8-.799-2.855-.877-4.723.743-1.747 1.514-1.718 3.336-.359 4.338 1.27.934 3.01 1.086 4.338-.358 1.613-1.755 1.542-3.924.744-4.723m-3.873 3.376a.159.159 0 0 1-.115.047.16.16 0 0 1-.114-.047l-.724-.723a.16.16 0 0 1 0-.229.162.162 0 0 1 .23 0l.607.607L3.9 10.644a.162.162 0 0 1 .23 0 .164.164 0 0 1 0 .229l-1.881 1.882zm1.398-.548a.156.156 0 0 1-.111-.267l1.156-1.156a.155.155 0 0 1 .22 0 .155.155 0 0 1 0 .221L3.758 12.16a.15.15 0 0 1-.111.047m1.417.352l-.454.454a.153.153 0 0 1-.221 0 .158.158 0 0 1 0-.222l.455-.453a.156.156 0 0 1 .221 0 .155.155 0 0 1-.001.221m0-.853l-.88.88a.158.158 0 0 1-.111.048.158.158 0 0 1-.111-.048.156.156 0 0 1 0-.219l.881-.882a.156.156 0 0 1 .221.221"></path><path
                fill="#282E68"
                d="M10.138 11.283c0 .004-.006.007-.009.003-.186-.257-.51-.412-.872-.412-.672 0-1.179.521-1.179 1.209 0 .681.519 1.213 1.179 1.213.363 0 .687-.156.872-.414.003-.004.009-.002.009.002v.234c0 .072.058.13.128.13h.105a.129.129 0 0 0 .128-.13v-2.066a.128.128 0 0 0-.128-.129h-.105a.13.13 0 0 0-.128.129v.231zm-.555 1.616c-.606.201-1.142-.232-1.142-.82a.84.84 0 0 1 .841-.856.85.85 0 0 1 .853.952.824.824 0 0 1-.552.724M14.461 10.875c-.688 0-1.186.507-1.186 1.205 0 .706.498 1.218 1.186 1.218.4 0 .752-.172.966-.467a.116.116 0 0 0-.048-.172l-.082-.038a.153.153 0 0 0-.174.042.844.844 0 0 1-.654.287c-.448 0-.76-.269-.822-.703 0-.003.003-.005.007-.005h1.854a.097.097 0 0 0 .097-.092l.002-.07c-.002-.722-.462-1.205-1.146-1.205m0 .348c.432 0 .729.265.783.693.001.003-.002.006-.004.006h-1.583c-.003 0-.005-.003-.004-.006.065-.435.365-.693.808-.693M17.407 10.875c-.359 0-.688.162-.872.419-.002.003-.01.002-.01-.003v-.245a.122.122 0 0 0-.12-.121h-.119a.123.123 0 0 0-.123.121v3.188c0 .066.055.121.123.121h.119c.065 0 .12-.055.12-.121v-1.349c0-.004.008-.006.01-.002.187.258.51.414.872.414.672 0 1.179-.519 1.179-1.208 0-.692-.507-1.214-1.179-1.214m-.319.396a.854.854 0 0 1 1.142.824.842.842 0 0 1-.847.855.849.849 0 0 1-.853-.955.821.821 0 0 1 .558-.724M19.486 10.018h-.073a.143.143 0 0 0-.143.142v.758c0 .003-.003.006-.005.006h-.267a.143.143 0 0 0-.143.143v.034c0 .079.064.142.143.142h.267c.002 0 .005.002.005.005v1.859c0 .078.064.143.143.143h.073a.144.144 0 0 0 .143-.143v-1.859c0-.003.002-.005.006-.005h.373a.143.143 0 0 0 .143-.142v-.034a.143.143 0 0 0-.143-.143h-.373c-.004 0-.006-.002-.006-.006v-.758a.143.143 0 0 0-.143-.142M20.762 9.862c-.147 0-.264.11-.264.25 0 .134.119.244.264.244.154 0 .271-.105.271-.244-.001-.143-.117-.25-.271-.25M20.733 13.249h.059a.152.152 0 0 0 .151-.152v-2.021a.152.152 0 0 0-.151-.152h-.059a.151.151 0 0 0-.152.152v2.021c0 .084.068.152.152.152M22.73 10.875c-.704 0-1.214.507-1.214 1.205 0 .646.449 1.143 1.068 1.21.797.088 1.471-.627 1.349-1.417-.091-.59-.569-.998-1.203-.998m0 2.074c-.493 0-.852-.366-.852-.87 0-.459.308-.803.745-.851a.874.874 0 0 1 .962.888.842.842 0 0 1-.855.833M12.813 10.924h-.181a.175.175 0 0 0-.144.074l-.47.733c-.002.003-.007.003-.009 0l-.475-.733a.174.174 0 0 0-.144-.074h-.181a.087.087 0 0 0-.07.139l.655.974c.002.001.002.004 0 .006l-.753 1.065a.089.089 0 0 0 .071.141h.171a.177.177 0 0 0 .143-.072l.583-.83c.002-.002.007-.002.009 0l.573.828a.175.175 0 0 0 .144.074h.176c.072 0 .113-.08.072-.14l-.75-1.071v-.007l.651-.968a.087.087 0 0 0-.071-.139"></path></svg></span></span></span>
          </button>
        </span>
      </div>
      <div class="axeptio-card-footer">
        <button class="axeptio-btn-left"
                v-text="trans('example.accept')"></button>
        <button class="axeptio-btn-right"
                v-text="trans('example.next')"></button>
      </div>
    </div>
  </div>
</template>
