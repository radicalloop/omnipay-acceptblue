<?php

namespace Tests\Feature;

use Omnipay\Omnipay;

class PurchaseTest extends \PHPUnit\Framework\TestCase
{
    protected $gateway;

    protected function setUp(): void
    {
        $this->gateway = Omnipay::create('AcceptBlue');
        $this->gateway->initialize([
            'username' => getenv('ACCEPTBLUE_USERNAME'),
            'password' => getenv('ACCEPTBLUE_PASSWORD'),
            'sandbox' => getenv('ACCEPTBLUE_SANDBOX') === 'true',
        ]);
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'amount' => 78,
            'card' => [
                'number' => '5137221111116668',
                'expiryMonth' => 6,
                'expiryYear' => 2036,
                'cvv' => '123',
                'billingFirstName' => "John",
                'billingLastName' => "Doe",
                "billingAddress1" => "address 1",
                "billingAddress2" => "address 2",
                "billingCity" => "New York",
                "billingState" => "NY",
                "billingPostcode" => "121212",
                "email" => "johndoe@test.com"
            ],
            'invoiceNumber' => "452627"
        ]);
        $response =  $request->send();
        $this->assertTrue($response->isSuccessful());
    }
}
