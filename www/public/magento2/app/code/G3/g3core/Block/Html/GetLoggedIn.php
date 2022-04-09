<?php

namespace G3\g3core\Block\Html;

class GetLoggedIn {
  protected $customerSession;
 
  public function __construct(\Magento\Customer\Model\Session $customerSession) {
      $this->customerSession = $customerSession;
  }

  public function isCustomerLoggedIn() {
      return $this->_customerSession->isLoggedIn();
  }
}
