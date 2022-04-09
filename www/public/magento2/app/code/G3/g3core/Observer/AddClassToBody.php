<?php
namespace G3\g3core\Observer;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Sales\Model\OrderFactory as OrderFactory;
use Magento\Checkout\Model\Cart as CartModel;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Context as Context;
use Magento\Framework\Registry as Registry;

class AddClassToBody implements ObserverInterface
{
    /** @var PageConfig */
    protected $pageConfig;
	  /** @var CustomerSession */
    protected $customerSession;
    protected $registry;

    public function __construct(PageConfig $pageConfig, CustomerSession $customerSession, CartModel $cartModel, OrderFactory $orderFactory, Context $context, Registry $registry)
    {
        $this->pageConfig = $pageConfig;
        $this->customerSession = $customerSession;
        $this->cartModel = $cartModel;
        $this->orderFactory = $orderFactory;
        $this->context = $context;
        $this->registry = $registry;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->customerSession->isLoggedIn()) {
            $this->pageConfig->addBodyClass('customer-logged-out');
        } else {
            $this->pageConfig->addBodyClass('customer-logged-in');

            $customerData = $this->customerSession->getCustomer();

            if ($customerData->getData()['group_id'] == 1) {
                $this->pageConfig->addBodyClass('private-customer');
            } else {
                $this->pageConfig->addBodyClass('business-customer');
            }

            $this->getFirstOrder($customerData->getData()['email']);
        }

        $category = $this->registry->registry('current_category');

        if($this->context->getRequest()->getFullActionName() == 'catalog_product_view'){
            if (!is_null ($category)) {
                $this->pageConfig->addBodyClass('current-category-'.$category->getName());
            }            
        }

        $this->getTotalWeight();
    }

    public function getTotalWeight()
    {
        $items = $this->cartModel->getQuote()->getAllItems();

        $weight = 0;
        foreach($items as $item) {
            $weight += ($item->getWeight() * $item->getQty()) ;        
        }
        $weightChar = str_replace('-','.',$weight); 
        if ($weightChar > 40.0) {
            $temp = 'heavy-order';
        } else {
            $temp = 'light-order';
        }

        return $this->pageConfig->addBodyClass($temp);
    }

    public function getFirstOrder($emailId){
        $order = $this->orderFactory->create()->getCollection()->addAttributeToSelect('customer_email')
                ->addFieldToFilter('customer_email',array('eq'=>$emailId))->getFirstItem();

        if($order->getCustomerEmail()){
            $this->pageConfig->addBodyClass('regular-customer');
        }
        else{
            $this->pageConfig->addBodyClass('first-time-customer');
        }

    }
}
