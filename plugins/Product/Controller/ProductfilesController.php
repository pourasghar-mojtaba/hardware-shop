<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Productfile $Productfile
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ProductfilesController extends ProductAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

	public function admin_index() {
		$this->Productfile->recursive = -1;
		$this->set('title_for_layout',__d(__SHOP_LOCALE,'product_list'));
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Productfile']['search'])){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'=>array(
					'Productcategory.title',
					'Productfile.id',
					'Productfile.title',
					'Productfile.mini_detail',
					'Productfile.price',
					'Productfile.status',
					'Productfile.created',
				),
				'joins'=>array(array('table' => 'productcategories',
					'alias' => 'Productcategory',
					'type' => 'left',
					'conditions' => array(
					'Productfile.product_category_id = Productcategory.id ',
					)
				 )),
				'conditions' => array('Productfile.title LIKE'=> ''.$this->request->data['Productfile']['search'].'%' ),
				'limit'     => $limit,
				'order'                     => array(
					'Productfile.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'=>array(
					'Product.title',
					'Productfile.id',
					'Productfile.title',
					'Productfile.file',
					'Productfile.created',
				),
				'joins'=>array(array('table' => 'products',
					'alias' => 'Product',
					'type' => 'left',
					'conditions' => array(
					'Productfile.product_id = Product.id ',
					)
				 )),
				'limit'=> $limit,
				'order' => array(
					'Productfile.id'=> 'desc'
				)
			);
		}
		$productfiles = $this->paginate('Productfile');
		$this->set(compact('productfiles'));
	}

	public function admin_add() {
		$this->set('title_for_layout',__d(__SHOP_LOCALE,'add_product'));
		if($this->request->is('post')){
			$datasource = $this->Productfile->getDataSource();
			try
			{
				$datasource->begin();

				//pr($this->request->data);exit();
				if(!empty($this->request->data['Productfile']['pfile'])){

					foreach($this->request->data['Productfile']['pfile'] as $key => $value){
						if(trim($value['name']) == '')
						{
							unset($this->request->data['Productfile']['pfile'][$key]);
							unset($this->request->data['Productfile']['title'][$key]);
						}
					}
					$data = array();
					$file_list = array();

					foreach($this->request->data['Productfile']['pfile'] as $key => $value){

						$output = $this->_file($value,$key);
						if(!$output['error']) $file = $output['filename'];
						else
						{
							$file = '';
							if(!empty($file_list))
							{
								foreach($file_list as $file){
									@unlink(__SHOP_FILE_URL."/".$file);
								}
							}
							throw new Exception($output['message'].'  '.__d(__SHOP_LOCALE,'file_name').' '.$value['name']);
						}

						$file_list[] = $file;

						$data[] = array('Productfile' => array(
								'file'     => $file ,
								'title'     => $this->request->data['Productfile']['title'][$key],
								'product_id'=> $this->request->data['Productfile']['product_id']
							));

					}

					if(!$this->Productfile->saveMany($data,array('deep' => true)))
						throw new Exception(__d(__SHOP_LOCALE,'the_product_file_not_saved'));
				}

				$datasource->commit();

				$this->Redirect->flashSuccess(__d(__SHOP_LOCALE,'the_product_has_been_saved'),array('action'=>'index'));
			} catch(Exception $e){
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}
		}
		$this->LoadDropDownList();
	}

	public function admin_delete($id = null) {
		$this->Productfile->id = $id;
		if(!$this->Productfile->exists()){
			$this->Redirect->flashWarning(__d(__SHOP_LOCALE,'invalid_productfile'));
		}
		$this->Productfile->recursive = -1;
		$options['fields'] = array(
			'Productfile.id',
			'Productfile.file'
		   );

		$options['conditions'] = array(
			'Productfile.id'=>$id
		);
		$file = $this->Productfile->find('first',$options);

		if($this->Productfile->delete()){

			 if(!empty($file)){
					@unlink(__SHOP_FILE_PATH."/".$file['Productfile']['file']);
			 	}
			$this->Redirect->flashSuccess(__d(__SHOP_LOCALE,'the_product_has_been_deleted'));
		}
		else
		{
			$this->Redirect->flashWarning(__d(__SHOP_LOCALE,'the_productfile_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action'=> 'index'));
	}



	public function _file($data,$index)
	{
		App::uses('Sanitize', 'Utility');

		$output = array();

		if($data['size'] > 0)
		{
			$ext = $this->Httpupload->get_extension($data['name']);
			$filename = md5(rand().$_SERVER['REMOTE_ADDR']);
			if(file_exists(__SHOP_FILE_URL.$filename.'.'.$ext))
				$filename = md5(rand().$_SERVER[REMOTE_ADDR]);
			$this->Httpupload->setmodel('Productfile');
			$this->Httpupload->setuploadindex($index);
			$this->Httpupload->setuploaddir(__SHOP_FILE_PATH);
			$this->Httpupload->setuploadname('pfile');
			$this->Httpupload->settargetfile($filename.'.'.$ext);
			$this->Httpupload->setmaxsize(__UPLOAD_FILE_MAX_SIZE);
			$this->Httpupload->allowExt = __UPLOAD_File_EXT;


			if(!$this->Httpupload->upload())
			{
				//pr($this->Httpupload->get_error());exit();
				return array('error'   =>true,'filename'=>'','message' =>$this->Httpupload->get_error());
			}
			$filename .= '.'.$ext;

		}
		else return array('error'   =>true,'filename'=>'','message' =>'');

		return array('error'   =>false,'filename'=>$filename);
	}

	public function admin_edit($id = null)
	{
		$this->set('title_for_layout',__d(__SHOP_LOCALE,'edit_productfile'));
		if(!$this->Productfile->exists($id)){
			$this->Redirect->flashWarning(__d(__SHOP_LOCALE,'invalid_product'));
		}
		if($this->request->is(array('post', 'put'))){

			$datasource = $this->Productfile->getDataSource();
			try
			{
				$datasource->begin();

				/*if(!$this->Productfile->save($this->request->data))
				throw new Exception(__d(__SHOP_LOCALE,'the_product_could_not_be_saved_Please_try_again'));

				 */
				// file opration
				//pr($this->request->data);exit();

				if(!empty($this->request->data['Productfile']['id']))
				{
					foreach($this->request->data['Productfile']['id'] as $key => $value){

						if($this->request->data['Productfile']['pfile'][$key]['size'] > 0)
						{

							@unlink(__SHOP_FILE_PATH."/".$this->request->data['Productfile']['old_file'][$key]);

							$output = $this->_file($this->request->data['Productfile']['pfile'][$key],$key);
							if(!$output['error']) $file = $output['filename'];
							else
							{
								$file = '';
								if(!empty($file_list))
								{
									foreach($file_list as $img){
										@unlink(__SHOP_FILE_PATH."/".$img);
									}
								}
								throw new Exception($output['message'].'  '.__d(__SHOP_LOCALE,'file_name').' '.$this->request->data['Productfile']['pfile'][$key]['name']);
							}

							$file_list[] = $file;
						}
						else $file = $this->request->data['Productfile']['old_file'][$key];

						$ret   = $this->Productfile->updateAll(
							array('Productfile.title'=> '"'.$this->request->data['Productfile']['title'][$key].'"' ,
								'Productfile.file'=> '"'.$file.'"','Productfile.product_id'=> '"'.$this->request->data['Productfile']['product_id'].'"'
							),   //fields to update
							array('Productfile.id'=> $value )  //condition
						);
						if(!$ret)
						{
							throw new Exception(__d(__SHOP_LOCALE,'the_product_file_not_saved'));
						}
					}
				}

				// file opration

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__SHOP_LOCALE,'the_productfile_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e)
			{
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}

		}
		else
		{
			$this->Productfile->recursive = -1;
			$options = array('conditions' => array('Productfile.' . $this->Productfile->primaryKey=> $id));
			 $this->request->data = $this->Productfile->find('first', $options);
			 $this->Productfile->recursive = -1;
			 $options=array();
			 $options['fields'] = array(
			 		'Productfile.id',
			 		'Productfile.title',
			 		'Productfile.file'
			 	   );
			 $options['conditions'] = array(
			 	'Productfile.id' => $id
			 	);
			 $productfiles = $this->Productfile->find('all',$options);
			 $this->set('productfiles', $productfiles);

		}
		$this->LoadDropDownList();
	}

	public function LoadDropDownList(){
		$this->Productfile->Product->recursive = -1;

		$options['fields'] = array(
			'Product.id',
			'Product.title'
		   );

		$options['order'] = array(
			'Product.id'=> 'asc'
		);

		$products = $this->Productfile->Product->find('all',$options);
		$this->set('products',$products);
	}
}
