<?php
App::uses('AppModel', 'Model');
/**
 * Review Model
 *
 * @property Account $Account
 * @property User $User
 * @property ReviewImage $ReviewImage
 */
class Review extends AppModel {


  public $REVIEW_STATUS = array(
    "pending"   => 0,
    'denied'    => -1,
    "approved"  => 1
  );

  /**
   * User submitted the account comment but haven't been reviewd by administrator.
   */
  const STATUS_PENDING     = 0;
  /**
   * User comments might have insult words that denied by administrator
   */
  const STATUS_DENIED      = -1;
  /**
   * User's comments had been approved.
   */
  const STATUS_APPROVED    = 1;

  /**
   * Validation rules
   *
   * @var array
   */
  public $validate = array(
    'comment' => array(
      'notempty' => array(
        'rule' => array('notempty'),
        'message' => 'comment can not leave as blank',
        'allowEmpty' => false,
        'required' => false,
        'last' => false, // Stop validation after this rule
        'on' => 'create', // Limit validation to 'create' or 'update' operations
      ),
    ),
    'gene_rating' => array(
      'inlist' => array(
        'rule' => array('inlist', array(1, 5)),
        'message' => 'only 1 to 5 is allowed',
        'allowEmpty' => false,
        //'required' => false,
        'last' => false, // Stop validation after this rule
        'on' => 'create', // Limit validation to 'create' or 'update' operations
      ),
    ),
    'service_rating' => array(
      'between' => array(
        'rule' => array('between',1, 5),
        'message' => 'only 1 to 5 is allowed'
      ),
    ),
    'envi_rating' => array(
      'between' => array(
        'rule' => array('between',1, 5),
        'message' => 'only 1 to 5 is allowed'
      ),
    ),
    'food_rating' => array(
      'between' => array(
        'rule' => array('between', 1, 5),
        'message' => 'only 1 to 5 is allowed'
      ),
    ),
  );

  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
    'Account' => array(
      'className' => 'Account',
      'foreignKey' => 'account_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    ),
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'user_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    )
  );

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
    'ReviewImage' => array(
      'className' => 'ReviewImage',
      'foreignKey' => 'review_id',
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
