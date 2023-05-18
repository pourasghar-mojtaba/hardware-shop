<!-- BEGIN FOOTER -->


<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-8">
				<p>
					 <a href="http://springdesigng.com/" target="_blank">
					 	<img  src="<?php  echo __SITE_URL.'img/springlogo.png'; ?>"/>
					 </a>
				</p>
			</div>
			<div class="col-md-4 col-sm-4">
				<ul class="social-footer">
					<li>
						<a href="#">
							<i class="fa fa-facebook">
							</i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-google-plus">
							</i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-linkedin">
							</i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-twitter">
							</i>
						</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END COPYRIGHT -->

<!-- Load javascripts at bottom, this will reduce page load time -->
<!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<![endif]-->


<?php
echo $this->Html->script(__USER.'plugins/jquery-1.10.2.min');
echo $this->Html->script(__USER.'plugins/jquery-migrate-1.2.1.min');
echo $this->Html->script(__USER.'plugins/bootstrap/js/bootstrap.min');
echo $this->Html->script(__USER.'plugins/back-to-top');
echo $this->Html->script(__USER.'plugins/fancybox/source/jquery.fancybox.pack');
echo $this->Html->script(__USER.'plugins/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min');
echo $this->Html->script(__USER.'plugins/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min');
echo $this->Html->script(__USER.'plugins/bxslider/jquery.bxslider.min');
echo $this->Html->script(__USER.'scripts/app');
echo $this->Html->script(__USER.'scripts/index');
echo $this->Html->script(__USER.'plugins/jquery.mixitup.min');
echo $this->Html->script(__USER.'scripts/portfolio');
?>
<script type="text/javascript">
	jQuery(document).ready(function()
		{
			App.init();
			App.initBxSlider();
			Index.initRevolutionSlider();
			Portfolio.init();   
		});
</script>