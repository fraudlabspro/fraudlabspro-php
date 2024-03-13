# FraudLabs Pro PHP API

## Configuration Class
```{py:class} Configuration(api_key)
Configure FraudLabs Pro API key.

:param str api_key: (Required) FraudLabs Pro API key.
```

## FraudValidation Class
```{py:class} FraudValidation(config_object)
Initiate FraudValidation class.

:param object config_object: (Required) The configuration object returned by Configuration Class.
```

```{py:function} getTransaction(id, type)
Retrieve an existing transaction from FraudLabs Pro fraud detection system.

:param str id: (Required) FraudLabs Pro transaction ID or Order ID.
:param str type: (Required) ID type. Either: **FraudLabsPro\FraudValidation::FLP_ID** or **FraudLabsPro\FraudValidation::ORDER_ID**

:return: Returns the details about the transaction in JSON object.
:rtype: Object

| Parameter                                     | Type    | Description |
|-----------------------------------------------|---------|--------------|
| ip_geolocation.ip                             | string  | IP address of the transaction. |
| ip_geolocation.continent                      | string  | Estimated continent of the IP address. |
| ip_geolocation.country_code                   | string  | Estimated ISO-3166 alpha-2 country code of the IP address. |
| ip_geolocation.country_name                   | string  | Estimated country of the IP address. |
| ip_geolocation.region                         | string  | Estimated region of the IP address. |
| ip_geolocation.city                           | string  | Estimated city of the IP address. |
| ip_geolocation.latitude                       | decimal | Estimated latitude of the IP address in 4 precisions. |
| ip_geolocation.longitude                      | decimal | Estimated longitude of the IP address in 4 precisions. |
| ip_geolocation.zip_code                       | string  | Estimated ZIP code of the IP address. |
| ip_geolocation.timezone                       | string  | Estimated timezone of the IP address. |
| ip_geolocation.isp_name                       | string  | Estimated ISP name of the IP address. |
| ip_geolocation.domain                         | string  | Estimated domain name of the IP address. |
| ip_geolocation.netspeed                       | string  | Estimated netspeed of the IP address. |
| ip_geolocation.mobile_mnc                     | string  | Estimated mobile mnc information of the IP address, if it is a mobile network. |
| ip_geolocation.mobile_mcc                     | string  | Estimated mobile mcc information of the IP address, if it is a mobile network. |
| ip_geolocation.mobile_brand                   | string  | Estimated mobile brand information of the IP address, if it is a mobile network. |
| ip_geolocation.elevation                      | integer | Estimated elevation of the IP address. |
| ip_geolocation.usage_type                     | string  | Estimated usage type of the IP address. Return values as below: <br/>• Commercial<br/>• Organization<br/>• Government<br/>• Military<br/>• University/College/School<br/>• Library<br/>• Content Delivery Network<br/>• Fixed Line ISP<br/>• Mobile ISP<br/>• Data Center/Web Hosting/Transit<br/>• Search Engine Spider |
| ip_geolocation.is_proxy                       | boolean | Whether the IP address is from a known anonymous proxy server. |
| ip_geolocation.is_in_blacklist                | boolean | Whether the IP address is in our blacklist database. |
| billing_address.distance_in_km                | integer | Distance of location between IP address and bill. Value in kilometer. |
| billing_address.distance_in_mile              | integer | Distance of location between IP address and bill. Value in mile. |
| billing_address.is_ip_country_match           | boolean | Whether country of IP address matches billing address country. |
| shipping_address.is_address_ship_forward      | boolean | Whether the shipping address is in database of known mail drops. |
| shipping_address.is_bill_city_match           | boolean | Whether the billing city matches the shipping city. |
| shipping_address.is_bill_state_match          | boolean | Whether the billing state matches the shipping state. |
| shipping_address.is_bill_country_match        | boolean | Whether the billing country matches the shipping country. |
| shipping_address.is_bill_postcode_match       | boolean | Whether the billing postal/zip code matches the shipping postal/zip code. |
| shipping_address.is_export_controlled_country | boolean | Whether the country is from an embargoed country. |
| shipping_address.is_in_blacklist              | boolean | Whether the ship address is in our blacklist database. |
| email_address.is_free                         | boolean | Whether the email is from free email provider. |
| email_address.is_disposable                   | boolean | Whether the email is a disposable email. Only applicable for Small Plan onward. |
| email_address.is_domain_exists                | boolean | Whether the email domain name is a valid domain. |
| email_address.is_new_domain_name              | boolean | Whether the email domain name a newly registered name. Only applicable for non-free email domain. |
| email_address.is_in_blacklist                 | boolean | Whether the email address is in our blacklist database. |
| phone_number.is_disposable                    | boolean | Whether the phone number is a disposable phone number. Only applicable for Medium Plan onward. |
| phone_number.is_in_blacklist                  | boolean | Whether the user's phone number is in our blacklist database. |
| username.is_high_risk                         | boolean | Whether the username is in our high risk database. |
| username.is_in_blacklist                      | boolean | Whether the username is in our blacklist database. |
| credit_card.card_brand                        | string  | The brand of the card. Available on Medium plan onward only. |
| credit_card.card_type                         | string  | Whether the card is a type of credit or debit. Available on Medium plan onward only. |
| credit_card.card_issuing_bank                 | string  | The name of the bank where the card being issued. Available on Medium plan onward only. |
| credit_card.card_issuing_country              | string  | The ISO-3166 alpha-2 Country Codes where the card being issued. Available on Medium plan onward only. |
| credit_card.is_prepaid                        | boolean | Whether the credit card is a type of prepaid card. |
| credit_card.is_bin_exist                      | boolean | Whether the BIN information matches our BIN list. |
| credit_card.is_bin_country_match              | boolean | Whether the country of issuing bank matches BIN country code. |
| credit_card.is_in_blacklist                   | boolean | Whether the credit card is in our blacklist database. |
| device.is_malware_exploit                     | boolean | Whether the machine is infected. |
| device.is_in_blacklist                        | boolean | Whether the device Id is in our blacklist database. |
| user_order_id                                 | string  | Return the order identifier given by merchant earlier. |
| fraudlabspro_id                               | string  | System own unique identifier to identify this API transaction. |
| fraudlabspro_score                            | integer | Overall score between 1 and 100. 100 is the highest risk and 1 is the lowest risk. |
| fraudlabspro_status                           | string  | Final action based on the rules analysis. Return values: APPROVE \| REJECT \| REVIEW |
| fraudlabspro_rules                            | array   | Return the rules triggered by the system. Available on Mini plan onward only.  |

```

