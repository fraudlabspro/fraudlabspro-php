<?php

namespace FraudLabsPro;

/**
 * FraudLabsPro Order module.
 * Validates order for possible fraud and feedback user decision.
 */
class Order
{
	/**
	 * Order statuses.
	 *
	 * @const string
	 */
	const APPROVE = 'APPROVE';
	const REJECT = 'REJECT';
	const REJECT_BLACKLIST = 'REJECT_BLACKLIST';

	/**
	 * Payment methods.
	 *
	 * @const string
	 */
	const CREDIT_CARD = 'CREDITCARD';
	const PAYPAL = 'PAYPAL';
	const GOOGLE_CHECKOUT = 'GOOGLECHECKOUT';
	const CASH_ON_DELIVERY = 'COD';
	const MONEY_ORDER = 'MONEYORDER';
	const WIRE_TRANSFER = 'WIRED';
	const BANK_DEPOSIT = 'BANKDEPOSIT';
	const BITCOIN = 'BITCOIN';
	const OTHERS = 'OTHERS';

	/**
	 * ID types.
	 *
	 * @const string
	 */
	const FLP_ID = 'fraudlabspro_id';
	const ORDER_ID = 'user_order_id';

	/**
	 * Validate order for possible fraud.
	 *
	 * @param array $params parameters of order details
	 *
	 * @return object fraudLabs Pro result in JSON object
	 */
	public static function validate($params = [])
	{
		$queries = [
			'key'            => Configuration::apiKey(),
			'format'         => 'json',
			'source'         => 'FraudLabsPro PHP SDK',
			'source_version' => FraudLabsPro::VERSION,
			'session_id'     => session_id(),
			'flp_check_sum'  => (isset($_COOKIE['flp_checksum'])) ? $_COOKIE['flp_checksum'] : '',

			// Billing information
			'ip'            => (isset($params['ip'])) ? $params['ip'] : self::getClientIp(),
			'first_name'    => (isset($params['billing']['firstName'])) ? $params['billing']['firstName'] : '',
			'last_name'     => (isset($params['billing']['lastName'])) ? $params['billing']['lastName'] : '',
			'username_hash' => (isset($params['billing']['username'])) ? self::doHash($params['billing']['username']) : '',
			'password_hash' => (isset($params['billing']['password'])) ? self::doHash($params['billing']['password']) : '',
			'email'         => (isset($params['billing']['email'])) ? $params['billing']['email'] : '',
			'email_domain'  => (isset($params['billing']['email'])) ? substr($params['billing']['email'], strpos($params['billing']['email'], '@') + 1) : '',
			'email_hash'    => (isset($params['billing']['email'])) ? self::doHash($params['billing']['email']) : '',
			'user_phone'    => (isset($params['billing']['phone'])) ? preg_replace('/\D/', '', $params['billing']['phone']) : '',
			'bill_addr'     => (isset($params['billing']['address'])) ? $params['billing']['address'] : '',
			'bill_city'     => (isset($params['billing']['city'])) ? $params['billing']['city'] : '',
			'bill_state'    => (isset($params['billing']['state'])) ? $params['billing']['state'] : '',
			'bill_zip_code' => (isset($params['billing']['postcode'])) ? $params['billing']['postcode'] : '',
			'bill_country'  => (isset($params['billing']['country'])) ? $params['billing']['country'] : '',

			// Order information
			'user_order_id'   => (isset($params['order']['orderId'])) ? $params['order']['orderId'] : '',
			'user_order_memo' => (isset($params['order']['note'])) ? $params['order']['note'] : '',
			'amount'          => (isset($params['order']['amount'])) ? number_format($params['order']['amount'], 2, '.', '') : 0,
			'quantity'        => (isset($params['order']['quantity'])) ? $params['order']['quantity'] : 1,
			'currency'        => (isset($params['order']['currency'])) ? $params['order']['currency'] : 'USD',
			'department'      => (isset($params['order']['department'])) ? $params['order']['department'] : '',
			'payment_mode'    => (isset($params['order']['paymentMethod'])) ? $params['order']['paymentMethod'] : '',

			// Credit card information
			'bin_no'     => (isset($params['card']['number'])) ? substr($params['card']['number'], 0, 6) : '',
			'card_hash'  => (isset($params['card']['number'])) ? self::doHash($params['card']['number']) : '',
			'avs_result' => (isset($params['card']['avs'])) ? self::doHash($params['card']['avs']) : '',
			'cvv_result' => (isset($params['card']['cvv'])) ? self::doHash($params['card']['cvv']) : '',

			// Shipping information
			'ship_addr'     => (isset($params['shipping']['address'])) ? $params['shipping']['address'] : '',
			'ship_city'     => (isset($params['shipping']['city'])) ? $params['shipping']['city'] : '',
			'ship_state'    => (isset($params['shipping']['state'])) ? $params['shipping']['state'] : '',
			'ship_zip_code' => (isset($params['shipping']['postcode'])) ? $params['shipping']['postcode'] : '',
			'ship_country'  => (isset($params['shipping']['country'])) ? $params['shipping']['country'] : '',
		];

		$response = Http::post('https://api.fraudlabspro.com/v1/order/screen', $queries);

		if (($json = json_decode($response)) === null) {
			return false;
		}

		return $json;
	}

