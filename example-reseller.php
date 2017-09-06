<?php
// Preset PHP settings
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'lib/FraudLabsPro.php';

// Configures FraudLabs Pro Reseller key
FraudLabsPro\Configuration::resellerKey('YOUR_RESELLER_KEY');

// User details
$userDetails = [
	'username'			=> 'banana88',
	'email'				=> 'banana88@gmail.com',
	'name'				=> 'Richard J. Quintanilla',
	'address1'			=> '1056 Eagle Street',
	'address2'			=> '',
	'city'				=> 'Carbondale',
	'state'				=> 'IL',
	'postcode'			=> '62901',
	'country'			=> 'US',
	'phone'				=> '618-351-4860',
	'fax'				=> '',
	'company'			=> 'The Monster Inc.',
	'industry'			=> FraudLabsPro\Account::ONLINE_GAMES,
];

// Creates user account
$result = FraudLabsPro\Account::create($userDetails);

if ($result) {
	// Prints result
	echo '<h2>FraudLabs Pro Result</h2>';

	echo '<pre>';

	foreach ($result as $key => $value) {
		echo '<strong>' . str_pad($key, 40) . '</strong>';
		echo $value . "\n";
	}

	echo '</pre>';

	if (!$result->fraudlabspro_error_code) {
		// Subscribes user to Micro plan
		FraudLabsPro\Account::subscribe([
			'username'	=> $result->username,
			'plan'		=> FraudLabsPro\Account::MICRO_PLAN,
		]);
	}
}
