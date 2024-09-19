<?php

namespace Omnipay\AcceptBlue\Message;

use Omnipay\AcceptBlue\Traits\Level3Data;

class ChargeStoredCardRequest extends AbstractRequest
{

    protected $urlSegment = 'transactions/charge';

    public function getData()
    {
        $this->validate('amount', 'transactionId');

        $data = [];

        $data['source'] = $this->getTransactionId();
        $data['amount'] = $this->getAmount() + 0;


        $billingInfo = [];
        if ($this->getFirstName()) {
            $billingInfo['first_name'] = $this->getFirstName();
        }
        if ($this->getLastName()) {
            $billingInfo['last_name'] = $this->getLastName();
        }

        if ($this->getBillingAddress1()) {
            $billingInfo['street'] = $this->getBillingAddress1();
        }

        if ($this->getBillingAddress2()) {
            $billingInfo['street2'] = $this->getBillingAddress2();
        }

        if ($this->getCity()) {
            $billingInfo['city'] = $this->getCity();
        }
        if ($this->getState()) {
            $billingInfo['state'] = $this->getState();
        }
        if ($this->getBillingPostcode()) {
            $billingInfo['zip'] = $this->getBillingPostcode();
        }

        if (count($billingInfo)) {
            $data['billing_info'] = $billingInfo;
        }

        if ($this->getEmail()) {
            $data['customer'] = [
                'email' => $this->getEmail()
            ];
        }

        $data = array_merge($data, $this->getBillingData());
        
        return $data;
    }

    //Setters & Getters are required because of Helper::initialize
    public function getFirstName()
    {
        return $this->getParameter('billingFirstName');
    }

    public function setFirstName($value)
    {
        return $this->setParameter('billingFirstName', $value);
    }

    public function getLastName()
    {
        return $this->getParameter('billingLastName');
    }

    public function setLastName($value)
    {
        return $this->setParameter('billingLastName', $value);
    }

    public function getBillingAddress1()
    {
        return $this->getParameter('billingAddress1');
    }

    public function setBillingAddress1($value)
    {
        return $this->setParameter('billingAddress1', $value);
    }

    public function getBillingAddress2()
    {
        return $this->getParameter('billingAddress2');
    }

    public function setBillingAddress2($value)
    {
        return $this->setParameter('billingAddress2', $value);
    }

    public function getCity()
    {
        return $this->getParameter('billingCity');
    }

    public function setCity($value)
    {
        return $this->setParameter('billingCity', $value);
    }

    public function getState()
    {
        return $this->getParameter('billingState');
    }

    public function setState($value)
    {
        return $this->setParameter('billingState', $value);
    }

    public function getBillingPostcode()
    {
        return $this->getParameter('billingPostcode');
    }

    public function setBillingPostcode($value)
    {

        return $this->setParameter('billingPostcode', $value);
    }

    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }

    public function getDescription()
    {
        return $this->getParameter('description');
    }

    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }
}
