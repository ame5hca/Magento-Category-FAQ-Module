<?php

namespace AmeshExtensions\CategoryFaq\Ui\Component\Listing\Column;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class to display category name instead of id in grid
 */
class Category extends Column
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $categoryCollectionFactory;

    /**
     * Category construct function
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CollectionFactory $categoryCollectionFactory
     * @param array $components
     * @param array $data
     * @return void
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        CollectionFactory  $categoryCollectionFactory,
        array              $components = [],
        array              $data = []
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Column value modifier function
     *
     * @param array<mixed> $dataSource
     * @return array<mixed>
     */
    public function prepareDataSource(array $dataSource): array
    {
        $fieldName = $this->getData('name');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$fieldName] = $this->getCategoryNameById($item[$fieldName]);
            }
        }
        return $dataSource;
    }

    /**
     * Get the category name from id
     *
     * @param int|string $categoryId
     * @return mixed
     */
    private function getCategoryNameById($categoryId): mixed
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addFieldToSelect('name');
        $collection->addFieldToFilter('entity_id', ['eq' => $categoryId]);
        if ($collection->getSize()) {
            return $collection->getFirstItem()->getName();
        }
        return $categoryId;
    }
}
