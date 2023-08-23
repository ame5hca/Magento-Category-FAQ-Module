<?php

namespace AmeshExtensions\CategoryFaq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * FAQ template resource model class
 */
class FaqTemplate extends AbstractDb
{
    /**
     * Construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('giftgroup_category_faq_template', 'id');
    }
}