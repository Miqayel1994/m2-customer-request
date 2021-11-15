<?php
namespace ArmMage\CustomerRequest\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class CustomerRequest extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('ArmMage\CustomerRequest\Model\ResourceModel\CustomerRequest');
    }
}