<?php

namespace Omnipay\AcceptBlue\Message;

class PurchaseRequest extends AbstractRequest
{
    protected $urlSegment = 'transactions/charge';

    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();

        $data['amount'] = $this->getAmount() + 0;
        $data['card'] = $this->getCard()->getNumber();
        $data['expiry_month'] = (int) $this->getCard()->getExpiryMonth();
        $data['expiry_year'] = (int) $this->getCard()->getExpiryYear();

        if ($this->getCard()->getCvv()) {
            $data['cvv2'] = $this->getCard()->getCvv();
        }

        $data = array_merge($data, $this->getBillingData());

        return $data;
    }
}
