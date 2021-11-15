<?php
namespace ArmMage\CustomerRequest\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class CustomerRequest extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('am_customer_request', 'id');
    }
   
}