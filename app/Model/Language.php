<?php
App::uses('AppModel', 'Model');

class Language extends AppModel
{
	public
	function _getAllLangs()
	{
		$options['fields'] = array(
			'Language.id',
			'Language.code',
			'Language.title'
		);

		$languages = $this->find('all',$options);
		return $languages;
	}

}
?>