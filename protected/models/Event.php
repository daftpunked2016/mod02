<?php

/**
 * This is the model class for table "{{event}}".
 *
 * The followings are the available columns in table '{{event}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $event_type
 * @property integer $areacon_area_no
 * @property integer $host_chapter_id
 * @property string $host_chair_name
 * @property string $host_chair_email
 * @property string $date
 * @property string $time
 * @property string $venue
 * @property integer $status_id
 */
class Event extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{event}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, event_type, host_chapter_id, date, end_date, time, venue, status_id', 'required'),
			array('event_type, areacon_area_no, host_chapter_id, status_id, host_account_id', 'numerical', 'integerOnly'=>true),
			array('name, description', 'length', 'max'=>255),
			array('time', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, event_type, areacon_area_no, host_chapter_id, host_account_id, date, end_date, time, venue, event_avatar, status_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'event_type' => array(self::BELONGS_TO, 'EventTypes', 'event_type'),
			'event_attendees' => array(self::HAS_MANY, 'EventAttendees', 'event_id'),
			'payments' => array(self::HAS_MANY, 'Payments', 'event_id'),
			'sales' => array(self::HAS_MANY, 'Sales', 'event_id'),
			'event_ps' => array(self::HAS_MANY, 'EventPS', 'event_id'),
			'event_pricing' => array(self::HAS_ONE, 'EventPricing', 'event_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Event Name',
			'description' => 'Description',
			'event_type' => 'Event Type',
			'areacon_area_no' => 'Area No.',
			'host_chapter_id' => 'Host Chapter',
			'host_account_id' => 'Host Account ID',
			'host_chair_email' => 'Host Chair Email',
			'date' => 'Event Start Date',
			'end_date' => 'Event End Date',
			'time' => 'Time',
			'venue' => 'Venue',
			'event_avatar' => 'Event Poster *',
			'status_id' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('event_type',$this->event_type);
		$criteria->compare('areacon_area_no',$this->areacon_area_no);
		$criteria->compare('host_chapter_id',$this->host_chapter_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('venue',$this->venue,true);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Event the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function countNewEvents()
	{
		$count = 0;
		$events = Event::model()->findAll('status_id = 1');
		$account_id = Yii::app()->user->id;
		$user = User::model()->find('account_id = '.$account_id);
		$chapter = Chapter::model()->findByPk($user->chapter_id);

		foreach($events as $event)
		{
			$event_attendee = EventAttendees::model()->find('event_id = '.$event->id.' AND account_id = '.$account_id);

			if($event_attendee == null)
			{
				if($event->event_type == 1) //NATCON
				{
					$count++;
				}
				else if($event->event_type == 2) //AREACON
				{
					if($event->areacon_area_no == $chapter->area_no)
						$count++;
				}
				else if($event->event_type == 3) //1st PRESIDENTS
				{
					$count++;
				}
				else if($event->event_type == 4)
				{
					if($user->position_id == 11)
						$count++;
				}
				else if($event->event_type == 5)
				{
					$count++;
				}
			}	
		}

		return $count;
	}

	public function scopes()
	{
		return array(
			'isActive' => array(
				'condition' => 't.status_id = 1',
			),
		);
	}

	public function countAttendees(array $event_attendees, $payment_status = 0)
	{
		$count = 0;

		if($payment_status == 0)
			$count =  count($event_attendees);//all registrantrs
		else {
			foreach($event_attendees as $attendee) {
				if($attendee->payment_status == $payment_status) 
					$count++;
			}
		}

		return $count;
	}

	//TODAY's UPDATES
	public function countTodaysAttendees(array $event_attendees)
	{
		$count = 0;
		$date_now = date('Y-m-d');

		foreach($event_attendees as $attendee)
		{
			$date_registered =	date('Y-m-d', strtotime($attendee->date_registered));

			if($date_now === $date_registered)
				$count++;
		}

		return $count;
	}

	public function getPercentageTA(array $event_attendees)
	{
		$orig = $this->countTodaysAttendees($event_attendees);
		$comp = $this->countAttendees($event_attendees);
		$percentage = ($orig/$comp);
		$conv_perc = ($percentage * 100);
		$rounded_perc = round($conv_perc, 0);

		return $rounded_perc; 
	}

	public function countTodaysPayments(array $payments)
	{
		$count = 0;
		$date_now = date('Y-m-d');

		foreach($payments as $payment)
		{
			$convert_date = strtotime($payment->date_uploaded);
			$date_uploaded = date('Y-m-d', $convert_date);

			if($date_now === $date_uploaded)
				$count++;
		}

		return $count;
	}

	public function getPercentageTP(array $payments)
	{
		$orig = $this->countTodaysPayments($payments);
		$comp = $this->countTotalUploadedPayments($payments);
		$percentage = ($orig/$comp);
		$conv_perc = ($percentage * 100);
		$rounded_perc = round($conv_perc, 0);

		return $rounded_perc; 
	}

	public function computeTodaysSales(array $sales)
	{
		$totalsales = 0.00;
		$date_now = date('Y-m-d');

		foreach($sales as $sale)
		{
			$convert_date = strtotime($sale->date_created);
			$date_created = date('Y-m-d', $convert_date);

			if($date_now === $date_created)
				$totalsales = $totalsales + $sale->total_amount;
		}

		return $totalsales;
	}

	public function getPercentageTS(array $sales)
	{
		$orig = $this->computeTodaysSales($sales);
		$comp = $this->computeTotalSales($sales);
		$percentage = ($orig/$comp);
		$conv_perc = ($percentage * 100);
		$rounded_perc = round($conv_perc, 0);

		return $rounded_perc; 
	}


	public function computeExpectedTodaysSales(EventPricing $eventpricing, array $event_attendees)
	{
		$totalsales = 0.00;
		$date_now = date('Y-m-d');

		if($eventpricing->pricing_type == 3)
		{
			foreach($attendees as $attendee)
			{
				$convert_date = strtotime($attendee->date_registered);
				$date_registered = date('Y-m-d', $convert_date);

				if($date_now === $date_registered)
				{
					$price = $this->determinePackagePricing($event_id, $attendee->id);
					$totalsales = $totalsales + $price;
				}
			} 
		}
		else
		{
			foreach($attendees as $attendee)
			{
				$price = $eventpricing->regular_price;
				$date_registered = date('Y-m-d', $convert_date);

				if($date_now === $date_registered)
					$totalsales = $totalsales + $price;
			}
		}

		return $totalsales;
	}

	public function getPercentageETS(array $sales)
	{
		$orig = $this->computeExpectedTodaysSales($sales);
		$comp = $this->computeExpectedTotalSales($sales);
		$percentage = ($orig/$comp);
		$conv_perc = ($percentage * 100);
		$rounded_perc = round($conv_perc, 0);

		return $rounded_perc; 
	}


	//AREA COUNTING
	public function countAreaRegistrants(array $event_attendees, $area_no, $payment_status = 0)
	{
		$count = 0;

		if($payment_status == 0)
			$attendees = $event_attendees;
		else {
			$attendees = array();
			
			foreach($event_attendees as $attendee_payment_check) {
				if($payment_status == $attendee_payment_check->payment_status)
					$attendees[] = $attendee_payment_check;
			}
		}

		foreach($attendees as $attendee)
		{
			$user = $attendee->user;
			//$chapter = Chapter::model()->findByPk($user->chapter_id);
			$chapter = $attendee->chapter;

			if($area_no == $chapter->area_no)
				$count++;
		}

		return $count;
	}

	public function countAreaMembers(array $accounts, $area_no)
	{
		$count = 0;

		//$accounts = Account::model()->findAll('status_id = 1 AND account_type_id = 2');

		foreach($accounts as $account)
		{
			//$user = User::model()->find('account_id = '.$account->id);
			//$chapter = Chapter::model()->findByPk($user->chapter_id);
			//$user = $account->user;
			$chapter = $account->chapter;

			if($area_no == $chapter->area_no)
				$count++;
		}

		return $count;
	}

	public function getPercentage(array $event_attendees, array $accounts, $area_no, $payment_status = 0)
	{
		$comp = $this->countAreaMembers($accounts, $area_no);

		if($payment_status == 0)
		{
			$orig = $this->countAreaRegistrants($event_attendees, $area_no);
		}
		else
		{
			$orig = $this->countAreaRegistrants($event_attendees, $area_no, $payment_status);
		}

		$percentage = ($orig/$comp);
		$conv_perc = ($percentage * 100);
		$rounded_perc = round($conv_perc, 0);

		return $rounded_perc; 
	}

	//SALES
	public function computeExpectedTotalSales(EventPricing $eventpricing, array $event_attendees)
	{
		$totalsales = 0.00;
		$attendees = $event_attendees;

		if($eventpricing->pricing_type == 3)
		{
			foreach($attendees as $attendee)
			{
				$price = $this->determinePackagePricing($eventpricing, $attendee);
				$totalsales = $totalsales + $price;
			} 
		}
		else
		{
			foreach($attendees as $attendee)
			{
				$price = $eventpricing->regular_price;
				$totalsales = $totalsales + $price;
			}
		}

		return $totalsales;
	}

	public function computeTotalSales(array $sales)
	{
		$totalsales = 0.00;
		//$sales = Sales::model()->findAll('event_id = '.$event_id);

		foreach($sales as $sale)
			$totalsales = $totalsales + $sale->total_amount;

		return $totalsales;
	}

	//PAYMENTS
	public function countTotalUploadedPayments(array $payments)
	{
		return count($payments);
	}

	public function countTotalValidatedPayments(array $payments)
	{
		$count = 0;

		foreach($payments as $payment)
			if($payment->status_id == 1)
				$count++;
			
		return $count;
	}

	public function determinePackagePricing(EventPricing $eventpricing, EventAttendees $eventattendees)
	{
		if($eventpricing->pricing_type == 3) // if pricing_type = Packages -> determine packages
		{
			$price = 0;
			$date_now = strtotime($eventattendees->date_registered);
			$eb_begin_date = strtotime($eventpricing->eb_begin_date);
			$eb_end_date = strtotime($eventpricing->eb_end_date);
			$regular_begin_date = strtotime($eventpricing->regular_begin_date);
			$regular_end_date = strtotime($eventpricing->regular_end_date);
			$onsite_begin_date = strtotime($eventpricing->onsite_begin_date);
			$onsite_end_date = strtotime($eventpricing->onsite_end_date);

			if(($date_now <= $eb_begin_date || $date_now >= $eb_begin_date) && $date_now<=$eb_end_date && $date_now < $regular_begin_date) //early bird
				$price = $eventpricing->early_bird_price;
			elseif(($date_now > $eb_end_date || $date_now >= $regular_begin_date) && $date_now<=$regular_end_date && $date_now < $onsite_begin_date) //reg
				$price = $eventpricing->regular_price;	
			elseif(($date_now > $regular_end_date || $date_now >= $onsite_begin_date) && ($date_now<=$onsite_end_date || $date_now > $onsite_end_date)) //onsite
				$price = $eventpricing->onsite_price;	

			return $price;
		}
		else
			return 0;
	}

	public function setNewEventNotifProp($event_id) {
		$event = Event::model()->findByPk($event_id);
		$accountEmails = array();

		/* ACCOUNT EMAILS */ 
		$accounts = Account::model()->findAll('status_id = 1');
		
		foreach($accounts as $account) {
			$accountEmails[] = $account->username; 
		}

		/* EMAIL PROPERTIES */
		$subject = "JCI Philippines | New Event Has Been Posted";
		$body = "Greetings! <br/><br/>
				A new event has been posted in your myJCIP Events Page and now available for registration. Event details will be shown below. <br><br>
				<b>Event Name:</b> <i><b>".$event->name."</b></i><br/> 
				<b>Date:</b> ".date('F d, Y', strtotime($event->date))." (".$event->time.")<br/>
				<b>Venue:</b> ".$event->venue."<br/>
				<b>Details:</b> ".$event->description."<br/><br />
				To register and view more about the event details, you can now log-in to your account and visit the Events Listing page by clicking this link : <a href='http://jci.org.ph/mod02/index.php/'>JCI Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
				JCI Philippines";

		/* EMAIL SEND */
		Account::model()->populateMsgPropMultiple($accountEmails, $subject, $body);

		/*switch ($event->event_type) {
			case 1: //NATCON
				$accounts = Account::model()->findAll('status_id = 1');

				

			break;

			case 2: //AREA CON
				$users = User::model()->with(array(
						    'chapter' => array(
						    	'select'=> false,
						        'condition' => 'chapter.area_no = '.$event->areacon_area_no,
						    ),
						    'account' => array(
						    	'select'=> false,
						        'condition' => 'account.status_id = 1',
						    ),
						    ))->findAll();

				foreach($users as $user) {
					$accountEmails[] =$user->account->username; 
				}
.
			break;

			case 3: //1ST PRES
				$users = User::model()->findAll('position_id = 11');

				foreach($users as $user) {
					$accountEmails[] =$user->account->username; 
				}
				
			break;

			case 4: //MIDYEAR
				# code...
				break;

			case 5: //OTHERS EVENT
				# code...
				break;
			
			default:
				# code...
				break;
		}*/

	}

	public function setEmailProp($type, $account_id, $event_id)
	{
		$subject = $event = Event::model()->findByPk($event_id);
		$body = ''; 

		switch ($type) {
			case 1: //FOR HOST, NEW REGISTERED USER FOR THE EVENT
				$subject = "JCI Philippines Event Host | New Member Has Been Registered to the Event";
				$body = "A new member has successfully registered to the event you've been hosting. 
				You can now check the newly registered member by logging in your Event Host Account in this link : <a href='http://jci.org.ph/mod02/index.php/host/'>JCI Event Host Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
				JCI Philippines";
				break;

			case 2: //FOR HOST, IF A NEW PAYMENT HAS BEEN UPLOADED
				$subject = "JCI Philippines Event Host | New Payment Has Been Uploaded to the Event";
				$body = "A member has uploaded its payment to the event you've been hosting. 
				<b>* Please carefully validate the payment before approving it.</b>
				You can now check the new uploaded payment by logging in your Event Host Account in this link : <a href='http://jci.org.ph/mod02/index.php/host/'>JCI Event Host Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
				JCI Philippines";
				break;

			case 3: //FOR HOST, IF A REJECTED PAYMENT WAS RESUBMITTED
				$subject = "JCI Philippines Event Host | A Rejected Payment Has Been Resubmitted";
				$body = "A member has resubmitted its payment that has been rejected. 
				<b>* Please carefully validate the payment before approving it.</b>
				You can now check the resubmitted payment by logging in your Event Host Account in this link : <a href='http://jci.org.ph/mod02/index.php/host/'>JCI Event Host Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
				JCI Philippines";
				break;

			case 4: //FOR HOST, IF ASSIGNED AS HOST FOR THE EVENT
				$account = Account::model()->findByPk($account_id);
				$subject = "JCI Philippines | Assigned as Event Host";
				$body = "You've been assigned as an Event Host for an upcoming JCI Event. Please use the following log-in credentials for your Event Host account. <br/><br/>
				<b>Event No. :</b> <i><b>".$event_id."</b></i><br/> 
				<b>Username :</b> ".$account->username."<br/>
				<b>Password:</b> jciph-eventhost<br/><br/><br />
				You can now view the event details and other transactions by logging in your Event Host Account in this link : <a href='http://jci.org.ph/mod02/index.php/host/'>JCI Event Host Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
				JCI Philippines";
				break;

			case 5: //FOR USER, IF PAYMENT WAS ACCEPTED
				$subject = "JCI Philippines | Payment Successfully Verified";
				$body = "Your payment has been successfully verified by the Event Host.
				You're now ready to be a part of the event!<br/><br/>
				<b> * Check your transaction history to validate your payment status.</b>
				You can now log-in to your account by  : <a href='http://jci.org.ph/mod02/index.php/'>JCI Event Host Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
				JCI Philippines";
				break;

			case 6: //FOR USER, IF PAYMENT WAS REJECTED
				$subject = "JCI Philippines | Payment Rejected";
				$body = "Your payment has been rejected by the Event Host. 
				Please carefully verify the payment details that you've submitted and uploaded. <br/>
				You can Edit & Resubmit it by viewing your Transactions History page. (Events > Transactions History)<br /><br />
				To know more of why your payment was rejected, please contact the Event Host.<br/>
				You can now check the rejected payment by logging in into this link : <a href='http://jci.org.ph/mod02/index.php/admin/'>JCI Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
				JCI Philippines";
				break;

			case 7: //FOR USER, IF PAYMENT WAS REJECTED
				$subject = "JCI Philippines | Billing Statement for Event Registration";
				$body = "You have successfully registered for the event but your status will still be for <b>Pending</b>, until your payment was received. <br/>
				To view your Billing Statement details, click the link below.<br/><br/>
				<b>Link:</b> <a href='http://jci.org.ph/mod02/index.php/event/viewbspdf?event_id=".$event_id."&account_id=".$account_id."'>JCI Event Registration Billing Statement</a> <br/><br/><br/>
				Log-in into your account now by clicking this link : <a href='http://jci.org.ph/mod02/index.php/admin/'>JCI Log-in Page</a> <br /><br />
				Please always check your e-mail and keep yourself updated. Thank you!<br /><br />
				JCI Philippines";
				break;
			
			default:
				print_r("ERROR: Email Type not recognized");
				exit;
				break;
		}

		$send =  Account::model()->populateMsgProperties($account_id, $subject, $body);
	}
}
