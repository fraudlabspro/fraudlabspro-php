# Quickstart

## Dependencies

This module requires API key to function. You may subscribe a free API key at https://www.fraudlabspro.com

## Installation

Install this package using the command as below:

```
composer require fraudlabspro/fraudlabspro-php
```

## Sample Codes

### Validate Order

You can validate your order as below:

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

// Configures FraudLabs Pro API key
$config = new FraudLabsPro\Configuration('YOUR_API_KEY');
$fraudlabspro = new FraudLabsPro\FraudValidation($config);

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
		
		// Please refer reference section for full list of payment methods
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
$result = $fraudlabspro->validate($orderDetails);
```

### Get Transaction

You can get the details of a transaction as below:

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

// Configures FraudLabs Pro API key
$config = new FraudLabsPro\Configuration('YOUR_API_KEY');
$fraudlabspro = new FraudLabsPro\FraudValidation($config);

$result = $fraudlabspro->getTransaction('20170906MXFHSTRF', FraudLabsPro\FraudValidation::FLP_ID);
```

### Feedback

You can approve, reject or ignore a transaction as below:

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

// Configures FraudLabs Pro API key
$config = new FraudLabsPro\Configuration('YOUR_API_KEY');
$fraudlabspro = new FraudLabsPro\FraudValidation($config);

$fraudlabspro->feedback([
	'id'		=> '20170906MXFHSTRF',
	// Please refer to reference section for full list of feedback statuses
	'status'	=> FraudLabsPro\FraudValidation::APPROVE,
	'note'		=> 'This customer made a valid purchase before.',
]);

```

### Send SMS Verification

You can send SMS verification for authentication purpose as below:

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

// Configures FraudLabs Pro API key
$config = new FraudLabsPro\Configuration('YOUR_API_KEY');
$fraudlabsproSms = new \FraudLabsPro\SmsVerification($config);

// Send SMS Verification
$fraudlabsproSms->sendSms([
	'tel'			=> '+123456789',
	'mesg'			=> 'Hi, your OTP is <otp>.',
	'otp_timeout'	=> 3600,
	'country_code'	=> 'US',
]);
```

### Get SMS Verification Result

You can verify the OTP sent by Fraudlabs Pro SMS verification API as below:

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

// Configures FraudLabs Pro API key
$config = new FraudLabsPro\Configuration('YOUR_API_KEY');
$fraudlabsproSms = new \FraudLabsPro\SmsVerification($config);

// Get SMS Verification result
$fraudlabsproSms->verifyOtp([
	'tran_id'		=> 'UNIQUE_TRANS_ID',
	'otp'			=> 'OTP_RECEIVED',
]);
```