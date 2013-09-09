<?php
App::uses('AppController', 'Controller');
App::uses('Account', 'Model');
App::uses('Review',  'Model');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class AccountsController extends AppController {

  public $uses = array('Account', 'Review');

  public function beforeFilter(){
    $this->Auth->allow('suggest');
    $this->autoRender = false;

  }

  /**
   * User suggest an account, it used to save a brand new acccount that suggest by register when they couldn't find it
   * in our system.
   * @access public
   * @return void
   */
  public function suggest(){
    // only when user post json format
    if($this->request->is('post')){
      $account = $this->parseCreateAccountRequest();
      $createdAccount = $this->Account->save($account);

      $validationErrors = $this->Account->validationErrors;
      $responseBody = empty($validationErrors) ? $createdAccount : $validationErrors;
      $this->setResponse($responseBody);
    }else{
      $this->notSupport();
    }
  }


  /*
   * This method is used for register user add comments. Register user are
   * supposed to add comments when he/she is viewing the account, the web
   * service URL is /accounts/{accid}/comments
   *
   * @access public
   * @return void
   */
  public function comments($accid){

    // first we need to check if the account exists in our system and not been
    // deleted and it's still an enable account
    $exists = $this->Account->exists($accid);
    if(!$exists){
      $responseBody = array(
        'error'     => __("Account %s is not found", $accid)
      );
      $this->response->statusCode(404);
      $this->setResponse($responseBody);
      return;
    }

    $method = strtolower($this->httpMethod());
    switch($method){
      case 'get':
        echo "pull all reviews for this account";
        break;
      case 'post':
        echo "save review";

        $allowComment = $this->Account->allowComment($accid);
        if(!$allowComment){
          $this->setResponse(array('error' => __('comments on account is turned off.')));
          return;
        }
        $parsedComment = $this->parseCommentRequest($accid);

        $saved = $this->Review->saveAll($parsedComment);
        $validationErrors = $this->Review->validationErrors;

        $succeed = empty($validationErrors) ? true : false;

        if($succeed){
          $this->setResponse(array('success' => __("Your review had been saved")));
        }else{
          $this->setResponse($validationErrors);
        }

        break;
      case 'put':
        echo "change review?";
        break;
      default:
        echo "not supported";
    }

  }


  /* public comments($accid, $revid = null) {{{ */
  /**
   * Get all of registered user comments by one single account
   *
   * @param mixed $accid
   * @param bool $revid
   * @access public
   * @return void
   */
  public function comments1($accid, $revid){

    $reviews = $this->Account->getReviews($accid, $revid);

    $this->setResponse($reviews);

  }
  /* }}} */



  /* public account_info($accid) {{{ */
  /**
   * This function intend to retrieve all of account information, which include
   * reviews, account detailed info, account photos and menu/menu item etc.
   *
   * @param mixed $accid
   * @access public
   * @return void
   */
  public function account_info($accid){
    // FIXME Need to be implement later

  }
  /* }}} */



  /**
   * Parse user comment from request and set the default status as pending.
   *
   * @access private
   * @return void
   */
  private function parseCommentRequest($accid){
    $data = $this->data;

    $default = array(
      'status'      => Review::STATUS_PENDING,
      'account_id'  => $accid
    );

    $comment = array_merge($data, $default);

    return $this->Review->create($comment);
  }

  /**
   * Parse user request and consolidate the POSTED data as an account object
   *
   * @access private
   * @return array Account instance
   */
  private function parseCreateAccountRequest(){
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
