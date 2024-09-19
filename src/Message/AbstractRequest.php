<?php

namespace Omnipay\AcceptBlue\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://api.accept.blue/api/v2/';
    protected $sandboxEndpoint = 'https://api.sandbox.accept.blue/api/v2/';
    protected $urlSegment;
    protected $method = 'POST';
    protected $httpResponse;

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getSandbox()
    {
        return $this->getParameter('sandbox');
    }

    public function setSandbox($value)
    {
        return $this->setParameter('sandbox', $value);
    }

    public function getInvoiceNumber()
    {
        return $this->getParameter('invoiceNumber');
    }

    public function setInvoiceNumber($value)
    {
        return $this->setParameter('invoiceNumber', $value);
    }


    protected function getBillingData()
    {
        $data = [];
        if ($card = $this->getCard()) {
            $billingInfo = [];
            // customer billing details
            if ($card->getBillingFirstName()) {
                $billingInfo['first_name'] = $card->getBillingFirstName();
            }
            if ($card->getBillingLastName()) {
                $billingInfo['last_name'] = $card->getBillingLastName();
            }

            if ($card->getBillingAddress1()) {
                $billingInfo['street'] = $card->getBillingAddress1();
            }

            if ($card->getBillingAddress2()) {
                $billingInfo['street2'] = $card->getBillingAddress2();
            }

            if ($card->getBillingCity()) {
                $billingInfo['city'] = $card->getBillingCity();
            }
            if ($card->getBillingState()) {
                $billingInfo['state'] = $card->getBillingState();
            }
            if ($card->getBillingPostcode()) {
                $billingInfo['zip'] = $card->getBillingPostcode();
            }
            if ($card->getBillingCountry()) {
                $billingInfo['country'] = $card->getBillingCountry();
            }

            if (count($billingInfo)) {
                $data['billing_info'] = $billingInfo;
            }

            if ($card->getEmail()) {
                $data['customer'] = [
                    'email' => $card->getEmail()
                ];
            }
        }

        if ($this->getInvoiceNumber()) {
            $data['transaction_details'] = [
                'invoice_number' => $this->getInvoiceNumber()
            ];
        }

        return $data;
    }

    public function sendData($data)
    {
        $this->httpResponse = $this->httpClient->request($this->method, $this->getEndpoint() . $this->urlSegment, [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword()),
        ], json_encode($data));

        return $this->createResponse((string) $this->httpResponse->getBody());
    }


    protected function getEndpoint()
    {
        return $this->getSandbox() ? $this->sandboxEndpoint : $this->liveEndpoint;
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
