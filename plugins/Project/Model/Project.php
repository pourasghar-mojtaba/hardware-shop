<?php

class Project extends ProjectAppModel {
	
	var $actsAs = array('Containable');
	
	public $belongsTo = array(
		'Projectcategory' => array(
			'className' => 'Projectcategory',
			'foreignKey' => 'project_id',
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
        'Projectimage' => array(
			'className' => 'Projectimage',
			'foreignKey' => 'project_id',
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
	function _getCategories($parent_id)
	{
		$category_data = array();
		$this->Projectcategory->recursive = - 1;
		$query = $this->Projectcategory->find('all',array('fields'=> array('id','parent_id','title as title'),'conditions' => array('parent_id'=> $parent_id)));
		foreach($query as $result)
		{
			$category_data[] = array(
				'id'   => $result['Projectcategory']['id'],
				'title'=> $this->_getPath($result['Projectcategory']['id'])
			);

			$category_data = array_merge($category_data, $this->_getCategories($result['Projectcategory']['id']));
		}
		return $category_data;
	}
	public
	function _getPath($category_id)
	{
		$this->Projectcategory->recursive = - 1;
		$query = $this->Projectcategory->find('all',array('fields'=> array('id','parent_id','title as title'),'conditions' => array('id'=> $category_id)));

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