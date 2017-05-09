<?php
/* Copyright (C) 2013-2017 FraudLabsPro.com
 * All Rights Reserved
 *
 * This library is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; If not, see <http://www.gnu.org/licenses/>.
 *
 * Purpose: Class to implement fraud checking solution using FraudLabs Pro service.
 * 	        API Key required, and if you do not have an API key, you may sign up free
 * 			at http://www.fraudlabspro.com
 */

class FraudLabsPro {
	private $apiKey;

	// Constructor
	public function __construct($apiKey = ''){
		// Validate API Key
		if(!preg_match('/^[A-Z0-9]{32}$/', $apiKey))
			throw new exception('FraudLabsPro: INVALID API KEY');

		$this->apiKey = $apiKey;
	}

	// Core function for order validation
	public function validate($params = []){
		$queries = [
			'key'				=> $this->apiKey,
			'format'			=> 'json',
			'source'			=> 'FraudLabsPro PHP SDK',
			'source_version'	=> '2.0.0',
			'session_id'		=> session_id(),
			'flp_check_sum'		=> (isset($_COOKIE['flp_checksum'])) ? $_COOKIE['flp_checksum'] : '',

			// Billing information
			'ip'				=> (isset($params['ip'])) ? $params['ip'] : $_SERVER['REMOTE_ADDR'],
			'first_name'		=> (isset($params['billing']['firstName'])) ? $params['billing']['firstName'] : '',
			'last_name'			=> (isset($params['billing']['lastName'])) ? $params['billing']['lastName'] : '',
			'username_hash'		=> (isset($params['billing']['username'])) ? $this->doHash($params['billing']['username']) : '',
			'password_hash'		=> (isset($params['billing']['password'])) ? $this->doHash($params['billing']['password']) : '',
			'email'				=> (isset($params['billing']['email'])) ? $params['billing']['email'] : '',
			'emailDomain'		=> (isset($params['billing']['email'])) ? substr($params['billing']['email'], strpos($params['billing']['email'], '@') + 1) : '',
			'emailHash'			=> (isset($params['billing']['email'])) ? $this->doHash($params['billing']['email']) : '',
			'phone'				=> (isset($params['billing']['phone'])) ? preg_replace('/\D/', '', $params['billing']['phone']) : '',
			'bill_addr'			=> (isset($params['billing']['address'])) ? $params['billing']['address'] : '',
			'bill_city'			=> (isset($params['billing']['city'])) ? $params['billing']['city'] : '',
			'bill_state'		=> (isset($params['billing']['state'])) ? $params['billing']['state'] : '',
			'bill_zip_code'		=> (isset($params['billing']['postcode'])) ? $params['billing']['postcode'] : '',
			'bill_country'		=> (isset($params['billing']['country'])) ? $params['billing']['country'] : '',

			// Order information
			'user_order_id'		=> (isset($params['order']['orderId'])) ? $params['order']['orderId'] : '',
			'user_order_memo'	=> (isset($params['order']['note'])) ? $params['order']['note'] : '',
			'amount'			=> (isset($params['order']['amount'])) ? number_format($params['order']['amount'], 2, '', '.') : '',
			'quantity'			=> (isset($params['order']['quantity'])) ? $params['order']['quantity'] : 1,
			'currency'			=> (isset($params['order']['currency'])) ? $params['order']['currency'] : 'USD',
			'department'		=> (isset($params['order']['department'])) ? $params['order']['department'] : '',
			'payment_mode'		=> (isset($params['order']['paymentMethod'])) ? $params['order']['paymentMethod'] : '',

			// Credit card information
			'bin_no'			=> (isset($params['card']['number'])) ? substr($params['card']['number'], 0, 6) : '',
			'card_hash'			=> (isset($params['card']['number'])) ? $this->doHash($params['card']['number']) : '',
			'avs_result'		=> (isset($params['card']['avs'])) ? $this->doHash($params['card']['avs']) : '',
			'cvv_result'		=> (isset($params['card']['cvv'])) ? $this->doHash($params['card']['cvv']) : '',

			// Shipping information
			'ship_addr'			=> (isset($params['shipping']['address'])) ? $params['shipping']['address'] : '',
			'ship_city'			=> (isset($params['shipping']['city'])) ? $params['shipping']['city'] : '',
			'ship_state'		=> (isset($params['shipping']['state'])) ? $params['shipping']['state'] : '',
			'ship_zip_code'		=> (isset($params['shipping']['postcode'])) ? $params['shipping']['postcode'] : '',
			'ship_country'		=> (isset($params['shipping']['country'])) ? $params['shipping']['country'] : '',
		];

		$response = $this->http('https://api.fraudlabspro.com/v1/order/screen?' . http_build_query($queries));

		if(is_null($json = json_decode($response)))
			return FALSE;

		return $json;
	}

	// Feedback status to FraudLabs Pro API
	public function feedback($id, $status, $note = ''){
		switch($status){
			case 'APPROVE':
			case 'IGNORE':
			case 'REJECT':
			case 'REJECT_BLACKLIST':
				break;

			default:
				throw new exception('FraudLabsPro: INVALID FEEDBACK STATUS');
		}

		$queries = [
			'key'		=> $this->apiKey,
			'format'	=> 'json',
			'id'		=> $id,
			'action'	=> $status,
			'note'		=> $note,
		];

		$response = $this->http('https://api.fraudlabspro.com/v1/order/feedback?' . http_build_query($queries));

		if(is_null($json = json_decode($response)))
			return FALSE;

		return $json;
	}

	// Do the hashing. This applies to several params, i.e, email, username, password and credit card number
	private function doHash($s, $prefix='fraudlabspro_'){
		$hash = $prefix . $s;

		for($i = 0; $i < 65536; $i++)
			$hash = sha1($prefix . $hash);

		return $hash;
	}

	// Perform the HTTP query
	private function http($url){
		if(!function_exists('curl_init'))
			throw new exception('FraudLabsPro: cURL extension is not enabled.');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_USERAGENT, 'FRAUDLABSPRO API CLIENT 2.0.0');

		$response = curl_exec($ch);

		if(empty($response) || curl_error($ch) || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200){
			curl_close($ch);
			return FALSE;
		}

		curl_close($ch);

		return $response;
	}
}
