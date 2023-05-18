<?php


$this->add_hook('admin_group_menu','product_menu');

function product_menu($arg)
{
	$active = NULL;
	$controllers = array('products','productcategories');
	if(in_array($arg['request']->params['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-th'>
				</i>
				<span>
					". __d(__PRODUCT_LOCALE,'product_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'productcategories')	 $active = 'class="active"';
			echo"
				<li ".$active." >
					<a href='".__SITE_URL."admin/product/productcategories/index'>
						<i class='fa fa-circle-o'>
						</i> ".__d(__PRODUCT_LOCALE,'category_managment')."
					</a>
				</li>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'products')	 $active = 'class="active"';
			echo"	
				<li ".$active."> 
					<a href='".__SITE_URL."admin/product/products/index'>
						<i class='fa fa-circle-o'>
						</i> ". __d(__PRODUCT_LOCALE,'product_managment')."
					</a>
				</li>";



			echo"</ul>
		</li>
	";

}

$this->add_hook('user_menu','product_user_menu');
function product_user_menu($arg){
		_get_header_catrgories(0);
}

function _get_header_catrgories($parent_id) {

	App::uses('ProductAppModel', 'Product.Model');
	App::uses('Productcategory', 'Product.Model');

	$Productcategory = new Productcategory();

	$category_data = array();
	$Productcategory->recursive=-1;
	$query=	$Productcategory->find('all',array('fields' => array('id','parent_id','title as title'),'conditions' => array('parent_id' => $parent_id,'status'=>1)));

		foreach ($query as $result) {

			$sub_query=	$Productcategory->find('all',array('fields' => array('id','parent_id','title as title'),
			'conditions' => array('parent_id' => $result['Productcategory']['id'])));
			if(empty($sub_query)){
				echo "
					<li>
						<a class='dropdown-item' href='".__SITE_URL."product/products/search?categoryid_filter=".$result['Productcategory']['id']."'  >".$result['Productcategory']['title']."</a>
					</li>
				";
			}
			else{
				// <a href='javascript:void(0)' title='".$result['Productcategory']['id']."' >".$result['Productcategory']['title']."</a>
				echo "
					<li class='nav-item dropdown'> 
						<a class='nav-link dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' href='".__SITE_URL."product/products/search?categoryid_filter=".$result['Productcategory']['id']."' title='".$result['Productcategory']['id']."' >".$result['Productcategory']['title']." <i class='fa fa-angle-down m-l-5'></i></a>
						<ul class='b-none dropdown-menu font-14 animated fadeInUp'>
				";
						_get_header_catrgories($result['Productcategory']['id']);

				echo "  </ul>
					</li>";
				}

		}
}

$this->add_hook('last_product','last_product_slider');

function last_product_slider($arg){

	App::uses('ProductAppModel', 'Product.Model');
	App::uses('Product', 'Product.Model');
	$product = new Product();
	$product->recursive = - 1;
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
		'Message.status'=> 1
	);
	$options['order'] = array(
			'Technicalinfoitem.arrangment'=>'asc'
	);
	$options['limit'] = 5;
	$messages = $message->find('all',$options);

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

$this->add_hook('home_products','home_products');

function home_products($arg){

	App::uses('ProductAppModel', 'Product.Model');
	App::uses('Product', 'Product.Model');
	$product = new Product();
	$product->recursive = - 1;
	$options = array();
	$product->recursive = - 1;
	$options['fields'] = array(
		'Product.id',
		'Product.title',
		'Product.mini_detail',
		'(select image from productimages where product_id = Product.id limit 0,1)as image'
	);
	$options['conditions'] = array(
		'Product.status'=> 1
	);
	$options['order'] = array(
		'Product.id'=>'desc'
	);
	$options['limit'] = 8;
	$products = $product->find('all',$options);

	echo "<div class='portfolio-mini-wrapper'>
			<div class='container'>
				<div class='row'>
					<div class='col-md-12'>
						<!-- GRID WRAPPER FOR CONTAINER SIZING - HERE YOU CAN SET THE CONTAINER SIZE AND CONTAINER SKIN -->
						<div class='portfolio-container portfolio-active'>
							<div id='options' class='text-right'>
								<!-- THE FILTER BUTTONS -->
								<ul id='filters' class='filter'>								
									<li class='active first-tab'><a href='' data-filter='.filter-last-products'>".__d(__PRODUCT_LOCALE,'آخرین محصولات')."</a></li>	
								</ul>
							</div>
							<div id='portfolio-content' class='projects-container row' >
							";
							foreach($products as $product){
								echo "
									
										<div class='project-post filter-last-products col-lg-3 col-md-4 col-sm-6 col-xs-12'>
											<!-- THE CONTAINER FOR THE MEDIA AND THE COVER EFFECTS -->
											<img src='".__SITE_URL.__PRODUCT_IMAGE_URL.$product['0']['image']."' alt='".$product['Product']['title']."' style='height: 240px;width: 360px;' />
											<div class='project-content'>
												<div class='inner-project'>
													<h3>".$product['Product']['title']."</h3>                                    
													<a href='".__SITE_URL.__PRODUCT.'/products/view/'.$product['Product']['id'].'/'.$product['Product']['title']."' class='project-link'>".__('more')."</a>
												</div>	
											</div>
										</div>
									
								";
							}

						echo"
						</div>	
						</div>
					</div>
					<div class='clear'></div>
				</div>
			</div>
		</div>";
	//echo "<script type='text/javascript' src='".__SITE_URL.__THEME_PATH."/js/main.js'></script>";

}
?>
