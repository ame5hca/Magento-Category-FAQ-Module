<?php

namespace GiftGroup\CategoryFaq\Controller\Adminhtml\FAQ;

use GiftGroup\CategoryFaq\Model\FaqCategoryFactory;
use GiftGroup\CategoryFaq\Model\Registry\FaqCategory as FaqCategoryRegistry;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class responsible for the category faq edit form
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var FaqCategoryRegistry
     */
    private FaqCategoryRegistry $faqCategoryRegistry;

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var FaqCategoryFactory
     */
    private FaqCategoryFactory $faqCategoryFactory;

    /**
     * Edit construct function
     *
     * @param Context $context
     * @param FaqCategoryRegistry $faqCategoryRegistry
     * @param PageFactory $resultPageFactory
     * @param FaqCategoryFactory $faqCategoryFactory
     * @return void
     */
    public function __construct(
        Context             $context,
        FaqCategoryRegistry $faqCategoryRegistry,
        PageFactory         $resultPageFactory,
        FaqCategoryFactory  $faqCategoryFactory
    ) {
        $this->faqCategoryRegistry = $faqCategoryRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->faqCategoryFactory = $faqCategoryFactory;
        parent::__construct($context);
    }

    /**
     * Execute function for edit form.
     *
     * @return ResponseInterface|Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $faqCategoryModel = $this->faqCategoryFactory->create();
        $this->faqCategoryRegistry->clear();
        if ($id) {
            try {
                $faqCategoryModel->load($id);
                if (!$faqCategoryModel->getId()) {
                    throw new LocalizedException(
                        __('This faq no longer exist.')
                    );
                }
            } catch (\Exception $ex) {
                $this->messageManager->addErrorMessage($ex->getMessage());
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->faqCategoryRegistry->setFaq($faqCategoryModel);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(
            $faqCategoryModel->getId() ? __('Edit FAQ') : __('New FAQ')
        );
        return $resultPage;
    }
}
