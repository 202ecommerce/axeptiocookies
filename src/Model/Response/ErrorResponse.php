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

namespace AxeptiocookiesAddon\Model\Response;

if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesClasslib\Utils\Translate\TranslateTrait;

class ErrorResponse extends FrontResponse
{
    use TranslateTrait;

    protected $type = ResponseResultType::ERROR;

    protected $success = false;

    /**
     * @var string
     */
    protected $message;

    /**
     * @return string
     */
    public function getMessage()
    {
        if (empty($this->message)) {
            return $this->l('Error occurred', $this->getClassShortName());
        }

        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return ErrorResponse
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
