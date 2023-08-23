<?php

namespace AmeshExtensions\CategoryFaq\Model;

/**
 * Class to provide the FAQ data.
 */
class Faq
{
    /**
     * @var ResourceModel\FaqCategory\CollectionFactory
     */
    private ResourceModel\FaqCategory\CollectionFactory $faqCategoryCollectionFactory;

    /**
     * @var ResourceModel\FaqTemplate\CollectionFactory
     */
    private ResourceModel\FaqTemplate\CollectionFactory $faqTemplateCollectionFactory;

    /**
     * Faq construct function
     *
     * @param ResourceModel\FaqCategory\CollectionFactory $faqCategoryCollectionFactory
     * @param ResourceModel\FaqTemplate\CollectionFactory $faqTemplateCollectionFactory
     * @return void
     */
    public function __construct(
        ResourceModel\FaqCategory\CollectionFactory $faqCategoryCollectionFactory,
        ResourceModel\FaqTemplate\CollectionFactory $faqTemplateCollectionFactory
    ) {
        $this->faqCategoryCollectionFactory = $faqCategoryCollectionFactory;
        $this->faqTemplateCollectionFactory = $faqTemplateCollectionFactory;
    }

    /**
     * Get the category FAQ from the category id. If there is no category specific FAQ is added,
     * then the general template for FAQ will be returned.
     *
     * @param int|string $categoryId
     * @return ResourceModel\FaqCategory\Collection|ResourceModel\FaqTemplate\Collection
     */
    public function getCategoryFaqs($categoryId)
    {
        $faqCollection = $this->getFaqCategoryCollection($categoryId);
        if ($faqCollection->getSize()) {
            return $faqCollection;
        }
        return $this->getFaqTemplateCollection();
    }

    /**
     * Get the FAQ category collection
     *
     * @param int|string $categoryId
     * @return ResourceModel\FaqCategory\Collection
     */
    public function getFaqCategoryCollection($categoryId): ResourceModel\FaqCategory\Collection
    {
        $collection = $this->faqCategoryCollectionFactory->create();
        $collection->addFieldToFilter('is_active', ['eq' => 1]);
        $collection->addFieldToFilter('category_id', ['eq' => $categoryId]);
        return $collection;
    }
    
    /**
     * Get the FAQ template collection
     *
     * @return ResourceModel\FaqTemplate\Collection
     */
    public function getFaqTemplateCollection(): ResourceModel\FaqTemplate\Collection
    {
        $collection = $this->faqTemplateCollectionFactory->create();
        $collection->addFieldToFilter('is_active', ['eq' => 1]);
        return $collection;
    }
}
