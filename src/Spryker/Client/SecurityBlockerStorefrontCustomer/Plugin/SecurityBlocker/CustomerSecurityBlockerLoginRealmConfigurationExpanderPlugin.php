<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerStorefrontCustomer\Plugin\SecurityBlocker;

use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SecurityBlockerExtension\Dependency\Plugin\SecurityBlockerLoginRealmConfigurationExpanderPluginInterface;

/**
 * @method \Spryker\Client\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerFactory getFactory()
 * @method \Spryker\Client\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerConfig getConfig()
 * @method \Spryker\Client\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerClientInterface getClient()
 */
class CustomerSecurityBlockerLoginRealmConfigurationExpanderPlugin extends AbstractPlugin implements SecurityBlockerLoginRealmConfigurationExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands the login realm configurations with the customer realm, which the storefront customer login surfaces (Yves, Glue) share.
     *
     * @api
     *
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer> $securityBlockerLoginRealmConfigurationTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer>
     */
    public function expand(array $securityBlockerLoginRealmConfigurationTransfers): array
    {
        return $this->getClient()
            ->expandSecurityBlockerLoginRealmConfigurationsWithCustomerLoginRealmConfiguration($securityBlockerLoginRealmConfigurationTransfers);
    }
}