```{py:function} feedback(params)
Approve, reject or ignore a transaction.

:param array params: (Required) The parameters of order details.

| Parameter    | Type    | Description |
|--------------|---------|---------------------|
| id          | string  | (required) Unique transaction Id generated by Fraud Check API. |
| action         | string  | (required) Perform APPROVE, REJECT, or REJECT_BLACKLIST action to transaction.<br/>• APPROVE: Approve a transaction<br/>• REJECT: Reject a transaction<br/>• REJECT_BLACKLIST: Reject and blacklist the transaction<br/>When a transaction was blacklisted, the information will be recorded into the system for future blacklist validation check. |
| note  | integer | (optional) Notes for the feedback request. |
```

```{py:function} validate(params)
Retrieve geolocation information for an IP address.

:param array params: (Required) The details of a transaction.

| Parameter       | Type    | Description |
|-----------------|---------|-----------------|
| ip              | string  | (required) IP address of online transaction. It supports both IPv4 and IPv6 address format. |
| billing->lastName       | string  | (optional) User's last name. |
| billing->firstName | string  | (optional) User's first name. |
| billing->username    | string | (optional) User's username.                                             |
| billing->password    | string | (optional) User's password.                                             |
| billing->email       | string | (optional) User's email address.                                        |
| billing->phone       | string | (optional) User's phone number.                                         |
| billing->address       | string  | (optional) Street address of billing address. |
| billing->city       | string  | (optional) City of billing address. |
| billing->state      | string  | (optional) State of billing address. It supports state codes, e.g. NY (New York), for state or province of United States or Canada.|
| billing->country    | string  | (optional) Country of billing address. It requires the input of ISO-3166 alpha-2 country code, e.g. US for United States.|
| billing->postcode   | string  | (optional) Postal or ZIP code of billing address. |
| shipping->address       | string  | (optional) Street address of shipping address. |
| shipping->city       | string  | (optional) City of shipping address. |
| shipping->state      | string  | (optional) State of shipping address. It supports state codes, e.g. NY - New York, for state or province of United States or Canada. |
| shipping->country    | string  | (optional) Country of shipping address. It requires the input of ISO-3166 alpha-2 country code, e.g. US for United States. |
| shipping->postcode   | string  | (optional) Postal or ZIP code of shipping address. |
| card->number         | string        | Billing credit card number or BIN number.                    |
| card->avs      | string  | (optional) The single character AVS result returned by the credit card processor. |
| card->cvv      | string  | (optional) The single character CVV2 result returned by the credit card processor.<br/> This is not for the input of the actual CVV code from the back of the credit card. |
| order->orderId   | string  | (optional) Merchant identifier to uniquely identify a transaction. It supports<br/> maximum of 15 characters user order id input. |
| order->note          | string        | (optional) Merchant description of an order transaction. It supports maximum of 200 characters. |
| order->amount          | decimal | (optional) Amount of the transaction. |
| order->quantity        | integer | (optional) Total quantity of the transaction. |
| order->currency        | string  | (optional) Currency code used in the transaction. It requires the input of<br/> ISO-4217 (3 characters) currency code, e.g. USD for US Dollar. |
| order->department      | string  | (optional) Merchant identifier to uniquely identify a product or service department. |
| order->paymentMethod    | string  | (optional) Payment mode of transaction. Valid values: creditcard \| affirm \| paypal \| googlecheckout \| bitcoin \| cod \| moneyorder \| wired \|<br/> bankdeposit \| elviauthorized \| paymitco \| cybersource \| sezzle \| viabill \| amazonpay \| pmnts_gateway \| giftcard \| ewayrapid \| others. |

:return: Returns the geolocation information in array. Refer below table for the fields avaliable in the array
:rtype: array

**RETURN FIELDS**

| Parameter                                     | Type    | Description |
|-----------------------------------------------|---------|--------------|
| ip_geolocation.ip                             | string  | IP address of the transaction. |
| ip_geolocation.continent                      | string  | Estimated continent of the IP address. |
| ip_geolocation.country_code                   | string  | Estimated ISO-3166 alpha-2 country code of the IP address. |
| ip_geolocation.country_name                   | string  | Estimated country of the IP address. |
| ip_geolocation.region                         | string  | Estimated region of the IP address. |
| ip_geolocation.city                           | string  | Estimated city of the IP address. |
| ip_geolocation.latitude                       | decimal | Estimated latitude of the IP address in 4 precisions. |
| ip_geolocation.longitude                      | decimal | Estimated longitude of the IP address in 4 precisions. |
| ip_geolocation.zip_code                       | string  | Estimated ZIP code of the IP address. |
| ip_geolocation.timezone                       | string  | Estimated timezone of the IP address. |
| ip_geolocation.isp_name                       | string  | Estimated ISP name of the IP address. |
| ip_geolocation.domain                         | string  | Estimated domain name of the IP address. |
| ip_geolocation.netspeed                       | string  | Estimated netspeed of the IP address. |
| ip_geolocation.mobile_mnc                     | string  | Estimated mobile mnc information of the IP address, if it is a mobile network. |
| ip_geolocation.mobile_mcc                     | string  | Estimated mobile mcc information of the IP address, if it is a mobile network. |
| ip_geolocation.mobile_brand                   | string  | Estimated mobile brand information of the IP address, if it is a mobile network. |
| ip_geolocation.elevation                      | integer | Estimated elevation of the IP address. |
| ip_geolocation.usage_type                     | string  | Estimated usage type of the IP address. Return values as below: <br/>• Commercial<br/>• Organization<br/>• Government<br/>• Military<br/>• University/College/School<br/>• Library<br/>• Content Delivery Network<br/>• Fixed Line ISP<br/>• Mobile ISP<br/>• Data Center/Web Hosting/Transit<br/>• Search Engine Spider   |
| ip_geolocation.is_proxy                       | boolean | Whether the IP address is from a known anonymous proxy server. |
| ip_geolocation.is_in_blacklist                | boolean | Whether the IP address is in our blacklist database. |
| billing_address.distance_in_km                | integer | Distance of location between IP address and bill. Value in kilometer. |
| billing_address.distance_in_mile              | integer | Distance of location between IP address and bill. Value in mile. |
| billing_address.is_ip_country_match           | boolean | Whether country of IP address matches billing address country. |
| shipping_address.is_address_ship_forward      | boolean | Whether the shipping address is in database of known mail drops. |
| shipping_address.is_bill_city_match           | boolean | Whether the billing city matches the shipping city. |
| shipping_address.is_bill_state_match          | boolean | Whether the billing state matches the shipping state. |
| shipping_address.is_bill_country_match        | boolean | Whether the billing country matches the shipping country. |
| shipping_address.is_bill_postcode_match       | boolean | Whether the billing postal/zip code matches the shipping postal/zip code. |
| shipping_address.is_export_controlled_country | boolean | Whether the country is from an embargoed country. |
| shipping_address.is_in_blacklist              | boolean | Whether the ship address is in our blacklist database. |
| email_address.is_free                         | boolean | Whether the email is from free email provider. |
| email_address.is_disposable                   | boolean | Whether the email is a disposable email. Only applicable for Small Plan onward. |
| email_address.is_domain_exists                | boolean | Whether the email domain name is a valid domain. |
| email_address.is_new_domain_name              | boolean | Whether the email domain name a newly registered name. Only applicable for non-free email domain. |
| email_address.is_in_blacklist                 | boolean | Whether the email address is in our blacklist database. |
| phone_number.is_disposable                    | boolean | Whether the phone number is a disposable phone number. Only applicable for Medium Plan onward. |
| phone_number.is_in_blacklist                  | boolean | Whether the user's phone number is in our blacklist database. |
| username.is_high_risk                         | boolean | Whether the username is in our high risk database. |
| username.is_in_blacklist                      | boolean | Whether the username is in our blacklist database. |
| credit_card.card_brand                        | string  | The brand of the card. Available on Medium plan onward only. |
| credit_card.card_type                         | string  | Whether the card is a type of credit or debit. Available on Medium plan onward only. |
| credit_card.card_issuing_bank                 | string  | The name of the bank where the card being issued. Available on Medium plan onward only. |
| credit_card.card_issuing_country              | string  | The ISO-3166 alpha-2 Country Codes where the card being issued. Available on Medium plan onward only. |
| credit_card.is_prepaid                        | boolean | Whether the credit card is a type of prepaid card. |
| credit_card.is_bin_exist                      | boolean | Whether the BIN information matches our BIN list. |
| credit_card.is_bin_country_match              | boolean | Whether the country of issuing bank matches BIN country code. |
| credit_card.is_in_blacklist                   | boolean | Whether the credit card is in our blacklist database. |
| device.is_malware_exploit                     | boolean | Whether the machine is infected. |
| device.is_in_blacklist                        | boolean | Whether the device Id is in our blacklist database. |
| user_order_id                                 | string  | Return the order identifier given by merchant earlier. |
| fraudlabspro_id                               | string  | System own unique identifier to identify this API transaction. |
| fraudlabspro_score                            | integer | Overall score between 1 and 100. 100 is the highest risk and 1 is the lowest risk. |
| fraudlabspro_status                           | string  | Final action based on the rules analysis. Return values: APPROVE \| REJECT \| REVIEW |
| fraudlabspro_rules                            | array   | Return the rules triggered by the system. Available on Mini plan onward only. |
| api_version                                   | string  | Version of the fraud analysis engine used in this transaction. |
| remaining_credits                             | integer | Balance of queries in your account after this transaction. |
```

