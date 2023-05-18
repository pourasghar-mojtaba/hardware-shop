<?php


$this->add_hook('admin_group_menu', 'product_menu');

function product_menu($arg)
{
	$active = NULL;
	$controllers = array('products', 'productcategories', 'orders', 'discounttypes', 'discountcoupons', 'productdiscounts');
	//pr($arg['arguments']['controller']);
	if (in_array($arg['arguments']['controller'], $controllers)) $active = 'active';
	echo "
		<li class='treeview " . $active . "'>
			<a href='#'>
				<i class='fa fa-th'>
				</i>
				<span>
					" . __d(__PRODUCT_LOCALE, 'product_managment') . "
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
	$active = NULL;
	if ($arg['arguments']['controller'] == 'productcategories') $active = 'class="active"';
	echo "
				<li " . $active . " >
					<a href='" . __SITE_URL . "admin/product/productcategories/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__PRODUCT_LOCALE, 'category_managment') . "
					</a>
				</li>";
	$active = NULL;
	if ($arg['arguments']['controller'] == 'products') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/product/products/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__PRODUCT_LOCALE, 'product_managment') . "
					</a>
				</li>";
	/*
		$active = NULL;
		if ($arg['arguments']['controller'] == 'productfiles') $active = 'class="active"';
		echo "
					<li " . $active . ">
						<a href='" . __SITE_URL . "admin/".__PRODUCT."/productfiles/index'>
							<i class='fa fa-circle-o'>
							</i> " . __d(__PRODUCT_LOCALE, 'productfile_managment') . "
						</a>
					</li>";
		$active = NULL;*/
	$active = NULL;
	if ($arg['arguments']['controller'] == 'orders') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/" . __PRODUCT . "/orders/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__PRODUCT_LOCALE, 'order_managment') . "
					</a>
				</li>";

	$active = NULL;
	if ($arg['arguments']['controller'] == 'discounttypes') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/" . __PRODUCT . "/discounttypes/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__PRODUCT_LOCALE, 'discounttype_managment') . "
					</a>
				</li>";
	/*$active = NULL;
	if ($arg['arguments']['controller'] == 'discountcoupons') $active = 'class="active"';
	echo "
				<li " . $active . ">
					<a href='" . __SITE_URL . "admin/" . __PRODUCT . "/discountcoupons/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__PRODUCT_LOCALE, 'discountcoupons_managment') . "
					</a>
				</li>";*/
	$active = NULL;
	if ($arg['arguments']['controller'] == 'productdiscounts') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/" . __PRODUCT . "/productdiscounts/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__PRODUCT_LOCALE, 'productdiscounts_managment') . "
					</a>
				</li>";

	echo "</ul>
		</li>
	";

}

$this->add_hook('user_menu', 'product_user_menu');
function product_user_menu($arg)
{
	echo "<li class='nav-item mega-dropdown-toggle'><a class='nav-link' href='".__SITE_URL."products'>" . __d(__PRODUCT_LOCALE, 'shop') . "</a></li>";
	//_get_header_catrgories($arg,0);
}

$this->add_hook('mobile_user_menu', 'product_mobile_user_menu');
function product_mobile_user_menu($arg)
{
	echo "<div class='card'><div class='card-header'><a href='".__SITE_URL.__PRODUCT."/products/search' class='mobile-menu-link'>" . __d(__PRODUCT_LOCALE, 'shop') . "</a></div></div>";
}

