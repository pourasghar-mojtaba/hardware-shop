<?php

class Blog extends BlogAppModel {
	public $name = 'Blog';
	public $useTable = "blogs";
	public $primaryKey = 'id';

	var $actsAs = array('Containable');


	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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

  public $hasMany = array(
		'Blogrelatetag' => array(
			'className' => 'Blogrelatetag',
			'foreignKey' => 'blog_id',
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
		'Blogcomment' => array(
			'className' => 'Blogcomment',
			'foreignKey' => 'blog_id',
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
	  'Blogtranslation' => array(
		  'className' => 'Blogtranslation',
		  'foreignKey' => 'blog_id',
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


}

?>