## SmsVerification Class
```{py:class} SmsVerification(config_object)
Initiate SmsVerification class.

:param object config_object: (Required) The configuration object returned by Configuration Class.
```

```{py:function} sendSms(params)
Send SMS Verification for authentication.

:param str params: (Required) Parameters of sms details.

| Parameter    | Type    | Description |
|--------------|---------|---------------------|
| tel          | string  | (required) The recipient mobile phone number in E164 format which is a plus followed by just numbers with no spaces or parentheses.  For example, +12015550123  |
| country_code | string  | (optional) ISO 3166 country code for the recipient mobile phone number. If parameter is supplied, then some basic telephone number validation is done. |
| mesg         | string  | (required) The message template for the SMS. Add &lt;otp&gt; as placeholder for the actual OTP to be generated. Max length is 140 characters.  For example, Your OTP for the transaction is &lt;otp&gt;  |
| otp_timeout  | integer |  (optional) Timeout feature for OTP value in seconds. Default is 3600 seconds(1 hour). Min timeout is 15 seconds whereas max timeout is 86400 seconds(24 hours). |


:return: Returns the details about the transaction in JSON object.
:rtype: Object

| Parameter         | Type   | Description |
|-------------------|--------|-------------|
| tran_id           | string | Unique ID (20 characters) for this particular API call. |
| credits_remaining | string | Number of remaining credits for sending SMS. |

```

```{py:function} verifyOtp(id, type)
Get SMS Verification result.

:param str params: (Required) Parameters of sms details.

| Parameter         | Type   | Description |
|-------------------|--------|-------------|
| tran_id           | string | (required) Unique ID (20 characters) for this particular API call. |
| otp | string | (required) The OTP that was sent to the recipient’s phone. |

:return: Returns the details about the transaction in JSON object.
:rtype: Object

| Parameter         | Type   | Description |
|-------------------|--------|-------------|
| result           | string | Indicates if the input parameters matched a valid OTP. Y if a valid OTP is found and N if no valid OTP found. |
```