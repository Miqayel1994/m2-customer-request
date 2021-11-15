<?php
namespace ArmMage\CustomerRequest\Controller\Adminhtml\CustomerNotification;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

    protected function _isAllowed()
    {
        return true;
    }


}