<?php
namespace ArmMage\CustomerRequest\Model\ResourceModel\CustomerRequest;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('ArmMage\CustomerRequest\Model\CustomerRequest', 'ArmMage\CustomerRequest\Model\ResourceModel\CustomerRequest');
    }
}