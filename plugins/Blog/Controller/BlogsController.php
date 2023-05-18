<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class BlogsController extends BlogAppController
{

	var $helpers = array('Cms');
	var $components = array('Cms', 'Httpupload');

	/**
	 * Controller name
	 *
	 *
	 * /**
	 * follow to anoher user
	 * @param undefined $id
	 *
	 */

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('view', 'get_last_blog', 'get_my_blog', 'last', 'tags', 'admin_user_search', 'main_page_blogs', 'home_blog');
		$this->_add_admin_member_permision(array('admin_pin', 'admin_unpin'));
	}


	function index()
	{

		$this->set('title_for_layout', __('blog_title'));
		//$this->set('description_for_layout',$user['User']['details']);
		//$this->set('keywords_for_layout',$user['User']['name']);
		if ($this->request->is('post')) {
			$User_Info = $this->Session->read('User_Info');
			$data = Sanitize::clean($this->request->data);
			$file = $data['Blog']['blog_file'];
			if ($file['size'] > 0) {
				$output = $this->_attach_file();
				if (!$output['error']) $this->request->data['Blog']['file'] = $output['filename'];
				else {
					$this->request->data['Blog']['file'] = '';
					$this->Session->setFlash($output['message'], 'error');
					return;
				}
			}

			$this->request->data['Blog']['active'] = 0;
			$this->request->data['Blog']['user_id'] = $User_Info['id'];
			$this->request->data['Blog']['title_' . $this->Session->read('Config.language')] = '';
			$this->Blog->create();
			if ($this->Blog->save($this->request->data)) {
				$this->Redirect->flashSuccess(__d(__BLOG_LOCALE, 'the_blog_has_been_saved'));
			} else $this->Redirect->flashWarning(__d(__BLOG_LOCALE, 'the_blog_no_saved'));

		}
	}


	function _attach_file()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Blog']['blog_file'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__BLOG_IMAGE_PATH . $filename . '.' . $ext)) $filename = md5(rand() . $_SERVER[REMOTE_ADDR]);
			-
			$this->Httpupload->setmodel('Blog');
			$this->Httpupload->setuploaddir(__BLOG_IMAGE_PATH);
			$this->Httpupload->setuploadname('blog_file');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			$this->Httpupload->setmaxsize(__UPLOAD_FILE_MAX_SIZE);
			$this->Httpupload->allowExt = __UPLOAD_File_EXTENSION;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		}
		return array('error' => false, 'filename' => $filename);
	}

	/**
	 *
	 * @param undefined $id
	 *
	 */
	function tag($id = null)
	{
		$this->Blog->Blogrelatetag->Blogtag->recursive = -1;
		$tag = $this->Blog->Blogrelatetag->Blogtag->findById($id);
		$this->set('title_for_layout', __('search_blog_with_tag') . ' ' . $tag['Blogtag']['title']);
		$this->set('description_for_layout', __('search_blog_with_tag'));
		$this->set('keywords_for_layout', $tag['Blogtag']['title']);
		$this->set('tag_id', $id);
	}

	/**
	 *
	 *
	 */
	function search()
	{
		$this->set('title_for_layout', __('search'));
		$this->set('description_for_layout', __('search_blog_with_tag'));

		if (isset($_POST['year'])) $year = $_POST['year'];
		else $year = '';
		if (isset($_POST['month'])) $month = $_POST['month'];
		else $month = '';
		if (isset($_POST['writer'])) $writer = $_POST['writer'];
		else $writer = '';
		if (isset($_POST['search_text'])) $search_text = $_POST['search_text'];
		else $search_text = '';
		if (isset($_POST['tag'])) $tag = $_POST['tag'];
		else $tag = '';
		$this->set('year', $year);
		$this->set('month', $month);
		$this->set('writer', $writer);
		$this->set('search_text', $search_text);
		$this->set('tag', $tag);
	}

	function _blog_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Blog']['image'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__BLOG_IMAGE_PATH . $filename . '.' . $ext)) $filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Blog');
			$this->Httpupload->setuploaddir(__BLOG_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			$this->Httpupload->setmaxsize(4194304);
			$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 200;
			$this->Httpupload->thumb_height = 200;
			//$this->Httpupload->setimagemaxsize(1400,400);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		}
		return array('error' => false, 'filename' => $filename);
	}

	/**
	 *
	 * @param undefined $blog_id
	 *
	 */
	function add_blog_save($blog_id = 0)
	{

		$User_Info = $this->Session->read('User_Info');
		$this->request->data['Blog']['status'] = 0;
		$this->request->data['Blog']['body'] = trim($this->request->data['Blog']['body']);
		$this->request->data['Blog']['user_id'] = $User_Info['id'];
		$this->request->data = Sanitize::clean($this->request->data);
		$data = Sanitize::clean($this->request->data);

		$set_publish = $this->request->data['Blog']['set_publish'];
		$channels = $this->request->data['Blog']['channel'];
		$file = $data['Blog']['image'];

		if ($file['size'] > 0) {
			$output = $this->_blog_picture();
			if (!$output['error']) {
				$cover_image = $output['filename'];
			} else {
				$cover_image = '';
				echo "<script>show_warning_msg('" . $output['message'] . "');remove_modal();</script>";
				return;
			}
		} else    $cover_image = "";
		$this->request->data['Blog']['image'] = $cover_image;

		$this->Blog->create();
		try {
			$result = $this->Blog->save($this->request->data);

			if ($result) {
				$data = array();
				$blog_id = $this->Blog->getLastInsertID();
				if ($set_publish == 1) {
					$this->_publish_blog($blog_id, 0);
				}
				//print_r($this->request->data['Blog']['channel']);exit();
				foreach ($channels as $cid) {
					$dt = array('Blogchannel' => array('blog_id' => $blog_id, 'channel_id' => $cid));
					array_push($data, $dt);
				}
				if (!empty($data)) {
					//print_r($data);exit();
					$this->Blog->Blogchannel->recursive = -1;
					$this->Blog->Blogchannel->create();
					$this->Blog->Blogchannel->saveMany($data);
				}
			}

			echo "<script>
			show_success_msg('" . __('the_blog_has_been_saved') . "');
			refresh_last_blog(0);
			load_blog(0);
			load_blog_tab(0);
			remove_modal();

			</script>";

		} catch (Exception $e) {
			echo "<script>
			show_success_msg('" . __('the_bloh_could_not_be_saved') . "');
			remove_modal();
			load_blog_tab(0);
			</script>";
		}
	}

	function edit_blog_save($blog_id = 0)
	{


		$this->Blog->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Blog.id',
			'Blog.title',
			'Blog.image',
			'Blog.created'
		);
		$options['conditions'] = array(
			"Blog.id" => $blog_id
		);

		$blog = $this->Blog->find('first', $options);


		$User_Info = $this->Session->read('User_Info');
		$this->request->data['Blog']['status'] = 0;
		$this->request->data['Blog']['id'] = $blog_id;
		$this->request->data['Blog']['body'] = trim($this->request->data['Blog']['body']);
		$this->request->data = Sanitize::clean($this->request->data);
		$data = Sanitize::clean($this->request->data);

		//print_r($this->request->data);exit();
		$channels = $this->request->data['Blog']['channel'];

		$set_publish = $this->request->data['Blog']['set_publish'];

		$file = $data['Blog']['image'];

		if ($file['size'] > 0) {
			$output = $this->_blog_picture();
			if (!$output['error']) {
				$cover_image = $output['filename'];
			} else {
				$cover_image = '';
				echo "<script>show_warning_msg('" . $output['message'] . "');remove_modal();</script>";
				return;
			}
		} else $cover_image = $blog['Blog']['image'];
		$this->request->data['Blog']['image'] = $cover_image;

		try {
			$result = $this->Blog->save($this->request->data);

			if ($result) {
				$data = array();
				$blog_id = $blog['Blog']['id'];


				$this->Blog->Blogchannel->deleteAll(array('Blogchannel.blog_id' => $blog_id), FALSE);
				//print_r($this->request->data['Blog']['channel']);exit();
				foreach ($channels as $cid) {
					$dt = array('Blogchannel' => array('blog_id' => $blog_id, 'channel_id' => $cid));
					array_push($data, $dt);
				}
				if (!empty($data)) {
					//print_r($data);exit();
					$this->Blog->Blogchannel->recursive = -1;
					$this->Blog->Blogchannel->create();
					$this->Blog->Blogchannel->saveMany($data);
				}
				$this->Blog->Post->recursive = -1;
				$ret = $this->Blog->Post->query("update posts set status = 2 where  blog_id = " . $blog_id);

				if ($set_publish == 1) {
					$this->_publish_blog($blog_id, 1);
				}

				/*$ret= $this->Blog->Post->updateAll(
				array( 'Post.status' =>'2'),   //fields to update
				array( 'Post.blog_id' => $blog_id )  //condition
				);*/

			}

			echo "<script>
			show_success_msg('" . __('the_blog_has_been_saved') . "');
			remove_modal();
			load_blog_tab(" . $blog . ");
			</script>";

		} catch (Exception $e) {
			echo "<script>
			show_success_msg('" . __('the_bloh_could_not_be_saved') . "');
			refresh_last_blog(0);
			remove_modal();
			load_blog_tab(" . $blog . ");
			</script>";
		}
	}

	public
	function _publish_blog($blog_id, $type)
	{
		$User_Info = $this->Session->read('User_Info');

		$this->Blog->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Blog.id',
			'Blog.image',
			'Blog.title',
			'Blog.body'
		);
		$options['conditions'] = array(
			"Blog.id" => $blog_id
		);
		$blog = $this->Blog->find('first', $options);

		$this->Blog->Post->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Post.id',
		);
		$options['conditions'] = array(
			"Post.blog_id" => $blog_id
		);
		$post = $this->Blog->Post->find('first', $options);

		$ret = $this->Blog->query("update blogs set status = 1 where id =" . $blog_id);

		$this->request->data = array();

		if (!empty($post)) {
			$this->request->data['Post']['id'] = $post['Post']['id'];

		} else {
			$this->request->data['Post']['blog_id'] = $blog['Blog']['id'];
			$this->request->data['Post']['user_id'] = $User_Info['id'];
			$this->request->data['Post']['url'] = __SITE_URL . 'blogs/view/' . $blog['Blog']['id'];
		}
		$this->request->data['Post']['status'] = 0;
		$this->request->data['Post']['url_title'] = $blog['Blog']['title'];
		//$this->request->data['Post']['url_content'] = trim(mb_substr($blog['Blog']['body'],0,100));;
		$this->request->data['Post']['url_image'] = __SITE_URL . __BLOG_IMAGE_PATH . "/" . $blog['Blog']['image'];


		if ($this->Blog->Post->save($this->request->data)) {
			$sql = "INSERT INTO notifications 		(
			notification_id,
			from_user_id,
			to_user_id,
			type,
			notification_type,
			notification_body,
			created
			)
			SELECT          " . $blog_id . ",
			" . $User_Info['id'] . ",
			Follow.from_user_id,
			" . $type . ",
			5,
			'" . substr($blog['Blog']['title'], 0, 35) . "',
			now()
			From follows as Follow
			where Follow.to_user_id = " . $User_Info['id'] . "
			";
			$ret = $this->Blog->query($sql);

			if (empty($post)) {


				/// send email

				/*$Email = new CakeEmail();
				$Email->template('mention_sendemail', 'sendemail_layout');
				$Email->subject(__('used_your_user_name'));
				$Email->emailFormat('html');
				$Email->to($user['User']['email']);
				$Email->from(array(__Madaner_Email => __Email_Name));
				$Email->viewVars(array('from_name'=>$User_Info['name'],'from_user_name'=>$User_Info['user_name'],'to_name'=>$user['User']['name'],'text'=>$this->request->data['Post']['body'],'email'=>$user['User']['email'],'name'=>$user['User']['name'],'image'=>$User_Info['image'],'post_id'=>$post_id,'sex'=>$User_Info['sex']));
				$Email->send();*/


				$post_id = $this->Blog->Post->getLastInsertID();
				$this->Blog->Post->Allpost->recursive = -1;
				$this->request->data = array();
				$this->request->data['Allpost']['post_id'] = $post_id;
				$this->request->data['Allpost']['user_id'] = $User_Info['id'];
				$this->request->data['Allpost']['type'] = 0;
				$this->request->data['Allpost']['created'] = date('Y-m-d H:i:s');
				$this->request->data = Sanitize::clean($this->request->data);
				$this->Blog->Post->Allpost->create();
				$this->Blog->Post->Allpost->save($this->request->data);
			}
		}

	}

	/**
	 *
	 * @param undefined $blog_id
	 *
	 */
	function add_blog($blog_id = 0)
	{

		$User_Info = $this->Session->read('User_Info');

		$this->Blog->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Blog.id',
			'Blog.title',
			'Blog.image',
			'Blog.image_x',
			'Blog.image_y',
			'Blog.created'
		);
		$options['conditions'] = array(
			"Blog.user_id" => $User_Info['id']
		);

		$options['order'] = array(
			'Blog.id' => 'desc'
		);
		$blogs = $this->Blog->find('all', $options);


		$this->set('blogs', $blogs);
		$this->set('blog_id', $blog_id);

		if ($blog_id == 0) {
			$this->set('title_for_layout', __('add_new_blog'));
			$this->set('description_for_layout', __('add_new_blog'));
			$this->set('keywords_for_layout', __('add_new_blog'));
		} else {
			$this->set('title_for_layout', __('edit_blog'));
			$this->set('description_for_layout', __('edit_blog'));
			$this->set('keywords_for_layout', __('edit_blog'));
		}

	}

	/**
	 *
	 *
	 */
	function admin_index()
	{
		$this->set('title_for_layout', __d(__BLOG_LOCALE, 'blog_list'));
		//$this->Blog->recursive = - 1;
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Blog']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'joins' => array(

					array('table' => 'blogtranslations',
						'alias' => 'Blogtranslation',
						'type' => 'LEFT',
						'conditions' => array(
							'Blogtranslation.blog_id = Blog.id '
						)
					)

				),
				'fields' => array(
					'User.name',
					'Blog.id',
					'Blogtranslation.title',
					'Blog.num_viewed',
					'Blog.status',
					'Blog.created',
					'Blog.image',
					'Blog.num_new_comment',
					'Blog.pinsts',
					'Blog.num_comment'
				),
				'conditions' => array('Blog.title LIKE' => '%' . $this->request->data['Blog']['search'] . '%', 'Blogtranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order' => array(
					'Blog.pinsts' => 'desc',
					'Blog.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				/*'joins'=>array(

				),*/
				'joins' => array(

					array('table' => 'blogtranslations',
						'alias' => 'Blogtranslation',
						'type' => 'LEFT',
						'conditions' => array(
							'Blogtranslation.blog_id = Blog.id '
						)
					)

				),
				'fields' => array(
					'User.name',
					'Blog.id',
					'Blogtranslation.title',
					'Blog.num_viewed',
					'Blog.status',
					'Blog.created',
					'Blog.image',
					'Blog.num_new_comment',
					'Blog.pinsts',
					'Blog.num_comment'
				),
				'conditions' => array('Blogtranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order' => array(
					'Blog.pinsts' => 'desc',
					'Blog.id' => 'desc'
				)
			);
		}
		$blogs = $this->paginate('Blog');
		$this->set(compact('blogs'));
	}

	/**
	 *
	 *
	 */
	function admin_add()
	{
		$this->set('title_for_layout', __d(__BLOG_LOCALE, 'add_blog'));
		$this->Blog->recursive = -1;
		if ($this->request->is('post')) {
			$datasource = $this->Blog->getDataSource();
			try {
				$datasource->begin();
				$data = Sanitize::clean($this->request->data);
				$file = $data['Blog']['image'];

				if ($file['size'] > 0) {
					$output = $this->_blog_picture();
					if (!$output['error']) {
						$cover_image = $output['filename'];
					} else {
						$cover_image = '';
					}
				} else    $cover_image = "";

				$User_Info = $this->Session->read('AdminUser_Info');
				if (empty($this->request->data['Blog']['profile_name']))
					$this->request->data['Blog']['profile_id'] = 0;
				$this->request->data['Blog']['user_id'] = $User_Info['id'];
				$this->request->data['Blog']['image'] = $cover_image;
				$this->request->data = Sanitize::clean($this->request->data);
				$this->Blog->create();
				if (!$this->Blog->save($this->request->data))
					throw new Exception(__d(__BLOG_LOCALE, 'the_blog_could_not_be_saved'));
				$blog_id = $this->Blog->getLastInsertID();


				/**
				 *
				 * @blog translate
				 *
				 */

				$this->Blog->Blogtranslation->recursive = - 1;
				$this->request->data['Blogtranslation']['blog_id'] = $blog_id;
				$this->request->data['Blogtranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Blogtranslation']['title'] = trim($this->request->data['Blogtranslation']['title']);
				$this->request->data['Blogtranslation']['little_detail'] = trim($this->request->data['Blogtranslation']['little_detail']);
				$this->request->data['Blogtranslation']['detail'] = trim($this->request->data['Blogtranslation']['detail']);
				$this->Blog->Blogtranslation->create();
				if(!$this->Blog->Blogtranslation->save($this->request->data))
					throw new Exception(__d(__BLOG_LOCALE,'the_blog_could_not_be_saved'));

				/**
				 *
				 * blog translate
				 *
				 */

				/* tags */
				$data = array();
				$dt = array();
				if (isset($_POST['new_tags']) && !empty($_POST['new_tags'])) {
					$tags = $_POST['new_tags'];//explode('#',$this->request->data['Blogrelatetag']['tag']);
					$tags = array_filter($tags, 'strlen');
					$this->loadModel('Blogtag');
					if (!empty($tags)) {

						foreach ($tags as $tag) {
							$tag = trim($tag);

							$options = array();
							$oldtag = array();

							$options['fields'] = array(
								'Blogtag.id',
							);
							$options['conditions'] = array(
								'Blogtag.title' => $tag
							);
							$oldtag = $this->Blogtag->find('first', $options);

							if (empty($oldtag)) {

								$this->request->data['Blogtag']['title'] = $tag;
								$this->request->data['Blogtag']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
								$this->Blogtag->create();

								if (!$this->Blogtag->save($this->request->data)) {
									throw new Exception(__d(__BLOG_LOCALE, 'the_blog_tag_not_saved'));
								}
								$tag_id[] = $this->Blogtag->getLastInsertID();

							} else {
								$tag_id[] = $oldtag['Blogtag']['id'];
							}


						}
					}

				}

				$data = array();
				if (isset($this->request->data['Blogrelatetag']['blog_tag_id'])) {
					foreach ($this->request->data['Blogrelatetag']['blog_tag_id'] as $id) {
						$dt = array('Blogrelatetag' => array('blog_id'    => $blog_id,'blog_tag_id'=>$id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)));
						array_push($data,$dt);
					}
				}

				if (!empty($tag_id)) {
					foreach ($tag_id as $tid) {
						$dt = array('Blogrelatetag' => array('blog_id'    => $blog_id,'blog_tag_id'=>$tid,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)));
						array_push($data,$dt);
					}

				}

				if (!empty($this->request->data['Blogrelatetag']['blog_tag_id']) || !empty($tag_id)) {
					$this->Blog->Blogrelatetag->create();
					if (!$this->Blog->Blogrelatetag->saveMany($data))
						throw new Exception(__d(__BLOG_LOCALE, 'the_blog_tag_not_saved'));
				}
				/* tags*/

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__BLOG_LOCALE, 'the_blog_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				@unlink(__BLOG_IMAGE_PATH . "/" . $cover_image);
				@unlink(__BLOG_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}


	}

	/**
	 *
	 * @param undefined $id
	 *
	 */
	function _set_blog($id)
	{
		$this->Blog->recursive = -1;
		$this->Blog->id = $id;
		if (!$this->Blog->exists()) {
			$this->Session->setFlash(__('invalid_id_for_blog'));
			return;
		}

		/*
		* Test allowing to not override submitted data
		*/
		if (empty($this->request->data)) {

			$this->Blog->recursive = -1;
			$options = array();
			$options['fields'] = array(
				'Blog.id',
				'Blogtranslation.title',
				'Blog.image',
				'Blogtranslation.little_detail',
				'Blogtranslation.detail',
				'Blog.status',
				'Blog.slug',
				'Blog.link',
				'Blog.created',
				'Profile.id',
				'Profile.name',
			);
			$options['joins'] = array(
				array('table' => 'users',
					'alias' => 'Profile',
					'type' => 'left',
					'conditions' => array(
						'Profile.id = Blog.profile_id'
					)
				),
				array('table'     => 'blogtranslations',
					'alias'     => 'Blogtranslation',
					'type'      => 'left',
					'conditions' => array(
						'Blog.id = Blogtranslation.blog_id',
						"Blogtranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			);
			$options['conditions'] = array(
				"Blog.id" => $id
			);

			$blog = $this->Blog->find('first', $options);

			//$this->request->data = $this->Blog->findById($id);
		}
		if(empty($blog)){
			$blog = array(
				"Blog" => array(
					"id" => $id,
					"image"=>"",
					"status"=>1,
					"link"=>""
				),
				"Blogtranslation" => array(
					"title" => "",
					"little_detail"=>"",
					"detail"=>""
				)
			);
		}
		$this->set('blog', $blog);
		$this->request->data = $blog;

		return $blog;
	}

	/**
	 *
	 * @param undefined $id
	 *
	 */
	function admin_edit($blog_id = null)
	{
		$this->set('title_for_layout', __d(__BLOG_LOCALE, 'edit_blog'));
		$this->Blog->id = $blog_id;
		if (!$this->Blog->exists()) {
			$this->Session->setFlash(__('invalid_id_for_blog'));
			return;
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			$datasource = $this->Blog->getDataSource();
			try {
				$datasource->begin();

				$this->Blog->recursive = -1;
				$options = array();
				$options['fields'] = array(
					'Blog.id',
					'Blog.image',
				);
				$options['conditions'] = array(
					"Blog.id" => $blog_id
				);

				$blog = $this->Blog->find('first', $options);


				$User_Info = $this->Session->read('User_Info');
				//$this->request->data['Blog']['status'] = 0;
				if (empty($this->request->data['Blog']['profile_name']))
					$this->request->data['Blog']['profile_id'] = 0;
				$this->request->data['Blog']['id'] = $blog_id;
				$this->request->data = Sanitize::clean($this->request->data);
				$data = Sanitize::clean($this->request->data);

				$file = $data['Blog']['image'];

				if ($file['size'] > 0) {
					$output = $this->_blog_picture();
					if (!$output['error']) {
						$cover_image = $output['filename'];
					} else {
						$cover_image = '';
					}
				} else $cover_image = $blog['Blog']['image'];
				$this->request->data['Blog']['image'] = $cover_image;

				if (!$this->Blog->save($this->request->data))
					throw new Exception(__d(__BLOG_LOCALE, 'the_blog_could_not_be_saved'));


				$this->Blog->Blogtranslation->recursive = - 1;
				$options = array();
				$options['conditions'] = array(
					"Blogtranslation.blog_id"=> $blog_id,
					"Blogtranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Blog->Blogtranslation->find('count',$options);

				/*
								* @blog translate
								*/
				if($count==0){
					$this->Blog->Blogtranslation->recursive = - 1;
					$this->request->data['Blogtranslation']['blog_id'] = $blog_id;
					$this->request->data['Blogtranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Blogtranslation']['title'] = trim($this->request->data['Blogtranslation']['title']);
					$this->request->data['Blogtranslation']['little_detail'] = trim($this->request->data['Blogtranslation']['little_detail']);
					$this->request->data['Blogtranslation']['detail'] = trim($this->request->data['Blogtranslation']['detail']);
					$this->Blog->create();
					if(!$this->Blog->Blogtranslation->save($this->request->data))
						throw new Exception(__d(__BLOG_LOCALE,'the_blog_could_not_be_saved'));
				}else
				{
					$ret= $this->Blog->Blogtranslation->updateAll(
						array('Blogtranslation.title' =>'"'.trim($this->request->data['Blogtranslation']['title']).'"',
							'Blogtranslation.little_detail' =>'"'.$this->request->data['Blogtranslation']['little_detail'].'"',
							'Blogtranslation.detail' =>'"'.$this->request->data['Blogtranslation']['detail'].'"'
						),
						array('Blogtranslation.blog_id'=>$blog_id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))

					);
					if(!$ret){

						throw new Exception(__d(__BLOG_LOCALE,'the_blog_could_not_be_saved'));
					}
				}
				/*
				* blog translate
				*/

				/* tags */
				$data = array();
				$dt = array();
				/*if (!$this->Blog->Blogrelatetag->deleteAll(array('Blogrelatetag.blog_id' => $blog_id), FALSE))
					throw new Exception(__d(__BLOG_LOCALE, 'the_blog_tag_not_saved'));*/

				$ret = $this->Blog->Blogrelatetag->query("
					 delete from blogrelatetags 					
					 where id in(
					     SELECT * FROM (
					           select Blogrelatetag.id 
					            from blogrelatetags as Blogrelatetag
					                inner join blogtags as Blogtag
					                        on Blogtag.id = Blogrelatetag.blog_tag_id
					             where Blogrelatetag.blog_id = ".$blog_id."
					               and Blogtag.language_id = ".$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)."
					         ) AS p
						)
					  		 
				");

				if (isset($_POST['new_tags']) && !empty($_POST['new_tags'])) {
					$tags = $_POST['new_tags'];//explode('#',$this->request->data['Blogrelatetag']['tag']);
					$tags = array_filter($tags, 'strlen');
					$this->loadModel('Blogtag');
					if (!empty($tags)) {
						foreach ($tags as $tag) {
							$tag = trim($tag);

							$options = array();
							$oldtag = array();

							$options['fields'] = array(
								'Blogtag.id',
							);
							$options['conditions'] = array(
								'Blogtag.title' => $tag
							);
							$oldtag = $this->Blogtag->find('first', $options);

							if (empty($oldtag)) {

								$this->request->data['Blogtag']['title'] = $tag;
								$this->request->data['Blogtag']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
								$this->Blogtag->create();

								if (!$this->Blogtag->save($this->request->data)) {
									throw new Exception(__d(__BLOG_LOCALE, 'the_blog_tag_not_saved'));
								}
								$tag_id[] = $this->Blogtag->getLastInsertID();

							} else {
								$tag_id[] = $oldtag['Blogtag']['id'];
							}


						}
					}

				}

				$data = array();
				if (isset($this->request->data['Blogrelatetag']['blog_tag_id'])) {
					foreach ($this->request->data['Blogrelatetag']['blog_tag_id'] as $id) {
						$dt = array('Blogrelatetag' => array('blog_id'    => $blog_id,'blog_tag_id'=>$id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)));
						array_push($data,$dt);
					}
				}

				if (!empty($tag_id)) {
					foreach ($tag_id as $tid) {
						$dt = array('Blogrelatetag' => array('blog_id'    => $blog_id,'blog_tag_id'=>$tid,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)));
						array_push($data,$dt);
					}

				}

				if (!empty($this->request->data['Blogrelatetag']['blog_tag_id']) || !empty($tag_id)) {
					$this->Blog->Blogrelatetag->create();
					if (!$this->Blog->Blogrelatetag->saveMany($data))
						throw new Exception(__d(__BLOG_LOCALE, 'the_blog_tag_not_saved'));
				}
				/* tags*/

				$datasource->commit();

				if ($file['size'] > 0) {
					@unlink(__BLOG_IMAGE_PATH . "/" . $blog['Blog']['image']);
					@unlink(__BLOG_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $blog['Blog']['image']);
				}

				$this->Redirect->flashSuccess(__d(__BLOG_LOCALE, 'the_blog_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				if ($file['size'] > 0) {
					@unlink(__BLOG_IMAGE_PATH . "/" . $cover_image);
					@unlink(__BLOG_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				}
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}


		}

		$options = array();
		$this->Blog->Blogrelatetag->recursive = -1;
		$options['fields'] = array(
			'Blogrelatetag.id',
			'Blogtag.title',
			'Blogtag.id'
		);
		$options['joins'] = array(
			array('table' => 'blogtags',
				'alias' => 'Blogtag',
				'type' => 'INNER',
				'conditions' => array(
					'Blogtag.id = Blogrelatetag.blog_tag_id'
				)
			)
		);
		$options['conditions'] = array(
			'Blogrelatetag.blog_id' => $blog_id,
			'Blogtag.language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
		);
		$blogrelatetags = $this->Blog->Blogrelatetag->find('all', $options);
		$this->set('blogrelatetags', $blogrelatetags);

		$this->_set_blog($blog_id);

	}


	function admin_manager()
	{

	}

	function admin_delete($id = null)
	{
		$this->Blog->id = $id;
		if (!$this->Blog->exists()) {
			$this->Redirect->flashWarning(__d(__BLOG_LOCALE, 'invalid_id_for_blog'), array('action' => 'index'));
		}
		$blog = $this->Blog->findById($id);
		if ($this->Blog->delete($id)) {

			@unlink(__BLOG_IMAGE_PATH . "/" . $blog['Blog']['image']);
			@unlink(__BLOG_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $blog['Blog']['image']);

			$this->Redirect->flashSuccess(__d(__BLOG_LOCALE, 'delete_blog_success'), array('action' => 'index'));
		} else {
			$this->Redirect->flashWarning(__d(__BLOG_LOCALE, 'delete_blog_not_success'), array('action' => 'index'));
		}

	}

	/**
	 *
	 *
	 */
	function refresh_blog()
	{

		$this->Blog->recursive = -1;

		if (isset($_REQUEST['first'])) {
			$first = $_REQUEST['first'];
		} else $first = 0;
		$end = 5;

		$options['fields'] = array(
			'User.id',
			'User.name',
			'User.user_name',
			'User.role_id',
			'Blog.id',
			'Blog.title_' . $this->Session->read('Config.language') . ' as title',
			'Blog.body_' . $this->Session->read('Config.language') . ' as body',
			'Blog.little_body_' . $this->Session->read('Config.language') . ' as little_body',
			'Blog.num_viewed',
			'Blog.created'
		);
		$options['joins'] = array(
			array('table' => 'users',
				'alias' => 'User',
				'type' => 'LEFT',
				'conditions' => array(
					'User.id = Blog.user_id ',
				)
			)

		);

		$options['conditions'] = array(
			"Blog.status" => 1
		);

		$options['order'] = array(
			'Blog.id' => 'desc'
		);
		$options['limit'] = $end;
		$options['offset'] = $first;

		$blogs = $this->Blog->find('all', $options);
		$this->set(compact('blogs'));
		$this->render('/Elements/Blogs/Ajax/refresh_blog', 'ajax');

	}

	/**
	 *
	 * @param undefined $id
	 *
	 */


	function refresh_tag()
	{

		$this->Blog->recursive = -1;

		if (isset($_REQUEST['first'])) {
			$first = $_REQUEST['first'];
		} else $first = 0;
		$end = 5;

		if (isset($_REQUEST['tag_id'])) {
			$tag_id = $_REQUEST['tag_id'];
		}

		$User_Info = $this->Session->read('User_Info');

		$options['fields'] = array(
			'distinct(Blog.id) as id',
			'User.id',
			'User.name',
			'User.user_name',
			'User.role_id',
			'Blog.title_' . $this->Session->read('Config.language') . ' as title',
			'Blog.body_' . $this->Session->read('Config.language') . ' as body',
			'Blog.little_body_' . $this->Session->read('Config.language') . ' as little_body',
			'Blog.num_viewed',
			'Blog.created'
		);
		$options['joins'] = array(
			array('table' => 'users',
				'alias' => 'User',
				'type' => 'LEFT',
				'conditions' => array(
					'User.id = Blog.user_id ',
				)
			),
			array('table' => 'blogrelatetags',
				'alias' => 'Blogrelatetag',
				'type' => 'LEFT',
				'conditions' => array(
					'Blogrelatetag.blog_id = Blog.id ',
				)
			)

		);

		$options['conditions'] = array(
			"Blog.status" => 1,
			"Blogrelatetag.blog_tag_id" => $tag_id
		);

		$options['order'] = array(
			'Blog.id' => 'desc'
		);
		$options['limit'] = $end;
		$options['offset'] = $first;

		$blogs = $this->Blog->find('all', $options);
		$this->set(compact('blogs'));
		$this->render('/Elements/Blogs/Ajax/refresh_blog', 'ajax');

	}

	/**
	 *
	 *
	 */
	function add_search()
	{

		$this->Blog->recursive = -1;

		if (isset($_REQUEST['first'])) {
			$first = $_REQUEST['first'];
		} else $first = 0;
		$end = 5;

		if (isset($_REQUEST['year'])) {
			$year = $_REQUEST['year'];
		} else $year = '';
		if (isset($_REQUEST['month'])) {
			$month = $_REQUEST['month'];
		} else $month = '';
		if (isset($_REQUEST['writer'])) {
			$writer = $_REQUEST['writer'];
		} else $writer = '';
		if (isset($_REQUEST['search_text'])) {
			$search_text = $_REQUEST['search_text'];
		} else $search_text = '';
		if (isset($_REQUEST['tag'])) {
			$tag = $_REQUEST['tag'];
		} else $tag = '';

		$User_Info = $this->Session->read('User_Info');

		$options['fields'] = array(
			'DISTINCT (Blog.id)',
			'User.id',
			'User.name',
			'User.user_name',
			'User.role_id',
			'Blog.title_' . $this->Session->read('Config.language') . ' as title',
			'Blog.body_' . $this->Session->read('Config.language') . ' as body',
			'Blog.little_body_' . $this->Session->read('Config.language') . ' as little_body',
			'Blog.num_viewed',
			'Blog.created'
		);
		$options['joins'] = array(
			array('table' => 'users',
				'alias' => 'User',
				'type' => 'LEFT',
				'conditions' => array(
					'User.id = Blog.user_id ',
				)
			),
			array('table' => 'blogrelatetags',
				'alias' => 'Blogrelatetag',
				'type' => 'LEFT',
				'conditions' => array(
					'Blogrelatetag.blog_id = Blog.id ',
				)
			),
			array('table' => 'blogtags',
				'alias' => 'Blogtag',
				'type' => 'LEFT',
				'conditions' => array(
					'Blogtag.id = Blogrelatetag.blog_tag_id ',
				)
			)
		);

		$options['conditions'] = array(
			"Blog.status" => 1,
			"date(Blog.created) like " => $year . "%",
			"User.name like " => $writer . "%",
			"Blog.title_" . $this->Session->read('Config.language') . " like " => $search_text . "%",
			"Blogtag.title like " => $tag . "%",
		);

		if (isset($month) && (isset($year) && !empty($year))) {
			$options['conditions'] = array(
				"Blog.status" => 1,
				"date(Blog.created) like " => $year . '-' . $month . "%",
				"User.name like " => $writer . "%",
				"Blog.title_" . $this->Session->read('Config.language') . " like " => $search_text . "%",
				"Blogtag.title like " => $tag . "%",
			);
		}


		$options['order'] = array(
			'Blog.id' => 'desc'
		);
		$options['limit'] = $end;
		$options['offset'] = $first;

		$blogs = $this->Blog->find('all', $options);
		$this->set(compact('blogs'));
		$this->render('/Elements/Blogs/Ajax/refresh_blog', 'ajax');

	}


	/**
	 *
	 * @param undefined $id
	 *
	 */
	function view($id = null)
	{


		$this->Blog->recursive = -1;


		$this->Blog->id = $id;
		if (!$this->Blog->exists()) {
			$blog = $this->Blog->findBySlug($id);
			if (empty($blog)) {
				throw new NotFoundException(__('not_valid_page'));
			}
			$id = $blog['Blog']['id'];
		}


		$User_Info = $this->Session->read('User_Info');

		$ret = $this->Blog->updateAll(
			array('Blog.num_viewed' => 'Blog.num_viewed + 1'),   //fields to update
			array('Blog.id' => $id)  //condition
		);

		$options['fields'] = array(
			'Blog.id',
			'Blogtranslation.title',
			'Blogtranslation.detail',
			'Blog.image',
			'Blog.num_viewed',
			'Blogtranslation.little_detail',
			'Blog.created',
			'Blog.link',
			'Profile.id',
			'Profile.name',
			'Profile.image',
			'Blog.slug',
			'Blog.num_viewed',
			'Blog.num_comment',
			'Profile.user_name'
		);

		$options['joins'] = array(
			array('table' => 'users',
				'alias' => 'Profile',
				'type' => 'left',
				'conditions' => array(
					'Profile.id = Blog.profile_id'
				)
			),
			array('table'     => 'blogtranslations',
				'alias'     => 'Blogtranslation',
				'type'      => 'left',
				'conditions' => array(
					'Blog.id = Blogtranslation.blog_id'
				)
			),
			array('table'     => 'languages',
				'alias'     => 'Language',
				'type'      => 'left',
				'conditions' => array(
					'Language.id = Blogtranslation.language_id'
				)
			)
		);

		$options['conditions'] = array(
			"Blog.status" => 1,
			"Blog.id" => $id,
			'Language.code'=> $this->Session->read('Config.language')
		);

		$blog = $this->Blog->find('first', $options);
		//pr($blog);
		$this->set(compact('blog'));

		$this->loadModel('Blogtag');
		$this->Blogtag->recursive = -1;

		$options['fields'] = array(
			'Blogtag.id',
			'Blogtag.title'
		);
		$options['joins'] = array(
			array('table' => 'blogrelatetags',
				'alias' => 'Blogrelatetag',
				'type' => 'LEFT',
				'conditions' => array(
					'Blogrelatetag.blog_tag_id = Blogtag.id ',
				)
			)
		,
			array('table'     => 'languages',
				'alias'     => 'Language',
				'type'      => 'left',
				'conditions' => array(
					'Language.id = Blogrelatetag.language_id'
				)
			)
		);

		$options['conditions'] = array(
			"Blogrelatetag.blog_id" => $id,
			'Language.code'=> $this->Session->read('Config.language')
		);

		$options['order'] = array(
			'Blogtag.id' => 'desc'
		);


		$tags = $this->Blogtag->find('all', $options);

		$tag_str = '';
		$tag_id = '';
		if (!empty($tags)) {
			foreach ($tags as $tag) {
				$tag_str = $tag_str . $tag['Blogtag']['title'] . ',';
				$tag_id = $tag_id . $tag['Blogtag']['id'] . ',';
			}
		}

		/* similar blogs */
		$similar_blogs = array();
		if (trim($tag_id) <> '') {
			$similar_blogs = $this->Blog->query("SELECT
			DISTINCT(Blog.id),
			Blogtranslation.title,
			Blog.image,
			Blog.num_viewed ,
			Blog.slug ,
			Blog.num_comment,
			Blog.created
			from blogs as Blog
			   inner join blogrelatetags as Blogrelatetag
			           on Blogrelatetag.blog_id = Blog.id
			   inner join blogtranslations as Blogtranslation
			         on Blog.id = Blogtranslation.blog_id
			   inner join languages as Language
			 		 on  Language.id = Blogtranslation.language_id        
			WHERE Blog.status = 1
			  and Language.code = '".$this->Session->read('Config.language')."'        
			  and Blog.id <> " . $id . " 
			  and Blogrelatetag.blog_tag_id in (" . substr($tag_id, 0, strlen($tag_id) - 1) . ")
			ORDER BY Blog.id desc
			limit 0,9");

			$this->set(compact('similar_blogs'));
		}

		/* similar blogs */

		$this->Blog->recursive = -1;
		$last_blogs = $this->Blog->query("SELECT
			Blog.id,
			Blogtranslation.title,
			Blogtranslation.little_detail,
			Blog.image,
       		Blog.slug ,
			Blog.num_viewed ,
			Blog.num_comment,
			Blog.created  
			from blogs as Blog
			inner join blogtranslations as Blogtranslation
			         on Blog.id = Blogtranslation.blog_id
			 inner join languages as Language
			 		on  Language.id = Blogtranslation.language_id        
			WHERE Blog.status = 1
			  and Language.code = '".$this->Session->read('Config.language')."'
			  and Blog.id <> " . $id . "
			ORDER BY Blog.id desc
			limit 0,10");

		$this->set(compact('last_blogs'));

		$this->Blog->recursive = -1;
		$besttags = $this->Blog->query("
			SELECT BlogTag.title,BlogTag.id,count(*) as UssesTagCount 
			FROM `blogrelatetags` BlogRelate
			inner join blogtags as BlogTag 
			  on BlogRelate.`blog_tag_id` = BlogTag.id
			  inner join languages as Language
			 		on  Language.id = BlogRelate.language_id  
			WHERE  Language.code = '".$this->Session->read('Config.language')."'
			GROUP by BlogTag.id
			ORDER by  UssesTagCount desc  limit 0,10
		");

		$this->set(compact('besttags'));


		$this->set('title_for_layout', $blog['Blogtranslation']['title'] . __('default_title'));
		$this->set('description_for_layout', $blog['Blogtranslation']['little_detail']);
		$this->set('keywords_for_layout', $tag_str);
		$this->set('header_canonical', __SITE_URL.__BLOG."/".$blog['Blog']['slug']);

		$this->set('blog_id', $id);
		$this->set('tags', $tags);
		$this->set('title', $blog['Blogtranslation']['title']);
		$this->set('weblog_detail', $blog['Blogtranslation']['title']);

		$open_graph_items = array(
			"property='og:title'" => $blog['Blogtranslation']['title'],
			"property='og:description'" => $blog['Blogtranslation']['little_detail'],
			"property='og:image'" => __SITE_URL . __BLOG_IMAGE_PATH . __UPLOAD_THUMB . '/' . $blog['Blog']['image'],
			"property='og:url'" => __SITE_URL.__BLOG."/".$blog['Blog']['slug'],

			"name='twitter:title'" => $blog['Blogtranslation']['title'],
			"name='twitter:description'" => $blog['Blogtranslation']['little_detail'],
			"name='twitter:image'" => __SITE_URL . __BLOG_IMAGE_PATH . __UPLOAD_THUMB . '/' . $blog['Blog']['image'],
			"name='twitter:card'" => 'summary'
		);
		$this->set('open_graph_items', $open_graph_items);
	}

	function user_count()
	{
		$this->Blog->recursive = -1;
		$options['conditions'] = array(
			'Blog.status' => 1
		);
		return $this->Blog->find('count', $options);
	}

	function blog_count()
	{
		$this->Blog->recursive = -1;
		$response['count'] = 0;

		$User_Info = $this->Session->read('User_Info');

		$blog_count = $this->Blog->find('count', array('conditions' => array('Blog.user_id' => $User_Info['id'])));
		$response['count'] = $blog_count;
		$this->set('ajaxData', json_encode($response));
		$this->render('/Elements/Blogs/Ajax/ajax_result', 'ajax');
	}

	function load_blog_form($id = 0)
	{
		if ($id != 0) {
			$this->Blog->Blogchannel->Channel->recursive = -1;
			$options['fields'] = array(
				'Channel.id',
				'Channel.title_' . $this->Session->read('Config.language') . ' as title',

			);
			$options['joins'] = array(
				array('table' => 'blog_channels',
					'alias' => 'Blogchannel',
					'type' => 'INNER',
					'conditions' => array(
						'Blogchannel.channel_id = Channel.id ',
					)
				)

			);

			$options['conditions'] = array(
				"Blogchannel.blog_id" => $id
			);

			$options['order'] = array(
				'Channel.id' => 'desc'
			);
			$cur_channels = $this->Blog->Blogchannel->Channel->find('all', $options);
			$this->set('cur_channels', $cur_channels);

			$options = array();
			$options['fields'] = array(
				'Blog.id',
				'Blog.title',
				'Blog.body',
				'Blog.image',
				'Blog.image_x',
				'Blog.image_y',
				'Blog.image_zoom',
				'Blog.created'
			);
			$options['conditions'] = array(
				"Blog.id" => $id
			);
			$blog = $this->Blog->find('first', $options);
			$this->set('blog', $blog);
		}

		$this->Blog->Blogchannel->Channel->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Channel.id',
			'Channel.title_' . $this->Session->read('Config.language') . ' as title',
		);
		$channels = $this->Blog->Blogchannel->Channel->find('all', $options);


		$this->set('channels', $channels);


		$this->render('/Elements/Blogs/Ajax/blog_form', 'ajax');
	}

	/**
	 *
	 * @param undefined $id
	 *
	 */
	function load_blog_tab($blog_id = 0)
	{
		$User_Info = $this->Session->read('User_Info');
		$this->Blog->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Blog.id',
			'LEFT(Blog.title,60) as title',
			'Blog.image',
			'Blog.created'
		);
		$options['conditions'] = array(
			"Blog.user_id" => $User_Info['id']
		);

		$options['order'] = array(
			'Blog.id' => 'desc'
		);
		$blogs = $this->Blog->find('all', $options);


		$this->set('blogs', $blogs);

		$this->set('blog_id', $blog_id);
		$this->render('/Elements/Blogs/Ajax/blog_tab', 'ajax');
	}

	public
	function delete_image()
	{
		$response['success'] = false;
		$response['message'] = null;

		$blog_id = Sanitize::clean($_REQUEST['blog_id']);

		$this->Blog->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Blog.id',
			'Blog.image',
		);
		$options['conditions'] = array(
			"Blog.id" => $blog_id
		);
		$blog = $this->Blog->find('first', $options);
		$this->Blog->recursive = -1;

		try {
			$ret = $this->Blog->query("update blogs set image = '' where id =" . $blog_id);
			@unlink(__BLOG_IMAGE_PATH . "/" . $blog['Blog']['image']);
			@unlink(__BLOG_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $blog['Blog']['image']);

			$response['success'] = TRUE;
		} catch (Exception $e) {
			$response['success'] = FALSE;
		}


		$response['message'] = $response['success'] ? '' : __('image_not_deleted');
		$this->set('ajaxData', json_encode($response));
		$this->render('/Elements/Blogs/Ajax/ajax_result', 'ajax');
	}

	/**
	 *
	 *
	 */
	public
	function delete_blog()
	{
		$response['success'] = false;
		$response['message'] = null;

		$blog_id = Sanitize::clean($_REQUEST['blog_id']);

		$this->Blog->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Blog.id',
			'Blog.image',
		);
		$options['conditions'] = array(
			"Blog.id" => $blog_id
		);
		$blog = $this->Blog->find('first', $options);
		$this->Blog->recursive = -1;

		try {
			if ($this->Blog->delete($blog_id)) {

				$this->Blog->Post->recursive = -1;
				$options = array();
				$options['fields'] = array(
					'Post.id',
				);
				$options['conditions'] = array(
					"Post.blog_id" => $blog_id
				);
				$post = $this->Blog->Post->find('first', $options);

				if ($this->Blog->Post->deleteAll(array('Post.id' => $post['Post']['id']), false)) {
					$options = array();
					$options['fields'] = array(
						'Post.id',
						'Post.image',
					);
					$options['conditions'] = array(
						"Post.parent_id" => $post['Post']['id']
					);
					$posts = $this->Blog->Post->find('all', $options);
					if (!empty($posts)) {
						foreach ($posts as $child_post) {
							if ($this->Blog->Post->delete($child_post['Post']['id'])) {
								try {
									@unlink(__POST_IMAGE_PATH . "/" . $child_post['Post']['image']);
									@unlink(__POST_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $child_post['Post']['image']);
								} catch (Exception $e) {

								}
							}
						}
					}
				}


				@unlink(__BLOG_IMAGE_PATH . "/" . $blog['Blog']['image']);
				@unlink(__BLOG_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $blog['Blog']['image']);
				$response['success'] = TRUE;
			}
		} catch (Exception $e) {
			$response['success'] = FALSE;
		}


		$response['message'] = $response['success'] ? '' : __('blog_not_deleted');
		$this->set('ajaxData', json_encode($response));
		$this->render('/Elements/Blogs/Ajax/ajax_result', 'ajax');
	}

	/**
	 *
	 *
	 */
	public
	function publish_blog()
	{
		$response['success'] = false;
		$response['message'] = null;

		$blog_id = Sanitize::clean($_REQUEST['blog_id']);

		$User_Info = $this->Session->read('User_Info');

		$this->Blog->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Blog.id',
			'Blog.image',
			'Blog.title',
			'Blog.body'
		);
		$options['conditions'] = array(
			"Blog.id" => $blog_id
		);
		$blog = $this->Blog->find('first', $options);

		$this->Blog->Post->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Post.id',
		);
		$options['conditions'] = array(
			"Post.blog_id" => $blog_id
		);
		$post = $this->Blog->Post->find('first', $options);

		$ret = $this->Blog->query("update blogs set status = 1 where id =" . $blog_id);

		$this->request->data = array();

		if (!empty($post)) {
			$this->request->data['Post']['id'] = $post['Post']['id'];
			$this->request->data['Post']['status'] = 0;
		} else {
			$this->request->data['Post']['blog_id'] = $blog['Blog']['id'];
			$this->request->data['Post']['user_id'] = $User_Info['id'];
			$this->request->data['Post']['url'] = __SITE_URL . 'blogs/view/' . $blog['Blog']['id'];
		}

		$this->request->data['Post']['url_title'] = $blog['Blog']['title'];
		$this->request->data['Post']['url_content'] = trim(mb_substr($blog['Blog']['body'], 0, 100));;
		$this->request->data['Post']['url_image'] = __SITE_URL . __BLOG_IMAGE_PATH . "/" . $blog['Blog']['image'];


		if ($this->Blog->Post->save($this->request->data)) {
			if (empty($post)) {
				$post_id = $this->Blog->Post->getLastInsertID();
				$this->Blog->Post->Allpost->recursive = -1;
				$this->request->data = array();
				$this->request->data['Allpost']['post_id'] = $post_id;
				$this->request->data['Allpost']['user_id'] = $User_Info['id'];
				$this->request->data['Allpost']['type'] = 0;
				$this->request->data['Allpost']['created'] = date('Y-m-d H:i:s');
				$this->request->data = Sanitize::clean($this->request->data);
				$this->Blog->Post->Allpost->create();
				$this->Blog->Post->Allpost->save($this->request->data);
			}
			$response['success'] = TRUE;
		}

		$response['message'] = $response['success'] ? __('blog_preview_save') : __('blog_preview_not_save');
		$this->set('ajaxData', json_encode($response));
		$this->render('/Elements/Blogs/Ajax/ajax_result', 'ajax');
	}

	function get_last_blog()
	{
		if (isset($_REQUEST['first'])) {
			$first = $_REQUEST['first'];
		} else $first = 0;
		$end = 10;

		$User_Info = $this->Session->read('User_Info');
		$blogs = $this->Blog->query("
			select
			User.id ,
			User.name ,
			User.sex ,
			User.email ,
			User.image ,
			User.user_name ,
			User.user_type ,
			User.image ,
			User.sex ,
			Blog.id,
			LEFT(Blog.title,60) as title,
			Blog.body,
			Blog.image,
			Blog.created
			from blogs as Blog
			inner join users as User
			on User.id = Blog.user_id
			where Blog.status = 1
			order by Blog.id desc
			limit " . $first . " , " . $end . "
			");


		$this->set(array(
			'blogs' => $blogs,
			'_serialize' => array('blogs')
		));

		$this->render('/Elements/Blogs/Ajax/refresh_last_blog', 'ajax');
	}

	function get_my_blog($user_id, $blog_id)
	{
		if (isset($_REQUEST['first'])) {
			$first = $_REQUEST['first'];
		} else $first = 0;
		$end = 10;

		$User_Info = $this->Session->read('User_Info');
		$blogs = $this->Blog->query("
			select
			User.id ,
			User.name ,
			User.sex ,
			User.email ,
			User.image ,
			User.user_name ,
			User.user_type ,
			User.image ,
			User.sex ,
			Blog.id,
			LEFT(Blog.title,60) as title,
			Blog.body,
			Blog.image,
			Blog.created
			from blogs as Blog
			inner join users as User
			on User.id = Blog.user_id
			where Blog.status = 1
			and user_id =  " . $user_id . "
			and Blog.id <>  " . $blog_id . "
			order by Blog.id desc
			limit " . $first . " , " . $end . "
			");


		$this->set(array(
			'blogs' => $blogs,
			'_serialize' => array('blogs')
		));

		$this->render('/Elements/Blogs/Ajax/refresh_last_blog', 'ajax');
	}

	function last()
	{
		$limit = 20;

		if (!empty($_REQUEST['page'])) {
			$page = $_REQUEST['page'];
		} else $page = 1;

		if (isset($page)) {
			$first = ($page - 1) * $limit;
		} else $first = 0;


		$this->Blog->recursive = -1;
		$blogs = $this->Blog->query("SELECT
			Blog.id,
			Blogtranslation.title,
			Blogtranslation.little_detail,
			Blog.num_viewed ,
			Blog.num_comment  ,
			Blog.created  ,
			Blog.slug  ,
			Blog.image
			from blogs as Blog
			 inner join blogtranslations as Blogtranslation
			         on Blog.id = Blogtranslation.blog_id
			 inner join languages as Language
			 		on  Language.id = Blogtranslation.language_id        
			WHERE Blog.status = 1
			  and Language.code = '".$this->Session->read('Config.language')."'
			ORDER BY Blog.pinsts desc , Blog.id desc
			limit " . $first . "," . $limit);

		$this->set(compact('blogs'));


		$options = array();
		$options['conditions'] = array(
			'Blog.status ' => 1
		);
		$total_count = $this->Blog->find('count', $options);
		$this->set(compact('total_count'));

		$this->set('weblog_detail', __d(__BLOG_LOCALE, 'weblog'));
		$this->set('limit', $limit);

		$this->set('title_for_layout', __d(__BLOG_LOCALE, 'blog') );
		$this->set('description_for_layout', __d(__BLOG_LOCALE, 'blog' . ',' . __('site_description')));
		$this->set('keywords_for_layout', __d(__BLOG_LOCALE, 'blog') . ',' . __('site_keywords'));


		$this->Blog->recursive = -1;
		$bestviewedblogs = $this->Blog->query("SELECT
			Blog.id,
			Blogtranslation.title,
			Blogtranslation.little_detail,
			Blog.num_viewed ,
			Blog.num_comment  ,
			Blog.created  ,
			Blog.slug  ,
			Blog.image
			from blogs as Blog
			 inner join blogtranslations as Blogtranslation
			         on Blog.id = Blogtranslation.blog_id
			 inner join languages as Language
			 		on  Language.id = Blogtranslation.language_id        
			WHERE Blog.status = 1
			  and Language.code = '".$this->Session->read('Config.language')."'
			ORDER BY num_viewed desc
			limit 0,8");

		$this->set(compact('bestviewedblogs'));

		$this->Blog->recursive = -1;
		$besttags = $this->Blog->query("
			SELECT BlogTag.title,BlogTag.id,count(*) as UssesTagCount 
			FROM `blogrelatetags` BlogRelate
			inner join blogtags as BlogTag 
			  on BlogRelate.`blog_tag_id` = BlogTag.id
			inner join languages as Language
			 		on  Language.id = BlogRelate.language_id    
			WHERE Language.code = '".$this->Session->read('Config.language')."'  
			GROUP by BlogTag.id
			ORDER by  UssesTagCount desc  limit 0,10
		");

		$this->set(compact('besttags'));
	}

	function home_blog()
	{
		$this->Blog->recursive = -1;
		$blogs = $this->Blog->query("SELECT
			Blog.id,
			Blog.title,
			Blog.little_detail,
			Blog.image
			from blogs as Blog
			WHERE Blog.status = 1			 
			ORDER BY Blog.pinsts desc , Blog.id desc
			limit 0,10");

		return $blogs;
	}

	function tags($tag)
	{
		$tag = str_replace('-', ' ', $tag);
		$limit = 20;

		if (!empty($_REQUEST['page'])) {
			$page = $_REQUEST['page'];
		} else $page = 1;

		if (isset($page)) {
			$first = ($page - 1) * $limit;
		} else $first = 0;


		$this->Blog->recursive = -1;
		$blogs = $this->Blog->query("SELECT
			DISTINCT (Blog.id),
			Blog.title,
			Blog.little_detail,
			Blog.image,
			Blog.num_viewed,
			Blog.slug,
			Blog.created  
			from blogs as Blog
				inner join blogrelatetags as Blogrelatetag
			           on Blogrelatetag.blog_id=Blog.id
			    inner join blogtags as Blogtag
			           on Blogrelatetag.blog_tag_id=Blogtag.id
			WHERE Blog.status = 1
			  and Blogtag.title like '%" . $tag . "%'
			ORDER BY Blog.id desc
			limit " . $first . "," . $limit);

		$this->set(compact('blogs'));

		$blog_count = $this->Blog->query("
		SELECT count(DISTINCT (Blog.id)) as count
			from blogs as Blog
				inner join blogrelatetags as Blogrelatetag
			           on Blogrelatetag.blog_id=Blog.id
			    inner join blogtags as Blogtag
			           on Blogrelatetag.blog_tag_id=Blogtag.id
			WHERE Blog.status = 1
			  and Blogtag.title like '%" . $tag . "%'");

		$this->set('total_count', $blog_count[0][0]['count']);

		$this->set('limit', $limit);
		$this->set('weblog_detail', $tag);

		$this->set('title_for_layout', $tag);
		$this->set('description_for_layout', $tag);
		$this->set('keywords_for_layout', $tag);


		$this->Blog->recursive = -1;
		$besttags = $this->Blog->query("
			SELECT BlogTag.title,BlogTag.id,count(*) as UssesTagCount 
			FROM `blogrelatetags` BlogRelate
			inner join blogtags as BlogTag 
			  on BlogRelate.`blog_tag_id` = BlogTag.id
			  
			GROUP by BlogTag.id
			ORDER by  UssesTagCount desc  limit 0,10
		");

		$this->set(compact('besttags'));
		$this->Blog->recursive = -1;
		$bestviewedblogs = $this->Blog->query("SELECT
			Blog.id,
			Blog.title,
			Blog.little_detail,
			Blog.num_viewed ,
			Blog.num_comment  ,
			Blog.created  ,
			Blog.image
			from blogs as Blog
			WHERE Blog.status = 1
			ORDER BY num_viewed desc
			limit 0,8");

		$this->set(compact('bestviewedblogs'));

		$this->render('last');


	}

	function admin_user_search()
	{

		$this->Blog->User->recursive = -1;

		$search_word = $_REQUEST["name"];
		$options['fields'] = array(
			'User.id',
			'User.name'
		);

		$options['conditions'] = array(
			'User.name LIKE' => "%$search_word%",
			'User.role_id' => 2,
			'User.status' => 1

		);

		$options['order'] = array(
			'User.id' => 'desc'
		);
		$options['limit'] = 15;

		$users = $this->Blog->User->find('all', $options);
		$this->set('users', $users);
		$this->render('/Elements/Blogs/Ajax/user_suggest', 'ajax');
	}

	function main_page_blogs()
	{


		$this->Blog->recursive = -1;
		$blogs = $this->Blog->query("SELECT
			Blog.id,
			Blog.title,
			Blog.little_detail,
			Blog.image
			from blogs as Blog
			WHERE Blog.status = 1
			ORDER BY Blog.id desc
			limit 0,3");

		$this->set(compact('blogs'));


		$options = array();
		$options['conditions'] = array(
			'Blog.status ' => 1
		);
		return $blogs;
	}

	function admin_pin($id)
	{

		$this->Blog->recursive = -1;

		$options = array();
		$options['fields'] = array(
			'max(Blog.pinsts) + 1 as maxpin',
		);

		$pin = $this->Blog->find('first', $options);


		$ret = $this->Blog->updateAll(
			array('Blog.pinsts' => $pin[0]['maxpin']),   //fields to update
			array('Blog.id' => $id)  //condition
		);
		if ($ret) {
			$this->Redirect->flashSuccess(__d(__BLOG_LOCALE, 'the_blogpin_has_been_saved'), array('action' => 'index'));
		}

	}


	function admin_unpin($id)
	{

		$this->Blog->recursive = -1;
		$ret = $this->Blog->updateAll(
			array('Blog.pinsts' => 0),   //fields to update
			array('Blog.id' => $id)  //condition
		);
		if ($ret) {
			$this->Redirect->flashSuccess(__d(__BLOG_LOCALE, 'the_blogunpin_has_been_saved'), array('action' => 'index'));
		}

	}

}
