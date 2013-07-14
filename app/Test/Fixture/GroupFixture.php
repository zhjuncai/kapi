<?php
/**
 * GroupFixture
 *
 */
class GroupFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'Group');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1000',
			'name' => 'Site Administrator',
			'description' => 'Site Administrator',
			'created' => '2013-06-22 22:45:02',
			'modified' => '2013-06-22 22:45:02'
		),
		array(
			'id' => '1001',
			'name' => 'Account Administrator',
			'description' => 'Account Administrator',
			'created' => '2013-06-22 22:45:02',
			'modified' => '2013-06-22 22:45:02'
		),
		array(
			'id' => '1002',
			'name' => 'Member',
			'description' => 'Member',
			'created' => '2013-06-22 22:45:02',
			'modified' => '2013-06-22 22:45:02'
		),
	);

}
