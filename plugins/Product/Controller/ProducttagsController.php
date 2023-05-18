<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class ProducttagsController extends ProductAppController {

   var $name = 'Producttags';
 /**
* follow to anoher user
* @param undefined $id
*
*/

public function beforeFilter() {
	parent::beforeFilter();

	$this->_add_admin_member_permision(array('admin_tag_search'));

 }

 /**
 * search on tag
 *
*/
 function search(){
	$this->Producttag->recursive = -1;
	$search_word = $_REQUEST['search_word'];
	$options['fields'] = array(
				'Producttag.id',
				'Producttag.title'
			   );
		$options['joins'] = array(
				array('table' => 'Productrelatetags',
					'alias' => 'Productrelatetag',
					'type' => 'LEFT',
					'conditions' => array(
					'Producttag.id = `Productrelatetag`.Producttag_id ',
					)
				) ,

				array('table' => 'Products',
					'alias' => 'Product',
					'type' => 'LEFT',
					'conditions' => array(
					'`Productrelatetag`.Product_id = `Product`.id ',
					)
				)

			);

		$options['conditions'] = array(
			   'Producttag.title LIKE'=> "$search_word%" ,
		);

		$options['order'] = array(
				'Producttag.id'=>'desc'
			);
		$options['limit'] = 3;

		$Products = $this->Producttag->find('all',$options);
		$this->set(compact('Products'));
}

 /**
 *
 *
*/
  function search_suggest(){
	$this->Producttag->recursive = -1;
	$search_word = $_REQUEST['search_word'];
	$options['fields'] = array(
				'Producttag.id',
				'Producttag.title'
			   );

		$options['conditions'] = array(
			   'Producttag.title LIKE'=> "$search_word%" ,
		);

		$options['order'] = array(
				'Producttag.id'=>'desc'
			);
		$options['limit'] = 3;

		$Producttags = $this->Producttag->find('all',$options);
		$this->set(compact('Producttags'));

		$this->render('/Elements/Products/Ajax/search_suggest','ajax');
}

 function admin_tag_search()
 {
	$search_word =  $_GET["term"] ;
	$options['fields'] = array(
				'Producttag.id',
				'Producttag.title'
			   );

	$options['conditions'] = array(
		   'Producttag.title LIKE'=> "$search_word%" ,
	);

	$options['order'] = array(
			'Producttag.id'=>'desc'
		);
	$options['limit'] = 5;

	$Producttags = $this->Producttag->find('all',$options);
    $this->set('search_result',$Producttags);
    $this->render(__PRODUCT_PLUGIN.'.Elements/Ajax/tag_search','ajax');
 }


 /**
 *
 */

 function get_Product_tag($id=null)
 {
 	$this->Producttag->recursive = -1;
		$options['fields'] = array(
				'Producttag.id',
				'Producttag.title'
			   );
		$options['joins'] = array(
				array('table' => 'Productrelatetags',
					'alias' => 'Productrelatetag',
					'type' => 'LEFT',
					'conditions' => array(
					'Productrelatetag.Producttag_id = Producttag.id ',
					)
				)

			);

		$options['conditions'] = array(
			"Productrelatetag.Product_id"=>$id
		);

		$options['order'] = array(
				'Producttag.id'=>'desc'
			);

		$tags = $this->Producttag->find('all',$options);
		//$this->set(compact('tags'));
		return $tags;
 }





}
