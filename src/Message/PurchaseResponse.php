<?php

namespace Omnipay\Cofidis\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpRedirectResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Cofidis Purchase Response
 *
 * @author Carlos Mendieta <carlos.mendieta@sddbrandcare.com>
 */

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return false;
    }
    public function isRedirect()
    {
        return true;
    }
    public function getRedirectUrl()
    {
        return $this->getRequest()->getEndpoint();
    }
    public function getRedirectMethod()
    {
        return 'POST';
    }
    public function getRedirectData()
    {
        return $this->data;
    }
    
    /**
     * Overrides original getRedirectResponse() to customize redirect form
     * @return HttpRedirectResponse | HttpResponse
     * @throws RuntimeException
     */
    public function getRedirectResponse()
    {
        if (!$this instanceof RedirectResponseInterface || !$this->isRedirect()) {
            throw new RuntimeException('This response does not support redirection.');
        }
        if ('GET' === $this->getRedirectMethod()) {
            return HttpRedirectResponse::create($this->getRedirectUrl());
        } elseif ('POST' === $this->getRedirectMethod()) {
            $hiddenFields = '';
            foreach ($this->getRedirectData() as $key => $value) {
                $hiddenFields .= sprintf(
                    '<input type="hidden" name="%1$s" value="%2$s" />',
                    htmlentities($key, ENT_QUOTES, 'UTF-8', false),
                    htmlentities($value, ENT_QUOTES, 'UTF-8', false)
                ) . "\n";
            }
            $view = \View::make('omnipay.cofidis', ['url' => $this->getRedirectUrl(), 'fields' => $hiddenFields]);
            return HttpResponse::create($view->render());
        }
        throw new RuntimeException('Invalid redirect method "'.$this->getRedirectMethod().'".');
    }
}
