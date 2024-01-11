<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class SmsVerificationTest extends TestCase
{
	public function testSendSms() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabsproSms = new \FraudLabsPro\SmsVerification($config);
		$result = $fraudlabsproSms->sendSms([
			'tel'			=> '+123456789',
			'mesg'			=> 'Hi, your OTP is <otp>.',
			'otp_timeout'	=> 3600,
			'country_code'	=> 'US',
		]);

		if ($GLOBALS['testApiKey'] == 'YOUR_API_KEY') {
			$this->assertEquals(
				'INVALID API KEY',
				$result->error->error_message,
			);
		} else {
			$this->assertEquals(
				'INVALID PHONE NUMBER',
				$result->error->error_message,
			);
		}
	}

	public function testVerifyOtp() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabsproSms = new \FraudLabsPro\SmsVerification($config);
		$result = $fraudlabsproSms->verifyOtp([
			'tran_id'		=> 'UNIQUE_TRANS_ID',
			'otp'			=> 'OTP_RECEIVED',
		]);

		if ($GLOBALS['testApiKey'] == 'YOUR_API_KEY') {
			$this->assertEquals(
				'INVALID API KEY',
				$result->error->error_message,
			);
		} else {
			$this->assertEquals(
				'INVALID OTP',
				$result->error->error_message,
			);
		}
	}
}