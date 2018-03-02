FraudLabs Pro PHP SDK
========================
This PHP module enables user to easily implement fraud detection feature into their solution using the API from https://www.fraudlabspro.com.

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

This module requires API key to function. You may subscribe a free API key at https://www.fraudlabspro.com




Usage Example
============
### Validate Order

#### Object Properties

| Property Name                     | Property Type | Description                                                  |
| --------------------------------- | ------------- | ------------------------------------------------------------ |
| ip                                | string        | IP address of online transaction. It supports both IPv4 and IPv6 address format. |
| billing->firstName   | string        | User's first name.                                           |
| billing->lastName    | string        | User's last name.                                            |
| billing->username    | string        | User's username.                                             |
| billing->password    | string        | User's password.                                             |
| billing->email       | string        | User's email address.                                        |
| billing->phone       | string        | User's phone number.                                         |
| billing->address     | string        | Street address of billing address.                           |
| billing->city        | string        | City of billing address.                                     |
| billing->state       | string        | State of billing address. It supports state codes, e.g. NY (New York), for state or province of United States or Canada. Please refer to [State & Province Codes](https://www.fraudlabspro.com/developer/reference/state-and-province-codes) for complete list. |
| billing->postcode    | string        | Postal or ZIP code of billing address.                       |
| billing->country     | string        | Country of billing address. It requires the input of ISO-3166 alpha-2 country code, e.g. US for United States. Please refer to [Country Codes](https://www.fraudlabspro.com/developer/reference/country-codes) for complete list. |
| order->orderId       | string        | Merchant identifier to uniquely identify a transaction. It supports maximum of 15 characters user order id input. |
| order->note          | string        | Merchant description of an order transaction. It supports maximum of 200 characters. |
| order->amount        | float         | Amount of the transaction.                                   |
| order->quantity      | integer       | Total quantity of the transaction.                           |
| order->currency      | string        | Currency code used in the transaction. It requires the input of ISO-4217 (3 characters) currency code, e.g. USD for US Dollar. Please refer to [Currency Codes](https://www.fraudlabspro.com/developer/reference/currency-codes) for complete list. |
| order->department    | string        | Merchant identifier to uniquely identify a product or service department. |
| order->paymentMethod | string        | Payment mode of transaction. Please see references section.  |
| card->number         | string        | Billing credit card number or BIN number.                    |
| card->avs            | string        | The single character AVS result returned by the credit card processor. Please refer to [AVS & CVV2 Response Codes](https://www.fraudlabspro.com/developer/reference/avs-and-cvv2-response-codes) for details. |
| card->cvv            | string        | The single character CVV2 result returned by the credit card processor. Please refer to [AVS & CVV2 Response Codes](https://www.fraudlabspro.com/developer/reference/avs-and-cvv2-response-codes) for details. |
| shipping->address    | string        | Street address of shipping address.                          |
| shipping->city       | string        | City of shipping address.                                    |
| shipping->state      | string        | State of shipping address. It supports state codes, e.g. NY - New York, for state or province of United States or Canada. Please refer to [State & Province Codes](https://www.fraudlabspro.com/developer/reference/state-and-province-codes) for complete list. |
| shipping->postcode   | string        | Postal or ZIP code of shipping address.                      |
| shipping->country    | string        | Country of shipping address. It requires the input of ISO-3166 alpha-2 country code, e.g. US for United States. Please refer to [Country Codes](https://www.fraudlabspro.com/developer/reference/country-codes) for complete list. |


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



### Feedback

#### Object Properties

| Property Name | Property Type | Description                                                  |
| ------------- | ------------- | ------------------------------------------------------------ |
| id            | string        | Unique transaction ID generated from **Validate** function.  |
| status        | string        | Perform APPROVE, REJECT, or REJECT_BLACKLIST action to transaction.	Refer to [reference section](#feedback-status) for status code. |
| note          | string        | Notes for the feedback request.                              |

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



## Reseller Usage

### Create Account

#### Object Properties

| Property Name | Property Type | Description                                                  |
| ------------- | :-----------: | ------------------------------------------------------------ |
| username      |    string     | Username of the new account.                                 |
| email         |    string     | Email address of the new account.                            |
| name          |    string     | Full name of the new user.                                   |
| address1      |    string     | Address field.                                               |
| address2      |    string     | Additional address field.                                    |
| city          |    string     | City name.                                                   |
| state         |    string     | State name.                                                  |
| postcode      |    string     | ZIP code/Postal code.                                        |
| country       |    string     | Country code.  It requires the input of ISO-3166 alpha-2 country code, e.g. US for United States. Please refer to																[Country Codes](https://www.fraudlabspro.com/developer/reference/country-codes) for complete list. |
| phone         |    string     | Phone number.                                                |
| fax           |    string     | Fax number.                                                  |
| company       |    string     | Company name.                                                |
| industry      |    string     | Industry ID of the business involved. Please refer to													 [reference section](#business-industry) for complete list. |


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



### Subscribe Plan

#### Object Properties

| Property Name | Property Type | Description                                                  |
| ------------- | :-----------: | ------------------------------------------------------------ |
| username      |    string     | Username of the account.                                     |
| plan          |    string     | Plan code for the plan. Please refer to [reference section](#fraudlabs-pro-plan) for the complete list. |

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


## SMS Verification

### Send SMS Verification

#### Object Properties

| Property Name | Property Type | Description                                                  |
| ------------- | :-----------: | ------------------------------------------------------------ |
| tel           |    string     | The recipient mobile phone number in E164 format which is a plus followed by just numbers with no spaces or parentheses. |
| mesg          |    string     | The message template for the SMS. Add <otp> as placeholder for the actual OTP to be generated. Max length is 140 characters. |
| country_code  |    string     | ISO 3166 country code for the recipient mobile phone number. If parameter is supplied, then some basic telephone number validation is done. |

```
require_once 'lib/FraudLabsPro.php';

// Configures FraudLabs Pro API key
FraudLabsPro\Configuration::apiKey('YOUR_API_KEY');

// Send SMS Verification
FraudLabsPro\SMSVerification::sendsms([
	'tel'			=> '+15616288674',
	'mesg'			=> 'Hi, your OTP is <otp>.',
	'country_code'		=> 'US',
]);
```



### Get SMS Verification Result

#### Object Properties

| Property Name | Property Type | Description                                                  |
| ------------- | :-----------: | ------------------------------------------------------------ |
| tran_id       |    string     | The unique ID that was returned by the Send SMS Verification that triggered the OTP sms. |
| otp           |    string     | The OTP that was sent to the recipient’s phone. |

```
require_once 'lib/FraudLabsPro.php';

// Configures FraudLabs Pro API key
FraudLabsPro\Configuration::apiKey('YOUR_API_KEY');

// Get SMS Verification result
FraudLabsPro\SMSVerification::verifysms([
	'tran_id'		=> 'UNIQUE_TRANS_ID',
	'otp'			=> 'OTP_RECEIVED',
]);
```



# Reference

#### Payment Method

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



#### Feedback Status

| Feedback Status               | Description                              |
| ----------------------------- | ---------------------------------------- |
| FraudLabsPro\Order::APPROVE   | Approves an order that under review status. |
| FraudLabsPro\Order::REJECT    | Rejects an order than under review status. |
| FraudLabsPro\Order::BLACKLIST | Rejects and blacklists an order.         |



#### Business Industry

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



#### FraudLabs Pro Plan

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
