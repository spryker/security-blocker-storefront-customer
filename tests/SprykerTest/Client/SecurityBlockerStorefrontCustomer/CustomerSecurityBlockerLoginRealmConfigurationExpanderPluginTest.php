<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\SecurityBlockerStorefrontCustomer;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer;
use Spryker\Client\SecurityBlockerStorefrontCustomer\Plugin\SecurityBlocker\CustomerSecurityBlockerLoginRealmConfigurationExpanderPlugin;
use Spryker\Client\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerClient;
use Spryker\Client\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerConfig as ClientSecurityBlockerStorefrontCustomerConfig;
use Spryker\Client\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerFactory;
use Spryker\Shared\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerConfig;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group SecurityBlockerStorefrontCustomer
 * @group CustomerSecurityBlockerLoginRealmConfigurationExpanderPluginTest
 * Add your own group annotations below this line
 */
class CustomerSecurityBlockerLoginRealmConfigurationExpanderPluginTest extends Unit
{
    protected const string OTHER_REALM = 'other-realm';

    protected SecurityBlockerStorefrontCustomerClientTester $tester;

    /**
     * A threshold of `0` disables its dimension, so it must reach the security blocker unchanged.
     */
    public function testExpandAddsTheCustomerRealmWithTheConfiguredThresholdsAndKeepsOtherRealms(): void
    {
        // Arrange
        $otherRealmConfigurationTransfer = (new SecurityBlockerLoginRealmConfigurationTransfer())->setRealm(static::OTHER_REALM);
        $customerSecurityBlockerLoginRealmConfigurationExpanderPlugin = new CustomerSecurityBlockerLoginRealmConfigurationExpanderPlugin();
        $customerSecurityBlockerLoginRealmConfigurationExpanderPlugin->setClient($this->createClientWithBackOfficeSettings([
            SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_NUMBER_OF_FAILED_ATTEMPTS => '7',
            SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS => '0',
        ]));

        // Act
        $securityBlockerLoginRealmConfigurationTransfers = $customerSecurityBlockerLoginRealmConfigurationExpanderPlugin->expand([static::OTHER_REALM => $otherRealmConfigurationTransfer]);

        // Assert
        $this->assertSame([static::OTHER_REALM, SecurityBlockerStorefrontCustomerConfig::LOGIN_REALM_CUSTOMER], array_keys($securityBlockerLoginRealmConfigurationTransfers));
        $customerLoginRealmConfigurationTransfer = $securityBlockerLoginRealmConfigurationTransfers[SecurityBlockerStorefrontCustomerConfig::LOGIN_REALM_CUSTOMER];
        $this->assertSame(SecurityBlockerStorefrontCustomerConfig::LOGIN_REALM_CUSTOMER, $customerLoginRealmConfigurationTransfer->getRealm());
        $this->assertSame(7, $customerLoginRealmConfigurationTransfer->getAccountNumberOfAttempts());
        $this->assertSame(0, $customerLoginRealmConfigurationTransfer->getGlobalChallengeNumberOfAttempts());
    }

    public function testGetCustomerLoginRealmConfigurationAppliesTheModuleDefaultsWhenNothingIsConfigured(): void
    {
        // Act
        $customerLoginRealmConfigurationTransfer = $this->createConfigWithBackOfficeSettings([])->getCustomerLoginRealmConfiguration();

        // Assert
        $this->assertSame(9, $customerLoginRealmConfigurationTransfer->getAccountNumberOfAttempts());
        $this->assertSame(900, $customerLoginRealmConfigurationTransfer->getAccountTtl());
        $this->assertSame(360, $customerLoginRealmConfigurationTransfer->getAccountBlockFor());
        $this->assertSame(3, $customerLoginRealmConfigurationTransfer->getAccountChallengeNumberOfAttempts());
        $this->assertSame(5, $customerLoginRealmConfigurationTransfer->getIpChallengeNumberOfAttempts());
        $this->assertSame(100, $customerLoginRealmConfigurationTransfer->getGlobalChallengeNumberOfAttempts());
        $this->assertSame(300, $customerLoginRealmConfigurationTransfer->getGlobalTtl());
    }

