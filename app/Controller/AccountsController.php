<?php
App::uses('AppController', 'Controller');
App::uses('Account', 'Model');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class AccountsController extends AppController {

  public $uses = array('Account');

  public function beforeFilter(){
    $this->Auth->allow('suggest');
    $this->autoRender = false;

  }

  /**
    * User suggest an account, it used to save a brand new acccount that suggest by register when they couldn't find it
    * in our system.
    *
    * @param mixed $var1
    * @param mixed $var2
    * @access public
    * @return void
    */
  public function suggest(){
    // only when user post json format
    if($this->request->is('post')){
      $account = $this->parseRequest();
      $createdAccount = $this->Account->save($account);

      $validationErrors = $this->Account->validationErrors;
      $responseBody = empty($validationErrors) ? $createdAccount : $validationErrors;
      $this->setResponse($responseBody);
    }
  }

  /**
   * Parse user request and consolidate the POSTED data as an account object
   *
   * @access private
   * @return array Account instance
   */
  private function parseRequest(){
    $accData = $this->data;

    $ACC_TYPES = Configure::read('Account.Type');
    $ACC_LEVEL = Configure::read('Account.Level');


    $default = array(
      'level'       => Account::BASIC,
      'level_name'  => $ACC_LEVEL[Account::BASIC],
      'type'        => Account::RESTAURANT,
      'type_name'   => $ACC_TYPES[Account::RESTAURANT],
      'status'      => Account::REGISTERED,
      'enabled'     => false
    );
    $mergedAcc = array_merge($accData, $default);
    return $this->Account->create($mergedAcc);
  }
}
