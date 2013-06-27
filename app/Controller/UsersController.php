<?php
App::uses('AppController', 'Controller');

App::uses('Group', 'Model');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {

  public $components = array('RequestHandler');

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

  public function all(){

    $users = $this->User->find('all');

    $this->set('_serialize', 'users');
    $this->set('users', $users);
  }


  public function register(){

    $this->autoLayout = false;
    $this->autoRender = false;

    if($this->request->is('post')){

      $username = $this->data['username'];
      $email = $this->data['email'];

      $default = array(
        'is_active' => false,
        'group_id' => Group::USER_GROUP_MEMBER,
        'is_delete' => false,
      );

      $newUser = $this->User->create(array_merge($default, $this->data));

      if($this->User->isUserExist($username)){
        $response = array('error' => __(sprintf('Username %s already been registered', $username)));
        return new CakeResponse(array('body'=>json_encode($response)));
      }

      if($this->User->isEmailExist($email)){
        $response = array('error' => __(sprintf('Email %s already been taken', $email)));
        return new CakeResponse(array('body'=>json_encode($response)));
      }

      $saveUser = $this->User->save($newUser);
      return new CakeResponse(array('body' => json_encode($saveUser)));

    }

  }

}
