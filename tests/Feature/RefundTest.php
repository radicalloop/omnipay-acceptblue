<?php

namespace Tests\Feature;

use Omnipay\Omnipay;

class RefundTest extends \PHPUnit\Framework\TestCase
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


    public function testRefundToTransactionId()
    {
        $request = $this->gateway->refund([
            'amount' => 1,
            'transactionId' => intval(getenv('ACCEPTBLUE_SETTLED_TRANSACTION_ID'))
        ]);


        $response =  $request->send();
        $this->assertTrue($response->isSuccessful());
    }
}
