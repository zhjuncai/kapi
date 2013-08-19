<?php

App::uses('Review', 'Model');
/**
 * ReviewFixture
 *
 */
class ReviewFixture extends CakeTestFixture {
  public $import = array(
    'model' => 'Review'
  );


  /**
   * Records
   *
   * @var array
   */
  public $records = array(
    array(
      'id' => 1,
      'account_id' => 1,
      'user_id' => 1,
      'comment' => 'Lorem ipsum dolor sit amet',
      'status' => Review::STATUS_APPROVED,
      'gene_rating' => 4,
      'service_rating' => 3,
      'envi_rating' => 4,
      'food_rating' => 5,
      'created' => '2013-08-12 21:16:56',
      'modified' => '2013-08-12 21:16:56',
    ),
    array(
      'id' => 2,
      'account_id' => 1,
      'user_id' => 1,
      'comment' => 'how can I say from user 1',
      'status' => Review::STATUS_APPROVED,
      'gene_rating' => 1,
      'service_rating' => 2,
      'envi_rating' => 3,
      'food_rating' => 3,
      'created' => '2013-08-12 21:16:56',
      'modified' => '2013-08-12 21:16:56',
    ),
    array(
      'id' => 3,
      'account_id' => 1,
      'user_id' => 2,
      'comment' => 'Comments from user 2: It is not a good rest',
      'status' => Review::STATUS_APPROVED,
      'gene_rating' => 4,
      'service_rating' => 3,
      'envi_rating' => 4,
      'food_rating' => 5,
      'created' => '2013-08-12 21:16:56',
      'modified' => '2013-08-12 21:16:56',
    ),
    array(
      'id' => 4,
      'account_id' => 1,
      'user_id' => 1,
      'comment' => 'FTW, This is going to be denied by Administrator',
      'status' => Review::STATUS_DENIED,
      'gene_rating' => 4,
      'service_rating' => 3,
      'envi_rating' => 4,
      'food_rating' => 5,
      'created' => '2013-08-12 21:16:56',
      'modified' => '2013-08-12 21:16:56',
    ),
  );

}
