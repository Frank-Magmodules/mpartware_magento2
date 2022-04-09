<?php

namespace G3\g3core\Block\Html;
use Magento\Backend\Block\Template\Context;
use Magento\Eav\Model\Config;

class GetGender extends \Magento\Framework\View\Element\Template {
   protected $eavConfig;

   public function __construct(
        Context $context,
        Config $eavConfig
    )
    {
        $this->eavConfig = $eavConfig;
        parent::__construct($context);

    }

    public function getCustomerGenderOptions(){
        $attribute = $this->eavConfig->getAttribute('customer','gender');
        $options = $attribute->getSource()->getAllOptions();
        return $options;
    }
}

?>
