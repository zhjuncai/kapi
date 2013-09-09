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
  public function testAccountImageUpload() {

/*    $this->testAction('/users/login', array(*/
      //'method' => 'post',
      //'data'   => array('username' => 'admin', 'password' => 'password')
    //));

    //$this->Controller = $this->generate('Upload', array(
      //'components' => array(
        //'Auth'  => array('user')
      //),
      //'methods' => array(
        //'account', 'isAuthorized'
      //),
      //'models'  => array(
        //'Account' => 'saveImages'
      //)
    //));

    //$this->Controller->->staticExpects($this->once())->method('saveImages');

    //$this->Controller->Auth->staticExpects($this->any())->method('user')
    //->with('id')->will($this->returnValue(1));
    //
    $registerUrl = 'http://localhost/kapi/users/register';
    $userInfo = array('username' => 'kaigenie', 'password' => 'password', 'email'=>'email@test.com');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $registerUrl);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $userInfo);
    $curlResult = curl_exec($curl);
    if(!$curlResult){
      trigger_error(curl_error($curl));
    }
    curl_close($curl);

    $loginUrl = 'http://localhost/kapi/users/login';
    $credentials = array('username' => 'kaigenie', 'password' => 'password');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $loginUrl);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $credentials);
    $curlResult = curl_exec($curl);
    if(!$curlResult){
      trigger_error(curl_error($curl));
    }
    curl_close($curl);

    $targetUrl = 'http://localhost/kapi/upload/account/1';

    $filename = '@'. ROOT . DS . APP_DIR . DS . 'Test' . DS . 'Case' . DS . 'Files' . DS . 'image_test.png';
    $postFields = array('file_contents' => $filename);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $targetUrl);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($curl, CURLOPT_HEADER, array(
      'X-Auth-Token' => '1a30e162e6df8ca57b07c3d65c8e6e61'
    ));
    $curlResult = curl_exec($curl);
    if(!$curlResult){
      trigger_error(curl_error($curl));
    }
    curl_close($curl);
  }

}
