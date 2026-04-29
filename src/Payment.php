<?php

namespace FraudLabsPro;

/**
 * FraudLabsPro Payment module.
 */
class Payment
{

	private $flpApiKey = '';

	public function __construct($config)
	{
		$this->flpApiKey = $config->apiKey;
	}

	/**
	 * Report the final payment status back to the system, helping improve fraud detection and risk assessment.
	 *
	 * @param array $params parameters of payment details
	 *
	 * @return object fraudLabs Pro result in JSON object
	 */
	public function feedback($params = [])
	{
		$queries = [
			'key'             => $this->flpApiKey,
			'format'          => 'json',
			'source'          => Configuration::SOURCE,
			'source_version'  => Configuration::VERSION,
			'email'           => ($params['email']) ?? '',
			'status'          => ($params['status']) ?? '',
			'message'         => ($params['message']) ?? '',
			'fraudlabspro_id' => ($params['fraudlabspro_id']) ?? '',
		];

		$http = new Http();
		$response = $http->post('https://api.fraudlabspro.com/v2/payment/feedback', $queries);

		if (($json = json_decode($response)) === null) {
			return false;
		}

		return $json;
	}
}

class_alias('FraudLabsPro\Payment', 'FraudLabsPro_Payment');
