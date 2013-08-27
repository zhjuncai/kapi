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
    'app.image',
    'app.accountimage'
  );

  /**
   * setUp method
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();
    $this->Account = ClassRegistry::init('Account');
    $this->Image = ClassRegistry::init('Image');
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
    $revid = null;
    $reviews = $this->Account->getReviews($accid, $revid);

    $this->assertNotEmpty($reviews);
    $this->assertArrayHasKey('Account', $reviews);
    $this->assertArrayHasKey('Review', $reviews);
    $this->assertEquals(count($reviews['Review']), 3);
  }

  public function testSaveImages(){
    $accid = 1;

    $this->Image->recursive = -1;
    $images = $this->Image->find('all');

    $accountImages = $this->Account->saveImages($images, $accid);
    $this->assertNotEmpty($accountImages);
    $this->assertEquals(count($accountImages), 3);

    $this->assertArrayHasKey('AccountImage', $accountImages[0]);
    $this->assertArrayHasKey('account_id', $accountImages[0]['AccountImage']);

    $this->assertEquals($accid, $accountImages[0]['AccountImage']['account_id']);



    $emptyImages = array();
    $accountImages = $this->Account->saveImages($emptyImages, $accid);
    $this->assertEmpty($accountImages);

  }


}
