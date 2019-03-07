<?php
/**
 * * Copyright © Magepotato. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magepotato\Tools\Controller\Adminhtml\Toolbox;

class Export extends \Magento\Backend\App\Action
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
        $type = $this->getRequest()->getParam('type');
        try {
            $this->helper->export($type, true);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_RAW);
    }
}
