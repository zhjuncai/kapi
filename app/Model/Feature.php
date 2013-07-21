<?php
App::uses('AppModel', 'Model');
/**
 * Feature Model
 *
 * @property Account $Account
 */
class Feature extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

  /**
   * Feature should be like Category and it's an standalone entity that does not rely on any other entities
   *
   * So there is no $belongsTo and $hasAndBelongsToMany definition
   */


}
