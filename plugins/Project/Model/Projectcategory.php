<?php

class Projectcategory extends ProjectAppModel
{
	public $name = 'Projectcategory';
	//public $useTable = "projectcategories";
	public $primaryKey = 'id';

	var $actsAs     = array('Containable');

	public $hasMany = array(
		'Project' => array(
			'className'   => 'Project',
			'foreignKey'  => 'id',
			'dependent'   => false,
			'conditions'  => '',
			'fields'      => '',
			'order'       => '',
			'limit'       => '',
			'offset'      => '',
			'exclusive'   => '',
			'finderQuery' => '',
			'counterQuery'=> ''
		)
	);

	public
	function _getCategories($parent_id)
	{
		$category_data = array();
		$this->recursive = - 1;
		$query = $this->find('all',array('fields'=> array('id','slug','parent_id','title as title'),'conditions' => array('parent_id'=> $parent_id)));
		foreach($query as $result)
		{
			$category_data[] = array(
				'id'   => $result['Projectcategory']['id'],
				'slug'   => $result['Projectcategory']['slug'],
				'title'=> $this->_getPath($result['Projectcategory']['id'])
			);

			$category_data = array_merge($category_data, $this->_getCategories($result['Projectcategory']['id']));
		}
		return $category_data;
	}
	public
	function _getPath($category_id)
	{
		$this->recursive = - 1;
		$query = $this->find('all',array('fields'=> array('id','slug','parent_id','title as title'),'conditions' => array('id'=> $category_id)));

		foreach($query as $category_info)
		{
			if($category_info['Projectcategory']['parent_id'])
			{
				return $this->_getPath($category_info['Projectcategory']['parent_id']) .
				" > " .$category_info['Projectcategory']['title'];
			}
			else
			{
				return $category_info['Projectcategory']['title'];
			}
		}
	}


}

?>