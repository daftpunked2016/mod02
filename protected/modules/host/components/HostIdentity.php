<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class HostIdentity extends CUserIdentity
{
	private $_id;
	public $event_id;
 
 
    //Must need to add
    public function __construct($username, $password, $event_id)
    {
        $this->username = $username;
        $this->password = $password;
        $this->event_id = $event_id;
    }
 
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
		$host = Host::model()->find('LOWER(username)="'.$username.'" AND event_id = '.$this->event_id.' AND status_id NOT IN (2,3,4) AND account_type_id = 3');

		if($host === null)
			Yii::app()->user->setFlash('error', 'Username / Password is incorrect');	
		else if(!$host->validatePassword($this->password))
		{
			echo $host->validatePassword($this->password);
			Yii::app()->user->setFlash('error', 'Username / Password is incorrect');	
		}
		else
		{
			$this->_id=$host->id;
			$this->username=$host->username;
			$this->setState('roles', $host->getRole());
			$this->setState('account_type_id', $host->account_type_id);
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