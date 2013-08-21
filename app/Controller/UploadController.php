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

  public $uses = array("AccountImage", "Account", "Image");

  public $components = array("ImageUpload");

  public function upload($type="", $id){

    switch ($type){
      case "account":
        self::_upload_account($id);
        break;
      case "menuitem":
        self::_upload_item($id);
        break;
      default:
        throw new NotFoundException("The page is not found");
      }
  }

  public function test($type, $accid){
    var_dump($type, $accid);
  }

  private function _upload_item($item_id){

  }

  private function _upload_account($account_id){

    $this->autoRender = false;

    if($this->request->is("post")){
      $images = $this->ImageUpload->upload(array("account_id" => $account_id));

      $this->AccountImage->saveImages($images,$account_id);

      $this->ImageUpload->json_response($images);

    }
  }

}
