<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Resolver;

use Amasty\ExtraFeeGraphQl\Model\Utils\CartProvider;
use Amasty\ExtraFeeGraphQl\Model\Utils\FeeQuoteCollectionProvider;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class AppliedFeeOptions implements ResolverInterface
{
    /**
     * @var CartProvider
     */
    private $cartProvider;

    /**
     * @var FeeQuoteCollectionProvider
     */
    private $feeQuoteCollectionProvider;

    public function __construct(
        CartProvider $cartProvider,
        FeeQuoteCollectionProvider $feeQuoteCollectionProvider
    ) {
        $this->cartProvider = $cartProvider;
        $this->feeQuoteCollectionProvider = $feeQuoteCollectionProvider;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|Value|mixed
     * @throws GraphQlAuthorizationException
     * @throws GraphQlInputException
     * @throws GraphQlNoSuchEntityException
     * @throws NoSuchEntityException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args[CartProvider::CART_ID_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', CartProvider::CART_ID_KEY));
        }

        $cart = $this->cartProvider->getCartForUser($args[CartProvider::CART_ID_KEY], $context);

        try {
            $totalRecords = $this->feeQuoteCollectionProvider->getFeeQuoteCollection((int)$cart->getId())->getSize();
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()), $e);
        }

        return [
            'quote_id' => (int)$cart->getId(),
            'total_records' => $totalRecords
        ];
    }
}
