<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2021 Amasty (https://www.amasty.com)
 * @package Amasty_ExtraFeeGraphQl
 */


namespace Amasty\ExtraFeeGraphQl\Model\Resolver;

use Amasty\Base\Model\Serializer;
use Amasty\Extrafee\Model\OptionManager;
use Amasty\ExtraFeeGraphQl\Model\Utils\OptionCollectionProvider;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FeeOptionsList implements ResolverInterface
{
    /**
     * @var OptionCollectionProvider
     */
    private $optionCollectionProvider;

    /**
     * @var OptionManager
     */
    private $optionManager;

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(
        OptionCollectionProvider $optionCollectionProvider,
        OptionManager $optionManager,
        Serializer $serializer
    ) {
        $this->optionCollectionProvider = $optionCollectionProvider;
        $this->optionManager = $optionManager;
        $this->serializer = $serializer;
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
        $result = [];
        $optionCollection = $this->optionCollectionProvider->getOptionCollection($value[FeeOptions::FEE_ID_KEY]);

        foreach ($optionCollection->getItems() as $option) {
            $optionLabels = $this->serializer->unserialize($option->getOptionsSerialized());
            $label = $this->optionManager->getOptionLabel($value[FeeOptions::STORE_ID_KEY], $optionLabels);
            $result[] = $option->setLabel($label);
        }

        return $result;
    }
}
