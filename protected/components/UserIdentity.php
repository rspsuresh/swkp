<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
/*    public function __construct($username, $password, $ipin)
    {
        parent::__construct($username, $password);
        $this->ipin=$ipin;
        print_r($ipin);die;
    }*/
    public function authenticate() {
        $users = UserDetails::model()->with('UserType', 'ClientDetails')->findByAttributes(array("ud_username" => $this->username, "ud_password" =>md5($this->password),'ud_flag'=>'A'));
        if (!isset($users["ud_username"]))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif (!isset($users["ud_password"]))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $users['ud_refid'];
            Yii::app()->request->cookies['username'] = new CHttpCookie('username', $this->username);
            Yii::app()->request->cookies['password'] = new CHttpCookie('password', $this->password);
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}