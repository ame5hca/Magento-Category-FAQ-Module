<?php

namespace GiftGroup\CategoryFaq\Controller\Adminhtml\FAQ;

use GiftGroup\CategoryFaq\Model\FaqCategoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class responsible for the faq category save functionality
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var FaqCategoryFactory
     */
    protected FaqCategoryFactory $faqCategoryFactory;

    /**
     * Save construct function
     *
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param FaqCategoryFactory $faqCategoryFactory
     * @return void
     */
    public function __construct(
        Context                $context,
        DataPersistorInterface $dataPersistor,
        FaqCategoryFactory     $faqCategoryFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->faqCategoryFactory = $faqCategoryFactory;
        parent::__construct($context);
    }

    /**
     * Execute function for saving the category faq
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('id');
            $faqCategoryModel = $this->faqCategoryFactory->create();
            if ($id) {
                try {
                    $faqCategoryModel->load($id);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('This faq no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            try {
                if ($id == '') {
                    unset($data['id']);
                }
                unset($data['form_key']);
                $faqCategoryModel->setData($data);
                $faqCategoryModel->save();

                $this->messageManager->addSuccessMessage(__('You saved the faq.'));
                $this->dataPersistor->clear('faq_category');
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __($e->getMessage())
                );
            }
            $this->dataPersistor->set('faq_category', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
