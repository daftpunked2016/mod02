<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$username = strtolower($this->username);
		$account=Account::model()->find('LOWER(username)="'.$username.'" and status_id NOT IN (2,3,4) AND account_type_id = 1');
		if($account===null)
			Yii::app()->user->setFlash('error', 'Username / password is incorrect');	
		else if(!$account->validatePassword($this->password))
		{
			echo $account->validatePassword($this->password);
			Yii::app()->user->setFlash('error', 'Username / password is incorrect');	
		}
		else
		{
			$this->_id=$account->id;
			$this->username=$account->username;
			$this->setState('roles', $account->getRole());
			$this->setState('account_type_id', $account->account_type_id);
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}
	
	/**
	 * Override getId() method
	 */
	public function getId()
	{
		return $this->_id;
	}
}