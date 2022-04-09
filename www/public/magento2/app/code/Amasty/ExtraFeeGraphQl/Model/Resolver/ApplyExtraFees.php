<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Resolver;

use Amasty\Extrafee\Model\FeeRepository;
use Amasty\Extrafee\Model\ResourceModel\ExtrafeeQuote\CollectionFactory as FeeQuoteCollectionFactory;
use Amasty\Extrafee\Model\TotalsInformationManagement;
use Amasty\ExtraFeeGraphQl\Model\Utils\CartProvider;
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
use Magento\Framework\Phrase;

class ApplyExtraFees implements ResolverInterface
{
    const FEE_ID_KEY = 'fee_id';
    const OPTIONS_IDS_KEY = 'options_ids';

    /**
     * @var TotalsInformationManagement
     */
    private $totalsInformationManagement;

    /**
     * @var CartProvider
     */
    private $cartProvider;

    /**
     * @var FeeRepository
     */
    private $feeRepository;

    /**
     * @var FeeQuoteCollectionFactory
     */
    private $feeQuoteCollectionFactory;

    public function __construct(
        TotalsInformationManagement $totalsInformationManagement,
        CartProvider $cartProvider,
        FeeRepository $feeRepository,
        FeeQuoteCollectionFactory $feeQuoteCollectionFactory
    ) {
        $this->totalsInformationManagement = $totalsInformationManagement;
        $this->cartProvider = $cartProvider;
        $this->feeRepository = $feeRepository;
        $this->feeQuoteCollectionFactory = $feeQuoteCollectionFactory;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return Value|Phrase|mixed
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

        if (empty($args[self::FEE_ID_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', self::FEE_ID_KEY));
        }

        if (!isset($args[self::OPTIONS_IDS_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', self::OPTIONS_IDS_KEY));
        }

        $feeId = $args[self::FEE_ID_KEY];
        $optionIds = explode(',', $args[self::OPTIONS_IDS_KEY]);

        $cart = $this->cartProvider->getCartForUser($args[CartProvider::CART_ID_KEY], $context);
        $fee = $this->feeRepository->getById($feeId);

        if (!$this->feeRepository->validateAddress($cart, $fee)) {
            return __('Extra fee is not available for your cart.');
        }

        try {
            $this->totalsInformationManagement->proceedQuoteOptions($cart, $feeId, $optionIds);
            $this->totalsInformationManagement->updateQuoteFees($cart);
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()), $e);
        }

        if (!$args[self::OPTIONS_IDS_KEY]) {
            return __('Extra fee was canceled.');
        }

        $feeQuoteCollection = $this->feeQuoteCollectionFactory->create();
        $feeQuoteCollection->addFilterByFeeQuoteOptions($feeId, $cart->getId(), $optionIds);

        if (!$feeQuoteCollection->getSize()) {
            return __('Extra fee was not applied.');
        }

        return __('Extra fee was applied.');
    }
}
