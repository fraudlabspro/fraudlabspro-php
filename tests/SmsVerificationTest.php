<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class SmsVerificationTest extends TestCase
{
	public function testSendSms() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabsproSms = new \FraudLabsPro\SmsVerification($config);
		$result = $fraudlabsproSms->sendSms([
			'tel'			=> '+1561628867',
			'mesg'			=> 'Hi, your OTP is <otp>.',
			'otp_timeout'	=> 3600,
			'country_code'	=> 'US',
		]);

		$this->assertEquals(
			'Invalid phone number.',
			$result->error,
		);
	}

	public function testVerifyOtp() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabsproSms = new \FraudLabsPro\SmsVerification($config);
		$result = $fraudlabsproSms->verifyOtp([
			'tran_id'		=> 'UNIQUE_TRANS_ID',
			'otp'			=> 'OTP_RECEIVED',
		]);

		$this->assertEquals(
			'Invalid OTP.',
			$result->error,
		);
	}
}