function _get_header_catrgories($arg, $parent_id)
{

	App::uses('ProductAppModel', 'Product.Model');
	App::uses('Productcategory', 'Product.Model');
	$lang = $arg['arguments']['lang'];
	$Productcategory = new Productcategory();

	$category_data = array();
	$Productcategory->recursive = -1;

	$options = array();
	$options['fields'] = array(
		'Productcategory.id',
		'Productcategory.parent_id',
		'Productcategorytranslation.title',
	);
	$options['joins'] = array(
		array('table' => 'productcategorytranslations',
			'alias' => 'Productcategorytranslation',
			'type' => 'left',
			'conditions' => array(
				'Productcategory.id = Productcategorytranslation.product_category_id',
				"Productcategorytranslation.language_id" => $lang
			)
		)
	);

	$options['conditions'] = array(
		'parent_id' => $parent_id,
		'status' => 1
	);

	$query = $Productcategory->find('all', $options);
	//$query = $Productcategory->find('all', array('fields' => array('id', 'parent_id', 'title as title'), 'conditions' => array('parent_id' => $parent_id, 'status' => 1)));

	foreach ($query as $result) {
		$options = array();
		$options['fields'] = array(
			'Productcategory.id',
			'Productcategory.parent_id',
			'Productcategorytranslation.title',
		);
		$options['joins'] = array(
			array('table' => 'productcategorytranslations',
				'alias' => 'Productcategorytranslation',
				'type' => 'left',
				'conditions' => array(
					'Productcategory.id = Productcategorytranslation.product_category_id',
					"Productcategorytranslation.language_id" => $lang
				)
			)
		);
		$options['conditions'] = array(
			'parent_id' => $result['Productcategory']['id'],
			'status' => 1
		);
		$sub_query = $Productcategory->find('all', $options);
		if (empty($sub_query)) {
			echo "
					<li class='nav-item mega-dropdown-toggle active'><a class='nav-link' href='" . __SITE_URL . "product/products/search?categoryid_filter=" . $result['Productcategory']['id'] . "'>
					" . $result['Productcategorytranslation']['title'] . "</a></li>
				";
		} else {
			// <a href='javascript:void(0)' title='".$result['Productcategory']['id']."' >".$result['Productcategory']['title']."</a>

			echo "
					<li class='nav-item dropdown-toggle'><a class='nav-link' href='" . __SITE_URL . "product/products/search?categoryid_filter=" . $result['Productcategory']['id'] . "'> " . $result['Productcategorytranslation']['title'] . "</a>
						<ul class='dropdown-menu'>
					
					<li class='nav-item dropdown'> 
						<a class='nav-link dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' href='" . __SITE_URL . "product/products/search?categoryid_filter=" . $result['Productcategory']['id'] . "' title='" . $result['Productcategory']['id'] . "' >" . $result['Productcategorytranslation']['title'] . " <i class='fa fa-angle-down m-l-5'></i></a>
						<ul class='b-none dropdown-menu font-14 animated fadeInUp'>
				";
			_get_header_catrgories($arg, $result['Productcategory']['id']);

			echo "  </ul>
					</li>";
		}

	}
}

$this->add_hook('last_categories', 'last_categories');

