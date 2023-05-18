<?php


$this->add_hook('admin_group_menu', 'slider_menu');

function slider_menu($arg)
{
	$active = NULL;
	$controllers = array('sliders');
	if (in_array($arg['arguments']['controller'], $controllers)) $active = 'active';
	echo "
		<li class='treeview " . $active . "'>
			<a href='#'>
				<i class='fa fa-dashcube'>
				</i>
				<span>
					" . __d(__SLIDER_LOCALE, 'slider_managment') . "
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
	$active = NULL;
	if ($arg['arguments']['controller'] == 'banners') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/slider/sliders/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__SLIDER_LOCALE, 'slider_managment') . "
					</a>
				</li>
			</ul>
		</li>
	";

}


$this->add_hook('last_slider', 'last_slider');

function last_slider($arg)
{

	App::uses('SliderAppModel', 'Slider.Model');
	App::uses('Slider', 'Slider.Model');

	$lang = $arg['arguments']['lang'];


	$sliders = array();
	$slider = new Slider();
	$slider->recursive = -1;
	$options['fields'] = array(
		'Slider.id',
		'Slidertranslation.url',
		'Slidertranslation.detail',
		'Slidertranslation.title',
		'Slidertranslation.image'
	);

	$options['joins'] = array(
		array('table' => 'slidertranslations',
			'alias' => 'Slidertranslation',
			'type' => 'left',
			'conditions' => array(
				'Slider.id = Slidertranslation.slider_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'inner',
			'conditions' => array(
				'Language.id = Slidertranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Slider.status' => 1,
		'Language.code' => $lang
	);
	$options['order'] = array(
		'Slider.arrangment' => 'asc'
	);
	//$options['limit'] = 5;
	$sliders = $slider->find('all', $options);


	$i = 0;

	foreach ($sliders as $slider) {

		?>
		<div class='bg-cover bg-center bg-no-repeat py-5'
			 style='background-image: url(<?php echo __SITE_URL . __SLIDER_IMAGE_URL . "/" . $slider['Slidertranslation']['image']; ?>);'>
			<span class='bg-overlay'></span>
			<div class='container bg-content py-md-5'>
				<div class='row justify-content-center py-md-5'>
					<div class='col-12 text-center py-md-5'>
						<div class='d-table w-100 bg-no-repeat bg-center'>
							<div class='d-table-cell align-middle'>
								<h2 class='display-4 text-white'><em class='font-weight-light'>
										<?php echo $slider['Slidertranslation']['title']; ?>
										<p class='text-xl text-white opacity-75 pb-4'><?php echo $slider['Slidertranslation']['detail']; ?></p>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
	}
}

?>
