<?php
App::uses('Image', 'Model');

/**
 * Image Test Case
 *
 */
class ImageTest extends CakeTestCase {

  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.image',
    // 'app.menuitem',
    // 'app.menu',
    'app.account',
    'app.review',
    'app.feature',
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Image = ClassRegistry::init('Image');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Image);

    parent::tearDown();
  }

  public function testImage(){
    $this->assertTrue(true);
  }

}
