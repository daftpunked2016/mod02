<?php
/* add variables or conditions if need */
class UserHeader extends CWidget
{
	
	public function init()
	{
		
	}
	
	public function run()
	{	
		$this->render("userHeader",array(
				// 'messages' => $messages,
			));
	}
}
?>