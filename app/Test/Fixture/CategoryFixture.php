<?php
/**
 * CategoryFixture
 *
 */
class CategoryFixture extends CakeTestFixture {

  /**
   * Only import database structure but not record.
   *
   * @var array
   */
  public $import = array(
    'model' => 'Category'
  );


/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Chinese Food',
			'description' => 'Deliciouse Chinese FOod',
			'created' => '2013-07-21 13:51:42',
			'modified' => '2013-07-21 13:51:42',
			'enabled' => true,
			'deleted' => null
		),
    array(
      'id' => 2,
      'name' => 'Thailand Food',
      'description' => 'Curry Food',
      'created' => '2011-07-21 13:51:42',
      'modified' => '2013-07-21 13:51:42',
      'enabled' => true,
      'deleted' => null
    ),
    array(
      'id' => 3,
      'name' => 'American Food',
      'description' => 'Curry Food',
      'created' => '2012-07-21 13:51:42',
      'modified' => '2013-07-21 13:51:42',
      'enabled' => true,
      'deleted' => true
    ),
    array(
      'id' => 4,
      'name' => 'Japan Food',
      'description' => 'Description',
      'created' => '2012-07-21 13:51:42',
      'modified' => '2013-07-21 13:51:42',
      'enabled' => true,
      'deleted' => true
    ),
	);

}
