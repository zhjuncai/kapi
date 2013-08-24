<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Menu $Menu
 * @property Review $Review
 * @property Image $Photo
 * @property Category $Category
 * @property Feature $Feature
 */
class Account extends AppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';

  /**
   * A basic account, basic account that might lack of features
   */
  const BASIC = '1';
  /**
   * A Premium Account that has full of features.
   */
  const PREMIUM = '2';

  /**
   * Now only consider three type of Account.
   **/
  const RESTAURANT = '1';
  const COFFEE_BAR = '2';
  const PUB        = '3';

  /**
   *    * Use is when account was first registered, but haven't been approved by Admin
   */
  const REGISTERED = 0;

  /**
   *    * Administrator is verifying the account.
   *       */
  const APPROVING = 1;

  /**
   *    * Account had been validate and approved and public
   *       */
  const ACTIVE = 2;


  //The Associations below have been created with all possible keys, those that are not needed can be removed

  /**
   * hasMany associations
   *
   * @var array
   */
  public $hasMany = array(
    'Menu' => array(
      'className' => 'Menu',
      'foreignKey' => 'account_id',
      'dependent' => false,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'exclusive' => '',
      'finderQuery' => '',
      'counterQuery' => ''
    ),
    'Review' => array(
      'className' => 'Review',
      'foreignKey' => 'account_id',
      'dependent' => false,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'exclusive' => '',
      'finderQuery' => '',
      'counterQuery' => ''
    ),
    'Photo' => array(
      'className' => 'Image',
      'foreignKey' => 'id',
      'dependent' => false,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'exclusive' => '',
      'finderQuery' => '',
      'counterQuery' => ''
    )
  );


  /**
   * hasAndBelongsToMany associations
   *
   * @var array
   */
  //http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html#hasandbelongstomany-habtm
  public $hasAndBelongsToMany = array(
    'Feature' => array(
      'className'             => 'Feature',
      'joinTable'             => 'accounts_features',
      'foreignKey'            => 'account_id',
      'associationForeignKey' => 'feature_id',
      'with'                  => 'AccountFeature', // If true (default value) cake will first delete existing relationship records in the foreign keys table before inserting new ones. Existing associations need to be passed again when updating
      'unique'                 => false,
      'conditions'             => '',
      'fields'                 => '',
      'order'                  => '',
      'limit'                  => '',
      'offset'                 => '',
      'finderQuery'            => '',
      'deleteQuery'            => '',
      'insertQuery'            => ''
    ),
    'Category' => array(
      'className'             => 'Category',
      'joinTable'             => 'accounts_category',
      'foreignKey'            => 'account_id',
      'associationForeignKey' => 'category_id',
      'with'                  => 'AccountCategory',
      'unique'                 => false,
      'conditions'             => '',
      'fields'                 => '',
      'order'                  => '',
      'limit'                  => '',
      'offset'                 => '',
      'finderQuery'            => '',
      'deleteQuery'            => '',
      'insertQuery'            => ''
    ),
    'Image' => array(
      'className'             => 'Image',
      'joinTable'             => 'accounts_images',
      'foreignKey'            => 'account_id',
      'associationForeignKey' => 'image_id',
      'with'                  => 'AccountImage',
      'unique'                 => false,
      'conditions'             => '',
      'fields'                 => '',
      'order'                  => '',
      'limit'                  => '',
      'offset'                 => '',
      'finderQuery'            => '',
      'deleteQuery'            => '',
      'insertQuery'            => ''
    )
  );

  /**
   * Account Validator.
   *
   * name, address  is mandatory
   */
  public $validate = array(
    'name'      => array(
      'rule'        => array('minLength', 5),
      'required'    => true,
      'message'     => "Account name is required"
    ),

    'level'         => array(
      'rule'        => array('between', 1, 2),
      'required'    => true
    ),
    'type'          => array(
      'rule'        => array('between', 10, 20),
      'required'    => true
    ),

    'street'        => array(
      'rule'        => array('minLength', 20),
      'required'    => true
    ),

    'telephone'     => array(
      'rule'        => array('minLength', 10),
      'required'    => true
    )

  );

  /* public getAllReviews($accid) {{{ */
  /**
   * Retrieve all reviews posted by registered user, and filter by review status, only approved reviews
   * return, any pending and denied reviews will be filted out.
   *
   * @param mixed $accid Account.id
   * @access public
   * @return void
   */
  public function getReviews($accid, $revid){

    $this->id = $accid;
    $this->Behaviors->load('Containable');

    $revCond= array('status' => Review::STATUS_APPROVED);

    if(isset($revid)){
      $revCond= array_merge($revCond, array('Review.id' => $revid));
    }

    $comments = $this->find('first', array(
      'conditions'    => array(
        'Account.id'      => $accid
      ),
      'fields' => array('Account.id', 'Account.name'),
      'contain' => array(
        'Review' => array(
          'fields'      => array('id', 'comment', 'gene_rating', 'food_rating', 'envi_rating', 'service_rating','user_id','created'),
          'conditions'  => $revCond,
          'order'       => array('created DESC')
        )
      )
    ));

    $this->Behaviors->unload('Containable');

    return $comments;
  }
  /* }}} */


  /* public allowComment($accid) {{{ */
  /**
   * Only enabled and allow_review flag marked as true accounts that is religiable to allow comments.
   *
   * @param mixed $accid Account id
   * @access public
   * @return void
   */
  public function allowComment($accid){

    $this->id = $accid;
    $this->recursive = -1;
    $allowed = $this->field('allow_review', array(
      'enabled' => true
    ), 'id desc');

    return $allowed;

  }
  /* }}} */

  public function saveImages($images = array(), $accountId = null){
    if(!empty($images)){
      $saved = array();
      foreach($images as $image){
        $data = array(
          'image_id'    => $image['Image']['id'],
          'account_id'  => $accountId
        );

        $this->AccountImage->create($data);

        $saved[] = $this->AccountImage->save($this->data);
      }
      return $saved;
    }

    return array();
  }

}
