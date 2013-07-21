<?php
App::uses('AppModel', 'Model');
/**
 * Image Model
 *
 * @property Menuitem $MenuItem
 * @property Account $Account
 */
class Image extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'MenuItem' => array(
			'className' => 'Menuitem',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Account' => array(
			'className' => 'Account',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
