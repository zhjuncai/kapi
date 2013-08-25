<?php
/**
 * UploadController handle all file (images most offen) upload in current
 * project, it supposed to handle account image upload, menu item image upload
 * etc.
 * User: zjczhjuncai@gmail.com
 * Date: 5/13/13
 * Time: 8:51 PM
 */
class UploadController extends AppController{

  public $uses = array("Account", "Image");

  public $components = array("ImageUpload");

  public function account($accid){

    $this->autoRender = false;

    if($this->request->is("post")){

      list($images, $errors) = $this->ImageUpload->upload(array("account_id" => $accid));
      $responseBody = array();
      if(!empty($images)){
        $savedImages = $this->Account->saveImages($images, $accid);
        $responseBody = array_merge($responseBody, array('images' => $this->ImageUpload->normalizeImage($images)));

      }

      if(!empty($errors)){
        $responseBody = array_merge($responseBody, array('errors' => $errors));
      }
      $this->setResponse($responseBody);
    }
  }

}
