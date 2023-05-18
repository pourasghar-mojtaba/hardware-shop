<div class="main-title" style="background-color: #f2f2f2">
	<div class="container">
		<h1 class="main-title__primary"><?php echo $page['Page']['title']; ?></h1>
		<h3 class="main-title__secondary">چیزی کمی در مورد ما</h3>
	</div>
</div>
<div class="breadcrumbs ">
	<div class="container">
		<span typeof="v:Breadcrumb"><a title="<?php echo __('home'); ?>" href="<?php echo __SITE_URL; ?>" class="home"><?php echo __('home'); ?></a></span>
		<span typeof="v:Breadcrumb"><span><?php echo $page['Page']['title']; ?></span></span>	
	</div>
</div>
<div class="master-container">
	<div class="container">
		<div class="row">
			<main class="col-xs-12" role="main">
				<div class="row">
					<div class="col-md-12">
						<?php
						echo $this->Cms->convert_character_editor($page['Page']['body']);
						?>
					</div>
				</div>	
			</main>
		</div>
	</div><!-- /container -->
</div>
