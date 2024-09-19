<?php

namespace Omnipay\AcceptBlue\Message;

class RefundRequest extends AbstractRequest
{
    protected $urlSegment = 'transactions/refund';

    public function getData()
    {
        $this->validate('amount', 'transactionId');
        $data = [];
        $data['reference_number'] = $this->getParameter('transactionId');
        $data['amount'] = $this->getAmount() + 0;
        return $data;
    }
}
