<?php

namespace Tests\Feature;

use Omnipay\Omnipay;

class AuthorizeAndCaptureTest extends \PHPUnit\Framework\TestCase
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

    /**
     * Tests an actual AUTHORIZE transaction and sets the returned transactionId.
     *
     */
    public function testAuthorize()
    {
        $request = $this->gateway->authorize([
            'card' => [
                'number' => '5137221111116668',
                'expiryMonth' => 6,
                'expiryYear' => 2036,
                'cvv' => '123'
            ]
        ]);

        $response = $request->send();
        self::$transactionId = $response->getTransactionId();
        $this->assertTrue($response->isSuccessful());
    }

    /**
     * Tests that a previously generated transactionId can be "captured".
     *
     * @depends testAuthorize
     */
    public function testCapture()
    {
        $request = $this->gateway->capture([
            'transactionId' => 'ref-' . self::$transactionId,
            'amount' => 1000
        ]);

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
    }
}
