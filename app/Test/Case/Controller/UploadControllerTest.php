<?php
App::uses('UploadController', 'Controller');

/**
 * UploadController Test Case
 *
 */
class UploadControllerTest extends ControllerTestCase {

  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.account',
    'app.user',
    'app.group',
    'app.login_token',
    'app.image',
    'app.account_image'
  );

  /**
   * testAccount method
   *
   * @return void
   */
  public function testAccount() {
    debug('in controller test case');
  }

}
