<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Resolver;

use Amasty\ExtraFeeGraphQl\Model\Utils\OptionCollectionProvider;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FeeOptions implements ResolverInterface
{
    const FEE_ID_KEY = 'fee_id';
    const STORE_ID_KEY = 'store_id';
    const TOTAL_RECORDS_KEY = 'total_records';

    /**
     * @var OptionCollectionProvider
     */
    private $optionCollectionProvider;

    public function __construct(OptionCollectionProvider $optionCollectionProvider)
    {
        $this->optionCollectionProvider = $optionCollectionProvider;
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
        if (empty($args[self::FEE_ID_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', self::FEE_ID_KEY));
        }

        if (empty($args[self::STORE_ID_KEY])) {
            throw new GraphQlInputException(__('Required parameter "%1" is missing', self::STORE_ID_KEY));
        }

        try {
            $totalRecords = $this->optionCollectionProvider->getOptionCollection($args[self::FEE_ID_KEY])->getSize();
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()), $e);
        }

        return [
            self::FEE_ID_KEY => $args[self::FEE_ID_KEY],
            self::STORE_ID_KEY => $args[self::STORE_ID_KEY],
            self::TOTAL_RECORDS_KEY => $totalRecords
        ];
    }
}
