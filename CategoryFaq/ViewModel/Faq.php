<?php

namespace AmeshExtensions\CategoryFaq\ViewModel;

use AmeshExtensions\CategoryFaq\Model\ResourceModel\FaqCategory\Collection as FaqCategoryCollection;
use AmeshExtensions\CategoryFaq\Model\ResourceModel\FaqTemplate\Collection as FaqTemplateCollection;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\RequestInterface;
use AmeshExtensions\CategoryFaq\Model\Faq as FaqModel;
use AmeshExtensions\CategoryFaq\Model\CategoryShortcodeRender;

/**
 * Class to provide the FAQ data to frontend view
 */
class Faq implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var FaqModel
     */
    private FaqModel $faq;

    /**
     * @var CategoryShortcodeRender
     */
    private CategoryShortcodeRender $shortcodeRender;

    /**
     * Faq construct function
     *
     * @param RequestInterface $request
     * @param FaqModel $faq
     * @param CategoryShortcodeRender $shortcodeRender
     * @return void
     */
    public function __construct(
        RequestInterface        $request,
        FaqModel                $faq,
        CategoryShortcodeRender $shortcodeRender
    ) {
        $this->request = $request;
        $this->faq = $faq;
        $this->shortcodeRender = $shortcodeRender;
    }

    /**
     * Get the current category FAQ's
     *
     * @return FaqCategoryCollection|FaqTemplateCollection|null
     */
    public function getCurrentCategoryFaqs(): FaqTemplateCollection|FaqCategoryCollection|null
    {
        $categoryId = $this->request->getParam('id', false);
        if ($categoryId) {
            return $this->faq->getCategoryFaqs($categoryId);
        }
        return null;
    }

    /**
     * Render the shortcodes in the data
     *
     * @param string $data
     * @return array|mixed[]|string|string[]
     */
    public function renderShortCodes($data): array|string
    {
        $categoryId = $this->request->getParam('id', false);
        return $this->shortcodeRender->render($data, $categoryId);
    }

    /**
     * Show/hide FAQ section. Hide the FAQ section from 2nd page
     *
     * @return bool
     */
    public function showFaq()
    {
        $pageNo = (int)$this->request->getParam('p', 0);
        if ($pageNo > 1) {
            return false;
        }
        return true;
    }
}
