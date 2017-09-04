<?php
require_once 'class.FraudLabsPro.php';

$fraud = new \FraudLabsPro\Order('API_KEY_HERE');

// Prepare transaction information
$params = [
	'ip'		=> $_SERVER['REMOTE_ADDR'],

	'order'		=> [
		'orderId'		=> '67398',
		'note'			=> 'Online shop',
		'currency'		=> 'USD',
		'amount'		=> '79.89',
		'quantity'		=> 1,
		'paymentMethod'	=> 'CREDITCARD',
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

// Validate the transaction with FraudLabs Pro
$result = $fraud->validate($params);

if($result){
	if($result->fraudlabspro_status != 'APPROVE'){
		// Cancel the order
	}

	if($result->fraudlabspro_score > 80){
		// High risk, better cancel the order
	}

	if($result->is_proxy_ip_address == 'Y'){
		// User cannot made purchase through proxy server, do something
	}
}