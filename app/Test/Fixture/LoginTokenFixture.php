<?php
/**
 * LoginTokenFixture
 *
 */
class LoginTokenFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'LoginToken');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'user_id' => '9999',
			'token' => '0efb582546d4a40f4498557adcf675f8',
			'duration' => '1 day',
			'used' => '1',
			'created' => '2013-07-04 13:56:52',
			'expired' => '2013-07-04 14:24:07'
		),
	);

}
