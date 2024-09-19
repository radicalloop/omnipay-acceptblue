<?php

namespace Omnipay\AcceptBlue\Message;

use Omnipay\Common\CreditCard;

class CreditRequest extends AbstractRequest
{
    protected $urlSegment = 'transactions/credit';

    public function getData()
    {
        $data = [];
        if ($this->getParameter('transactionId')) {
            $this->validate('amount', 'transactionId');
            $data['source'] = $this->getParameter('transactionId');
        } elseif ($this->getCard() instanceof CreditCard) {
            $this->validate('amount', 'card');
            $this->getCard()->validate();
            $data['card'] = $this->getCard()->getNumber();
            $data['expiry_month'] = (int) $this->getCard()->getExpiryMonth();
            $data['expiry_year'] = (int) $this->getCard()->getExpiryYear();
            if ($this->getCard()->getCvv()) {
                $data['cvv2'] = $this->getCard()->getCvv();
            }
        }
        $data['amount'] = $this->getAmount() + 0;
        return $data;
    }
}
