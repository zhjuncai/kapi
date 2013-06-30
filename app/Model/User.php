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

  var $actsAs = array('Multivalidatable');

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

  /**
   * Check if an username is reserved or already registered.
   *
   * @param null $username Username
   * @return bool return true if the username is reserved or exists
   */
  public function isUserExist($username = null){

    $exist = false;

    $user = $this->find('count', array(
      'conditions' => array(
        'username' => $username
      )
    ));

    if(isset($user) && !empty($user)){
      $exist = true;
    }else{
      $exist = in_array($username, $this->RESEVER_USERNAME) ? true : false;
    }

    return $exist;
  }

  /**
   * Check if the email address already been used or not
   *
   * @param null $email Primary email address
   * @return bool return true if email had been used
   */
  public function isEmailExist($email = null){

    $user = $this->find('count', array(
      'conditions' => array(
        'email' => $email
      )
    ));

    return empty($user) ? false : true;
  }


  public function login($username, $password){

    $validated = $this->check($username, $password);

    return $validated;

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
   * @return bool
   */
  protected function check($username, $password){
    if(empty($username) || empty($password)){
      return false;
    }else{
      $hashPwd = AuthComponent::password($password);

      $user = $this->find('first', array(
        'fields' => array('password', 'is_active', 'is_delete', 'last_login'),
        'conditions' => array('username' => $username)
      ));

      $actived = (bool)$user[$this->alias]['is_active'];
      $deleted = (bool)$user[$this->alias]['is_delete'];
      $matched = $hashPwd == $user[$this->alias]['password'] ? true : false;

      if($matched && $actived && !$deleted){
        // only when active & non-deleted user password is correct
        return true;
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
      'password' => array(
        'rule' => array('minLength', 6),
        'message' => 'Password must be at least 6 characters long, please try again.'
      )
    )
  );


}
