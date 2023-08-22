<?php

namespace GiftGroup\CategoryFaq\Controller\Adminhtml\Template;

use GiftGroup\CategoryFaq\Model\FaqTemplateFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class responsible for the faq template delete functionality
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var FaqTemplateFactory
     */
    private FaqTemplateFactory $faqTemplateFactory;

    /**
     * Delete construct function
     *
     * @param Context $context
     * @param FaqTemplateFactory $faqTemplateFactory
     * @return void
     */
    public function __construct(
        Context            $context,
        FaqTemplateFactory $faqTemplateFactory
    ) {
        $this->faqTemplateFactory = $faqTemplateFactory;
        parent::__construct($context);
    }

    /**
     * Execute function for delete functionality.
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $faqTemplateModel = $this->faqTemplateFactory->create();
                $faqTemplateModel->load($id);
                $faqTemplateModel->delete();
                $this->messageManager->addSuccessMessage(
                    __('You deleted the faq template.')
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
            __('We can\'t find a faq template to delete.')
        );
        return $resultRedirect->setPath('*/*/');
    }
}
