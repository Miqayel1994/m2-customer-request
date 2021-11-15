<?php

namespace ArmMage\CustomerRequest\Controller\Account;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use ArmMage\CustomerRequest\Model\CustomerRequestFactory;
use Magento\Customer\Model\Session;
class SendRequest extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $customerSession;

    /**
     * @param Context                                             $context
     * @param PageFactory                                         $resultPageFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Magezon\CustomerAttachments\Helper\Data            $dataHelper
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Session $session,
		CustomerRequestFactory $customerRequestfactory

    )
    {
        $this-> customerSession = $session;
        $this->resultPageFactory    = $resultPageFactory;
        $this->_customerRequestFactory    = $customerRequestfactory;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\View\Result\Page
     */


    public function execute()
    {
        if($this->customerSession->isLoggedIn()  ) {
            $text1 = $this->getRequest()->getPost('text');
            $customerObject = $this->customerSession->getCustomer();
            $name = $customerObject->getFirstname();
            $email = $customerObject->getEmail();
            $model = $this->_customerRequestFactory->create();
			$exists = $this->validateEmail( $model,  $email );
            if (!$exists){
            $model->setData([
                             'name'=> $name , 
                             'email'=> $email,
                             'text'=> $text1                            
                            ]);
            $model->save();           
            }else{
                $loadedModel = $this->getModelByEmail( $model , $email );
                // var_dump($loadedModel->getId());die;
                $model = $model->load($loadedModel->getId());
                $model->setText($text1);
                $model->save();
            } 
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Custom'));
        return $resultPage;
    }
    
    protected function validateEmail($model,  $email){
		$collection = $model->getCollection();
		$collection->addFieldToFilter('email', $email);
		return $collection->getSize() ? 1:0;
	}
    protected function getModelByEmail($model , $email){
        $collection = $model->getCollection();
        $loadedModel =  $collection->addFieldToFilter('email',$email)->getFirstItem();
        return $loadedModel;
    }
}