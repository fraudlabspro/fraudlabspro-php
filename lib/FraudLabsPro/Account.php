<?php
namespace FraudLabsPro;

/**
 * FraudLabsPro Account module.
 * Creates account and subscribes plan.
 */
class Account
{
	/**
	 * Industry type IDs.
	 * @const number
	 */
	const RETAIL_E_COMMERCE				= 1;
	const RETAIL_BRICK_AND_MORTAR		= 2;
	const HOSPITALITY_AND_ACCOMMODATION	= 3;
	const TICKETING_AND_EVENTS			= 4;
	const CLUBS_AND_BUYING_GROUPS		= 5;
	const MEMBERSHIPS_AND_SUBSCRIPTIONS	= 6;
	const DIGITAL_CONTENT				= 7;
	const ONLINE_GAMES					= 8;
	const SOFTWARE						= 9;
	const TELEPHONE_SERVICES			= 10;
	const TRAVEL						= 11;
	const NON_PROFIT_AND_CHARITY		= 12;
	const SERVICES						= 13;
	const HIGH_RISK_MERCHANTS			= 14;

	/**
	 * FraudLabs Pro plans.
	 * @const string
	 */
	const MICRO_PLAN = 'MICRO';
	const MINI_PLAN = 'MINI';
	const SMALL_PLAN = 'SMALL';
	const MEDIUM_PLAN = 'MEDIUM';
	const LARGE_PLAN = 'LARGE';

	/**
	 * Creates user account.
	 * @access public
	 * @param array $params Parameters of user details.
     * @return object FraudLabs Pro result in JSON object.
	 */
	public static function create($params = [])
	{
		$queries = [
			'key'				=> Configuration::resellerKey(),
			'format'			=> 'json',
			'source'			=> 'FraudLabsPro PHP SDK',
			'source_version'	=> FraudLabsPro::VERSION,

			'username'			=> (isset($params['username'])) ? $params['username'] : '',
			'email'				=> (isset($params['email'])) ? $params['email'] : '',
			'name'				=> (isset($params['name'])) ? $params['name'] : '',
			'address1'			=> (isset($params['address1'])) ? $params['address1'] : '',
			'address2'			=> (isset($params['address2'])) ? $params['address2'] : '',
			'city'				=> (isset($params['city'])) ? $params['city'] : '',
			'state'				=> (isset($params['state'])) ? $params['state'] : '',
			'zip_code'			=> (isset($params['postcode'])) ? $params['postcode'] : '',
			'country'			=> (isset($params['country'])) ? $params['country'] : '',
			'phone'				=> (isset($params['phone'])) ? preg_replace('/\D/', '', $params['phone']) : '',
			'fax'				=> (isset($params['fax'])) ? preg_replace('/\D/', '', $params['fax']) : '',
			'company'			=> (isset($params['company'])) ? $params['company'] : '',
			'industry'			=> (isset($params['industry'])) ? $params['industry'] : '',
			'integration'		=> (isset($params['integration'])) ? $params['integration'] : '',
		];

		$response = Http::get('https://api.fraudlabspro.com/v1/account/create?' . http_build_query($queries));

		if (is_null($json = json_decode($response))) {
			return FALSE;
		}

		return $json;
	}

	/**
	 * Subscribes existing user to a plan.
	 * @access public
	 * @param array $params Parameters of plan details.
     * @return object FraudLabs Pro result in JSON object.
	 */
	public static function subscribe($params = [])
	{
		$queries = [
			'key'				=> Configuration::resellerKey(),
			'format'			=> 'json',
			'source'			=> 'FraudLabsPro PHP SDK',
			'source_version'	=> Configuration::VERSION,

			'username'			=> (isset($params['username'])) ? $params['username'] : '',
			'plan'				=> (isset($params['plan'])) ? $params['plan'] : '',
		];

		$validPlans = [
			self::MICRO_PLAN, self::MINI_PLAN, self::SMALL_PLAN, self::MEDIUM_PLAN, self::LARGE_PLAN
		];

		if (!in_array($queries['plan'], $validPlans)) {
			throw new \RuntimeException('Invalid plan provided');
		}

		$response = Http::get('https://api.fraudlabspro.com/v1/plan/subscribe?' . http_build_query($queries));

		if (is_null($json = json_decode($response))) {
			return FALSE;
		}

		return $json;
	}
}

class_alias('FraudLabsPro\Account', 'FraudLabsPro_Account');
