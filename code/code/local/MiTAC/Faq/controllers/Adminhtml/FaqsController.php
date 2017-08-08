<?php
class MiTAC_Faq_Adminhtml_FaqsController extends Mage_Adminhtml_Controller_action
{
	public function indexAction()
	{
		//echo 'faq admin test';
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function newAction()
	{
		$this->_forward('edit');
	}
	
	public function editAction()
	{
		$id = $this->getRequest()->getParam('id');
		if($id){
			$model = Mage::getModel('mitacfaq/faqs')->load($id);
			if ($model->getId()){
				Mage::register('faqs_data', $model);
			}else{
				$this->_getSession()->addError('FAQ 資料不存在');
				$this->_redirect('*/*/');
			}
		}
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function saveAction()
	{
		$data = $this->getRequest()->getPost();
		if($data)
		{
			$model = Mage::getModel('mitacfaq/faqs');
			$model->setData($data);
			$model->setId($this->getRequest()->getParam('id'));
			
			try{
				$model->save();
				$this->_getSession()->addSuccess($this->__('The FAQ has	been saved.'));
			}catch (Exception $e){
				Mage::logException($e);
				$this->_getSession()->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/');
	}
	public function deleteAction()
	{
		if ($this->getRequest()->getParam('id') > 0) {
			try {
				$model = Mage::getModel('mitacfaq/faqs');
				$model->setId($this->getRequest()->getParam('id'))
				->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess('FAQ was successfully deleted');
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' =>
				$this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}	
}	