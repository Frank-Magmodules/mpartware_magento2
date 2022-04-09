<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Resolver;

use Amasty\Extrafee\Model\FeesInformationManagement;
use Amasty\ExtraFeeGraphQl\Model\Utils\CartProvider;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class QuoteFeeItems implements ResolverInterface
{
    /**
     * @var FeesInformationManagement
     */
    private $feesInformationManagement;

    /**
     * @var CartProvider
     */
    private $cartProvider;

    public function __construct(FeesInformationManagement $feesInformationManagement, CartProvider $cartProvider)
    {
        $this->feesInformationManagement = $feesInformationManagement;
        $this->cartProvider = $cartProvider;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|Value|mixed
     * @throws GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args[CartProvider::CART_ID_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', CartProvider::CART_ID_KEY));
        }

        $cart = $this->cartProvider->getCartForUser($args[CartProvider::CART_ID_KEY], $context);

        try {
            $feesItems = $this->feesInformationManagement->collectQuote($cart);
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()), $e);
        }

        return $feesItems;
    }
}
