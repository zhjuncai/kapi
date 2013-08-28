<?php
App::uses('Feature', 'Model');

/**
 * Feature Test Case
 *
 */
class FeatureTest extends CakeTestCase {

  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.feature',
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Feature = ClassRegistry::init('Feature');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Feature);

    parent::tearDown();
  }

  public function testFeature(){
    $allFeatures = $this->Feature->find('all');

    $this->assertEqual(count($allFeatures), 2);
    $this->assertNotEmpty($allFeatures);

  }

}
