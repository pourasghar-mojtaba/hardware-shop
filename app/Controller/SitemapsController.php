<?php

class SitemapsController extends AppController {
	

var $name = 'Sitemaps';
var $uses = array('Post', 'Info');
var $helpers = array('Time');
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
	   ,date(Blog.created) as dt
	   from blogs as Blog 
	   order  by  Blog.id desc
	"); 	
	$this->set('blogs', $response);
	
   $options = array();	
   App::import('Model','Page');
   $page= new Page();
   
   $options['fields'] = array(
				'Page.id',
				'Page.title',
				'Page.body',
				'Page.meta' ,
				'Page.keyword',
				'date(Page.created) as dt'
			   );
	$options['conditions'] = array(
		'Page.status' => 1
	);
	
	$options['order'] = array(
		'Page.arrangment'=>'asc'
	);
	
	$response1 = $page->find('all',$options); 
	
	$this->set('pages', $response1); 
	
	
   /*$options = array();
   App::uses(__PRODUCT_PLUGIN.'AppModel', __PRODUCT_PLUGIN.'.Model');
   App::uses('Product', __PRODUCT_PLUGIN.'.Model');
   $product= new Product();
   $product->recursive = -1;
    
   $response = $product->query("
	  select	
		Product.id
	   ,Product.title	
	   ,date(Product.created) as dt
	   from blogs as Product 
	   order  by  Product.id desc
	"); 	
	$this->set('products', $response); */
	
	$options = array();
   App::uses(__PROJECT_PLUGIN.'AppModel', __PROJECT_PLUGIN.'.Model');
   App::uses('Project', __PROJECT_PLUGIN.'.Model');
   App::uses('Projectcategory', __PROJECT_PLUGIN.'.Model');
   $project= new Project();
   $project->recursive = -1;
    
   $response = $project->query("
	  select	
		Project.id
	   ,Project.title	
	   ,date(Project.created) as dt
	   from projects as Project 
	   order  by  Project.id desc
	"); 	
	$this->set('projects', $response);
  
	
	$Projectcategory= new Projectcategory();
    $Projectcategory->recursive = -1;
	$project_categories =  $Projectcategory->_getCategories(0); 
	 
	$this->set('project_categories', $project_categories);
} 

	
	
}
?>