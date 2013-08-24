<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class TokenAuthenticate extends BaseAuthenticate{

  public function authenticate(CakeRequest $request, CakeResponse $response){
    var_dump($request, $response);

  }

  /* public getUser(CakeRequest $request) {{{ */
  /**
   * Implement token authenticate mechanism, retrieve user based on user passed
   * token, if token is not specified either in form, header or url, then it will
   * return false indicate that user are current not logged in.
   * @param CakeRequest $request
   * @access public
   * @return void
   */
  public function getUser(CakeRequest $request){

    $token = $this->_getToken($request);

    if(!$token){
      return false;
    }

    $foundUser = $this->_findUserByToken($token);
    return $foundUser;
  }
  /* }}} */

  public function _getToken($request){
    $token = $request->header(HEADER_AUTH_TOKEN);
    if($token){
      return $token;
    }else{
      $headers = getallheaders();
      if(!empty($headers[HEADER_AUTH_TOKEN])){
        return $headers[HEADER_AUTH_TOKEN];
      }
    }

    if(!empty($_GET[PARAM_AUTH_TOKEN])){
      return $_GET[PARAM_AUTH_TOKEN];
    }

    if(!empty($_POST[PARAM_AUTH_TOKEN])){
      return $_POST[PARAM_AUTH_TOKEN];
    }

    if($request->is('post') && !empty($request->data[PARAM_AUTH_TOKEN])){
      return $request->data[PARAM_AUTH_TOKEN];
    }
    return false;
  }

  /* public _findUser($token) {{{ */
  /**
   * Find user by token in order to validate if the request is an valid request.
   *
   * @param mixed $token
   * @access public
   * @return void
   */
  public function _findUserByToken($token){

    $userModel = $this->settings['userModel'];
    list(,$model) = pluginSplit($userModel);

    $result = ClassRegistry::init($userModel)->getUserByToken($token);

    if(empty($result) || empty($result[$model])){
      return false;
    }

    $user = $result[$model];

    unset($result[$model]);
    return array_merge($user, $result);
  }
  /* }}} */
}

?>
