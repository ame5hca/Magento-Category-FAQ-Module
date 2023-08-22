<?php

namespace GiftGroup\CategoryFaq\Ui\Component\Listing\Column;

/**
 * Class handling the actions of the grid view
 */
class FaqTemplateActions extends Actions
{
    /**
     * Get the faq template row edit action url
     *
     * @return string
     */
    public function getEditUrl(): string
    {
        return 'category_faq/template/edit';
    }

    /**
     * Get the faq template row delete action url
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return 'category_faq/template/delete';
    }
}