function last_categories($arg){
	App::uses('ProductAppModel', 'Product.Model');
	App::uses('Productcategory', 'Product.Model');
	$lang = $arg['arguments']['lang'];
	$Productcategory = new Productcategory();

	$category_data = array();
	$Productcategory->recursive = -1;

	$options = array();
	$options['fields'] = array(
		'Productcategory.id',
		'Productcategory.parent_id',
		'Productcategory.image',
		'Productcategorytranslation.title',
	);
	$options['joins'] = array(
		array('table' => 'productcategorytranslations',
			'alias' => 'Productcategorytranslation',
			'type' => 'inner',
			'conditions' => array(
				'Productcategory.id = Productcategorytranslation.product_category_id',
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'inner',
			'conditions' => array(
				'Language.id = Productcategorytranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'parent_id <>' => 0 ,
		'status' => 1,
		'Language.code' => $lang
	);

	$categories = $Productcategory->find('all', $options);

	echo  "
		<h2 class='h4 block-title text-center pt-4 mt-2'>".__d(__PRODUCT_LOCALE, 'categories') ."</h2>
		<div class='row pt-4'>
			";

		foreach ($categories as $category){
			echo "
				<div class='col-lg-3 col-md-4 col-sm-6'>
					<a class='d-block text-decoration-none mb-4' href='".__SITE_URL."products?categoryid_filter=".$category['Productcategory']['id']."'>
						<figure class='figure'> <img class='figure-img' src='". __SITE_URL . __PRODUCT_IMAGE_URL."/".$category['Productcategory']['image']."' alt='".$category['Productcategorytranslation']['title']."'>
							<figcaption class='figure-caption h6 text-lg text-center mb-2'>".$category['Productcategorytranslation']['title']."</figcaption>
						</figure>
					</a>
				</div>
			";
		}

		echo"</div>
	";


}

$this->add_hook('last_product', 'last_product_slider');

function last_product_slider($arg)
{

	App::uses('ProductAppModel', 'Product.Model');
	App::uses('Product', 'Product.Model');
	$product = new Product();
	$product->recursive = -1;
	$options['fields'] = array(
		'Message.id',
		'Message.user_id',
		'Message.message',
		'User.name',
		'User.image'
	);
	$options['joins'] = array(
		array('table' => 'users',
			'alias' => 'User',
			'type' => 'INNER',
			'conditions' => array(
				'User.id = Message.user_id'
			)
		)
	);
	$options['conditions'] = array(
		'Message.status' => 1
	);
	$options['order'] = array(
		'Technicalinfoitem.arrangment' => 'asc'
	);
	$options['limit'] = 5;
	$messages = $message->find('all', $options);

	echo "<ul class='bxslider'>
				<li>
					<em>
						<img src='<?php echo __SITE_URL.__IMAGE_PATH; ?>photos/img11.jpg' alt='' />
						<a href='portfolio_item.html'>
							<i class='fa fa-link icon-hover icon-hover-1'>
							</i>
						</a>
						<a href='<?php echo __SITE_URL.__IMAGE_PATH; ?>photos/img11.jpg' class='fancybox-button' title='Project Name #1' data-rel='fancybox-button'>
							<i class='fa fa-search icon-hover icon-hover-2'>
							</i>
						</a>
					</em>
					<a class='bxslider-block' href='#'>
						<strong>
							نصب درب سکوريت
						</strong>
						<b>
							تهران:: فروشگاه هفت
						</b>
					</a>
				</li>

			</ul>";

}

$this->add_hook('home_products', 'home_products');

function home_products($arg)
{

	App::uses('ProductAppModel', 'Product.Model');
	App::uses('Product', 'Product.Model');
	$product = new Product();
	$product->recursive = -1;
	$options = array();
	$lang = $arg['arguments']['lang'];
	$product->recursive = -1;
	$options['fields'] = array(
		'Product.id',
		'Product.price',
		'Product.slug',
		'Producttranslation.title',
		'Producttranslation.mini_detail',
		'(select image from productimages where product_id = Product.id limit 0,1)as image'
	);

	$options['joins'] = array(
		array('table' => 'producttranslations',
			'alias' => 'Producttranslation',
			'type' => 'left',
			'conditions' => array(
				'Product.id = Producttranslation.product_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'inner',
			'conditions' => array(
				'Language.id = Producttranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Product.status' => 1,
		'Language.code' => $lang
	);

	$options['order'] = array(
		'Product.id' => 'desc'
	);
	$options['limit'] = 6;
	$products = $product->find('all', $options);

	foreach ($products as $product) {
		echo "
						<div class='col-md-4'>
							<div class='product-box'>
								<div class='product-thumb'>
									<img  src='" . __SITE_URL . __PRODUCT_IMAGE_URL . $product['0']['image'] . "' alt='" . $product['Producttranslation']['title'] . "'  />
									<a href='" . __SITE_URL . __PRODUCT . '/' . $product['Product']['slug'] . "' title='' class='add-to-cart'><i class='fa  fa-shopping-bag'></i></a>
								</div>
								<h3><a href='" . __SITE_URL . __PRODUCT . '/' . $product['Product']['slug'] . "' title=''>" . $product['Producttranslation']['title'] . "</a></h3>
								<span class='price'>" . number_format( $product['Product']['price']) . " ریال</span>
							</div>
						</div>";
	}
}

?>
