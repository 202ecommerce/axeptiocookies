<?php
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

namespace AxeptiocookiesAddon\Handler\Template;

abstract class AbstractTemplateHandler
{
    /**
     * @var \Smarty_Internal_Template
     */
    protected $template;

    /**
     * @var string
     */
    protected $source;

    /**
     * @return string
     */
    public function handle()
    {
        try {
            return $this->getPlaceholder();
        } catch (\Exception $exception) {
            return $this->source;
        }
    }

    protected function getPlaceholder()
    {
        $tpl = \Context::getContext()
            ->smarty
            ->createTemplate('module:axeptiocookies/views/templates/front/template/placeholder.tpl')
            ->assign([
                'id' => uniqid(),
                'templateCode' => base64_encode($this->source),
                'module' => $this->getModule(),
            ]);

        return $tpl->fetch();
    }

    /**
     * @param \Smarty_Internal_Template $template
     *
     * @return AbstractTemplateHandler
     */
    public function setTemplate(\Smarty_Internal_Template $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @param string $source
     *
     * @return AbstractTemplateHandler
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    abstract protected function getModule();
}
