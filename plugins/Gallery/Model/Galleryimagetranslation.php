<?php

class Galleryimagetranslation extends GalleryAppModel {
	
	var $actsAs = array('Containable');
	

	
 	public $belongsTo = array(

		'Galleryimage' => array(
			'className' => 'Galleryimage',
			'foreignKey' => 'galleryimage_id',
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