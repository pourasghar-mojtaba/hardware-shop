<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model
 *
 */
class Setting extends AppModel {

 function _getSetting($lang_id=null){

 	if($lang_id != NULL){
	 	return $this->find('first',array('conditions'=>array("language_id"=>1)));
	 }
	else return $this->find('first');
 }


}
?>
