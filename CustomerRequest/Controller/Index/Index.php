<?php
namespace ArmMage\CustomerRequest\Controller\Index;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use ArmMage\CustomerRequest\Model\CustomerRequestFactory;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
    
	protected $_customerRequestFactory;

	public function __construct(
		Context $context,   
		PageFactory $pageFactory,
		CustomerRequestFactory $customerRequestfactory
		)
	{
		$this->_pageFactory = $pageFactory;
		$this->_customerRequestFactory = $customerRequestfactory;
		return parent::__construct($context);
	}

	public function execute()
	{ 
		try {
            $data = (array)$this->getRequest()->getPost();
            if ($data) {
                $model = $this->_customerRequestFactory->create();
				$exists = $this->validateEmail( $model,  $data );
				if (!$exists){	
                	$model->setData($data)->save();
                	$this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
        	    }else{
					$this->messageManager->addErrorMessage(__("Email is allready exist change email"));
				}
			}
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
				return $this->_pageFactory->create();
		
	}

	protected function validateEmail($model,  $data){
		$collection = $model->getCollection();
		$collection->addFieldToFilter('email', $data['email']);
		return $collection->getSize() ? 1:0;
	}
}