<?php
/* add variables or conditions if need */
class AdminLogin extends CWidget
{
	public function init()
	{
		
	}
	
	public function run()
	{	
		$model=new AdminLoginForm;
		$this->render('login', array(
			'model' => $model,
		));
		
	}
}
?>