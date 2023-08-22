<?php

namespace GiftGroup\CategoryFaq\Ui\Component\Listing\Column;

/**
 * Class handling the actions of the grid view
 */
class FaqActions extends Actions
{
    /**
     * Get the category faq row edit action url
     *
     * @return string
     */
    public function getEditUrl(): string
    {
        return 'category_faq/faq/edit';
    }

    /**
     * Get the category faq row delete action url
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return 'category_faq/faq/delete';
    }
}
