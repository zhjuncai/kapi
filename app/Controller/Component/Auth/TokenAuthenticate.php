<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class TokenAuthenticate extends BaseAuthenticate{

  public function authenticate(CakeRequest $request, CakeResponse $response){

    $foundUser = $this->getUser($request);

    return $foundUser;
  }

  public function getUser(CakeRequest $request){

    $field = $this->settings['fields'];

    $token = $this->_getToken($request);
    if(!$token){
      return false;
    }
    return $this->_findUserByToken($token);
  }

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
