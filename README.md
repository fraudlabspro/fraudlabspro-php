FraudLabs Pro PHP SDK
========================
This PHP module enables user to easily implement fraud detection feature into their solution using the API from [FraudLabs Pro](https://www.fraudlabspro.com).

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

This module requires an API key to function. You can [sign up for a free API key at FraudLabs Pro](https://www.fraudlabspro.com/checkout-micro).

# Developer Documentation
For installation instructions, usage, and code examples, refer to the [Developer Documentation](https://fraudlabspro-php.readthedocs.io/en/latest/index.html).


# Reference

#### Feedback Status

| Feedback Status                      | Description                                 |
| ------------------------------------ | ------------------------------------------- |
| FraudLabsPro\Order::APPROVE          | Approves an order that under review status. |
| FraudLabsPro\Order::REJECT           | Rejects an order than under review status.  |
| FraudLabsPro\Order::REJECT_BLACKLIST | Rejects and blacklists an order.            |


LICENCE
=====================
See the LICENSE file.
