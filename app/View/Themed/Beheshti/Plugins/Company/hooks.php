<?php


$this->add_hook('admin_group_menu', 'company_menu');

function company_menu($arg)
{
	$active = NULL;
	$controllers = array('companies');
	if (in_array($arg['request']->params['controller'], $controllers)) $active = 'active';
	echo "
		<li class='treeview " . $active . "'>
			<a href='#'>
				<i class='fa fa-briefcase'>
				</i>
				<span>
					" . __d(__COMPANY_LOCALE, 'company_managment') . "
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
	$active = NULL;
	if ($arg['request']->params['controller'] == 'companies') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/company/companies/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__COMPANY_LOCALE, 'company_managment') . "
					</a>
				</li>
			</ul>
		</li>
	";

}


$this->add_hook('last_companies', 'last_company_slider');

function last_company_slider($arg)
{

	App::uses('CompanyAppModel', 'Company.Model');
	App::uses('Company', 'Company.Model');

	$lang = $arg['arguments']['lang'];

	$company = new Company();
	$company->recursive = -1;
	$options['fields'] = array(
		'Company.id',
		'Company.url',
		'Companytranslation.title',
		'Company.image'
	);
	$options['joins'] = array(
		array('table' => 'companytranslations',
			'alias' => 'Companytranslation',
			'type' => 'left',
			'conditions' => array(
				'Company.id = Companytranslation.company_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'inner',
			'conditions' => array(
				'Language.id = Companytranslation.language_id'
			)
		)
	);
	$options['conditions'] = array(
		'Company.status' => 1,
		'Language.code' => $lang
	);
	$options['order'] = array(
		'Company.arrangment' => 'asc'
	);
	$options['limit'] = 12;
	$companies = $company->find('all', $options);

	foreach ($companies as $company) {
		?>
		<div class="item">
			<a class="d-block py-2 mb-30 gray-to-color" href="<?php echo $company['Company']['url'] ?>" target="_blank">
				<img class="d-block mx-auto opacity-75" src="<?php echo __SITE_URL . __COMPANY_IMAGE_URL . $company['Company']['image'] ; ?>" width="165" alt="<?php echo $company['Companytranslation']['title']; ?>"></a>
		</div>
		<?php
	}

	?>

	<?php
}

?>
