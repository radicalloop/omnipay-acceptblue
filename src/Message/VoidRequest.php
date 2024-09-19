<?php
namespace Omnipay\AcceptBlue\Message;

class VoidRequest extends AbstractRequest
{
    protected $urlSegment = 'transactions/void';

    public function getData()
    {
        $this->validate('transactionId');
        $data['reference_number'] = $this->getTransactionId();
        return $data;
    }
}
