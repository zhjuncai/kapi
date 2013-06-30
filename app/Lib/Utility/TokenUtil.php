<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ethan
 * Date: 30/06/13
 * Time: 17:13
 * To change this template use File | Settings | File Templates.
 */

class TokenUtil {

  public static function normalizeToken($data = array()){

    if(empty($data)){
      return null;
    }else{
      $token = Set::extract('/Token/token', $data);

      if(!$token){
        $token = Set::extract('/LoginToken/token', $data);
      }

      return array('token' => array_pop($token));
    }
  }

}