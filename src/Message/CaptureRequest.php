<?php

namespace Omnipay\AcceptBlue\Message;

use Omnipay\AcceptBlue\Traits\Level3Data;


class CaptureRequest extends AbstractRequest
{

    protected $urlSegment = 'transactions/charge';

    public function getData()
    {
        $this->validate('transactionId', 'amount');

        $data = [];
        $data['source'] = $this->getTransactionId();
        $data['amount'] = $this->getAmount() + 0;

        $data = array_merge($data, $this->getBillingData());


        return $data;
    }
}
