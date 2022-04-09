<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_Orderattr
 */


namespace Amasty\Orderattr\Model\Indexer\Mview;

use Magento\Framework\Mview\Config;
use Magento\Framework\Mview\View\AdditionalColumnsProcessor\ProcessorFactory;

class Changelog extends \Magento\Framework\Mview\View\Changelog
{
    public function __construct(\Magento\Framework\App\ResourceConnection $resource, Config $mviewConfig, ProcessorFactory $additionalColumnsProcessorFactory)
    {
        parent::__construct($resource, $mviewConfig, $additionalColumnsProcessorFactory);
        $this->connection = $this->resource->getConnection('sales');
    }
}
