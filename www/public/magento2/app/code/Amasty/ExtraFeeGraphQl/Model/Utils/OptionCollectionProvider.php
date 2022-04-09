<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Utils;

use Amasty\ExtraFeeGraphQl\Model\Resolver\FeeOptions;
use Amasty\Extrafee\Model\ResourceModel\Option\Collection;
use Amasty\Extrafee\Model\ResourceModel\Option\CollectionFactory;

class OptionCollectionProvider
{
    /**
     * @var CollectionFactory
     */
    private $optionCollectionFactory;

    public function __construct(CollectionFactory $optionCollectionFactory)
    {
        $this->optionCollectionFactory = $optionCollectionFactory;
    }

    /**
     * @param int $feeId
     * @return Collection
     */
    public function getOptionCollection(int $feeId): Collection
    {
        return $this->optionCollectionFactory->create()
            ->addFieldToFilter(FeeOptions::FEE_ID_KEY, $feeId);
    }
}
