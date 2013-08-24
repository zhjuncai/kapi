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
      if(!empty($images)){
        $this->Account->saveImages($images, $accid);
      }

      if(!empty($errors)){
        $this->setResponse($errors);
      }

    }
  }

}
