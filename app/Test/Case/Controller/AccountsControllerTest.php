<?php
App::uses('AccountsController', 'Controller');
App::uses('Account', 'Model');

/**
 * AccountsController Test Case
 *
 */
class AccountsControllerTest extends ControllerTestCase {

  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.account',
    'app.review',
    'app.image',
    'app.reviewimage',
    'app.user',
  );

  public function setUp(){
    parent::setUp();
    $this->Account = ClassRegistry::init('Account');
    $this->Review = ClassRegistry::init('Review');
  }

  public function tearDown(){
    unset($this->Account);
    unset($this->Review);
    parent::tearDown();
  }

  public function testAddValidReview(){

    $accid = 1;
    $userid = 2;

    $reviewContent = array(
      'comment' => 'This account is fantanstic, you will never forget it',
      'gene_rating'     => 1,
      'service_rating'  => 2,
      'food_rating'     => 3,
      'envi_rating'     => 5,
    );

    $userAccInfo = array(
      'user_id'     => $userid,
      'account_id'  => $accid,
    );

    $data = array_merge($reviewContent, $userAccInfo);

    $result = $this->testAction('/accounts/comments/' . $accid, array('method' => 'post', 'data' => $data));
    $resultObj = json_decode($result, true);
    $this->assertNotEmpty($resultObj);
    $this->assertArrayHasKey('success', $resultObj);


    $this->Review->recursive = -1;
    $foundReview = $this->Review->find('first', array(
      'conditions' => $reviewContent
    ));
    // make sure data was saved successfully.
    $this->assertNotEmpty($foundReview);
    // make sure data was saved correctly.
    $this->assertArrayHasKey('Review', $foundReview);
    $this->assertTrue($foundReview['Review']['comment'] == $reviewContent['comment']);
    $this->assertTrue($foundReview['Review']['gene_rating']     == $reviewContent['gene_rating']);
    $this->assertTrue($foundReview['Review']['service_rating']  == $reviewContent['service_rating']);

    $this->assertTrue($foundReview['Review']['food_rating']     == $reviewContent['food_rating']);
    $this->assertTrue($foundReview['Review']['envi_rating']  == $reviewContent['envi_rating']);
  }


  public function testAccountNotExitAddReview(){
    $accid = "notexisted";
    $userid = 2;
    $result = $this->testAction('/accounts/comments/' . $accid, array('method' => 'post', 'data' => array()));
    $jsonObj = json_decode($result, true);
    $this->assertNotEmpty($jsonObj);
    $this->assertArrayHasKey('error', $jsonObj);

  }
  public function testInvalidContentAddReview(){
    $accid = 1;
    $userid = 1;
    $reviewContent = array(
      'comment'   => 'this is not going to be save',
      'gene_rating' => 10,
      'service_rating'  => -2,
      'food_rating'     => 1,
      'envi_rating'     => 'abc'
    );

    $data = array_merge($reviewContent, array(
      'user_id' => $userid,
      'account_id' => $accid
    ));
    $result = $this->testAction('/accounts/comments/' . $accid, array('method' => 'post', 'data' => $data));
    debug($result);
    $jsonObj = json_decode($result, true);
    $this->assertNotEmpty($jsonObj);
  }
}
