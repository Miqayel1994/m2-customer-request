<?php
 
namespace ArmMage\ReatailPrice\Plugin;

use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;

class Product
{
    protected $customerSession;
    protected $customerRepository;

    
    public function __construct(
    
        CustomerRepositoryInterface $customerRepository,        
        Session $session   
        )
        
        {
            $this-> customerSession = $session;
            $this->customerRepository = $customerRepository;

        }
        
        public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
        {
        $product =   $subject;
        $customerId = $this->customerSession->getCustomerId();
            if($customerId){
                $customer = $this->customerRepository->getById($customerId);
                // var_dump(get_class_methods($customer));die;
                $customerInfo = $customer->getCustomAttributes();
                var_dump($customerInfo);die;

                var_dump($customer->getCustomAttributes());
                var_dump(get_class_methods($customer));die;
                if($customerInfo){
                  $refPrice = $product->getData('am_ref_discount_price');
                  // var_dump($refPrice);die;
                  if($refPrice){
                    return  $refPrice;
                  }
                }
            }      
            // var_dump($result);die;
        return $result;
    }
}

 
// public function getCustomerExtensionAttribute() {
//     $customerId = 1; // Your Customer Id
//     $customer = $this->customerRepository->getById($customerId);
//     $extensionAttributes = $customer->getExtensionAttributes();
//     echo $isSubscribed = $extensionAttributes->getIsSubscribed(); // bool 
//     echo $getVertexCustomerCode = $extensionAttributes->getVertexCustomerCode(); // display vertex code if set
// }