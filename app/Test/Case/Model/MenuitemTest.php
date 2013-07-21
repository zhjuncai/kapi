<?php
App::uses('Menuitem', 'Model');

/**
 * Menuitem Test Case
 *
 */
class MenuitemTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.menuitem',
		'app.menu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Menuitem = ClassRegistry::init('Menuitem');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Menuitem);

		parent::tearDown();
	}

}
