<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 * @property User $User
 */
class Group extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

  /**
   * Site Administrator, Super user
   */
  const USER_GROUP_SITE_ADMIN      = 1000;

  /**
   * Account Admin, aka External Administrator
   */
  const USER_GROUP_ACCOUNT_ADMIN   = 1001;

  /**
   * Normal User who can add post comments on accounts
   */
  const USER_GROUP_MEMBER          = 1002;

  public static $USER_GROUP_NAMES = array(
    self::USER_GROUP_SITE_ADMIN     => 'Site Administrator',
    self::USER_GROUP_ACCOUNT_ADMIN  => 'Account Administrator',
    self::USER_GROUP_MEMBER         => 'Member'
  );


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
