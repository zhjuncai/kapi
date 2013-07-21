<?php
App::uses('AppModel', 'Model');
/**
 * Menuitem Model
 *
 * @property Menu $Menu
 */
class Menuitem extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'menuitem';

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
		'Menu' => array(
			'className' => 'Menu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
