<?php
namespace ArmMage\CustomerRequest\Controller\Adminhtml\CustomerNotification;
use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    protected $_model;
	protected $_customerRequestFactory;

    public function __construct(
        Action\Context $context,
        \ArmMage\CustomerRequest\Model\CustomerRequest $model,
        \ArmMage\CustomerRequest\Model\CustomerRequestFactory $customerRequestfactory
        )
    {
        parent::__construct($context);
        $this->_model = $model;
		$this->_customerRequestFactory = $customerRequestfactory;

    }

    protected function _isAllowed()
    {
        return true;
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id){
                if ($params){
                
                    $customers = $this->_customerRequestFactory->create();    
			    	$exists = $this->validateEmail( $customers,  $params );
                    if(!$exists){ 
                    try{
                        $model = $this->_model;
                        $model->load($id);
                        $model->setData('name',$params['name'])->setData('email',$params['email'])->save();
                    }
                    catch (\Exception $e) {
                        $this->messageManager->addError($e->getMessage());
                        return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
                    }
                  }else{
                    $this->messageManager->addErrorMessage(__("Email is allready exist change email"));
                  }
                    
                }
                return $resultRedirect->setPath('*/*/');   
        }
        else{
            if ($params){
                $customers = $this->_customerRequestFactory->create();    
			    $exists = $this->validateEmail( $customers,  $params );
                if(!$exists){ 
                try{
                    $model = $this->_model;
                    $model->setData('name',$params['name'])->setData('email',$params['email'])->save();
                }
                catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
                }
                }else{
                $this->messageManager->addErrorMessage(__("Email is allready exist change email"));
                }
            }
            return $resultRedirect->setPath('*/*/');
        }

    

    }
    protected function validateEmail($model,  $data){
		$collection = $model->getCollection();
		$collection->addFieldToFilter('email', $data['email']);
		return $collection->getSize() ? 1:0;
	}

}
