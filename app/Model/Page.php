<?php
App::uses('AppModel', 'Model');

class Page extends AppModel
{
	public
	function _getPageInfo($id,$lang)
	{
		
		
		$options['fields'] = array(
			'Page.id',
			'Page.title',
			'Page.body',
			'Page.meta' ,
			'Page.keyword'
		);
		
		$options['joins'] = array(
			array('table'     => 'languages',
				'alias'     => 'Language',
				'type'      => 'left',
				'conditions' => array(
					'Language.id = Page.language_id'
				)
			  )
		);
		
		$options['conditions'] = array(
			'Page.id'=> $id,
			'Language.code'=>$lang
		);
		$page = $this->find('first',$options);
		return $page;
	}

}
?>