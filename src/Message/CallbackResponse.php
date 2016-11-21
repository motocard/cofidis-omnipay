<?php

namespace Omnipay\Cofidis\Message;

use Symfony\Component\HttpFoundation\Request;

/**
 * Cofidis Callback Response
 *
 * @author Carlos Mendieta <carlos.mendieta@sddbrandcare.com>
 */
class CallbackResponse
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Check callback response from cofidis
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return (bool)$this->request->get('accept');
    }

    /**
     * Get the response status as string
     *
     * @return bool|string
     */
    public function getResponseStatus()
    {
        switch ($this->request->get('accept')) {
            case '0':
                return 'rejected';
            case '1':
                return 'accepted';
            case '2':
                return 'ASNEF_pending';
        }
        return 'unknown';
    }
}
