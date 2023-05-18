<section class="rabiabeauty-inner-welocme-section rabiabeauty-bg" style="background-image: url('<?php echo __SITE_URL.__THEME_PATH;?>img/gallery.jpg')">
	<div class="rabiabeauty-black-overlay"></div>
	<div class="container">
		<div class="rabiabeauty-inner-welcome-content">
			<h1 class="color-white"><?php echo __d(__GALLERY_LOCALE,'last_galleries'); ?></h1>
             
		</div>
		<div class="rabiabeauty-inner-welcome-footer-content"></div>
	</div>
</section>


<section class="rabiabeauty-pagefeed-section section-padding-no-banner">

	<div class="elementor elementor-237">

		<div class="elementor-inner">

			<div class="elementor-section-wrap">
							
				<section data-id="f8699f2" class="elementor-element elementor-element-f8699f2 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						

					<div class='elementor-container elementor-column-gap-default'>

						<div class='elementor-row'>

							<div data-id='8179c9a' class='elementor-element elementor-element-8179c9a elementor-column elementor-col-100 elementor-top-column' data-element_type='column'>

								<div class='elementor-column-wrap elementor-element-populated'>

									<div class='elementor-widget-wrap'>

										<div data-id='bf45a65' class='elementor-element elementor-element-bf45a65 xs-heading-text-center elementor-widget elementor-widget-xs-heading' data-element_type='xs-heading.default'>

											<div class='elementor-widget-container'>

												<div class='rabiabeauty-big-sub-heading'> <h3></h3>
												</div>
											</div>
										</div>

										<div data-id='aee2649' class='elementor-element elementor-element-aee2649 elementor-widget elementor-widget-xs-portfolio' data-element_type='xs-portfolio.default'>

											<div class='elementor-widget-container'>

												<div class='rabiabeauty-photo-gallery-wraper'>

													<div class='rabiabeauty-portfolio-nav rabiabeauty-version portfolio-menu'>
														<ul id='filters' class='option-set clearfix' data-option-key='filter'>
															<li><a href='#' data-option-value='*' class='selected'>همه موارد</a></li>
															<?php
															foreach($galleries as $gallery){
																echo "<li><a href='#' data-option-value='.gallery".$gallery['Gallery']['id']."'>".$gallery['Gallerytranslation']['title']."</a></li>";
															}
															?>
														</ul>
													</div>

													<div class='rabiabeauty-photo-gallery-grid'>
														<?php
														$counter = 1;
														foreach($galleryimages as $galleryimage){
			 
															$double_size='';
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
														}
														?>

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</section>
			</div>
		</div>
	</div>
</section>