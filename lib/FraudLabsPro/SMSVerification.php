<?php

namespace FraudLabsPro;

/**
 * FraudLabsPro SMS Verification module.
 * Send SMS Verification for authentication and get Verification result.
 */
class SMSVerification
{
	/**
	 * Send SMS Verification for authentication.
	 *
	 * @param array $params parameters of sms details
	 *
	 * @return object fraudLabs Pro result in JSON object
	 */
	public static function sendsms($params = [])
	{
		if (isset($params['tel'])) {
			if (strpos($params['tel'], '+') !== 0) {
				$params['tel'] = '+' . $params['tel'];
			}
		}

		$queries = [
			'key'          => Configuration::apiKey(),
			'format'       => 'json',
			'tel'          => (isset($params['tel'])) ? $params['tel'] : '',
			'otp_timeout'  => (isset($params['otp_timeout'])) ? $params['otp_timeout'] : 3600,
			'mesg'         => (isset($params['mesg'])) ? $params['mesg'] : '',
			'country_code' => (isset($params['country_code'])) ? $params['country_code'] : '',
		];

		$response = Http::post('https://api.fraudlabspro.com/v1/verification/send', $queries);

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
	public static function verifysms($params = [])
	{
		$queries = [
			'key'     => Configuration::apiKey(),
			'format'  => 'json',
			'tran_id' => (isset($params['tran_id'])) ? $params['tran_id'] : '',
			'otp'     => (isset($params['otp'])) ? $params['otp'] : '',
		];

		$response = Http::post('https://api.fraudlabspro.com/v1/verification/result', $queries);

		if (($json = json_decode($response)) === null) {
			return false;
		}

		return $json;
	}
}

class_alias('FraudLabsPro\SMSVerification', 'FraudLabsPro_SMSVerification');
