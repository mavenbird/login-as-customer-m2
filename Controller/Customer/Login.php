<?php
namespace Mavenbird\LoginAsCustomer\Controller\Customer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Login extends Action
{
    protected $customerRepository;
    protected $customerSession;
    protected $messageManager;
    protected $resultRedirectFactory;

    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        Session $customerSession,
        ManagerInterface $messageManager,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $customerId = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($customerId) {
            try {
                $customer = $this->customerRepository->getById($customerId); // CustomerInterface
                $this->customerSession->setCustomerDataAsLoggedIn($customer);
                $this->customerSession->regenerateId();

                $this->messageManager->addSuccessMessage(__('You are now logged in as %1', $customer->getFirstname() . ' ' . $customer->getLastname()));
                return $resultRedirect->setPath('customer/account');
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Customer not found.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Customer ID missing.'));
        }

        return $resultRedirect->setPath('/');
    }
}
