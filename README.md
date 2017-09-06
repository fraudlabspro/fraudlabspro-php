FraudLabs Pro PHP SDK
========================
This PHP module enables user to easily implement fraud detection feature into their solution using the API from http://www.fraudlabspro.com.

Below are the features of this PHP module:
- Fraud analysis and scoring
- IP address geolocation & proxy validation
- Email address validation
- Credit card issuing bank validation
- Transaction velocity validation
- Device transaction validation
- Blacklist validation
- Custom rules trigger
- Email notification of fraud orders
- Mobile app notification of fraud orders

This module requires API key to function. You may subscribe a free API key at http://www.fraudlabspro.com




Usage Example
============
#### Validate Order

```
<?php
require_once 'lib/FraudLabsPro.php';

// Configures FraudLabs Pro API key
FraudLabsPro\Configuration::apiKey('YOUR_API_KEY');

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
		'paymentMethod'	=> FraudLabsPro\Order::CREDIT_CARD,
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
$result = FraudLabsPro\Order::validate($orderDetails);
```



#### Feedback

```
<?php
require_once 'lib/FraudLabsPro.php';

// Configures FraudLabs Pro API key
FraudLabsPro\Configuration::apiKey('YOUR_API_KEY');

FraudLabsPro\Order::feedback([
	'id'		=> '20170906MXFHSTRF',
	// Please refer to reference section for full list of feedback statuses
	'status'	=> FraudLabsPro\Order::APPROVE,
	'note'		=> 'This customer made a valid purchase before.',
]);

```



### Reseller Usage

#### Create Account

```
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
	// Refer reference section for full list of industries
	'industry'			=> FraudLabsPro\Account::ONLINE_GAMES,
];

// Creates user account
$result = FraudLabsPro\Account::create($userDetails);
```



#### Subscribe Plan

```
require_once 'lib/FraudLabsPro.php';

// Configures FraudLabs Pro Reseller key
FraudLabsPro\Configuration::resellerKey('YOUR_RESELLER_KEY');

// Subscribe to Micro plan
FraudLabsPro\Account::subscribe([
	'username'	=> $result->username,
	// Please refer to reference section for full list of plans
	'plan'		=> FraudLabsPro\Account::MICRO_PLAN,
]);
```



# Reference

| Payment Method                       |
| ------------------------------------ |
| FraudLabsPro\Order::CREDIT_CARD      |
| FraudLabsPro\Order::PAYPAL           |
| FraudLabsPro\Order::GOOGLE_CHECKOUT  |
| FraudLabsPro\Order::CASH_ON_DELIVERY |
| FraudLabsPro\Order::MONEY_ORDER      |
| FraudLabsPro\Order::WIRE_TRANSFER    |
| FraudLabsPro\Order::BANK_DEPOSIT     |
| FraudLabsPro\Order::BITCOIN          |
| FraudLabsPro\Order::OTHERS           |



| Feedback Status               | Description                              |
| ----------------------------- | ---------------------------------------- |
| FraudLabsPro\Order::APPROVE   | Approves an order that under review status. |
| FraudLabsPro\Order::REJECT    | Rejects an order than under review status. |
| FraudLabsPro\Order::BLACKLIST | Rejects and blacklists an order.         |



| Business Industry                        |
| ---------------------------------------- |
| FraudLabsPro\Account::RETAIL_E_COMMERCE  |
| FraudLabsPro\Account::RETAIL_BRICK_AND_MORTAR |
| FraudLabsPro\Account::HOSPITALITY_AND_ACCOMMODATION |
| FraudLabsPro\Account::TICKETING_AND_EVENTS |
| FraudLabsPro\Account::CLUBS_AND_BUYING_GROUPS |
| FraudLabsPro\Account::MEMBERSHIPS_AND_SUBSCRIPTIONS |
| FraudLabsPro\Account::DIGITAL_CONTENT    |
| FraudLabsPro\Account::ONLINE_GAMES       |
| FraudLabsPro\Account::SOFTWARE           |
| FraudLabsPro\Account::TELEPHONE_SERVICES |
| FraudLabsPro\Account::TRAVEL             |
| FraudLabsPro\Account::NON_PROFIT_AND_CHARITY |
| FraudLabsPro\Account::SERVICES           |
| FraudLabsPro\Account::HIGH_RISK_MERCHANTS |



| FraudLabs Pro Plan           |
| ---------------------------- |
| FraudLabsPro\Account::MICRO  |
| FraudLabsPro\Account::MINI   |
| FraudLabsPro\Account::SMALL  |
| FraudLabsPro\Account::MEDIUM |
| FraudLabsPro\Account::LARGE  |




LICENCE
=====================
See the LICENSE file.