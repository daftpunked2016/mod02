<?php 

class SalesController extends Controller
{

	public $layout = '/layouts/main';

	public function actionIndex()
	{ 
		$id = Yii::app()->getModule('host')->user->id;
		$host = Host::model()->findByPk($id);
		$event = Event::model()->findByPk($host->event_id);
		$result = array();
		$eventpricing = EventPricing::model()->find('event_id ='.$host->event_id);
	  	// $sales = Sales::model()->findAll();
		$sales = Sales::model()->findAll(array('condition' => 'event_id ='.$event->id));
		$grandTotal = 0;

		if(isset($_POST['area_no']) || isset($_POST['chapter']) || isset($_POST['region']) || isset($_POST['amount']) || isset($_POST['from']) || isset($_POST['to'])) 
		{ 
			if($_POST['area_no'] !== '' && $_POST['region'] === '*' && $_POST['chapter'] === '*')
			{
				foreach($sales as $sale)
				{
					$attendee = EventAttendees::model()->findByPk($sale->event_attendees_id);
					$user = User::model()->find('account_id = '.$attendee->account_id);
					$chapter = Chapter::model()->findByPk($user->chapter_id);

					if($chapter->area_no === $_POST['area_no'])
					{
						$result[] = $sale;
					}
				}
			}
			elseif($_POST['area_no'] !== '' && $_POST['region'] !== '*' && $_POST['chapter'] === '*')
			{
				foreach($sales as $sale)
				{
					$attendee = EventAttendees::model()->findByPk($sale->event_attendees_id);
					$user = User::model()->find('account_id = '.$attendee->account_id);
					$chapter = Chapter::model()->findByPk($user->chapter_id);

					if($chapter->region_id === $_POST['region'])
					{
						$result[] = $sale;
					}
				}
			} 
			elseif($_POST['area_no'] !== '' && $_POST['region'] !== '*' && $_POST['chapter'] !== '*')
			{
				foreach($sales as $sale)
				{
					$attendee = EventAttendees::model()->findByPk($sale->event_attendees_id);
					$user = User::model()->find('account_id = '.$attendee->account_id);
					$chapter = Chapter::model()->findByPk($user->chapter_id);

					if($chapter->id === $_POST['chapter'])
					{
						$result[] = $sale;
					}
				}
			}

			if($_POST['amount'])
			{
				if(!empty($result))
				{
					foreach($result as $key => $sale)
					{
						if($sale->total_amount !== $_POST['amount'])
						{
							unset($result[$key]);
						}
					}

					$result = array_values($result);	
				}
				else
				{
					foreach($sales as $sale)
					{
						if($sale->total_amount === $_POST['amount'])
						{
							$result[] = $sale;
						}
					}
				}
			}

			if($_POST['from'] || $_POST['to'])
			{
				if($_POST['from'] == null)
					$from = date('Y-m-d');
				else
					$from = $_POST['from'];
				
				if($_POST['to'] == null)
					$to = date('Y-m-d');
				else
					$to = $_POST['to'];


				if(!empty($result))
				{
					foreach($result as $key=>$sale)
					{
						if(strtotime($sale->date_created) <= strtotime($from) || strtotime($sale->date_created) >= strtotime($to))
							unset($result[$key]);

						$result = array_values($result);
					}
				}
				else
				{
					foreach($sales as $sale)
					{
						if(strtotime($sale->date_created) >= strtotime($from) && strtotime($sale->date_created) <= strtotime($to))
							$result[] = $sale;
					}
				}
			}
		}
		else
		{
			foreach($sales as $sale)
			{
				$result[] = $sale;
			}
		}

		$salesDP=new CArrayDataProvider($result, array(
			'pagination' => array(
				'pageSize' => 20
			)
		));
		
		foreach ($result as $value)
			$grandTotal = $grandTotal + $value->total_amount;
		
		
		$this->render('index',array(
			'salesDP'=>$salesDP,
			'event'=>$event,
			'grandTotal'=>$grandTotal,
		));
	}
}
