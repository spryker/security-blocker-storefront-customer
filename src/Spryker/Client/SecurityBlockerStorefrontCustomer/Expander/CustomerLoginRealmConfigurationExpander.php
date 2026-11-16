<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SecurityBlockerStorefrontCustomer\Expander;

use Spryker\Client\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerConfig;

class CustomerLoginRealmConfigurationExpander implements CustomerLoginRealmConfigurationExpanderInterface
{
    public function __construct(protected SecurityBlockerStorefrontCustomerConfig $securityBlockerStorefrontCustomerConfig)
    {
    }

    /**
     * @param array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer> $securityBlockerLoginRealmConfigurationTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\SecurityBlockerLoginRealmConfigurationTransfer>
     */
    public function expand(array $securityBlockerLoginRealmConfigurationTransfers): array
    {
        $securityBlockerLoginRealmConfigurationTransfer = $this->securityBlockerStorefrontCustomerConfig->getCustomerLoginRealmConfiguration();
        $securityBlockerLoginRealmConfigurationTransfers[$securityBlockerLoginRealmConfigurationTransfer->getRealmOrFail()] = $securityBlockerLoginRealmConfigurationTransfer;

        return $securityBlockerLoginRealmConfigurationTransfers;
    }
}
