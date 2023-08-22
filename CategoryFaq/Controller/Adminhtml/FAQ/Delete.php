<?php

namespace GiftGroup\CategoryFaq\Controller\Adminhtml\FAQ;

use GiftGroup\CategoryFaq\Model\FaqCategoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class responsible for the faq delete functionality
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var FaqCategoryFactory
     */
    private FaqCategoryFactory $faqCategoryFactory;

    /**
     * Delete construct function
     *
     * @param Context $context
     * @param FaqCategoryFactory $faqCategoryFactory
     * @return void
     */
    public function __construct(
        Context            $context,
        FaqCategoryFactory $faqCategoryFactory
    ) {
        $this->faqCategoryFactory = $faqCategoryFactory;
        parent::__construct($context);
    }

    /**
     * Execute function for delete.
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $faqCategoryModel = $this->faqCategoryFactory->create();
                $faqCategoryModel->load($id);
                $faqCategoryModel->delete();
                $this->messageManager->addSuccessMessage(
                    __('You deleted the faq.')
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    $e->getMessage()
                );
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(
            __('We can\'t find a faq to delete.')
        );
        return $resultRedirect->setPath('*/*/');
    }
}
