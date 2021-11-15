<?php
namespace ArmMage\CustomerRequest\Controller\Adminhtml\CustomerNotification;
use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
    protected function _isAllowed()
    {
        return true;
    }

}