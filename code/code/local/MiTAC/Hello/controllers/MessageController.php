<?php
class MiTAC_Hello_MessageController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{	
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function postAction()
	{
		// 取得 Post 資料
		$postData = Mage::app()->getRequest()->getPost();
		
		//設定留言板網址
		$url = Mage::Helper('mitachello')->getMessageUrl();
		
		//判斷是否有留言
		if($postData['message']==null)
		{
			Mage::getSingleton('core/session')->addError('請輸入留言');
			$this->_redirectUrl($url);
			return;
		}
		
		// 判斷使用者是否登入
		if(Mage::getSingleton('customer/session')->isLoggedIn())
		{
			// 取得使用者Session
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			$name = $customer->getName();
		}
		else {
			$name = '訪客';
		}
		
		//整理資料
		$Data = array(
				'content' => $postData['message'],
				'name' => $name
			);
		
		// 呼叫 Model
		$Message = Mage::getModel('mitachello/message');
		//設定資料
		$Message->setData($Data);
		//儲存資料
		$Message->save();
		//Log
		Mage::log($name . ' 留言囉',null,'message.log');
		//成功訊息
		Mage::getSingleton('core/session')->addSuccess('感謝你的留言');
		//返回留言板
		$this->_redirectUrl($url);
		return;
	}
}
