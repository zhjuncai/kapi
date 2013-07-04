<?php
App::uses('AppController', 'Controller');

App::uses('Group', 'Model');
App::uses('TokenUtil', 'Utility');

/**
 * Users Controller
 *
 */
class UsersController extends AppController {

  public $name = 'user';

  public $uses = array('User');

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

  public function test(){

    $users = $this->User->find('all');

    $this->setResponse($users);

  }


  /**
   * Register an user. This function only accept POST json data as input, then save the corresponding
   * user information into User table.
   *
   * Json format need at least contain following fields
   * <ul>
   *  <li>username </li>
   *  <li>password </li>
   *  <li>email </li>
   * </ul>
   * @return CakeResponse JSON Response
   */
  public function register(){


    $this->User->setValidation('register');

    if($this->request->is('post')){

      $username = $this->data['username'];
      $email = $this->data['email'];

      $default = array(
        'is_active' => true,
        'group_id' => Group::USER_GROUP_MEMBER,
        'is_delete' => null,
      );

      $newUser = $this->User->create(array_merge($default, $this->data));

      if($this->User->isUserExist($username)){
        $response = array('error' => __(sprintf('Username %s already been registered', $username)));
        $this->setResponse($response);
        return;
      }

      if($this->User->isEmailExist($email)){
        $response = array('error' => __(sprintf('Email %s already been taken', $email)));
        $this->setResponse($response);
        return;
      }

      $saveUser = $this->User->save($newUser);
      $validationErrors = $this->User->validationErrors;
      $responseBody = empty($validationErrors) ? $saveUser : $validationErrors;
      $this->setResponse($responseBody);
    }

  }

  /**
   * Let user login system and create & save login token into database. It either return json or xml format
   * according to url extension parsing and the response body inclduing a token that used to verify user other
   * requests going forward
   *
   */
  public function login(){

    if($this->request->is('post')){

      $username = $this->data['username'];
      $password = $this->data['password'];

      $loginResult = $this->User->login($username, $password);

      if($loginResult){
        // login success
        $token = TokenUtil::normalizeToken($loginResult);
        $this->setResponse($token);

      }else{
        // fail to login, need notify requester
        $this->setResponse(array('error' => 'either username or password is incorrect'));

      }
    }else{
        $this->notSupport();
    }


  }

  /**
   * Log an user out from the system. Do two things, one is delete user session if exists, and remove
   * login token from database.
   */
  public function logout() {
    $this->Auth->logout();
    $this->User->logout($this->token());
  }

  /**
   * Change a user password.
   *
   * User who uses this function should provide username, old password, new password and confirmed password.
   *
   */
  public function changePassword(){

    if($this->request->is('post')){
      // only post method could change password
      $this->User->setValidation('changePassword');

      $username = $oldPass = $newPass = null;

      if(isset($this->data['username'])){
        $username = trim($this->data['username']);
      }
      
      if(isset($this->data['oldPass'])){
        $oldPass = $this->data['oldPass'];
      }

      if(isset($this->data['newPass'])){
        $newPass = $this->data['newPass'];
      }

      $token = $this->token();

      if($oldPass){
        // username and password provided, no token needed.
        $existUser = $this->User->isUserExist($username);
        if(!$existUser){
          $this->setResponse(array('error'=>'user does not exist.'));
          return;
        }else{
          // user exist, need to check if the old password is correct
          $passedUser = $this->User->check($username, $oldPass);

          $updateSucceed = $this->User->updatePassword($username, $newPass, $passedUser, null);
          if($updateSucceed){
            $this->setResponse(array(
              'result' => true,
              'message' =>'your password was updated'
            ));
            return;
          }else{
            $this->setResponse(array(
              'result' => false,
              'message' => 'Your password is incorrect.'
            ));
            return;
          }

        }
      }else{
        // if old password is not provided, we need token to validate user.
        if(!empty($token) && $this->User->validToken($token)){
          $updateSucceed = $this->User->updatePassword($username, $newPass, null, $token);

          if($updateSucceed){
            $this->setResponse(array(
              'result' => true,
              'message' =>'your password was updated'
            ));
          }else{
            $this->setResponse(array(
              'result' => false,
              'message' =>'your password fail to update.'
            ));
          }
          return;
        }else{
          $this->setResponse(array(
            'result' => false,
            'message' => 'user need authentication to change password'
          ));
          return;
        }
      }
    }else{
      $this->notSupport();
    }

  }

}
