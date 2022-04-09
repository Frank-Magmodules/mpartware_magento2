<?php
/*
const ID = 'id';
const CONFIRMATION = 'confirmation';
const CREATED_AT = 'created_at';
const UPDATED_AT = 'updated_at';
const CREATED_IN = 'created_in';
const DOB = 'dob';
const EMAIL = 'email';
const FIRSTNAME = 'firstname';
const GENDER = 'gender';
const GROUP_ID = 'group_id';
const LASTNAME = 'lastname';
const MIDDLENAME = 'middlename';
const PREFIX = 'prefix';
const STORE_ID = 'store_id';
const SUFFIX = 'suffix';
const TAXVAT = 'taxvat';
const WEBSITE_ID = 'website_id';
const DEFAULT_BILLING = 'default_billing';
const DEFAULT_SHIPPING = 'default_shipping';
const KEY_ADDRESSES = 'addresses';
const DISABLE_AUTO_GROUP_CHANGE = 'disable_auto_group_change';
*/
namespace G3\g3core\Block\Html;

class GetCustomerInfo extends \Magento\Framework\View\Element\Template {
    protected $_customerSession;
    protected $_customer;
    protected $_page;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Magento\Customer\Model\Session $customer,
        \Magento\Cms\Model\Page $page,
        array $data = []
        ) {
        $this->_customerSession = $customerSession->create();
        $this->_customer = $customer;
        $this->_page = $page;
        parent::__construct($context, $data);
    }

    public function getCustomerLastName(){
        if($this->_customerSession->isLoggedIn()){
            return $this->_customer->getCustomerData()->getLastName();
        }
    }

    public function getCustomerGender(){
        if($this->_customerSession->isLoggedIn()){
            return $this->_customer->getCustomerData()->getGender();
        }
    }

    public function getPageID() {
        if ($this->_page->getId()) {
            $pageId = $this->_page->getId();
        }
    }

    public function userIsLoggedIn() {
        return $this->_customerSession->isLoggedIn();
    }

    public function getUserTaxvat() {
        return $this->_customerSession->getTaxvat();
    }
}
