<?php
/**
 * userFixture
 *
 */
class UserFixture extends CakeTestFixture {

  public $import = array(
    'model' => 'User'
  );


/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'group_id' => '1000',
			'username' => 'admin',
			'password' => '84f29ad73c217a078daf75a6d036fe5f3add395d',
			'email' => 'zjczhjuncai@gmail.com',
			'slave_email' => null,
			'first_name' => 'Super',
			'last_name' => 'Admin',
			'confirm_code' => null,
			'last_login' => null,
			'created' => '2013-06-22 22:45:02',
			'modified' => '2013-06-22 22:45:02',
			'is_active' => true,
			'is_delete' => true,
			'total_point' => null
		),

		array(
			'id' => '9999',
			'group_id' => '1002',
			'username' => 'cakephp',
			'password' => '54f8b7323f832264bd73235796ea613f606d4758',
			'email' => 'cakephp@gmail.com',
			'slave_email' => null,
			'first_name' => null,
			'last_name' => null,
			'confirm_code' => null,
			'last_login' => null,
			'created' => '2013-07-06 02:53:23',
			'modified' => '2013-07-06 02:53:23',
			'is_active' => true,
			'is_delete' => null,
			'total_point' => null
		),
	);

}
