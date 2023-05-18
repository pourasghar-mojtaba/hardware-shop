<?php

 
$this->add_hook('admin_group_menu','price_menu');

function price_menu($arg)
{
	$active = NULL;
	$controllers = array('prices');
	if(in_array($arg['request']->params['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-dollar'>
				</i>
				<span>
					". __d(__PRICE_LOCALE,'price_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'prices')	 $active = 'class="active"';	
			echo"	
				<li ".$active."> 
					<a href='".__SITE_URL."admin/price/prices/index'>
						<i class='fa fa-circle-o'>
						</i> ". __d(__PRICE_LOCALE,'price_managment')."
					</a>
				</li>
			</ul>
		</li>
	";
	
}


$this->add_hook('last_prices','last_prices');

function last_prices($arg){
	
	App::uses('PriceAppModel', 'Price.Model');
	App::uses('Price', 'Price.Model');
	$price = new Price();
	$price->recursive = - 1;
	$options['fields'] = array(
		'Price.id',
		'Price.title',
		'Price.buy_price',
		'Price.sel_price',
		'Price.price_date',
	); 
	$options['conditions'] = array(
		'Price.status'=> 1
	);
	$options['order'] = array(
		'Price.arrangment'=>'asc'
	);
	$options['limit'] = 5;
	$prices = $price->find('all',$options);
	echo "<h3 class='widget-title'>".__d(__PRICE_LOCALE,'prices')."</h3>";
	echo "<table class='buildpress-table'> 
	<thead>
			<tr>
				<th>".__d(__PRICE_LOCALE,'title')."</th>
				<th class='align-center'>".__d(__PRICE_LOCALE,'buy_price')."</th>
				<th class='align-center'>".__d(__PRICE_LOCALE,'sel_price')."</th>
				<th class='align-center'>".__d(__PRICE_LOCALE,'price_date')."</th>
			</tr>
	</thead>
	<tbody>";
	foreach($prices as $price){
		echo "<tr>
				<td>".$price['Price']['title']."</td>
				<td class='align-center'>". number_format($price['Price']['buy_price'])."</td>
				<td class='align-center'>". number_format($price['Price']['sel_price'])."</td>
				<td class='align-center'>". $price['Price']['price_date']."</td>
			</tr>";		
	}
	echo "</tbody></table>";
	
	
}
?>