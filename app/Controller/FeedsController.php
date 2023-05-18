<?php

class FeedsController extends AppController {
	

var $helpers = array('Time','Text');
var $components = array('RequestHandler');

public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow();
}


function index ()
{    
   	
   $options = array();
   App::uses(__BLOG_PLUGIN.'AppModel', __BLOG_PLUGIN.'.Model');
   App::uses('Blog', __BLOG_PLUGIN.'.Model');
   $blog= new Blog();
   $blog->recursive = -1;
    
   $response = $blog->query("
	  select	
		Blog.id
	   ,Blog.title	
	   ,Blog.little_detail	
	   , Blog.created 
	   from blogs as Blog 
	   order  by  Blog.id desc
	"); 	
	$this->set('blogs', $response);
	 
} 	
}
?>