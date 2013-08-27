<?php
/**
 * AccountImageFixture
 *
 */
class AccountImageFixture extends CakeTestFixture {

  /**
   * Fields
   *
   * @var array
   */
  public $fields = array(
    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
    'account_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
    'image_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'primary' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'primary image display as account portrait'),
    'indexes' => array(
      'PRIMARY' => array('column' => 'id', 'unique' => 1),
      'fk_account_images_account_id_idx' => array('column' => 'account_id', 'unique' => 0),
      'fk_account_images_image_id_idx' => array('column' => 'image_id', 'unique' => 0)
    ),
    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
  );


}
