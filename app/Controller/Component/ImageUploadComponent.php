<?php
/**
 * This component handle image upload in application;
 *
 * User: zjczhjuncai@gmail.com
 * Date: 5/13/13
 * Time: 9:05 PM
 */
App::import('Component', 'Upload');

class ImageUploadComponent extends UploadComponent{

  private $accountId = null;

  function __construct(ComponentCollection $collection, $options = null){

    parent::__construct();

    $this->Image = ClassRegistry::init('Image');

    $uploadConfig = Configure::read("App.Uploads");

    $this->options = array_merge($this->options , $uploadConfig);

    if($options){
      // handle other options if provided
    }
  }

  public function delete_file(){

  }

  /**
   * @param array $option
   * @return array
   * @throws ConfigureException
   */
  public function upload($option = array()){

    if(isset($option["account_id"])){
      $this->accountId = $option["account_id"];
    }else{
      throw new ConfigureException("Account is missing");
    }
    $files = $this->upload_files();
    $images = $errors = array();
    if(!empty($files)){
      foreach($files as $key=>$file){
        if(isset($this->error)){
          $errors[] = $file->error;
        }else{
          $this->Image->create();
          $image = array(
            'name' => $file->original_name,
            'directory' => $file->dir,
            'extension' => $file->ext,
            'size'      => $file->size,
            'unique_name' => $file->name,
            'relative_path' => $file->relative_path,
            'mime_type'   => $file->type
          );
          $savedImage = $this->Image->save($image);
          $images[] = $savedImage;
        }
      }
      return array($images, $errors);
    }

    return null;
  }

  public function json_response($images){

    $model = "Image";

    if(empty($images)){
      return "";
    }

    $files = array();

    foreach ($images as $image) {
      $file = new stdClass();

      $file->name = $image[$model]["unique_name"];
      $file->original_name = $image[$model]["name"];

      foreach ($this->options['image_versions'] as $version => $options) {
        if (!empty($version)) {
          if (is_file($this->get_upload_path($file->name, $version))) {
            $file->{$version . '_url'} = rtrim($this->get_static_server(), '/') .
              $image[$model]["relative_path"] . $version . '/' . $file->name;
          }
        }
      }
      $file->type = $image[$model]["mime_type"];
      $file->size = $image[$model]["size"];
      $files[] = $file;
    }

    return $this->generate_response(array($this->options['param_name'] => $files), true);
  }

  public function initialize(Controller $controller){

    // $this->init();

  }

  protected function get_unique_filename($name, $type, $index, $content_range){
    if(isset($name)){
      $tmp = explode('.', $name);
      if(is_array($tmp) && count($tmp) > 1){
        $ext = $tmp["1"];
        return uniqid() . '.' . strtolower($ext);
      }
    }
    return null;
  }

  public function handle_form_data($file, $index){
    // Handle form data, e.g. $_REQUEST['description'][$index]
  }

  protected function get_upload_path($file_name = null, $version = null){
    $file_name = $file_name ? $file_name : '';
    $version_path = empty($version) ? '' : $version . '/';
    return $this->options['upload_dir'] . $this->get_account_path()
      . $this->get_user_path() . $version_path . $file_name;
  }

  protected function get_relative_path($file_name = null){

    $file_name = $file_name ? $file_name : '';
    return $this->get_account_path()[0] == '/' ? $this->get_account_path() : '/' . $this->get_account_path();
  }

  protected function get_account_path(){
    return $this->accountId . '/';
  }

}
