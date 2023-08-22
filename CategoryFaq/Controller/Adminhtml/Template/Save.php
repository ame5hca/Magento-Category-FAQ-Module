<?php

namespace GiftGroup\CategoryFaq\Controller\Adminhtml\Template;

use GiftGroup\CategoryFaq\Model\FaqTemplateFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class responsible for the faq template save functionality
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var FaqTemplateFactory
     */
    protected FaqTemplateFactory $faqTemplateFactory;

    /**
     * Save construct function
     *
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param FaqTemplateFactory $faqTemplateFactory
     * @return void
     */
    public function __construct(
        Context                $context,
        DataPersistorInterface $dataPersistor,
        FaqTemplateFactory     $faqTemplateFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->faqTemplateFactory = $faqTemplateFactory;
        parent::__construct($context);
    }

    /**
     * Execute function for saving the faq template
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('id');
            $faqTemplateModel = $this->faqTemplateFactory->create();
            if ($id) {
                try {
                    $faqTemplateModel->load($id);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('This faq template no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            try {
                if ($id == '') {
                    unset($data['id']);
                }
                unset($data['form_key']);
                $faqTemplateModel->setData($data);
                $faqTemplateModel->save();

                $this->messageManager->addSuccessMessage(__('You saved the faq template.'));
                $this->dataPersistor->clear('faq_template');
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __($e->getMessage())
                );
            }
            $this->dataPersistor->set('faq_template', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
