<?php
namespace G3\g3core\Block\Html;
class Categorylist extends \Magento\Framework\View\Element\Template
{
    protected $_categoryCollectionFactory;
    protected $_categoryHelper;
    protected $_storeManager;
    protected $_categoryRepository;

    private $_layerResolver;

    protected $_categoryFactory;
    protected $_category;

    protected $_productRepository;
    protected $_registry;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryHelper = $categoryHelper;
        $this->_storeManager = $storeManager;
        $this->_categoryRepository = $categoryRepository;
        $this->_layerResolver = $layerResolver;
        $this->_categoryFactory = $categoryFactory;
        $this->_productRepository = $productRepository;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false) {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setStore($this->_storeManager->getStore()->getId());

        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }

        // select categories of certain level
        if ($level) {
            $collection->addLevelFilter($level);
        }

        // sort categories by some value
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }

        // set pagination
        if ($pageSize) {
            $collection->setPageSize($pageSize);
        }

        return $collection;
    }

    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true) {
        return $this->_categoryHelper->getStoreCategories($sorted = false, $asCollection = false, $toLoad = true);
    }

    public function getParentId($categoryId = false) {
        return $this->getCategory($categoryId)->getParentId();
    }

    public function getAllChildren($parent_category_id = null) {
        if (is_null($parent_category_id)) $parent_category_id = 3;
        $categoryObj = $this->_categoryRepository->get($parent_category_id);
        $subCategories = $categoryObj->getChildrenCategories();
        return $subCategories;
    }

    public function getCurrentCategory() {
        return $this->_layerResolver->get()->getCurrentCategory();
    }


    public function getCategory($categoryId) {
        $this->_category = $this->_categoryFactory->create();
        $this->_category->load($categoryId);
        return $this->_category;
    }

    public function getChildren($categoryId = false) {
        if ($this->_category) {
            return $this->_category->getChildren();
        } else {
            return $this->getCategory($categoryId)->getChildren();
        }
    }

    public function getParentCategory($categoryId = false) {
        if ($this->_category) {
            return $this->_category->getParentCategory();
        } else {
            return $this->getCategory($categoryId)->getParentCategory();        
        }        
    }

    public function getProductById($id) {        
        return $this->_productRepository->getById($id);
    }
    
    public function getCurrentProduct() {        
        return $this->_registry->registry('current_product');
    }
}
