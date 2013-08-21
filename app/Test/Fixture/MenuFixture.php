<?php
/**
 * MenuFixture
 *
 */
class MenuFixture extends CakeTestFixture {

  /**
   * import db structure from model and define user data by themselves.
   */
  public $import = array('Model' => 'Menu');

  /**
   * Records
   *
   * @var array
   */
  public $records = array(
    array(
      'id' => 1,
      'account_id' => 1,
      'name' => 'Lorem ipsum dolor sit amet',
      'description' => 'Lorem ipsum dolor sit amet',
      'type' => 'Lorem ipsum dolor sit amet',
      'created' => '2013-08-21 22:22:23',
      'modified' => '2013-08-21 22:22:23',
      'is_published' => 1
    ),
  );

}
