<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class HostLoginForm extends CFormModel
{
	public $username;
	public $password;
	public $event_id;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
	
		return array(
			// username and password are required
			array('username, password', 'required'),
			array('username', 'email'),
			array('event_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>60),
			array('username', 'length', 'max'=>128),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
			'username'=>'Username / Email',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{			
			$this->_identity = new HostIdentity($this->username,$this->password, $this->event_id);

			if(!$this->_identity->authenticate())
			{
				$this->addError('password','Incorrect email address or password.');
			} 
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity = new HostIdentity($this->username,$this->password, $this->event_id);
			$this->_identity->authenticate($this->event_id);
		}
		if($this->_identity->errorCode===HostIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 60; // 30 days
			Yii::app()->getModule('host')->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	
		 

}