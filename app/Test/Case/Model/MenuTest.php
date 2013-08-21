<?php
App::uses('Menu', 'Model');

/**
 * Menu Test Case
 *
 */
class MenuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.menu',
		'app.account',
		'app.review',
		'app.user',
		'app.group',
		'app.login_token',
		'app.review_image',
		'app.image',
		'app.menuitem',
		'app.feature',
		'app.account_feature',
		'app.category',
		'app.account_category',
		'app.account_image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Menu = ClassRegistry::init('Menu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Menu);

		parent::tearDown();
	}

}
