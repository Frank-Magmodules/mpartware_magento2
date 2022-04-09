<?php

namespace G3\AlgoliasearchCustomizer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class UpdateFrontendConfiguration implements ObserverInterface
{
    public function __construct()
    {
    }

    public function execute(Observer $observer)
    {
        $configuration = $observer->getData('configuration');
        
        // var_dump('<pre>');
        // var_dump($configuration);
        // var_dump('</pre>');
        // die();
    }
}
