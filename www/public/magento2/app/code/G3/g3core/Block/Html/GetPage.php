<?php

namespace G3\g3core\Block\Html;

class GetPage extends \Magento\Framework\View\Element\Template {
  protected $request;
 
  public function __construct(\Magento\Framework\App\Request\Http $request) {
    $this->_request = $request;
  }

  public function currentPage() {
    if ($this->_request->getFullActionName() == 'cms_index_index') {
      return 'home';
    }
  }
}
