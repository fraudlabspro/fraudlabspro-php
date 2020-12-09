<?php
// Preset PHP settings
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/vendor/autoload.php';

// Configures FraudLabs Pro API key
$config = new FraudLabsPro\Configuration('YOUR_API_KEY');

// Order details
$orderDetails = [
	// IP parameter is optional, this library can detects IP address automatically
	'ip'		=> '146.112.62.105',

	'order'		=> [
		'orderId'		=> '67398',
		'note'			=> 'Online shop',
		'currency'		=> 'USD',
		'amount'		=> '79.89',
		'quantity'		=> 1,
		'paymentMethod'	=> FraudLabsPro\FraudValidation::CREDIT_CARD,
	],

	'card'		=> [
		'number'	=> '4556553172971283',
	],

	'billing'	=> [
		'firstName'	=> 'Hector',
		'lastName'	=> 'Henderson',
		'email'		=> 'hh5566@gmail.com',
		'phone'		=> '561-628-8674',

		'address'	=> '1766 Powder House Road',
		'city'		=> 'West Palm Beach',
		'state'		=> 'FL',
		'postcode'	=> '33401',
		'country'	=> 'US',
	],

	'shipping'	=> [
		'address'	=> '4469 Chestnut Street',
		'city'		=> 'Tampa',
		'state'		=> 'FL',
		'postcode'	=> '33602',
		'country'	=> 'US',
	],
];

// Sends the order details to FraudLabs Pro
$fraudlabspro = new FraudLabsPro\FraudValidation($config);
$result = $fraudlabspro->validate($orderDetails);

if ($result) {
	// Prints fraud result
	echo '<h2>FraudLabs Pro Result</h2>';

	echo '<pre>';

	foreach ($result as $key => $value) {
		echo '<strong>' . str_pad($key, 40) . '</strong>';
		echo $value . "\n";
	}

	echo '</pre>';

	if ($result->fraudlabspro_status != 'APPROVE') {
		// Cancel the order
	}

	if ($result->fraudlabspro_score > 80) {
		// High risk, better cancel the order
	}

	if ($result->is_proxy_ip_address == 'Y') {
		// User cannot made purchase through proxy server, do something
	}

	if ($result->fraudlabspro_status == 'REVIEW') {
		// Orders from US are trusted, approve and feedback to FarudLabs Pro
		if ($result->ip_country == 'US' && $result->is_proxy_ip_address == 'N') {
			$fraudlabspro->feedback([
				'id'		=> $result->fraudlabspro_id,
				'status'	=> FraudLabsPro\FraudValidation::APPROVE,
				'note'		=> 'We trust orders from US.',
			]);
		}
	}
}
