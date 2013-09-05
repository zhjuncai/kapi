<?php
/**
 * LoginTokenFixture
 *
 */
class LoginTokenFixture extends CakeTestFixture {

  /**
   * Import
   *
   * @var array
   */
  public $import = array('model' => 'LoginToken');

  /**
   * Records
   *
   * @var array
   */
  public $records = array(
    array(
      'id' => '1',
      'user_id' => '9999',
      'token' => 'c09787cf4107fd9c7a7d4546fee167beb6779074',
      'duration' => '1 day',
      'used' => '1',
      'created' => '2013-07-04 13:56:52',
      'expired' => '2013-07-04 14:24:07'
    ),
  );

}
