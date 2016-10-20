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

    public function setDocumentType($products)
    {
        $this->setParameter('documentType', $products);
    }
    public function setDocument($products)
    {
        $this->setParameter('document', $products);
    }

    public function setProducts($products)
    {
        $this->setParameter('products', $products);
    }


    public function getData()
    {
        $data = [
            'importe'        => (float)$this->getAmount(),
            'precioTotal'    => (float)$this->getAmount(),
            'tipo_documento' => $this->getParameter('documentType'),
            'nif'            => $this->getParameter('document'),
            'referencia'     => $this->getParameter('order'),
            'vendedor'       => $this->getParameter('merchantCode'),
            'producto'       => $this->getParameter('productCode'),
            'carencia'       => $this->getParameter('deferral'),
            'url_acept'      => $this->getParameter('returnUrl'),
            'url_rechaz'     => $this->getParameter('cancelUrl'),
            'url_cancel'     => $this->getParameter('cancelUrl'),
            'url_confirm'    => $this->getParameter('confirmCallback'),
            'url_error'      => $this->getParameter('errorCallback'),
        ];

        $card = $this->getCard();

        if ($card) {
            $data['nombre']     = $card->getBillingFirstName();
            $data['apellidos']  = $card->getBillingLastName();
            $data['cod_postal'] = $card->getPostcode();
            $data['email']      = $card->getEmail();
            $data['telefono']   = $card->getPhone();
            $data['via']        = $card->getAddress1();
            $data['poblacion']  = $card->getCity();
        }

        foreach ($this->getParameter('products') as $key => $product) {
            $data['cantidadCompra' . ($key+1)] = round($product['quantity'], 2);
            $data['precioCompra' . ($key+1)]   = $product['price'];
            $data['descCompra' . ($key+1)]     = $product['description'];
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