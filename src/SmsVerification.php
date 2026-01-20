<?php

namespace FraudLabsPro;

/**
 * FraudLabsPro SMS Verification module.
 * Send SMS Verification for authentication and get Verification result.
 */
class SmsVerification
{

	private $flpApiKey = '';

	public function __construct($config)
	{
		$this->flpApiKey = $config->apiKey;
	}

	/**
	 * Send SMS Verification for authentication.
	 *
	 * @param array $params parameters of sms details
	 *
	 * @return object fraudLabs Pro result in JSON object
	 */
	public function sendSms($params = [])
	{
		if ((isset($params['country_code'])) && (strlen($params['country_code']) != 2)) {
			throw new \RuntimeException('Invalid ISO3166 Country Code.');
		}
		if ((isset($params['otp_timeout'])) && (! is_int($params['otp_timeout']))) {
			throw new \RuntimeException('otp_timeout value must be integer.');
		}
		
		if (isset($params['tel'])) {
			if (strpos($params['tel'], '+') !== 0) {
				$params['tel'] = '+' . $params['tel'];
			}
		}

		$queries = [
			'key'            => $this->flpApiKey,
			'format'         => 'json',
			'source'         => Configuration::SOURCE,
			'source_version' => Configuration::VERSION,
			'tel'            => (isset($params['tel'])) ? $params['tel'] : '',
			'otp_timeout'    => (isset($params['otp_timeout'])) ? $params['otp_timeout'] : 3600,
			'mesg'           => (isset($params['mesg'])) ? $params['mesg'] : '',
			'country_code'   => (isset($params['country_code'])) ? $params['country_code'] : '',
			'source'         => (isset($params['source'])) ? $params['source'] : 'sdk-php',
		];

		$http = new Http();
		$response = $http->post('https://api.fraudlabspro.com/v2/verification/send', $queries);

		if (($json = json_decode($response)) === null) {
			return false;
		}

		return $json;
	}

	/**
	 * Get Verification result.
	 *
	 * @param array $params parameters of sms details
	 *
	 * @return object fraudLabs Pro result in JSON object
	 */
	public function verifyOtp($params = [])
	{
		$queries = [
			'key'            => $this->flpApiKey,
			'format'         => 'json',
			'source'         => Configuration::SOURCE,
			'source_version' => Configuration::VERSION,
			'tran_id'        => (isset($params['tran_id'])) ? $params['tran_id'] : '',
			'otp'            => (isset($params['otp'])) ? $params['otp'] : '',
		];

		$http = new Http();
		$response = $http->get('https://api.fraudlabspro.com/v2/verification/result?' . http_build_query($queries));

		if (($json = json_decode($response)) === null) {
			return false;
		}

		return $json;
	}
}

class_alias('FraudLabsPro\SmsVerification', 'FraudLabsPro_SmsVerification');
