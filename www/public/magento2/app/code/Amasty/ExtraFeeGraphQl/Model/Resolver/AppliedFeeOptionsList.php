<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Resolver;

use Amasty\ExtraFeeGraphQl\Model\Utils\FeeQuoteCollectionProvider;
use Magento\Framework\DataObject;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;

class AppliedFeeOptionsList implements ResolverInterface
{
    /**
     * @var GetCartForUser
     */
    private $getCartForUser;

    /**
     * @var FeeQuoteCollectionProvider
     */
    private $feeQuoteCollectionProvider;

    public function __construct(
        GetCartForUser $getCartForUser,
        FeeQuoteCollectionProvider $feeQuoteCollectionProvider
    ) {
        $this->getCartForUser = $getCartForUser;
        $this->feeQuoteCollectionProvider = $feeQuoteCollectionProvider;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return DataObject[]|Value|mixed
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        return $this->feeQuoteCollectionProvider->getFeeQuoteCollection($value['quote_id'])->getItems();
    }
}
