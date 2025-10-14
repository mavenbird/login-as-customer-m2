<?php
namespace Mavenbird\LoginAsCustomer\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_ENABLE = 'mavenbird_loginascustomer/general/enable';

    /**
     * Check if the module is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnable($storeId = null)
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $value ? true : false;
    }
}
