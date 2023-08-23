<?php

namespace AmeshExtensions\CategoryFaq\Model;

use Magento\Framework\Model\AbstractModel;
use AmeshExtensions\CategoryFaq\Model\ResourceModel\FaqCategory as FaqCategoryResource;

/**
 * FAQ category model class
 */
class FaqCategory extends AbstractModel
{
    /**
     * Cache tag
     */
    public const CACHE_TAG = 'giftgp_faq_category';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'giftgp_faq_category';

    /**
     * Construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(FaqCategoryResource::class);
    }
}
