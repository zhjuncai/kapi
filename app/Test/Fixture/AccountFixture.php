<?php
/**
 * AccountFixture
 *
 */
class AccountFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'comment' => 'Business Name', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4000, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'level' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'identify account as basic or premium?'),
		'openTo' => array('type' => 'time', 'null' => true, 'default' => null),
		'level_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'integer', 'null' => false, 'default' => null),
		'type_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'country' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'state' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'suburb' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'zipcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'street' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'comment' => 'Address', 'charset' => 'utf8'),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mobile_num' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mobile_num2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fax' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'geolat' => array('type' => 'float', 'null' => true, 'default' => null),
		'geolng' => array('type' => 'float', 'null' => true, 'default' => null),
		'avg_spending' => array('type' => 'integer', 'null' => true, 'default' => null),
		'seat_num' => array('type' => 'integer', 'null' => true, 'default' => null),
		'biz_hour_from' => array('type' => 'time', 'null' => true, 'default' => null),
		'biz_hour_to' => array('type' => 'time', 'null' => true, 'default' => null),
		'enabled' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => 1, 'comment' => 'Status (Enable/Disable)'),
		'note' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Creation Date'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'biz_day_from' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'biz_day_to' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'expire_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'open_hour' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => 'open hour text for display', 'charset' => 'utf8'),
		'allow_review' => array('type' => 'text', 'null' => true, 'default' => 'b\'1\'', 'length' => 1, 'comment' => 'is account allow user to comment? switch'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'level' => 1,
			'openTo' => '13:26:18',
			'level_name' => 'Lorem ipsum dolor sit amet',
			'type' => 1,
			'type_name' => 'Lorem ipsum dolor sit amet',
			'country' => 'Lorem ipsum dolor sit amet',
			'state' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'suburb' => 'Lorem ipsum dolor sit amet',
			'zipcode' => 'Lorem ip',
			'street' => 'Lorem ipsum dolor sit amet',
			'telephone' => 'Lorem ipsum dolor ',
			'mobile_num' => 'Lorem ipsum dolor ',
			'mobile_num2' => 'Lorem ipsum dolor ',
			'fax' => 'Lorem ipsum dolor ',
			'email' => 'Lorem ipsum dolor sit amet',
			'website' => 'Lorem ipsum dolor sit amet',
			'geolat' => 1,
			'geolng' => 1,
			'avg_spending' => 1,
			'seat_num' => 1,
			'biz_hour_from' => '13:26:18',
			'biz_hour_to' => '13:26:18',
			'enabled' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2013-07-21 13:26:18',
			'modified' => '2013-07-21 13:26:18',
			'biz_day_from' => 'Lorem ipsum dolor ',
			'biz_day_to' => 'Lorem ipsum dolor ',
			'expire_date' => '2013-07-21 13:26:18',
			'open_hour' => 'Lorem ipsum dolor sit amet',
			'allow_review' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
