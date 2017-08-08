<?php
class MiTAC_Hello_Model_Observer
{
	public function newCustomerMessage($observer)
	{
		//取得事件中的Customer
		$customer = $observer->getEvent()->getCustomer();
		//準備留言
		$Data = array(
			'content' => '大家好 我是 '. $customer->getName() .'，很高興可以來到這裡',
			'name' => $customer->getName()
			);
		// 呼叫 Model
		$Message = Mage::getModel('mitachello/message');
		//設定資料
		$Message->setData($Data);
		//儲存資料
		$Message->save();
	}
}