<?php
class Mitac_Hello_Block_Hello extends Mage_Core_Block_Template
{
    public function sayHello()
    { 
        echo 'Hello from Block function';
    }
	
	public function saySomething( $str = '')
    { 
        echo $str ;
    }
	
	public function doplus( $a, $b)
    { 
        echo $a . '+' . $b . '=' . ($a+$b);
    }
}
