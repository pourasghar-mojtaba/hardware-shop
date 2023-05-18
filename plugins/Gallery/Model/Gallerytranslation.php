<?php

class Gallerytranslation extends GalleryAppModel {
	
	var $actsAs = array('Containable');
	

	
 	public $belongsTo = array(

		'Gallery' => array(
			'className' => 'Gallery',
			'foreignKey' => 'gallery_id',
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