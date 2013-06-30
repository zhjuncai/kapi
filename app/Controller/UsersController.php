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
      $this->response->type('json');
      $this->response->httpCodes(406);
      $this->response->body('HTTP Method is not supported');
    }


  }

  public function logout() {
    $this->Auth->logout();
    $this->User->logout($this->token());
  }

}
