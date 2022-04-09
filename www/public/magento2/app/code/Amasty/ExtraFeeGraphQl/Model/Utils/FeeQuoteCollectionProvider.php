<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Utils;

use Amasty\Extrafee\Model\ResourceModel\ExtrafeeQuote\CollectionFactory as FeeQuoteCollectionFactory;
use Amasty\Extrafee\Model\ResourceModel\ExtrafeeQuote\Collection;

class FeeQuoteCollectionProvider
{
    /**
     * @var FeeQuoteCollectionFactory
     */
    private $feeQuoteCollectionFactory;

    public function __construct(FeeQuoteCollectionFactory $feeQuoteCollectionFactory)
    {
        $this->feeQuoteCollectionFactory = $feeQuoteCollectionFactory;
    }

    /**
     * @param int $cartId
     * @return Collection
     */
    public function getFeeQuoteCollection(int $cartId): Collection
    {
        return $this->feeQuoteCollectionFactory->create()
            ->addFieldToFilter('option_id', ['neq' => '0'])
            ->addFieldToFilter('quote_id', $cartId);
    }
}
