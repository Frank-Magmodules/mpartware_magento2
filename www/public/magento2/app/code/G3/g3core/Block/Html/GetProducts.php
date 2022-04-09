<?php

namespace G3\g3core\Block\Html;
use Magento\Catalog\Block\Product\ListProduct;
class GetProducts extends \Magento\Framework\View\Element\Template {

    protected $_productCollectionFactory;
    protected $imageHelperFactory;
    protected $taxCalculation;
    protected $scopeConfig;
    protected $_productFactory;
        
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Block\Product\ListProduct $listProductBlock,
        \Magento\Catalog\Helper\ImageFactory $imageHelperFactory,   
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Tax\Api\TaxCalculationInterface $taxCalculation,     
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\CatalogInventory\Model\StockRegistry $stockRegistry,
        array $data = []
    )
    {    
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->productRepository = $productRepository; 
        $this->listProductBlock = $listProductBlock; 
        $this->imageHelperFactory = $imageHelperFactory;
        $this->scopeConfig = $scopeConfig;
        $this->taxCalculation = $taxCalculation;       
        $this->_productFactory = $productFactory;    
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->stockRegistry = $stockRegistry;        
        parent::__construct($context, $data);
    }
    
    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        //$collection->setPageSize(3); // fetching only 3 products
        return $collection;
    }

    public function getAddToCartPostParams($product)
    {
        return $this->listProductBlock->getAddToCartPostParams($product);
    }

    public function getProductPrice($product)
    {
        return $this->listProductBlock->getProductPrice($product);
    }

    public function getProductImageUrl($product)
    {
        $product = $this->productRepository->getById($product);
        return $this->imageHelperFactory->create()->init($product, 'category_page_grid')->getUrl();
    }

    public function getProductImages($productID) {
        $_product = $this->_productFactory->create()->load($productID);
        $productImages = $_product->getMediaGalleryImages();
        return $productImages;
    }

    public function getPriceInclAndExclTax($product)
    {
        //$product = $this->productRepository->getById($productId);
        //var_dump($product);
        
        if ($taxAttribute = $product->getCustomAttribute('tax_class_id')) {
            // First get base price (=price excluding tax)
            $productRateId = $taxAttribute->getValue();
            $rate = $this->taxCalculation->getCalculatedRate($productRateId);
    
            if ((int) $this->scopeConfig->getValue(
                'tax/calculation/price_includes_tax', 
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE) === 1
            ) {
                // Product price in catalog is including tax.
                $priceExcludingTax = $product->getPrice() / (1 + ($rate / 100));
            } else {
                // Product price in catalog is excluding tax.
                $priceExcludingTax = $product->getPrice();
            }
    
            $priceIncludingTax = $priceExcludingTax + ($priceExcludingTax * ($rate / 100));
    
            return [
                'incl' => $priceIncludingTax,
                'excl' => $priceExcludingTax
            ];
        }
    
        throw new LocalizedException(__('Tax Attribute not found'));
    }

    public function getStockStatus($sku)
    {
        $stockData = null;
        try {
            $stockStatus = $this->stockRegistry->getStockStatusBySku(
                $sku,
                $this->storeManager->getWebsite()->getId()
            );
 
            $stockData = $stockStatus->getStockItem();
 
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
        return $stockData;
    }

    public function getConfigChildProductIds($id){
        $product = $this->productRepository->getById($id);
        //https://magento.stackexchange.com/questions/117783/getting-simple-products-from-configurable/155252#155252
        $childProducts = $product->getTypeInstance()->getUsedProducts($product);

        return $childProducts;
    }
}