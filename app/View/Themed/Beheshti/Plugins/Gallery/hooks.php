<?php

 
$this->add_hook('admin_group_menu','gallery_menu');

function gallery_menu($arg)
{
	$active = NULL;
	$controllers = array('galleries','gallerycategories');
	 
	if(in_array($arg['arguments']['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-photo'>
				</i>
				<span>
					". __d(__GALLERY_LOCALE,'gallery_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			 
			$active = NULL;
			if($arg['arguments']['controller'] == 'galleries')	 $active = 'class="active"';	
			echo"	
				<li ".$active."> 
					<a href='".__SITE_URL."admin/gallery/galleries/index'>
						<i class='fa fa-circle-o'>
						</i> ". __d(__GALLERY_LOCALE,'gallery_managment')."
					</a>
				</li>
			</ul>
		</li>
	";
	
}

$this->add_hook('user_menu','gallery_user_menu');
function gallery_user_menu($arg){		
	echo"	<!-- MENU ITEM -->
		<li class='menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-237 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children wp-megamenu-item-288  wpmm_dropdown_menu  wpmm-fadeindown wpmm-submenu-right'>
			<a class='nav-link' href='".__SITE_URL.__GALLERY."/galleries/view'>".__d(__GALLERY_LOCALE,'gallery')."</a>
		</li>
		<!-- /MENU ITEM -->	 ";	 	 
}


$this->add_hook('home_galleries','home_galleries');

function home_galleries($arg){
	
	App::uses('GalleryAppModel', 'Gallery.Model');
	App::uses('Gallery', 'Gallery.Model');
	$gallery = new Gallery();
 
 	$lang = $arg['arguments']['lang']; 
 
 
	$options = array();
	$gallery->recursive = - 1;
	$options['fields'] = array(
		'Gallery.id',
		'Gallerytranslation.title'
	);
	
	$options['joins'] = array(
		array('table'     => 'gallerytranslations',
			'alias'     => 'Gallerytranslation',
			'type'      => 'left',
			'conditions' => array(
				'Gallery.id = Gallerytranslation.gallery_id'
			  )
			),
		array('table'     => 'languages',
			'alias'     => 'Language',
			'type'      => 'left',
			'conditions' => array(
				'Language.id = Gallerytranslation.language_id'
			)
		  )
	);
		 
	$options['conditions'] = array(
		'Gallery.status'=> 1,
		'Language.code'=>$lang
	);
	$options['order'] = array(
		'Gallery.id'=>'asc'
	);
	$galleries = $gallery->find('all',$options);
	
	//--------------------------------------------------------
	$options = array();
	$gallery->Galleryimage->recursive = - 1;
	$options['fields'] = array(
		'Galleryimage.image',
		'Galleryimage.gallery_id',
		'Galleryimagetranslation.title'
	);
	
	$options['joins'] = array(
		array('table'     => 'galleryimagetranslations',
			'alias'     => 'Galleryimagetranslation',
			'type'      => 'left',
			'conditions' => array(
				'Galleryimage.id = Galleryimagetranslation.galleryimage_id'
			  )
			),
		array('table'     => 'languages',
			'alias'     => 'Language',
			'type'      => 'left',
			'conditions' => array(
				'Language.id = Galleryimagetranslation.language_id'
			)
		  )
	);
		 
	$options['conditions'] = array(
		'Language.code'=>$lang
	);
	$options['order'] = array(
		'Galleryimage.id'=>'desc'
	);
	//$options['limit'] = 5;
	$galleryimages = $gallery->Galleryimage->find('all',$options);
	 
	echo "
	
		<div class='elementor-container elementor-column-gap-default'>

								<div class='elementor-row'>

									<div data-id='8179c9a' class='elementor-element elementor-element-8179c9a elementor-column elementor-col-100 elementor-top-column' data-element_type='column'>

										<div class='elementor-column-wrap elementor-element-populated'>

											<div class='elementor-widget-wrap'>

												<div data-id='bf45a65' class='elementor-element elementor-element-bf45a65 xs-heading-text-center elementor-widget elementor-widget-xs-heading' data-element_type='xs-heading.default'>

													<div class='elementor-widget-container'>

														<div class='rabiabeauty-big-sub-heading'> <h3>".__d(__GALLERY_LOCALE,'last_galleries')."</h3>
														</div>
													</div>
												</div>

												<div data-id='aee2649' class='elementor-element elementor-element-aee2649 elementor-widget elementor-widget-xs-portfolio' data-element_type='xs-portfolio.default'>

													<div class='elementor-widget-container'>

														<div class='rabiabeauty-photo-gallery-wraper'>

															<div class='rabiabeauty-portfolio-nav rabiabeauty-version portfolio-menu'>
																<ul id='filters' class='option-set clearfix' data-option-key='filter'>
																	<li><a href='#' data-option-value='*' class='selected'>همه موارد</a></li>
";																	foreach($galleries as $gallery){
																	   echo "<li><a href='#' data-option-value='.gallery".$gallery['Gallery']['id']."'>".$gallery['Gallerytranslation']['title']."</a></li>";
																	}
echo"		
																</ul>
															</div>

    <div class='rabiabeauty-photo-gallery-grid'>
	
	";
	
 		$counter = 1;
		$gallery_id = 0;
		$gallery_counter = 1;
		foreach($galleryimages as $galleryimage){
			 
			$double_size='';
			
			if($gallery_id == $galleryimage['Galleryimage']['gallery_id']){
				$gallery_counter++;
			}else $gallery_counter = 1;
			 
			if($gallery_counter >= 3){				
				continue;	
			}
			
			$imagePath = __SITE_URL.__GALLERY_IMAGE_URL.__UPLOAD_THUMB.'/'.$galleryimage['Galleryimage']['image'];
			if($counter % 5 ==0){
				$double_size =  'double_size';
				$imagePath = __SITE_URL.__GALLERY_IMAGE_URL.$galleryimage['Galleryimage']['image'];
			}
			
			
			
			echo "
				
					<div class='rabiabeauty-photo-gallery-grid-item gallery".$galleryimage['Galleryimage']['gallery_id']." ".$double_size."'>

						<div class='rabiabeauty-single-photo-gallery rabiabeauty-3d'>

							<div class='rabiabeauty-3d-project-card'> 
							
							<img src='".$imagePath."' class='xs-lazy-' alt='Laser treatment' alt='".$galleryimage['Galleryimagetranslation']['title']."'>

								<div class='rabiabeauty-photo-gallery-content'> 
								<a href='".__SITE_URL.__GALLERY_IMAGE_URL.$galleryimage['Galleryimage']['image']."' class='rabiabeauty-image-popup rabiabeauty-iocn-btn full-round-btn bg-color-pink'> 
								<i class='fa fa-eye'></i></a>                                
								<!--<a href='".__SITE_URL.__GALLERY.'/galleries/view/'.$galleryimage['Galleryimage']['gallery_id'].'/'.str_replace(' ','-',$galleryimage['Galleryimagetranslation']['title'])."' class='rabiabeauty-iocn-btn full-round-btn bg-color-purple'> 
								<i class='fa fa-link'></i></a>-->
								</div>

								<div class='rabiabeauty-gallery-overlay'>
								</div>
							</div>
						</div>
					</div>
					
							
			";
			$counter++;
			$gallery_id = $galleryimage['Galleryimage']['gallery_id'];
		}
		
	 echo"
	        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>";
	 
	 
}
?>