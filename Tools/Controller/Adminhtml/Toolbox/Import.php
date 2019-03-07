<?php
/**
 * * Copyright © Magepotato. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magepotato\Tools\Controller\Adminhtml\Toolbox;

class Import extends \Magento\Backend\App\Action
{
    protected $helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magepotato\Tools\Helper\FileDataManager $helper
    ){
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        $file = $this->getRequest()->getFiles('import_file');
        $type = $this->getRequest()->getPost('import_type');
        try {
            list($total, $processed) = $this->helper->import($file, $type);
            $this->messageManager->addSuccess(__('Imported %1 out of %2 records', $total, $processed));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
