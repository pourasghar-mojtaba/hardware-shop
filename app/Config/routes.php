<?php

Router::connect('/', array(
	'controller' => 'pages',
	'action' => 'display',
	'home'));

//Router::connect(' / pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/admin', array(
	'controller' => 'users',
	'action' => 'dashboard',
	'admin' => true));
Router::connect('/:language/:controller/:action/*', array(), array('language' =>
	'[a-z]{3}'));


Router::connect('/blog/:slug',
	array(
		'plugin' => 'blog',
		'controller' => 'blogs',
		'action' => 'view'
	),
	array(
		'pass' => array('slug')
	));

Router::connect('/company/:slug',
	array(
		'plugin' => 'company',
		'controller' => 'companies',
		'action' => 'view'
	),
	array(
		'pass' => array('slug')
	));

Router::connect('/product/:slug',
	array(
		'plugin' => 'product',
		'controller' => 'products',
		'action' => 'view'
	),
	array(
		'pass' => array('slug')
	));
Router::connect('/products',
	array(
		'plugin' => 'product',
		'controller' => 'products',
		'action' => 'search'
	),
	array(
		//'pass' => array('slug')
	));
Router::connect('/orders/purchases',
	array(
		'plugin' => 'product',
		'controller' => 'orders',
		'action' => 'purchases'
	),
	array(
		//'pass' => array('slug')
	));

Router::connect('/orders/detail/:id',
	array(
		'plugin' => 'product',
		'controller' => 'orders',
		'action' => 'detail'
	),
	array(
		'pass' => array('id')
	));

Router::connect('/orders/register',
	array(
		'plugin' => 'product',
		'controller' => 'orders',
		'action' => 'register'
	),
	array(
		//'pass' => array('slug')
	));
Router::connect('/orders/end_order',
	array(
		'plugin' => 'product',
		'controller' => 'orders',
		'action' => 'end_order'
	),
	array(
		//'pass' => array('slug')
	));
Router::connect('/products/basket',
	array(
		'plugin' => 'product',
		'controller' => 'products',
		'action' => 'basket'
	),
	array(
		//'pass' => array('slug')
	));
Router::connect('/sitemap.xml', array('controller' => 'sitemaps', 'action' => 'index', 'ext' => 'xml'));
Router::connect('/rss.xml', array('controller' => 'feeds', 'action' => 'index', 'ext' => 'xml'));
Router::parseExtensions('rss');
CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
