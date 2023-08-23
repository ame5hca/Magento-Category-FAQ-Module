<?php

namespace AmeshExtensions\CategoryFaq\Model;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory as MostViewedProductsCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class render the shortcodes in the FAQ
 */
class CategoryShortcodeRender
{
    private const PRODUCT_LIST_LIMIT = 4;

    /**
     * @var CategoryRepositoryInterface
     */
    private CategoryRepositoryInterface $categoryRepository;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    
    /**
     * @var MostViewedProductsCollectionFactory
     */
    private MostViewedProductsCollectionFactory $mostViewedProductCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * CategoryShortcodeRender construct function
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param LoggerInterface $logger
     * @param MostViewedProductsCollectionFactory $mostViewedProductCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @return void
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        LoggerInterface             $logger,
        MostViewedProductsCollectionFactory $mostViewedProductCollectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
        $this->mostViewedProductCollectionFactory = $mostViewedProductCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Render the short codes with the corresponding category data.
     *
     * @param string $data
     * @param int|string $categoryId
     * @return string|array<mixed>|string[]
     */
    public function render($data, $categoryId): string|array
    {
        try {
            $category = $this->categoryRepository->get($categoryId);
        } catch (\Exception $e) {
            $this->logger->info('FAQ Error = ' . $e->getMessage());
        }
        $data = str_replace('{name}', $category->getName(), $data);
        $data = str_replace('{url}', $category->getUrl(), $data);
        $data = $this->renderLowPriceProductListShortCode($category, $data);
        return $this->renderMostViewedProductListShortCode($category, $data);
    }

    /**
     * Generate the low price product list for a short code.
     *
     * @param object $category
     * @param string $data
     * @return string|array<mixed>|string[]
     */
    private function renderLowPriceProductListShortCode($category, $data): string|array
    {
        if (str_contains($data, '{generate_low_price_products_list}')) {
            $productCollection = $category->getProductCollection();
            $productCollection->addAttributeToSelect(['name', 'url', 'price']);
            $productCollection->setOrder('price', 'ASC');
            $productCollection->setPageSize(self::PRODUCT_LIST_LIMIT);
            $productCollection->setCurPage('1');
            if ($productCollection->getSize()) {
                $data .= '<br/><ol>';
                foreach ($productCollection as $product) {
                    $data .= '<li><a href="' . $product->getProductUrl() . '">' . $product->getName() . '</a></li>';
                }
                $data .= '</ol>';
            }
            $data = str_replace('{generate_low_price_products_list}', '', $data);
        }
        return $data;
    }
    
    /**
     * Generate most viewed product list for a short code.
     *
     * @param object $category
     * @param string $data
     * @return string|array<mixed>|string[]
     */
    private function renderMostViewedProductListShortCode($category, $data): string|array
    {
        if (str_contains($data, '{generate_most_viewed_products_list}')) {
            $storeId = $this->storeManager->getStore()->getId();
            $collection = $this->mostViewedProductCollectionFactory->create();
            $collection->addAttributeToSelect('*');
            $collection->addCategoryFilter($category);
            $collection->addViewsCount();
            $collection->setStoreId($storeId)->addStoreFilter($storeId);
            $collection->setPageSize(self::PRODUCT_LIST_LIMIT);
            $collection->setCurPage(1);

            $items = $collection->getItems();
            if (count($items)) {
                $data .= '<br/><ol>';
                foreach ($items as $product) {
                    $data .= '<li><a href="' . $product->getProductUrl() . '">' . $product->getName() . '</a></li>';
                }
                $data .= '</ol>';
            }
            $data = str_replace('{generate_most_viewed_products_list}', '', $data);
        }
        return $data;
    }
}
