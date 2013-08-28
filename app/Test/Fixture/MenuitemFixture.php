<?php
/**
 * MenuitemFixture
 *
 */
class MenuitemFixture extends CakeTestFixture {

  public $import = array('Model'=>'MenuItem');

  /**
   * Records
   *
   * @var array
   */
  public $records = array(
    array(
      'id' => 1,
      'menu_id' => 1,
      'name' => 'Lorem ipsum dolor sit amet',
      'description' => 'Lorem ipsum dolor sit amet',
      'price' => 1,
      'valid_from' => '2013-07-21',
      'valid_to' => '2013-07-21',
      'is_recommend' => '1',
      'created' => '2013-07-21 13:31:37',
      'modified' => '2013-07-21 13:31:37',
      'currency' => 'L',
      'symbol' => ''
    ),
  );

}
