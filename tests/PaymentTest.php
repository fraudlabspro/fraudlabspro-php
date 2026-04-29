<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
	public function testFeedback() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabsproPayment = new \FraudLabsPro\Payment($config);
		$result = $fraudlabsproPayment->feedback([
			'email'   => '',
			'status'  => 'declined',
			'message' => 'Call Issuer. Pick Up Card. (2047)',
		]);

		if ($GLOBALS['testApiKey'] == 'YOUR_API_KEY') {
			$this->assertEquals(
				'INVALID API KEY',
				$result->error->error_message,
			);
		} else {
			$this->assertEquals(
				'INVALID EMAIL ADDRESS',
				$result->error->error_message,
			);
		}
	}
}