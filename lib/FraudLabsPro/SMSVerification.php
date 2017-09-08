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
	 * @access public
	 * @param array $params Parameters of sms details.
	 * @return object FraudLabs Pro result in JSON object.
	 */
	public static function sendsms($params = [])
	{
		if (isset($params['tel'])) {
			if (strpos($params[ 'tel' ], '+') !== 0 )
				$params[ 'tel' ] = '+' . $params[ 'tel' ];
		}

		$queries = [
			'key'				=> Configuration::apiKey(),
			'format'			=> 'json',
			'tel'				=> (isset($params['tel'])) ? $params['tel'] : '',
			'mesg'				=> (isset($params['mesg'])) ? $params['mesg'] : '',
			'country_code'		=> (isset($params['country_code'])) ? $params['country_code'] : '',
		];

		$response = Http::get('https://api.fraudlabspro.com/v1/verification/send?' . http_build_query($queries));

		if (is_null($json = json_decode($response))) {
			return FALSE;
		}

		return $json;
	}

	/**
	 * Get Verification result.
	 * @access public
	 * @param array $params Parameters of sms details.
	 * @return object FraudLabs Pro result in JSON object.
	 */
	public static function verifysms($params = [])
	{
		$queries = [
			'key'				=> Configuration::apiKey(),
			'format'			=> 'json',
			'tran_id'			=> (isset($params['tran_id'])) ? $params['tran_id'] : '',
			'otp'				=> (isset($params['otp'])) ? $params['otp'] : '',
		];

		$response = Http::get('https://api.fraudlabspro.com/v1/verification/result?' . http_build_query($queries));

		if (is_null($json = json_decode($response))) {
			return FALSE;
		}

		return $json;
	}
}

class_alias('FraudLabsPro\SMSVerification', 'FraudLabsPro_SMSVerification');
