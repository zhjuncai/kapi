<?php
App::uses('UsersController', 'Controller');

/**
 * UsersController Test Case
 *
 */
class UsersControllerTest extends ControllerTestCase {

  /**
   * Fixtures
   *
   * @var array
   */
  public $fixtures = array(
    'app.user',
    'app.login_token',
  );

  public function testLogin(){
    $loginData = array(
      "username" => "admin",
      "password" => "password"
    );
    $results = $this->testAction('/users/login', array('data' => $loginData, 'method' => 'post'));
    $returnObj = json_decode($results, true);
    $this->assertNotEmpty($returnObj);
    $this->assertArrayHasKey('token', $returnObj);

    $wrongUser = array(
      "username" => 'cakephp',
      "password" => 'somenost'
    );
    $results = $this->testAction('/users/login', array('data' => $wrongUser, 'method' => 'post'));
    $returnObj = json_decode($results, true);
    $this->assertNotEmpty($returnObj);
    $this->assertArrayHasKey('error', $returnObj);
    $this->assertArrayNotHasKey('token', $returnObj);

    $results = $this->testAction('/users/login', array('method' => 'get'));
    $this->assertEqual($this->controller->response->statusCode(), 405);
    $this->assertNotEmpty($this->controller->response->body());
  }

}
