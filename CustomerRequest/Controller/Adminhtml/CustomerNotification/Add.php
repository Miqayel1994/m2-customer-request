<?php
namespace ArmMage\CustomerRequest\Controller\Adminhtml\CustomerNotification;
use Magento\Backend\App\Action;

class Add extends \Magento\Backend\App\Action
{
    public function execute()
    {
       die('test add');
    }

    protected function _isAllowed()
    {
        return true;
    }


}