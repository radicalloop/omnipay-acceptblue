<?php

namespace Omnipay\AcceptBlue;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'AcceptBlue';
    }

    public function getDefaultParameters()
    {
        return [
            'username' => '',
            'password' => '',
            'sandbox' => true,
        ];
    }

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
    public function authorize(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\AcceptBlue\Message\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\AcceptBlue\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\AcceptBlue\Message\PurchaseRequest', $parameters);
    }

    public function void(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\AcceptBlue\Message\VoidRequest', $parameters);
    }

    public function credit(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\AcceptBlue\Message\CreditRequest', $parameters);
    }

    public function chargeStoredCard(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\AcceptBlue\Message\ChargeStoredCardRequest', $parameters);
    }

    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\AcceptBlue\Message\RefundRequest', $parameters);
    }

    public function createCard(array $parameters = [])
    {
        throw new \Exception('Not implemented');
    }

    public function removeAuthorizedTransaction(array $parameters = [])
    {
        throw new \Exception('Not implemented');
    }


    public function acceptNotification(array $parameters = [])
    {
        throw new \Exception('Not implemented');
    }

    public function completeAuthorize(array $parameters = [])
    {
        throw new \Exception('Not implemented');

    }

    public function completePurchase(array $parameters = [])
    {
        throw new \Exception('Not implemented');

    }

    public function fetchTransaction(array $parameters = [])
    {
        throw new \Exception('Not implemented');

    }

    public function updateCard(array $parameters = [])
    {
        throw new \Exception('Not implemented');

    }

    public function deleteCard(array $parameters = [])
    {
        throw new \Exception('Not implemented');

    }

}
