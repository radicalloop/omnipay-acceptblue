<?php

namespace Tests\Feature;

use Omnipay\Omnipay;

class ChargeStoredCardTest extends \PHPUnit\Framework\TestCase
{
    protected $gateway;
    public static $transactionId;


    protected function setUp(): void
    {
        $this->gateway = Omnipay::create('AcceptBlue');
        $this->gateway->initialize([
            'username' => getenv('ACCEPTBLUE_USERNAME'),
            'password' => getenv('ACCEPTBLUE_PASSWORD'),
            'sandbox' => getenv('ACCEPTBLUE_SANDBOX') === 'true',
        ]);
    }


    public function testPurchaseForStoredCard()
    {
        $request = $this->gateway->purchase([
            'amount' => 60,
            'card' => [
                'number' => '4761530001111118',
                'expiryMonth' => 6,
                'expiryYear' => 2036,
                'cvv' => '123'
            ]
        ]);
        $response =  $request->send();
        $this->assertTrue($response->isSuccessful());

        $transactionId = $response->getTransactionReference();
        self::$transactionId = $transactionId;

    }

   /**
     * Tests that a previously generated transactionId can be "captured".
     * @depends testPurchaseForStoredCard
     */
    public function testChargeStoredCard()
    {
        $request = $this->gateway->chargeStoredCard([
            'transactionId' => 'ref-' . self::$transactionId,
            'amount' => 88,
            'billingFirstName' => "Jane",
            'billingLastName' => "Doe",
            "billingAddress1" => "address 10",
            "billingAddress2" => "address 22",
            "billingCity" => "NewYork",
            "billingState" => "NY",
            "billingPostcode" => "121212",
            "email" => "janedoe@test.com"
        ]);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }
}
