<?php
/**
 * ReviewImageFixture
 *
 */
class ReviewImageFixture extends CakeTestFixture {

  /**
   * Import
   *
   * @var array
   */
  public $import = array('records' => false);

  /**
   * Fields
   *
   * @var array
   */
  public $fields = array(
    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'one review could attach multiple images, but one image only belong to one review'),
    'review_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
    'image_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'is_deleted' => array('type' => 'boolean', 'null' => true, 'default' => null),
    'indexes' => array(
      'PRIMARY' => array('column' => 'id', 'unique' => 1),
      'fk_review_images_review_id_idx' => array('column' => 'review_id', 'unique' => 0),
      'fk_review_images_image_id_idx' => array('column' => 'image_id', 'unique' => 0)
    ),
    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
  );

}
