<?php
/* add variables or conditions if need */
	class HostLeftside extends CWidget
	{
		
		public function init()
		{
			
		}
		
		public function run()
		{	
			$id = Yii::app()->getModule('host')->user->id;
			$host = Host::model()->findByPk($id);
			$event = Event::model()->findByPk($host->event_id);

			$this->render("hostLeftside",array(
				'event' => $event,
			));
		}
	}
?>