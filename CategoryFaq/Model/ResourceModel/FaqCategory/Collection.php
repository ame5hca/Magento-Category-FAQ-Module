<?php

namespace AmeshExtensions\CategoryFaq\Model\ResourceModel\FaqCategory;

use AmeshExtensions\CategoryFaq\Model\ResourceModel\FaqCategory as FaqCategoryResource;
use AmeshExtensions\CategoryFaq\Model\FaqCategory as FaqCategoryModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * FAQ category collection class
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'giftgp_faq_category_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'faq_category_collection';

    /**
     * Construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(FaqCategoryModel::class, FaqCategoryResource::class);
    }
}
