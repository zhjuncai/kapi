<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * User Model
 *
 * @property Reward $Reward
 * @property Group $Group
 */
class User extends AppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'username';

  public $actsAs = array('Multivalidatable');


  private $RESEVER_USERNAME = array(
    'admin', 'administrator', 'test', 'tester', 'ethan' , 'user'
  );

  //The Associations below have been created with all possible keys, those that are not needed can be removed
  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
    'Group' => array(
      'className' => 'Group',
      'foreignKey' => 'group_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    )
  );

  public $hasOne = array(
    'Token' => array(
      'className' => 'LoginToken'
    )
  );

  /**
   * Check if an username is reserved or already registered.
   *
   * @param null $username Username
   * @return bool return true if the username is reserved or exists
   */
  public function isUserExist($username = null){

    $exist = false;

    $exist = in_array($username, $this->RESEVER_USERNAME) ? true : false;

    if($exist){
      return $exist;
    }else{
      $this->recursive = -1;

      $user = $this->find('count', array(
        'conditions' => array(
          'username' => $username
        )
      ));

      return $user > 0 ? true :false;
    }

  }

  /**
   * Check if the email address already been used or not
   *
   * @param null $email Primary email address
   * @return bool return true if email had been used
   */
  public function isEmailExist($email = null){

    $this->recursive = -1;

    $user = $this->find('count', array(
      'conditions' => array(
        'email' => $email
      )
    ));

    return empty($user) ? false : true;
  }


  /**
   * Sign on one user.
   *
   * - Check username & password
   * - If username and password match exactly
   * -- update last login timestamp
   * -- Create or update login token
   *
   * @param $username User username
   * @param $password User password
   * @return bool|mixed
   */
  public function authenticate($username, $password){

    $validated = $this->check($username, $password);

    if($validated){
      // validate username & password

      $userId = $validated[$this->alias]['id'];

      // update last update field
      $this->updateLastLogin($userId);

      // generate user login token.
      $loginToken = $this->updateLoginToken($userId, $username, $password);

      return $loginToken;
    }
    return $validated;
  }

  /**
   * Logout an user.
   *
   * @param null $token
   */
  public function logout($token = null){
    $this->Token->invalid($token);
  }

  /**
   * Check the username and password in order to validate request user.
   *
   * Rule 1, Password Match
   * Rule 2, User is active
   * Rule 3, Non-deleted
   *
   * @param $username User.username
   * @param $password User.password
   * @return bool false or user entity
   */
  public function check($username, $password){

    $this->recursive = -1;

    if(empty($username) || empty($password)){
      return false;
    }else{
      $hashPwd = AuthComponent::password($password);

      $user = $this->find('first', array(
        'fields' => array('id','password', 'is_active', 'is_delete', 'last_login'),
        'conditions' => array('username' => $username)
      ));

      if(empty($user)){
        // return directly if no user found
        return false;
      }

      $actived = (bool)$user[$this->alias]['is_active'];
      $deleted = (bool)$user[$this->alias]['is_delete'];
      $matched = $hashPwd == $user[$this->alias]['password'] ? true : false;

      if($matched && $actived && !$deleted){
        // only when active & non-deleted user password is correct
        return $user;
      }else{
        CakeLog::warning(sprintf("failed to login user %s", $username));
        CakeLog::warning(sprintf("is_active=%s, is_delete=%s", $actived, $deleted));
        return false;
      }
    }

  }

  /**
   * Hash the password before saving user in db.
   *
   * @param array $option
   * @return bool|void
   */
  public function beforeSave($option = array()){
    if(isset($this->data[$this->alias]['password'])){
      $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }

  }

  /**
   * Default validation ruleset
   */
  var $validate = array(
    'username' => array('rule' => 'alphanumeric', 'message' => 'Only letters and numbers please.'),
    'password' => array('rule' => array('minLength', 6), 'message' => 'Password must be at least 6 characters long.'),
    'email' => array('rule' => 'email', 'message' => 'Must be a valid email address.'),
  );

  /**
   * Custom validation rulesets
   */
  var $validationSets = array(

    'register' => array(
      'username' => array(
        'username-6' => array(
          'rule' => array('minLength', 6),
          'message' => 'Username must be at least 6 characters long.'
        ),
        'username-alphanumeric' => array(
          'rule' => 'alphanumeric',
          'message' => 'Only letters and numbers, please try again.'
        )

      ),
      'password' => array(
        'rule' => array('minLength', 6),
        'message' => 'Password must be at least 6 characters long, please try again.'
      ),
      'email' => array(
        'rule' => 'email',
        'message' => 'Must be a valid email address.'
      ),
    ),
    'changePassword' => array(

      'username' => array(
        'username-6' => array(
          'rule' => array('minLength', 6),
          'message' => 'Username must be at least 6 characters long.'
        ),
        'username-alphanumeric' => array(
          'rule' => 'alphanumeric',
          'message' => 'Only letters and numbers, please try again.'
        )

      ),
      'password' => array(
        'rule' => array('minLength', 6),
        'message' => 'Password must be at least 6 characters long, please try again.'
      )
    )
  );

  /**
   * Update the last_login field.
   *
   * @param $userId user primary key
   */
  public function updateLastLogin($userId)
  {
    $this->id = $userId;
    $this->saveField('last_login', date('Y-m-d H:i:m', time()));
  }

  /**
   * see if token already exists for passing user id and extends expire date accordingly, otherwise create
   * one brand new token for this user.
   *
   * @param $userId User id
   * @param $username User username
   * @param $password User password
   * @return mixed
   */
  public function updateLoginToken($userId, $username, $password)
  {

    $existToken = $this->Token->check($userId);

    if($existToken){
      $this->Token->id = $existToken[$this->Token->alias]['id'];
      $this->Token->saveField('expired', date('Y-m-d H:i:m', time()));
      return $existToken;
    }

    $token = md5(uniqid(mt_rand(), true) . time() . $username . $password);

    // TODO: might need make it configurable
    $duration = '1 day';

    $this->Token->create(array(
      'user_id' => $userId,
      'token' => $token,
      'duration' => $duration,
      'used' => 1,
      'expired' => date('Y-m-d H:i:m', strtotime($duration))
    ));

    $loginToken = $this->Token->save();
    return $loginToken;
  }

  /**
   * Change user password.
   *
   * @param $user User an user instance
   * @param $newPassword new password need to be updated
   * @return bool true if update success
   */
  public function updatePassword($username, $newPassword, $user = null, $token = null){

    if($user){
      $userId = $user[$this->alias]['id'];
      $this->id = $userId;
      return $this->saveField('password', $newPassword);
    }else if(isset($token)){
      // to prevent user update other people's password, we need verify username here.

      $tokenUser = $this->Token->getUser($token);

      if(empty($tokenUser) || $username !== $tokenUser[$this->alias]['username']){
        return false;
      }else{
        $userId = $tokenUser[$this->alias]['id'];
        $this->id = $userId;
        return $this->saveField('password', $newPassword);
      }

    }else{
      return false;
    }


  }

  public function validToken($token){
    return $this->Token->isValidToken($token);
  }

  /* public getUserByToken($token) {{{ */
  /**
   * getUserByToken
   *
   * @param mixed $token
   * @access public
   * @return void
   */
  public function getUserByToken($token){

    $user = $this->Token->getUser($token);

    if(isset($user['Token'])){
      unset($user['Token']);
    }

    return $user;

  }
  /* }}} */
}
