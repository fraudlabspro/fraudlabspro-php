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

# Developer Documentation
To learn more about installation, usage, and code examples, please visit the developer documentation at [https://fraudlabspro-php.readthedocs.io/en/latest/index.html.](https://fraudlabspro-php.readthedocs.io/en/latest/index.html)


# Reference

#### Feedback Status

| Feedback Status                      | Description                                 |
| ------------------------------------ | ------------------------------------------- |
| FraudLabsPro\FraudValidation::APPROVE          | Approves an order that under review status. |
| FraudLabsPro\FraudValidation::REJECT           | Rejects an order than under review status.  |
| FraudLabsPro\FraudValidation::REJECT_BLACKLIST | Rejects and blacklists an order.            |


LICENCE
=====================
See the LICENSE file.
