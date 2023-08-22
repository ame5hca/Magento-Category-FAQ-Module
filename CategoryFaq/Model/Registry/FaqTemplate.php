<?php

namespace GiftGroup\CategoryFaq\Model\Registry;

/**
 * Class is responsible for serving the faq template data.
 * Get and set method of the class will be doing the functionality.
 */
class FaqTemplate
{
    /**
     * @var mixed
     */
    private $faqTemplateData = null;

    /**
     * Get the faq template data
     *
     * @return mixed
     */
    public function getTemplateData(): mixed
    {
        return $this->faqTemplateData;
    }

    /**
     * Set the faq template data
     *
     * @param mixed $data
     * @return $this
     */
    public function setTemplateData($data): static
    {
        $this->faqTemplateData = $data;
        return $this;
    }

    /**
     * Clear the data
     *
     * @return $this
     */
    public function clear(): static
    {
        $this->faqTemplateData = null;
        return $this;
    }
}
