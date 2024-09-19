<?php

namespace Omnipay\AcceptBlue\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    public $responseString;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = json_decode($data, true);

        if (! in_array($this->getCode(), ['A', 'P', 'D', 'E'])) {
            throw new InvalidResponseException($data);
        }
        $this->responseString = $data;
    }

    public function isSuccessful()
    {
        return $this->getCode() === 'A';
    }

    public function getTransactionReference()
    {
        if (isset($this->data['reference_number'])) {
            return $this->data['reference_number'];
        }
        return null;
    }

    public function getTransactionId()
    {
        return $this->getTransactionReference();
    }

    public function getInvoiceNumber()
    {
        if (isset($this->data['transaction']['transaction_details']['invoice_number'])) {
            return $this->data['transaction']['transaction_details']['invoice_number'];
        }
        return null;
    }

    public function getCode()
    {
        if (isset($this->data['status_code'])) {
            return $this->data['status_code'];
        }
        return null;
    }

    public function getError()
    {
        if (isset($this->data['error_message'])) {
            return $this->data['error_message'];
        }
        return null;
    }

    public function getStatus()
    {
        if (isset($this->data['status'])) {
            return $this->data['status'];
        }
        return null;
    }

    public function getMessage()
    {
        return $this->isSuccessful() ? $this->getStatus() : $this->getError();
    }
}
