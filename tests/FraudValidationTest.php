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
			$result->fraudlabspro_message,
		);
	}

	public function testApiKeyExist() {
		if ($GLOBALS['testApiKey'] == 'YOUR_API_KEY') {
			trigger_error("Enter a valid FraudLabs Pro API Key in tests/bootstrap.php for real testing.", E_USER_NOTICE);
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
				$result->ip_country,
			);
		}
	}

	public function testGetTransaction() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabspro = new FraudLabsPro\FraudValidation($config);
		$result = $fraudlabspro->getTransaction('20170906MXFHSTRF', FraudLabsPro\FraudValidation::FLP_ID);

		$this->assertEquals(
			'NA',
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
				$result->fraudlabspro_message,
			);
		} else {
			$this->assertEquals(
				'INVALID TRANSACTION ID',
				$result->fraudlabspro_message,
			);
		}
	}
}