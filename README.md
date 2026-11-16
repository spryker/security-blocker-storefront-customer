# SecurityBlockerStorefrontCustomer Module
[![Latest Stable Version](https://poser.pugx.org/spryker/security-blocker-storefront-customer/v/stable.svg)](https://packagist.org/packages/spryker/security-blocker-storefront-customer)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.3-8892BF.svg)](https://php.net/)

Module provides functionality to secure storefront customer authentication process. It owns the `customer` login realm, whose account lock and security check (CAPTCHA) limits per account, per IP address and across all accounts are set in the Back Office on **Configuration → Security → Login Lock → Customer Accounts** (`security:login_lock:customer:*`).

## Installation

```
composer require spryker/security-blocker-storefront-customer
```

## Documentation

[Spryker Documentation](https://docs.spryker.com)
