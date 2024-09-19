<?php

namespace Omnipay\AcceptBlue\Message;

class AuthorizeRequest extends AbstractRequest
{

    protected $urlSegment = 'transactions/verify';


    public function getData()
    {
        $this->validate('card');
        $this->getCard()->validate();

        $data['card'] = $this->getCard()->getNumber();
        $data['expiry_month'] = $this->getCard()->getExpiryMonth();
        $data['expiry_year'] = $this->getCard()->getExpiryYear();
        if ($this->getCard()->getCvv()) {
            $data['cvv2'] = $this->getCard()->getCvv();
        }
        return $data;
    }
}
