<?php
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 * @property Account $Account
 * @property Menuitem $Menuitem
 */
class Menu extends AppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';

  /**
   * Validation rules
   *
   * @var array
   */
  public $validate = array(
    'account_id' => array(
      'numeric' => array(
        'rule' => array('numeric'),
        //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
      ),
    ),
    'name' => array(
      'notempty' => array(
        'rule' => array('notempty'),
        //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
      ),
    ),
    'is_published' => array(
      'boolean' => array(
        'rule' => array('boolean'),
        //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
    )
  );

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
    'Menuitem' => array(
      'className' => 'Menuitem',
      'foreignKey' => 'menu_id',
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
