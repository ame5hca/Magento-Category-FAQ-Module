<?php

namespace AmeshExtensions\CategoryFaq\Ui\Component\Form;

use AmeshExtensions\CategoryFaq\Model\ResourceModel\FaqCategory\Collection;
use AmeshExtensions\CategoryFaq\Model\ResourceModel\FaqCategory\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

/**
 * Class to provide data to the faq form
 */
class FaqCategoryDataProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var array<mixed>|null
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $faqTemplateCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array<mixed> $meta
     * @param array<mixed> $data
     * @param PoolInterface|null $pool
     * @return void
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $faqTemplateCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $faqTemplateCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get the form data
     *
     * @return mixed[]|null
     * @throws FileSystemException
     * @throws LocalizedException
     */
    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $faqCategory) {
            $this->loadedData[$faqCategory->getId()] = $faqCategory->getData();
        }

        $data = $this->dataPersistor->get('faq_category');
        if (!empty($data)) {
            $faqCategory = $this->collection->getNewEmptyItem();
            $faqCategory->setData($data);
            $this->loadedData[$faqCategory->getId()] = $faqCategory->getData();
            $this->dataPersistor->clear('faq_category');
        }

        return $this->loadedData;
    }
}
