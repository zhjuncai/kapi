<?php
/**
 * UploadController handle all file (images most offen) upload in current
 * project, it supposed to handle account image upload, menu item image upload
 * etc.
 * User: zjczhjuncai@gmail.com
 * Date: 5/13/13
 * Time: 8:51 PM
 */
App::uses('AppController', 'Controller');

class UploadController extends AppController{

  public $uses = array("Account", "Image");

  public $components = array("ImageUpload");

  public function beforeFilter(){
    $pass = $this->request->pass;
    $accid = array_shift($pass);

    $existed= $this->Account->exists($accid);
    if(!$existed){
      $this->response->statusCode(404);
      $this->response->send();
      $this->_stop();
    }
    parent::beforeFilter();
  }

  public function account($accid){

    $this->autoRender = false;

    if($this->request->is("post")){

      list($images, $errors) = $this->ImageUpload->upload(array("account_id" => $accid));
      $responseBody = array();
      if(!empty($images)){
        $savedImages = $this->Account->saveImages($images, $accid);
        // $responseBody = array_merge($responseBody, array('images' => $this->ImageUpload->normalizeImage($images)));

      }

      if(!empty($errors)){
        $responseBody = array_merge($responseBody, array('errors' => $errors));
      }else{
        $responseBody = array('success' => __("Files had been uploaded successfully"));
      }

      if(empty($images) && empty($errors)){
        $responseBody = array("success" => __("You didn't upload any files"));
      }

      $this->setResponse($responseBody);
    }
  }

  /* public menu($accid, $menuid) {{{ */
  /**
   * This method accept user upload photots for account review. Registered user
   * is able to post reviews for an account along with some photos
   * The URL should be /kapi/upload/menu/<accid>/<revid>
   *
   * @param mixed $accid
   * @param mixed $revid
   * @access public
   * @return void
   */
  public function menu($accid, $revid){

    $review = $this->Review->exists($revid);
    if(empty($review)){
      // if review not found in database, check if json post had content, and
      // create the review for the $accid and saved the uploaded photos

    }

  }
  /* }}} */

}
