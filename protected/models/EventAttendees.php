<?php

/**
 * This is the model class for table "{{event_attendees}}".
 *
 * The followings are the available columns in table '{{event_attendees}}':
 * @property integer $id
 * @property integer $account_id
 * @property integer $event_id
 * @property integer $payment_status
 * @property integer $account_attendee_type
 */
class EventAttendees extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{event_attendees}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, event_id, payment_status, account_attendee_type, date_registered', 'required'),
			array('account_id, event_id, payment_status, account_attendee_type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, event_id, payment_status, account_attendee_type', 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'user' => array(self::BELONGS_TO, 'User', array('id'=>'account_id'),'through'=>'account'),
			'chapter' => array(self::BELONGS_TO, 'Chapter', array('chapter_id'=>'id'),'through'=>'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_id' => 'Account',
			'event_id' => 'Event',
			'payment_status' => 'Payment Status',
			'account_attendee_type' => 'Account Attendee Type',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('payment_status',$this->payment_status);
		$criteria->compare('account_attendee_type',$this->account_attendee_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventAttendees the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function eventRegistration($account_id, $event_id, $price, $pricing_type)
	{
		$event_attendee = new EventAttendees;
		$billing = new Billing;
		
		$event_attendee->account_id = $account_id;
		$event_attendee->event_id = $event_id;

		if($pricing_type == 1) // if event pricing was FREE
			$event_attendee->payment_status = 1; // 1 = PAID, 2 = PENDING, 3 = UNPAID, 4 = REJECTED
		else
			$event_attendee->payment_status = 3; // 1 = PAID, 2 = PENDING, 3 = UNPAID, 4 = REJECTED

		$event_attendee->date_registered =  date('Y-m-d H:i');
		$event_attendee->account_attendee_type = 2; //2 = USER

		$billing->price = $price;
		$billing->date_created = date('Y-m-d H:i');

		$valid = $event_attendee->validate();

		if($valid)
		{
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();

			if($event_attendee->save())
			{
				$billing->event_attendees_id = $event_attendee->id;
				
				if($billing->save())
				{
					$transaction->commit();
					return $event_attendee->id;
				}
				else
					return 0;
			}
			else
				return 0;
		}
		else
			return 0;
	}

	//CHECK IF THE USER WAS SUCCESSFULLY REGISTERED TO THE EVENT
	public function checkRegistration($event_attendee_id)
	{
		$event_attendee = EventAttendees::model()->findByPk($event_attendee_id);

		if($event_attendee != null)
		{
			return true;
		}
		else
			return false;
	}

	//CHECK IF THE USER HAS ALREADY REGISTERED FOR THE EVENT
	public function validateAttendee($event_id, $account_id)
	{
		$event_attendee = EventAttendees::model()->find('account_id = '.$account_id.' AND event_id = '.$event_id);

		if($event_attendee != null)
		{
			return false;
		}
		else
			return true;
	}

	//UPDATE ATTENDEE STATUS TO PENDING IF PAYMENT UPLOADING WAS SUCCESSFUL
	public function updateStatusToPending($event_attendee_id)
	{
		$event_attendee = EventAttendees::model()->findByPk($event_attendee_id);
		$event_attendee->payment_status = 2; //2 means pending

		if($event_attendee->save())
			return true;
		else
			return false;
	}

	public function scopes()
	{
		return array(
			'paidAttendee' => array(
				'condition' => 'payment_status = 1',
			),

			'pendingAttendee' => array(
				'condition' => 'payment_status = 2',
			),

			'unpaidAttendee' => array(
				'condition' => 'payment_status = 3',
			),

			'rejectAttendee' => array(
				'condition' => 'payment_status = 4',
			),
		);
	}
}
