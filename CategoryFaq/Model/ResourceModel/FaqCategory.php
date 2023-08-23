<?php

namespace AmeshExtensions\CategoryFaq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * FAQ category resource model class
 */
class FaqCategory extends AbstractDb
{
    /**
     * Construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('giftgroup_category_faq', 'id');
    }
}