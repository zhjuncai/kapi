<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Account $Account
 */
class Category extends AppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';


  /**
   * Category should be an standalone entity that does not rely on any other entities
   *
   * So there is no $belongsTo and $hasAndBelongsToMany definition
   */

}
