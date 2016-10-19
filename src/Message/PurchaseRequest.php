<?php

namespace Omnipay\Cofidis\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Cofidis Purchase Request
 *
 * @author Carlos Mendieta <carlos.mendieta@sddbrandcare.com>
 */
class PurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://www.cofidisonline.cofidis.es/FinanciacionEstandar/bienvenido.do';
    protected $testEndpoint = 'https://rqt-www.cofidisonline.cofidis.es/FinanciacionEstandar/bienvenido.do';

    public function setOrder($order)
    {
        return $this->setParameter('order', $order);
    }

    public function setMerchantCode($merchantCode)
    {
        $this->setParameter('merchantCode', $merchantCode);
    }

    public function setProductCode($productCode)
    {
        $this->setParameter('productCode', $productCode);
    }

    public function setDeferral($deferral)
    {
        $this->setParameter('deferral', $deferral);
    }

    public function setReturnUrl($returnUrl)
    {
        $this->setParameter('returnUrl', $returnUrl);
    }

    public function setCancelUrl($cancelUrl)
    {
        $this->setParameter('cancelUrl', $cancelUrl);
    }

    public function setConfirmCallback($confirmCallback)
    {
        $this->setParameter('confirmCallback', $confirmCallback);
    }

    public function setErrorCallback($errorCallback)
    {
        $this->setParameter('errorCallback', $errorCallback);
    }

    public function setProducts($products)
    {
        $this->setParameter('products', $products);
    }

    public function getData()
    {
        $data = [
            'importe'     => (float)$this->getAmount(),
            'precioTotal' => (float)$this->getAmount(),

            'nombre'         => $this->getParameter('name'),
            'apellidos '     => $this->getParameter('lastname'),
            'cod_postal'     => $this->getParameter('postalCode'),
            'email'          => $this->getParameter('email'),
            'telefono'       => $this->getParameter('phone'),
            'tipo_documento' => $this->getParameter('documentType'),
            'nif'            => $this->getParameter('document'),

            'url_acept'  => $this->getParameter('returnUrl'),
            'url_rechaz' => $this->getParameter('cancelUrl'),
            'url_cancel' => $this->getParameter('cancelUrl'),

            'url_confirm' => $this->getParameter('confirmCallback'),
            'url_error'   => $this->getParameter('errorCallback'),

            'referencia' => $this->getParameter('order'),
            'vendedor'   => $this->getParameter('merchantCode'),
            'producto'   => $this->getParameter('productCode'),
            'carencia'   => $this->getParameter('deferral'),

        ];

        foreach ($this->getParameter('products') as $key => $product) {
            $data['cantidadCompra' . $key] = round($product['quantity'], 2);
            $data['precioCompra' . $key]   = $product['price'];
            $data['descCompra' . $key]     = $product['description'];
        }

        return $data;
    }
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}