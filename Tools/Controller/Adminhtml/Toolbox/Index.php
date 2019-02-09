<?php
/**
 * * Copyright © Magepotato. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magepotato\Tools\Controller\Adminhtml\Toolbox;

class Index extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Magepotato_Core::magepotato');
        $resultPage->getConfig()->getTitle()->prepend(__('Potato Toolbox'));
        return $resultPage;
    }
}
