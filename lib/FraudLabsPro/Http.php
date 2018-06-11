<?php

namespace FraudLabsPro;

/**
 * FraudLabsPro HTTP Client
 * Sends Http requests using curl.
 *
 * @copyright  2018 FraudLabsPro.com
 */
class Http
{
	public static function get($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_USERAGENT, 'FraudLabsPro PHP SDK ' . FraudLabsPro::VERSION);

		$response = curl_exec($ch);

		if (empty($response) || curl_error($ch) || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
			curl_close($ch);

			return false;
		}

		curl_close($ch);

		return $response;
	}

	public static function post($url, $fields = [])
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_USERAGENT, 'FraudLabsPro PHP SDK ' . FraudLabsPro::VERSION);

		$queries = (!empty($fields)) ? http_build_query($fields) : '';

		if ($queries) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $queries);
		}

		$response = curl_exec($ch);

		if (empty($response) || curl_error($ch) || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
			curl_close($ch);

			return false;
		}

		curl_close($ch);

		return $response;
	}
}

class_alias('FraudLabsPro\Http', 'FraudLabsPro_Http');
