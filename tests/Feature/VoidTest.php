<?php

namespace Tests\Feature;

use Omnipay\Omnipay;

class VoidTest extends \PHPUnit\Framework\TestCase
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

    public function testPurchaseForVoid()
    {
        $request = $this->gateway->purchase([
            'amount' => 80,
            'card' => [
                'number' => '5137221111116668',
                'expiryMonth' => 6,
                'expiryYear' => 2036,
                'cvv' => '123'
            ]
        ]);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());

        $transactionId = $response->getTransactionReference();
        self::$transactionId = $transactionId;
    }

    /**
     * @depends testPurchaseForVoid
     */
    public function testVoidTransaction()
    {
        $request = $this->gateway->void([
            'transactionId' => self::$transactionId,
        ]);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }
}
