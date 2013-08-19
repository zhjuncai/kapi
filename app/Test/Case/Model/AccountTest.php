<?php
App::uses('Account', 'Model');

/**
 * Account Test Case
 *
 */
class AccountTest extends CakeTestCase {

  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.account',
    'app.review',
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Account = ClassRegistry::init('Account');
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown() {
    unset($this->Account);

    parent::tearDown();
  }

  public function testGetAllReviews(){
    $accid = 1;

    $reviews = $this->Account->getAllReviews($accid);

    $this->assertNotEmpty($reviews);
    $this->assertArrayHasKey('Account', $reviews);
    $this->assertArrayHasKey('Review', $reviews);
    $this->assertEquals(count($reviews['Review']), 3);
  }
}
