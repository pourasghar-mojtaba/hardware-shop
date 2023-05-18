<?php

class Gallery extends GalleryAppModel {
	
	var $actsAs = array('Containable');
	

	
 	public $hasMany = array(
        'Galleryimage' => array(
			'className' => 'Galleryimage',
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
		),
		'Gallerytranslation' => array(
			'className' => 'Gallerytranslation',
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