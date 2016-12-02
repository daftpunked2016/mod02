<?php

/**
 * This is the model class for table "{{host}}".
 *
 * The followings are the available columns in table '{{host}}':
 * @property integer $id
 * @property integer $account_id
 * @property string $username
 * @property string $password
 * @property integer $salt
 * @property integer $account_type_id
 * @property string $date_created
 * @property string $date_updated
 * @property integer $status_id
 */
class Host extends CActiveRecord
{
	public $new_password; 
	public $confirm_password; 
	public $current_password;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{host}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, event_id, username, password, account_type_id', 'required'),
			array('account_id, salt, event_id, account_type_id, status_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>40),
			array('password', 'length', 'max'=>128),

			//change password rules
			array('current_password, new_password, confirm_password', 'required', 'on' => 'changePwd'),
			array('current_password', 'findPasswords', 'on' => 'changePwd'),
			array('confirm_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>'New password doesn\'t match!', 'on'=>'changePwd'),
			array('new_password', 'length', 'min'=>8, 'max'=>16, 'on'=>'changePwd'),
			array('confirm_password', 'length', 'min'=>8, 'max'=>16, 'on'=>'changePwd'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_id, account_id, username, password, salt, account_type_id, date_created, date_updated, status_id', 'safe', 'on'=>'search'),
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
			'username' => 'Username',
			'password' => 'Password',
			'confirm_password' => 'Confirm Password',
			'new_password' => 'New Password',
			'current_password' => 'Current Password',
			'salt' => 'Salt',
			'account_type_id' => 'Account Type',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt);
		$criteria->compare('account_type_id',$this->account_type_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->salt=$this->generateSalt();
				$this->status_id = 1;
				$this->password=$this->hashPassword($this->password,$this->salt);
				$this->date_created = date('Y-m-d H:i');
				$this->date_updated = date('Y-m-d H:i');
			}
			else
			{
				$this->date_updated = date('Y-m-d H:i');
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Host the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}

	public function hashPassword($password,$salt)
	{
		//Used to encrypt the password
		//You can either use sha1, sha2 or sha256
		//md5 not that secure anymore
		return sha1($password.$salt);
	}

	public function getRole()
    {
    	$model=AccountType::model()->find(array(
    		'condition' => 'id=:id',
    		'params' => array(
    			':id' => $this->account_type_id,
    			)
    		));

    	if($model!==NULL)
    		return $model->account_type;
    }

    public function generateSalt()
	{
		// Simple timestamp. Needs to be worked on to make site more secure
		return time();
	}

	public function findPasswords($attribute, $params)
    {
        $host = Host::model()->findByPk(Yii::app()->host->id);
        if (!$this->validatePassword($this->current_password))
            $this->addError($attribute, 'Old password is incorrect.');
    }

    public function createEventHost($account_id, $event_id)
    {
    	$account=Account::model()->findByPk($account_id);

    	$host = new Host;
    	$host->account_id = $account->id;
    	$host->event_id = $event_id;
    	$host->username = $account->username;
    	$host->password = "jciph-eventhost";
    	$host->account_type_id = 3;

    	$valid = $host->validate();

    	if($valid)
    	{
    		try
			{
				if($host->save()) {
					Event::model()->setEmailProp(4, $account->id, $event_id); // EMAIL NOTIF
					return true;
				}
			}
			catch (Exception $e)
			{
				return false;
			}
    	}
    	else
    		print_r($host->getErrors());exit;
    }

    public function deactivateCurrentHost($event_id)
    {
    	$host = Host::model()->find('event_id = '.$event_id.' AND status_id = 1');

    	$host->status_id = 2;

    	$valid = $host->validate();

    	if($valid)
    	{
    		try
			{
				if($host->save())
					return true;
			}
			catch (Exception $e)
			{
				return false;
			}
    	}
    	else
    		print_r($host->getErrors());exit;
    }
}
