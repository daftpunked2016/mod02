<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
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
		$username=strtolower($this->username);
       
	   	$user=Account::model()->isActive()->find('LOWER(username)="'.$username.'" AND account_type_id IN (2,3,4)');
		$userinactive = Account::model()->isInactive()->find('LOWER(username)="'.$username.'" AND  account_type_id IN (2,3,4)');
		$userinactivepause = Account::model()->isInactivePause()->find('LOWER(username)="'.$username.'" AND  account_type_id IN (2,3,4)');
		$userreset = Account::model()->isReset()->find('LOWER(username)="'.$username.'" AND  account_type_id IN (2,3,4)');
		
 	    if($user==null && $userinactive==null && $userinactivepause==null && $userreset==null) {
 	    	Yii::app()->user->setFlash('error', 'Account not available or invalid!');
 	    } else if($userinactive!=null || $userinactivepause!=null) {
			Yii::app()->user->setFlash('error', 'Account is Inactive! Please wait for your LO President approval.');
		// } else if($userreset != null) {
			// $this->_id=$userreset->id;
			// $this->username=$userreset->username;
			// $this->errorCode=self::ERROR_NONE;
			// Yii::app()->user->setFlash('error', 'Updating profile was turned off. Please contact JCIP HQ or NSG for details.');
		} else if(!$user->validatePassword($this->password)) { 
       		$this->errorCode=self::ERROR_PASSWORD_INVALID;
			Yii::app()->user->setFlash('error', 'Email / Password invalid!'); 
		} else {
            $this->_id=$user->id;
            $this->username=$user->username;
            $this->errorCode=self::ERROR_NONE;
        }
		
        return $this->errorCode==self::ERROR_NONE;
	}

	public function authenticateOutside()
	{
		$username=strtolower($this->username);
	   	$user = Account::model()->find('LOWER(username) = :username AND (account_type_id = 2 OR account_type_id = 3)', array(':username'=>$username));

	   	if($user == null) {
	   		return 6; //DATA INVALID
	   	} else {
	   		if(!$user->validatePassword($this->password)) {
	   			return 5; //PASSWORD INVALID
	   		} else {
	   			return $user->status_id; //STATUS OF USER
	   		}
	   	}
	}
	
	public function getId()
    {
        return $this->_id;
    }
}