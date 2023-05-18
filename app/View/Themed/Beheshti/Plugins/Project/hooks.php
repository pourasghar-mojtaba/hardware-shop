<?php

 
$this->add_hook('admin_group_menu','project_menu');

function project_menu($arg)
{
	$active = NULL;
	$controllers = array('projects','projectcategories');
	if(in_array($arg['request']->params['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-th'>
				</i>
				<span>
					". __d(__PROJECT_LOCALE,'project_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'projectcategories')	 $active = 'class="active"';
			echo"
				<li ".$active." >
					<a href='".__SITE_URL."admin/project/projectcategories/index'>
						<i class='fa fa-circle-o'>
						</i> ".__d(__PROJECT_LOCALE,'category_managment')."
					</a>
				</li>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'projects')	 $active = 'class="active"';	
			echo"	
				<li ".$active."> 
					<a href='".__SITE_URL."admin/project/projects/index'>
						<i class='fa fa-circle-o'>
						</i> ". __d(__PROJECT_LOCALE,'project_managment')."
					</a>
				</li>
			</ul>
		</li>
	";
	
}

$this->add_hook('user_menu','project_user_menu');
function project_user_menu($arg){		
		_get_header_catrgories(0);	 
}

function _get_header_catrgories($parent_id) {		
	
	App::uses('ProjectAppModel', 'Project.Model');
	App::uses('Projectcategory', 'Project.Model');
	
	$Projectcategory = new Projectcategory();
	
	$category_data = array();	
	$Projectcategory->recursive=-1;
	$query=	$Projectcategory->find('all',array('fields' => array('id','slug','parent_id','title as title'),'conditions' => array('parent_id' => $parent_id,'status'=>1)));

		foreach ($query as $result) {
			
			$sub_query=	$Projectcategory->find('all',array('fields' => array('id','slug','parent_id','title as title'),
			'conditions' => array('parent_id' => $result['Projectcategory']['id'])));
			if(empty($sub_query)){
				echo "
					<li>
						<a class='dropdown-item' href='".__SITE_URL."project/projects/index/".$result['Projectcategory']['slug']/*."/".$result['Projectcategory']['title']*/."'  >".$result['Projectcategory']['title']."</a>
					</li>
				";
			}
			else{
				// <a href='javascript:void(0)' title='".$result['Projectcategory']['id']."' >".$result['Projectcategory']['title']."</a>
				echo "
					<li class='nav-item dropdown'> 
						<a class='nav-link dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' href='".__SITE_URL."project/projects/search?categoryid_filter=".$result['Projectcategory']['id']."' title='".$result['Projectcategory']['id']."' >".$result['Projectcategory']['title']." <i class='fa fa-angle-down m-l-5'></i></a>
						<ul class='b-none dropdown-menu font-14 animated fadeInUp'>
				";
						_get_header_catrgories($result['Projectcategory']['id']);
				
				echo "  </ul>
					</li>";
				}
			
		}
}

$this->add_hook('last_project','last_project_slider');

function last_project_slider($arg){
	
	App::uses('ProjectAppModel', 'Project.Model');
	App::uses('Project', 'Project.Model');
	$project = new Project();
	$project->recursive = - 1;
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

$this->add_hook('home_projects','home_projects');

function home_projects($arg){
	
	App::uses('ProjectAppModel', 'Project.Model');
	App::uses('Project', 'Project.Model');
	$project = new Project();
	$project->recursive = - 1;
	$options = array();
	$project->recursive = - 1;
	$options['fields'] = array(
		'Project.id',
		'Project.title',
		'Project.mini_detail',
		'(select image from projectimages where project_id = Project.id limit 0,1)as image'
	);	 
	$options['conditions'] = array(
		'Project.status'=> 1
	);
	$options['order'] = array(
		'Project.id'=>'desc'
	);
	$options['limit'] = 9;
	$projects = $project->find('all',$options);
	
	echo " 
	<div class='container'>
				
		<div class='row'>
			<div class='col text-center'>
				<div class='sec-heading mx-auto'>
					<h2>".__d(__PROJECT_LOCALE,'last_projects')."</h2>
				</div>
			</div>
		</div>
		<div class='row'>
		  <div class='col-lg-12 col-md-12 col-xs-12'>
		    <div class='row portfolio-gallary'>
		";	
		foreach($projects as $project){
			echo "
				
					
					
						<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12 port-item design development'>
							<div class='portfolio-wrap portfolio-inner'>
								<img src='".__SITE_URL.__PROJECT_IMAGE_URL.__UPLOAD_THUMB.'/'.$project['0']['image']."' alt='".$project['Project']['title']."'>
								<div class='label'>
									<div class='label-text'>
										<a href='".__SITE_URL.__PROJECT.'/projects/view/'.$project['Project']['id'].'/'.str_replace(' ','-',$project['Project']['title'])."' class='text-title'>".$project['Project']['title']."</a>
										 
									</div>
									<div class='label-bg'></div>
								</div>
								<div class='zoom'>
									<a href='".__SITE_URL.__PROJECT_IMAGE_URL.$project['0']['image']."' class='popup-box'  data-lightbox='image' data-title='".$project['Project']['title']."'>
										<i class='ti-zoom-in'></i>
									</a>
								</div>
							</div>
						</div>

					
				
							
			";
		}
		
	 echo"
	        </div>
		  </div>
	 	</div>
	</div>";
	 
	 
}

$this->add_hook('admin_last_items','admin_last_projects');

function admin_last_projects(){
	
	App::uses('ProjectAppModel', 'Project.Model');
	App::uses('Project', 'Project.Model');
	$project = new Project();
	$project->recursive = - 1;
	$options = array();
	$project->recursive = - 1;
	$options['fields'] = array(
		'Project.id',
		'Project.title',
		'(select image from projectimages where project_id = Project.id limit 0,1)as image'
	);	 
	$options['conditions'] = array(
		'Project.status'=> 1
	);
	$options['order'] = array(
		'Project.id'=>'desc'
	);
	$options['limit'] = 5;
	$projects = $project->find('all',$options);
	
	echo "
		<div class='col-md-4'>
          <!-- PRODUCT LIST -->
          <div class='box box-primary'>
            <div class='box-header with-border'>
              <h3 class='box-title'>".__('last_projects')."</h3>

              <div class='box-tools pull-right'>
                <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i>
                </button>
                <button type='button' class='btn btn-box-tool' data-widget='remove'><i class='fa fa-times'></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class='box-body'>
              <ul class='products-list product-list-in-box'>
	";
	foreach($projects as $project){
		echo "
			<li class='item'>
              <div class='product-img'>
                <img src='".__SITE_URL.__PROJECT_IMAGE_URL.__UPLOAD_THUMB.'/'.$project['0']['image']."' alt='".$project['Project']['title']."'>
              </div>
              <div class='product-info'>
                <a href='".__SITE_URL."admin/project/projects/edit/". $project['Project']['id']."'>". $project['Project']['title']."</a>
                    <span class='product-description'>
                      
                    </span>
              </div>
            </li>
		";
	}
	
	echo "
			  </ul>
            </div>
            <!-- /.box-body -->
            <div class='box-footer text-center'>
              <a href='".__SITE_URL."admin/project/projects/index' class='uppercase'>". __('view_all_projects')."</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
	";
}
?>