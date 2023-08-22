<?php

namespace GiftGroup\CategoryFaq\Model\ResourceModel\FaqTemplate;

use GiftGroup\CategoryFaq\Model\ResourceModel\FaqTemplate as FaqTemplateResource;
use GiftGroup\CategoryFaq\Model\FaqTemplate as FaqTemplateModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * FAQ template collection class
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
    protected $_eventPrefix = 'giftgp_faq_template_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'faq_template_collection';

    /**
     * Construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(FaqTemplateModel::class, FaqTemplateResource::class);
    }
}
