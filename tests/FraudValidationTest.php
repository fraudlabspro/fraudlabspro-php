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

	public function testValidateOrder() {
		$config = new FraudLabsPro\Configuration($GLOBALS['testApiKey']);
		$fraudlabspro = new FraudLabsPro\FraudValidation($config);
		$result = $fraudlabspro->validate([
			'ip'		=> '8.8.8.8',
		]);

		$this->assertEquals(
			'US',
			$result->ip_country,
		);
	}
}