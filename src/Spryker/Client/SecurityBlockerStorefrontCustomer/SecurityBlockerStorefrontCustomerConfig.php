<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerStorefrontCustomer;

use Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer;
use Spryker\Client\Kernel\AbstractBundleConfig;
use Spryker\Shared\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerConfig as SharedSecurityBlockerStorefrontCustomerConfig;
use Spryker\Shared\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerConstants;

class SecurityBlockerStorefrontCustomerConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const SECURITY_BLOCKER_CUSTOMER_ENTITY_TYPE = 'customer';

    protected const int DEFAULT_CUSTOMER_ACCOUNT_BLOCKING_NUMBER_OF_ATTEMPTS = 9;

    protected const int DEFAULT_CUSTOMER_ACCOUNT_BLOCKING_COUNTING_WINDOW_MINUTES = 15;

    protected const int DEFAULT_CUSTOMER_ACCOUNT_BLOCKING_DURATION_MINUTES = 6;

    protected const int DEFAULT_CUSTOMER_ACCOUNT_CHALLENGE_NUMBER_OF_ATTEMPTS = 3;

    protected const int DEFAULT_CUSTOMER_IP_CHALLENGE_NUMBER_OF_ATTEMPTS = 5;

    protected const int DEFAULT_CUSTOMER_GLOBAL_CHALLENGE_NUMBER_OF_ATTEMPTS = 100;

    protected const int DEFAULT_CUSTOMER_GLOBAL_CHALLENGE_TIME_WINDOW_MINUTES = 5;

    protected const int SECONDS_PER_MINUTE = 60;

    /**
     * Specification:
     * - Returns the login protection settings of the customer realm (`SecurityBlockerStorefrontCustomerConfig::LOGIN_REALM_CUSTOMER`).
     * - Reads the account lock and the login challenge thresholds from the Back Office settings `security:login_lock:customer:*` of this module.
     * - Converts the time settings, which the Back Office stores in minutes, to seconds.
     * - Without the Configuration module: locks an account after 9 failed logins within 15 minutes for 6 minutes, and requires a
     *   login challenge after 3 failed logins to one account, 5 from one IP address or 100 across all accounts within 5 minutes.
     * - A threshold of `0` disables that dimension; it is never replaced by a default.
     *
     * @api
     */
    public function getCustomerLoginRealmConfiguration(): SecurityBlockerLoginRealmConfigurationTransfer
    {
        return (new SecurityBlockerLoginRealmConfigurationTransfer())
            ->setRealm(SharedSecurityBlockerStorefrontCustomerConfig::LOGIN_REALM_CUSTOMER)
            ->setAccountNumberOfAttempts($this->getIntegerSetting(SharedSecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_NUMBER_OF_FAILED_ATTEMPTS, static::DEFAULT_CUSTOMER_ACCOUNT_BLOCKING_NUMBER_OF_ATTEMPTS))
            ->setAccountTtl($this->getMinutesSettingInSeconds(SharedSecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_COUNTING_WINDOW, static::DEFAULT_CUSTOMER_ACCOUNT_BLOCKING_COUNTING_WINDOW_MINUTES))
            ->setAccountBlockFor($this->getMinutesSettingInSeconds(SharedSecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_DURATION, static::DEFAULT_CUSTOMER_ACCOUNT_BLOCKING_DURATION_MINUTES))
            ->setAccountChallengeNumberOfAttempts($this->getIntegerSetting(SharedSecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_ACCOUNT_NUMBER_OF_FAILED_ATTEMPTS, static::DEFAULT_CUSTOMER_ACCOUNT_CHALLENGE_NUMBER_OF_ATTEMPTS))
            ->setIpChallengeNumberOfAttempts($this->getIntegerSetting(SharedSecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_IP_NUMBER_OF_FAILED_ATTEMPTS, static::DEFAULT_CUSTOMER_IP_CHALLENGE_NUMBER_OF_ATTEMPTS))
            ->setGlobalChallengeNumberOfAttempts($this->getIntegerSetting(SharedSecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS, static::DEFAULT_CUSTOMER_GLOBAL_CHALLENGE_NUMBER_OF_ATTEMPTS))
            ->setGlobalTtl($this->getMinutesSettingInSeconds(SharedSecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_TIME_WINDOW, static::DEFAULT_CUSTOMER_GLOBAL_CHALLENGE_TIME_WINDOW_MINUTES));
    }

    /**
     * Specification:
     * - Returns security blocker customer entity type.
     *
     * @api
     */
    public function getSecurityBlockerCustomerEntityType(): string
    {
        return static::SECURITY_BLOCKER_CUSTOMER_ENTITY_TYPE;
    }

    /**
     * Specification:
     * - Returns Customer time for block in seconds.
     *
     * @api
     */
    public function getCustomerBlockForSeconds(): int
    {
        return $this->get(SecurityBlockerStorefrontCustomerConstants::CUSTOMER_BLOCK_FOR_SECONDS, 0);
    }

    /**
     * Specification:
     * - Returns Customer blocking TTL in seconds.
     *
     * @api
     */
    public function getCustomerBlockingTTL(): int
    {
        return $this->get(SecurityBlockerStorefrontCustomerConstants::CUSTOMER_BLOCKING_TTL, 0);
    }

    /**
     * Specification:
     * - Returns Customer number of attempts configuration.
     *
     * @api
     */
    public function getCustomerBlockingNumberOfAttempts(): int
    {
        return $this->get(SecurityBlockerStorefrontCustomerConstants::CUSTOMER_BLOCKING_NUMBER_OF_ATTEMPTS, 0);
    }

    protected function getIntegerSetting(string $settingKey, int $default): int
    {
        return (int)$this->getModuleConfig($settingKey, $default);
    }

    protected function getMinutesSettingInSeconds(string $settingKey, int $defaultMinutes): int
    {
        return $this->getIntegerSetting($settingKey, $defaultMinutes) * static::SECONDS_PER_MINUTE;
    }
}
