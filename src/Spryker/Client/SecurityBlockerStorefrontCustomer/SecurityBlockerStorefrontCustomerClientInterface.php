<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerStorefrontCustomer;

interface SecurityBlockerStorefrontCustomerClientInterface
{
    /**
     * Specification:
     * - Expands security blocker configuration settings with customer user settings.
     *
     * @api
     *
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerConfigurationSettingsTransfer> $securityBlockerConfigurationSettingsTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerConfigurationSettingsTransfer>
     */
    public function expandSecurityBlockerConfigurationsWithCustomerConfiguration(array $securityBlockerConfigurationSettingsTransfers): array;

    /**
     * Specification:
     * - Expands the login realm configurations with the customer realm, indexed by `SecurityBlockerStorefrontCustomerConfig::LOGIN_REALM_CUSTOMER`.
     * - Takes the thresholds from `SecurityBlockerStorefrontCustomerConfig::getCustomerLoginRealmConfiguration()`.
     *
     * @api
     *
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer> $securityBlockerLoginRealmConfigurationTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer>
     */
    public function expandSecurityBlockerLoginRealmConfigurationsWithCustomerLoginRealmConfiguration(
        array $securityBlockerLoginRealmConfigurationTransfers
    ): array;
}
