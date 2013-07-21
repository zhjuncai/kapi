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

}
