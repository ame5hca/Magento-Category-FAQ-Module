<?php

namespace AmeshExtensions\CategoryFaq\Model\Registry;

/**
 * Class is responsible for serving the faq category data.
 * Get and set method of the class will be doing the functionality.
 */
class FaqCategory
{
    /**
     * @var mixed
     */
    private $faqCategoryData = null;

    /**
     * Get the faq category data
     *
     * @return mixed
     */
    public function getFaq(): mixed
    {
        return $this->faqCategoryData;
    }

    /**
     * Set the faq category data
     *
     * @param mixed $data
     * @return $this
     */
    public function setFaq($data): static
    {
        $this->faqCategoryData = $data;
        return $this;
    }

    /**
     * Clear the data
     *
     * @return $this
     */
    public function clear(): static
    {
        $this->faqCategoryData = null;
        return $this;
    }
}
