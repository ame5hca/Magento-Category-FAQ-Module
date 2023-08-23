<?php

namespace AmeshExtensions\CategoryFaq\Controller\Adminhtml\Template;

use AmeshExtensions\CategoryFaq\Model\Registry\FaqTemplate as FaqTemplateRegistry;
use AmeshExtensions\CategoryFaq\Model\FaqTemplateFactory;
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
 * Class responsible for the faq templates edit form
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var FaqTemplateRegistry
     */
    private FaqTemplateRegistry $faqTemplateRegistry;

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var FaqTemplateFactory
     */
    private FaqTemplateFactory $faqTemplateFactory;

    /**
     * Edit construct function
     *
     * @param Context $context
     * @param FaqTemplateRegistry $faqTemplateRegistry
     * @param PageFactory $resultPageFactory
     * @param FaqTemplateFactory $faqTemplateFactory
     * @return void
     */
    public function __construct(
        Context             $context,
        FaqTemplateRegistry $faqTemplateRegistry,
        PageFactory         $resultPageFactory,
        FaqTemplateFactory  $faqTemplateFactory
    ) {
        $this->faqTemplateRegistry = $faqTemplateRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->faqTemplateFactory = $faqTemplateFactory;
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
        $faqTemplateModel = $this->faqTemplateFactory->create();
        $this->faqTemplateRegistry->clear();
        if ($id) {
            try {
                $faqTemplateModel->load($id);
                if (!$faqTemplateModel->getId()) {
                    throw new LocalizedException(
                        __('This faq template no longer exist.')
                    );
                }
            } catch (\Exception $ex) {
                $this->messageManager->addErrorMessage($ex->getMessage());
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->faqTemplateRegistry->setTemplateData($faqTemplateModel);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(
            $faqTemplateModel->getId() ? __('Edit FAQ Template') : __('New FAQ Template')
        );
        return $resultPage;
    }
}
