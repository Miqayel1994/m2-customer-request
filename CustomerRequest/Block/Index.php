<?php
namespace ArmMage\CustomerRequest\Block;
class Index extends \Magento\Framework\View\Element\Template
{
   public function getFormAction(){
      return $this->getUrl('customerrequest/index/index');
   }
}


