<?php
App::uses('User', 'Model');

/**
 * User Test Case
 *
 */
class UserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
    'app.group',
    'app.user',
		'app.login_token'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
    $this->username = 'cakephp';
    $this->password = 'password';
    $this->falsePassword = 'falsepass';
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}

/**
 * testIsUserExist method
 *
 * @return void
 */
	public function testIsUserExist() {

    $admin = $this->User->isUserExist('admin');

    $this->assertEqual($admin, true);

    $notExist = $this->User->isUserExist('user-not-exit');

    $this->assertEqual($notExist, false);


	}

/**
 * testIsEmailExist method
 *
 * @return void
 */
	public function testIsEmailExist() {

    $exist = $this->User->isEmailExist('zjczhjuncai@gmail.com');

    $this->assertEqual($exist, true);

    $exist = $this->User->isEmailExist('no-reply@gmail.com');

    $this->assertEqual($exist, false);
	}

/**
 * testLogin method
 *
 * @return void
 */
	public function testAuthenticate() {


    $cakeUser = $this->User->authenticate($this->username, $this->falsePassword);

    $this->assertEqual($cakeUser, false);

    $cakeUser = $this->User->authenticate($this->username, $this->password);

    $this->assertNotEmpty($cakeUser, 'cakephp user not found');
    $this->assertArrayHasKey('Token',$cakeUser);


	}


/**
 * testCheck method
 *
 * @return void
 */
	public function testCheck() {

    $succeed = $this->User->check($this->username, $this->password);

    $this->assertNotEmpty($succeed);
    $this->assertArrayHasKey($this->User->alias, $succeed);

    $falsy = $this->User->check($this->username, $this->falsePassword);

    $this->assertFalse($falsy);


	}

/**
 * testUpdateLastLogin method
 *
 * @return void
 */
	public function testUpdateLastLogin() {

    $lastLogin = date('Y-m-d H:i:m', time());

    $this->User->updateLastLogin(9999);

    $this->User->id = 9999;
    $updated = $this->User->field('last_login');

    $this->assertIdentical($lastLogin, $updated, 'last update failed');
	}

/**
 * testUpdateLoginToken method
 *
 * @return void
 */
	public function testUpdateLoginToken() {

    $userId = 9999;
    $anotherId = 1;
    $tokenStr = '0efb582546d4a40f4498557adcf675f8';

    $existToken = $this->User->updateLoginToken($userId, $this->username, $this->password);
    $this->assertNotEmpty($existToken);
    $this->assertEqual($existToken['Token']['token'], $tokenStr);


    $newToken = $this->User->updateLoginToken($anotherId, 'admin', 'P@ssword1');
    $this->assertNotEmpty($newToken);
  }

/**
 * testUpdatePassword method
 *
 * @return void
 */
	public function testUpdatePassword() {

    $newPass = 'secret';
    $token = '0efb582546d4a40f4498557adcf675f8';

    $newHashPassword = AuthComponent::password($newPass);

    $user = $this->User->findById(9999);

    $falsy = $this->User->updatePassword($this->username, $newPass, null, null);
    $this->assertFalse($falsy);

    $succeed = $this->User->updatePassword($this->username, $newPass, $user, null);
    $this->assertNotEmpty($succeed);
    $this->assertArrayHasKey($this->User->alias, $succeed);
    $this->assertIdentical($succeed[$this->User->alias]['password'], $newHashPassword);

    $succeed = $this->User->updatePassword($this->username, $newPass, null, $token);
    $this->assertNotEmpty($succeed);
    $this->assertArrayHasKey($this->User->alias, $succeed);
    $this->assertIdentical($succeed[$this->User->alias]['password'], $newHashPassword);

	}

/**
 * testValidToken method
 *
 * @return void
 */
	public function testValidToken() {
	}

}
