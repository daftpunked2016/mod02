<?php

/**
 * This is the model class for table "{{transactions}}".
 *
 * The followings are the available columns in table '{{transactions}}':
 * @property integer $id
 * @property integer $account_id
 * @property string $ip_address
 * @property integer $type
 * @property string $detail
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Account $account
 */
class Transactions extends CActiveRecord
{
	CONST TYPE_LOGIN = 1;
	CONST TYPE_ADD_ADMIN_ACCOUNT = 2;
	CONST TYPE_ADD_USER_ACCOUNT = 3;
	CONST TYPE_UPDATE_ADMIN_ACCOUNT = 4;
	CONST TYPE_UPDATE_USER_ACCOUNT = 5;
	CONST TYPE_RESERVE_TABLE = 6;
	CONST TYPE_CANCEL_RESERVATION = 7;
	CONST TYPE_ADD_EVENT = 8;
	CONST TYPE_UPDATE_EVENT = 9;
	
	/**
	 * @return string the associated database table name
	 */
	 
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return '{{transactions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, ip_address, type, detail, date_created', 'required'),
			array('account_id, type', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>45),
			array('detail', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, ip_address, type, detail, date_created', 'safe', 'on'=>'search'),
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
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
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
			'ip_address' => 'Ip Address',
			'type' => 'Type',
			'detail' => 'Detail',
			'date_created' => 'Date Created',
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
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function scopes()
	{
		return array(
			'isActive' => array(
				'condition' => 't.status_id = '.self::STATUS_ACTIVE,
			),
			
			'isInactive' => array(
				'condition' => 't.status_id = '.self::STATUS_INACTIVE,
			),
		);
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->date_created = date('Y-m-d H:i:s');
			}
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function get_client_ip() 
	{
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			if ($_SERVER['HTTP_CLIENT_IP'])
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		}
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			if($_SERVER['HTTP_X_FORWARDED_FOR'])
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		if (isset($_SERVER['HTTP_X_FORWARDED']))
		{
			if($_SERVER['HTTP_X_FORWARDED'])
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		}
		if (isset($_SERVER['HTTP_FORWARDED_FOR']))
		{
			if($_SERVER['HTTP_FORWARDED_FOR'])
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		}
		if (isset($_SERVER['HTTP_FORWARDED']))
		{
			if($_SERVER['HTTP_FORWARDED'])
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
		}
		if (isset($_SERVER['REMOTE_ADDR']))
		{
			if($_SERVER['REMOTE_ADDR'])
				$ipaddress = $_SERVER['REMOTE_ADDR'];
		}
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	
	public function generateLog($account_id, $type, $message = null)
	{
		$transaction = new Transactions;
		$transaction->account_id = $account_id;
		$transaction->type = $type;
		$transaction->ip_address = $this->get_client_ip();
		switch($type)
		{
			case self::TYPE_LOGIN:
				$transaction->detail = "User has logged in.";
			break;
			case self::TYPE_ADD_ADMIN_ACCOUNT:
				$transaction->detail = "User has added an admin account: ".$message;
			break;
			case self::TYPE_ADD_USER_ACCOUNT:
				$transaction->detail = "User has added a user account: ".$message;
			break;
			case self::TYPE_UPDATE_ADMIN_ACCOUNT:
				$transaction->detail = "User has updated an admin: ".$message;
			break;
			case self::TYPE_UPDATE_USER_ACCOUNT:
				$transaction->detail = "User has updated a user account: ".$message;
			break;
			case self::TYPE_RESERVE_TABLE:
				$transaction->detail = "User has reserved a table: ".$message;
			break;
			case self::TYPE_CANCEL_RESERVATION:
				$transaction->detail = "User has cancelled a reservation: ".$message;
			break;
			case self::TYPE_ADD_EVENT:
				$transaction->detail = "User has added an event: ".$message;
			break;
			case self::TYPE_UPDATE_EVENT:
				$transaction->detail = "User has updated an event: ".$message;
			break;
		}
		$transaction->save(false);
	}
	
	public function getTransactions($params = array())
	{
		$criteria = new CDbCriteria();
		
		if (isset($params['type']))
		{
			if ($params['type'] != null)
			{
				$criteria->mergeWith(array(
					'condition' => 't.type = "'.$params['type'].'"',
				));
			}
		}
			
		if (isset($params['account']))
		{
			$criteria->mergeWith(array(
				'join' => 'LEFT JOIN jci_user ru ON t.account_id = ru.account_id',
				'condition' => 't.account_id like "%'.$params['account'].'%" OR CONCAT_WS(" ", ru.firstname, ru.middlename, ru.lastname) like "%'.$params['account'].'%"',
			));
		}
		
		if (isset($params['detail']))
		{
			$criteria->mergeWith(array(
				'condition' => 't.detail like "%'.$params['detail'].'%"',
			));
		}
		
		if (isset($params['date']))
		{
			if ($params['date'] != null)
			{
				$criteria->mergeWith(array(
					'condition' => 'DATE_FORMAT(t.date_created, "%Y-%m-%d") = "'.$params['date'].'"',
				));
			}
		}
		
		if (isset($params['sort']))
		{
			$criteria->mergeWith(array(
				'order' => $params['sort'],
			));
		}
		
		return $this->findAll($criteria);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transactions the static model class
	 */
}
