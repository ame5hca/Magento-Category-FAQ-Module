<?php

namespace AmeshExtensions\CategoryFaq\Model;

use Magento\Framework\Model\AbstractModel;
use AmeshExtensions\CategoryFaq\Model\ResourceModel\FaqTemplate as FaqTemplateResource;

/**
 * FAQ template model class
 */
class FaqTemplate extends AbstractModel
{
    /**
     * Cache tag
     */
    public const CACHE_TAG = 'giftgp_faq_template';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'giftgp_faq_template';

    /**
     * Construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(FaqTemplateResource::class);
    }
}
