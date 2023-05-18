<?php

class Productcategory extends ProductAppModel
{
	public $name = 'Productcategory';
	//public $useTable = "productcategories";
	public $primaryKey = 'id';

	var $actsAs = array('Containable');

	public $hasMany = array(
		'Product' => array(
			'className' => 'Product',
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
		),
		'Productcategorytranslation' => array(
			'className' => 'Productcategorytranslation',
			'foreignKey' => 'product_category_id',
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

	public
	function _getCategories($parent_id, $lang)
	{
		$category_data = array();
		$this->recursive = -1;
		$query = $this->find('all',array('fields'=> array('id','parent_id'),'conditions' => array('parent_id'=> $parent_id)));

		foreach ($query as $result) {
			$category_data[] = array(
				'id' => $result['Productcategory']['id'],
				'title' => $this->_getPath($result['Productcategory']['id'],$lang)
			);

			$category_data = array_merge($category_data, $this->_getCategories($result['Productcategory']['id'],$lang));
		}
		return $category_data;
	}

	public
	function _getPath($category_id,$lang)
	{
		$this->recursive = -1;

		$options = array();
		$options['fields'] = array(
			'Productcategory.id',
			'Productcategory.arrangment',
			'Productcategory.parent_id',
			'Productcategory.status',
			'Productcategory.created',
			'Productcategorytranslation.title',
			'Productcategorytranslation.product_category_id',
			'Productcategory.slug',
		);
		$options['joins'] = array(
			array('table' => 'productcategorytranslations',
				'alias' => 'Productcategorytranslation',
				'type' => 'left',
				'conditions' => array(
					'Productcategory.id = Productcategorytranslation.product_category_id',
					"Productcategorytranslation.language_id" => $lang
				)
			)
		);

		$options['conditions'] = array(
			"Productcategory.id" => $category_id,
		);

		$query = $this->find('all',$options);
		//$query = $this->find('all', array('fields' => array('id', 'parent_id', 'title as title'), 'conditions' => array('id' => $category_id)));

		foreach ($query as $category_info) {
			if ($category_info['Productcategory']['parent_id']) {
				return $this->_getPath($category_info['Productcategory']['parent_id'],$lang) .
					" > " . $category_info['Productcategorytranslation']['title'];
			} else {
				return $category_info['Productcategorytranslation']['title'];
			}
		}
	}


}

?>
