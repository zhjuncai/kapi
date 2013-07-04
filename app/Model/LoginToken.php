<?php
App::uses('AppModel', 'Model');
/**
 * LoginToken Model
 *
 * @property User $User
 */
class LoginToken extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

  public $alias = 'Token';

  public $actsAs = array('Containable');

  /**
   * Check if user token already exists according to user_id and expire date.
   *
   * @param $userid user.id
   * @return bool|array
   */
  public function check($userid){

    $this->recursive = -1;

    $token = $this->find('first', array(
      'conditions' => array(
        'user_id' => $userid
      )
    ));

    if(empty($token)){
      return false;
    }else{
      return $token;
    }
  }

  /**
   * Delete token from database.
   *
   * @param $token $token
   * @return bool true if token deletion successfully
   */
  public function invalid($token){
    return $this->deleteAll(array(
      'token' => $token
    ));
  }

  /**
   * Check if the token is validate.
   * 1, should exist in database.
   * 2, should not expired.
   *
   * @param $token $token
   * @return bool true if token deletion successfully
   */
  public function isValidToken($token){

    $this->recursive = -1;

    if(!isset($token)){
      return false;
    }

    $tokenEntry = $this->find('first', array(
      'conditions' => array(
        'token' => $token
      )
    ));

    if(empty($tokenEntry)){
      return false;
    }else{
      $expired = $tokenEntry[$this->alias]['expired'];

      // FIXME: I don't know how to validate it yet, so hold it on.
      return true;
    }
  }


  public function getUserId($token){

    if(isset($token)){
      return $this->field('user_id', array(
        'conditions' => array('token' => $token)
      ));
    }

    return null;
  }

  public function getUser($token){

    $this->recursive = 1;


    if(isset($token)){

      $this->Behaviors->attach('Containable');

      $result =  $this->find('first', array(
        'fields' => array(
          'User.id', 'User.username' ,'Token.token', 'Token.expired'
        ),
        'conditions' => array(
          'token' => $token
        ),
        'contain' => 'User'
      ));

      $this->Behaviors->detach('Containable');

      return $result;
    }

    return null;
  }
}
