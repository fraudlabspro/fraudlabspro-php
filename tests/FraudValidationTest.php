<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class FraudValidationTest extends TestCase
{
	public function testInvalidApiKey() {
		$config = new FraudLabsPro\Configuration('');
		$fraudlabspro = new FraudLabsPro\FraudValidation($config);
		$result = $fraudlabspro->validate([
			'ip'		=> '8.8.8.8',
		]);

		$this->assertEquals(
			'INVALID API KEY',
			$result->error->error_message,
		);
	}

	public function testApiKeyExist() {
		if ($GLOBALS['testApiKey'] == 'YOUR_API_KEY') {
			echo "/*
* You could enter a FraudLabs Pro API Key in tests/bootstrap.php
* for real web service calling test.
* 
* You could sign up for a free API key at https://www.fraudlabspro.com/pricing
* if you do not have one.
*/";
			$this->assertEquals(
				'YOUR_API_KEY',
				$GLOBALS['testApiKey'],
			);
		} else {
			$this->assertNotEquals(
				'YOUR_API_KEY',
				$GLOBALS['testApiKey'],
			);
		}
	}

	public function testValidateOrder() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabspro = new FraudLabsPro\FraudValidation($config);
		$result = $fraudlabspro->validate([
			'ip'		=> '8.8.8.8',
		]);

		if ($GLOBALS['testApiKey'] == 'YOUR_API_KEY') {
			$this->assertEquals(
				'NA',
				$result->fraudlabspro_id,
			);
		} else {
			$this->assertEquals(
				'US',
				$result->ip_geolocation->country_code,
			);
		}
	}

	public function testGetTransaction() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabspro = new FraudLabsPro\FraudValidation($config);
		$result = $fraudlabspro->getTransaction('20170906MXFHSTRF', FraudLabsPro\FraudValidation::FLP_ID);

		$this->assertEquals(
			null,
			$result->fraudlabspro_id,
		);
	}

	public function testFeedback() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabspro = new FraudLabsPro\FraudValidation($config);
		$result = $fraudlabspro->feedback([
			'id'		=> '20170906MXFHSTRF',
			'status'	=> FraudLabsPro\FraudValidation::APPROVE,
			'note'		=> 'This customer made a valid purchase before.',
		]);

		if ($GLOBALS['testApiKey'] == 'YOUR_API_KEY') {
			$this->assertEquals(
				'INVALID API KEY',
				$result->error->error_message,
			);
		} else {
			$this->assertEquals(
				'INVALID TRANSACTION ID',
				$result->error->error_message,
			);
		}
	}
}