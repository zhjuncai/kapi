<?php
/**
 * ReviewFixture
 *
 */
class ReviewFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'account_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'comment' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 4000, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'comment' => 'pending, approved, spam', 'charset' => 'utf8'),
		'gene_rating' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'general rating'),
		'service_rating' => array('type' => 'integer', 'null' => true, 'default' => null),
		'envi_rating' => array('type' => 'integer', 'null' => true, 'default' => null),
		'food_rating' => array('type' => 'integer', 'null' => true, 'default' => null),
		'suggest_item' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_general_ci', 'comment' => 'use comma seperate menu item id holding user suggest food item', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modifiedBy' => array('type' => 'integer', 'null' => true, 'default' => null),
		'note' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_general_ci', 'comment' => 'comments that why it should be rejected', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_Reviews_Accounts1_idx' => array('column' => 'account_id', 'unique' => 0),
			'fk_Reviews_Users1_idx' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'account_id' => 1,
			'user_id' => 1,
			'comment' => 'Lorem ipsum dolor sit amet',
			'status' => '',
			'gene_rating' => 1,
			'service_rating' => 1,
			'envi_rating' => 1,
			'food_rating' => 1,
			'suggest_item' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-08-12 21:16:56',
			'modified' => '2013-08-12 21:16:56',
			'modifiedBy' => 1,
			'note' => 'Lorem ipsum dolor sit amet'
		),
	);

}
