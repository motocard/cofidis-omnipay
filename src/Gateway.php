<?php
namespace Omnipay\Cofidis;
use Symfony\Component\HttpFoundation\Request;
use Omnipay\Common\AbstractGateway;

/**
 * Cofidis Gateway
 *
 * @author Carlos Mendieta <carlos.mendieta@sddbrandcare.com>
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Cofidis';
    }

    public function getDefaultParameters()
    {
        return array(
            'deferral'     => '0',
            'documentType' => '1', // 1: Nif, 2: Residence Card  , 3: Passport
            'testMode'     => false
        );
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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cofidis\Message\PurchaseRequest', $parameters);
    }

    public function checkCallbackResponse(Request $request)
    {
        $response = new CallbackResponse($request, $this->getParameter('merchantKey'));
        return $response->isSuccessful();
    }
}