    /**
     * The Back Office stores whole numbers as strings, and the time settings in minutes.
     *
     * @dataProvider provideBackOfficeSettings
     */
    public function testGetCustomerLoginRealmConfigurationTakesEachValueFromItsBackOfficeSetting(
        string $settingKey,
        string $storedValue,
        string $property,
        int $expectedValue
    ): void {
        // Arrange
        $securityBlockerStorefrontCustomerConfig = $this->createConfigWithBackOfficeSettings([$settingKey => $storedValue]);

        // Act
        $customerLoginRealmConfigurationTransfer = $securityBlockerStorefrontCustomerConfig->getCustomerLoginRealmConfiguration();

        // Assert
        $this->assertSame($expectedValue, $customerLoginRealmConfigurationTransfer->toArray(true, true)[$property]);
    }

    /**
     * @return array<string, array{string, string, string, int}>
     */
    public function provideBackOfficeSettings(): array
    {
        return [
            'account lock' => [SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_NUMBER_OF_FAILED_ATTEMPTS, '4', SecurityBlockerLoginRealmConfigurationTransfer::ACCOUNT_NUMBER_OF_ATTEMPTS, 4],
            'account lock counting window in minutes' => [SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_COUNTING_WINDOW, '20', SecurityBlockerLoginRealmConfigurationTransfer::ACCOUNT_TTL, 1200],
            'account lock duration in minutes' => [SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_ACCOUNT_LOCK_DURATION, '10', SecurityBlockerLoginRealmConfigurationTransfer::ACCOUNT_BLOCK_FOR, 600],
            'challenge per account' => [SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_ACCOUNT_NUMBER_OF_FAILED_ATTEMPTS, '7', SecurityBlockerLoginRealmConfigurationTransfer::ACCOUNT_CHALLENGE_NUMBER_OF_ATTEMPTS, 7],
            'challenge per IP address' => [SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_IP_NUMBER_OF_FAILED_ATTEMPTS, '8', SecurityBlockerLoginRealmConfigurationTransfer::IP_CHALLENGE_NUMBER_OF_ATTEMPTS, 8],
            'challenge across all accounts' => [SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_NUMBER_OF_FAILED_ATTEMPTS, '50', SecurityBlockerLoginRealmConfigurationTransfer::GLOBAL_CHALLENGE_NUMBER_OF_ATTEMPTS, 50],
            'challenge time window across all accounts in minutes' => [SecurityBlockerStorefrontCustomerConfig::CONFIGURATION_KEY_CHALLENGE_ALL_ACCOUNTS_TIME_WINDOW, '2', SecurityBlockerLoginRealmConfigurationTransfer::GLOBAL_TTL, 120],
        ];
    }

    /**
     * @param array<string, string> $storedValues
     */
    protected function createClientWithBackOfficeSettings(array $storedValues): SecurityBlockerStorefrontCustomerClient
    {
        $securityBlockerStorefrontCustomerFactory = new SecurityBlockerStorefrontCustomerFactory();
        $securityBlockerStorefrontCustomerFactory->setConfig($this->createConfigWithBackOfficeSettings($storedValues));
        $securityBlockerStorefrontCustomerClient = new SecurityBlockerStorefrontCustomerClient();
        $securityBlockerStorefrontCustomerClient->setFactory($securityBlockerStorefrontCustomerFactory);

        return $securityBlockerStorefrontCustomerClient;
    }

    /**
     * @param array<string, string> $storedValues
     */
    protected function createConfigWithBackOfficeSettings(array $storedValues): ClientSecurityBlockerStorefrontCustomerConfig
    {
        return new class ($storedValues) extends ClientSecurityBlockerStorefrontCustomerConfig {
            /**
             * @param array<string, string> $storedValues
             */
            public function __construct(protected array $storedValues)
            {
            }

            /**
             * @param mixed|null $default
             * @param array<\Generated\Shared\Transfer\ConfigurationScopeTransfer> $configurationScopes
             */
            protected function getModuleConfig(string $key, $default = null, array $configurationScopes = []): mixed
            {
                return $this->storedValues[$key] ?? $default;
            }
        };
    }
}
