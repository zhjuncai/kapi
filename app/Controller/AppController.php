<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package   app.Controller
 * @link    http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

  const HEADER_AUTH_TOKEN = 'X-Auth-Token';
  const PARAM_AUTH_TOKEN = 'auth_token';

  public $components = array(
    'RequestHandler',
    'Acl',
    'Auth' => array(
      'authorize' => array(
        'Actions' => array('actionPath' => 'controllers')
      ),
      'authError' => 'You have to login.',
      'authenticate' => array(
        'Form' => array(
          'fields' => array('username' => 'username')
        )
      )
    ),
    'Session', 'Paginator'
  );

  public function beforeFilter(){

    $extension = $this->RequestHandler->ext;

    if(empty($extension)){
      // only if no extension found, supress cake no ctp view found error
      $this->autoRender = false;
    }

    // everyone allow to register, login & logout at least.
    $this->Auth->allow(array('register', 'login', 'logout', 'changePassword' ,'test'));
  }

  /**
   * Set Response according to request url and extension.l
   *
   * @param array $responseBody
   * @param string $node
   */
  public function setResponse($responseBody = array(), $node= 'results'){

    $extension =& $this->RequestHandler->ext;

    if(empty($extension)){
      $extension = 'json';
    }

    if($extension == 'xml'){
      $this->set('_serialize', $node);
      $this->set($node, array($responseBody));
    }else{
//      $this->set('_serialize', $node);
//      $this->set($node, $responseBody);

      $this->response->type('json');
      $this->response->body(json_encode($responseBody));
    }
  }

  /**
   * Method not support
   */
  public function notSupport(){
    $this->response->type('json');
    $this->response->httpCodes(406);
    $this->response->body(sprintf('HTTP Method %s is not supported', $this->request->method()));
  }


  /**
   * First get token from http header, then url parameters and last from post body.
   *
   * @return bool|mixed
   */
  public function token(){

    $token = $this->request->header($this::HEADER_AUTH_TOKEN);

    if($token){
      return $token;
    }else{
      $headers = getallheaders();
      if(!empty($headers[$this::HEADER_AUTH_TOKEN])){
        return $headers[$this::HEADER_AUTH_TOKEN];
      }
    }

    if(!empty($_GET[$this::PARAM_AUTH_TOKEN])){
      return $_GET[$this::PARAM_AUTH_TOKEN];
    }

    if(!empty($_POST[$this::PARAM_AUTH_TOKEN])){
      return $_POST[$this::PARAM_AUTH_TOKEN];
    }

    if($this->request->is('post') && !empty($this->data[$this::PARAM_AUTH_TOKEN])){
      return $this->data[$this::PARAM_AUTH_TOKEN];
    }

    return false;
  }

  /**
   * Return HTTP Request method
   *
   * @access public
   * @return http method
   */
  public function httpMethod(){
    return $_SERVER['REQUEST_METHOD'];
  }


  /**
   * Write the last sql log into error.log
   *
   * @param $model String model name.
   */
  public function getLastSqlLog($model){

    $modelInst = $this->{$model};
    $logs = array();

    if($modelInst){
      $logs = $modelInst->getDataSource()->getLog(false, false);
    }

    if(!isset($logs['log'])){
      return;
    }else{
      $lastLog = current(end($logs['log']));

      $this->log($lastLog, $type = LOG_WARNING);
    }


  }
}
