<?php
App::uses('AppModel', 'Model');
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

  private $RESEVER_USERNAME = array(
    'admin', 'administrator', 'ethan' , 'user'
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
}
