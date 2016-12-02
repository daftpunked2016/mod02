<?php
/* add variables or conditions if need */
class HostLogin extends CWidget
{
	public function init()
	{
		
	}
	
	public function run()
	{	
		$events = Event::model()->isActive()->findAll();

		$model=new HostLoginForm;
		$this->render('login', array(
			'model' => $model,
			'events' => $events,
		));
		
	}
}
?>