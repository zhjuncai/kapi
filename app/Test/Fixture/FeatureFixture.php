<?php
/**
 * FeatureFixture
 *
 */
class FeatureFixture extends CakeTestFixture {

  /**
   * Fields derived from test database and no fileds definition is required
   *
   */

  public $import = array(
    'model' => 'Feature'
  );


  /**
   * Records
   *
   * @var array
   */
  public $records = array(
    array(
      'id' => 1,
      'name' => 'Free Wifi',
      'description' => 'Totally Free, no charge',
      'created' => '2013-07-21 13:51:42',
      'modified' => '2013-07-21 13:51:42',
      'enabled' => true,
      'is_deleted' => null
    ),
    array(
      'id' => 2,
      'name' => 'Parking',
      'description' => 'Two Hours free Parking',
      'created' => '2011-07-21 13:51:42',
      'modified' => '2013-07-21 13:51:42',
      'enabled' => true,
      'is_deleted' => null
    )
  );

}
