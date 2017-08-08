<?php
class MiTAC_Hello_MitacController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{	
		//echo 'Hello World MiTAC';
		$this->loadLayout();
		$this->renderLayout();
	}
}