	/**
	 * Sends decision back to FraudLabs Pro.
	 *
	 * @param array $params parameters of order details
	 *
	 * @return object fraudLabs Pro result in JSON object
	 */
	public static function feedback($params = [])
	{
		$validStatuses = [
			self::APPROVE, self::REJECT, self::REJECT_BLACKLIST,
		];

		$status = (isset($params['status'])) ? $params['status'] : '';

		if (!in_array($status, $validStatuses)) {
			throw new \RuntimeException('Invalid order status provided');
		}

		$queries = [
			'key'            => Configuration::apiKey(),
			'format'         => 'json',
			'source'         => 'FraudLabsPro PHP SDK',
			'source_version' => FraudLabsPro::VERSION,
			'id'             => (isset($params['id'])) ? $params['id'] : '',
			'action'         => $status,
			'note'           => (isset($params['note'])) ? $params['note'] : '',
		];

		$response = Http::post('https://api.fraudlabspro.com/v1/order/feedback', $queries);

		if (($json = json_decode($response)) === null) {
			return false;
		}

		return $json;
	}

	/**
	 * Gets transaction result.
	 *
	 * @param string $id
	 * @param string $type
	 *
	 * @return object fraudLabs Pro result in JSON object
	 */
	private static function getTransaction($id, $type = 'fraudlabspro_id')
	{
		if (empty($id)) {
			throw new \RuntimeException('Invalid transaction ID');
		}

		$queries = [
			'key'     => Configuration::apiKey(),
			'format'  => 'json',
			'id'      => $id,
			'id_type' => ($type == self::FLP_ID) ? self::FLP_ID : self::ORDER_ID,
		];

		$response = Http::get('https://api.fraudlabspro.com/v1/order/result?' . http_build_query($queries));

		if (($json = json_decode($response)) === null) {
			return false;
		}

		return $json;
	}

	/**
	 * Gets client IP address.
	 *
	 * @return string IP address
	 */
	private static function getClientIp()
	{
		// If website is hosted behind CloudFlare protection.
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		}

		// Some load balancer using this header.
		if (isset($_SERVER['X-Real-IP']) && filter_var($_SERVER['X-Real-IP'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
			return $_SERVER['X-Real-IP'];
		}

		// Common header when web server is running behind a reversed proxy server.
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = trim(current(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));

			if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
				return $ip;
			}
		}

		return $_SERVER['REMOTE_ADDR'];
	}

	/**
	 * Hashes a string to protect its real value.
	 *
	 * @param mixed $value
	 * @param mixed $prefix
	 *
	 * @return string hashed string
	 */
	private static function doHash($value, $prefix = 'fraudlabspro_')
	{
		$hash = $prefix . $value;

		for ($i = 0; $i < 65536; ++$i) {
			$hash = sha1($prefix . $hash);
		}

		return $hash;
	}
}

class_alias('FraudLabsPro\Order', 'FraudLabsPro_Order');
