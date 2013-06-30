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
}
