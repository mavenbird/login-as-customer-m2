<?php
namespace Mavenbird\LoginAsCustomer\Ui\Component\Listing\Column;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Mavenbird\LoginAsCustomer\Helper\Data;

class LoginAsCustomer extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Data
     */
    protected $dataHelper;

    protected $storeManager;

    /**
     * LoginAsCustomer constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Data $dataHelper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
        $this->dataHelper = $dataHelper;

        if (!$this->dataHelper->isEnable()) {
            unset($data);
            $data = [];
        }
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }

        return $dataSource;
    }
    /**
     * Prepare item
     *
     * @param array $item
     * @return string
     */
    protected function prepareItem($item)
    {
        $frontendUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK)
            . 'loginascustomer/customer/login/id/' . $item['entity_id'];

        return '<a href="' . $frontendUrl . '" target="_blank">
                    Login As Customer
                </a>';
    }
}
