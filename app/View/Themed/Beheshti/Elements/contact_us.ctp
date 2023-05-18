<div class="main-title" style="background-color: #f2f2f2; ">
	<div class="container">
		<h1 class="main-title__primary"><?php echo $page['Page']['title']; ?></h1>
		<h3 class="main-title__secondary">ما منتظر شما براي دريافت در تماس با ما</h3>
	</div>
</div>
<div class="breadcrumbs breadcrumbs--page-builder">
	<div class="container">
		<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="<?php echo __('home'); ?>" href="<?php echo __SITE_URL; ?>" class="home"><?php echo __('home'); ?></a></span>
		<span typeof="v:Breadcrumb"><span property="v:title"><?php echo $page['Page']['title']; ?></span></span>	
	</div>
</div>

<div class="master-container">
	<div class="panel widget widget_pt_google_map panel-first-child panel-last-child" id="panel-29-0-0-0">	

		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1362.1496982116616!2d51.42666420165902!3d35.707616038945055!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8e017e958db205%3A0xb7c6cb488b0b8f1c!2sTehran+Province%2C+Tehran%2C+District+7%2C+Malek-osh-Shoara+Bahar%2C+No.+7!5e0!3m2!1sen!2s!4v1556492514838!5m2!1sen!2s" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
		
		</div>
	</div>
	<div class="spacer-big"></div>
	<div class="hentry container" role="main">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-grid widget widget_text panel-last-child">
					<h3 class="widget-title">تماس با ما</h3>	
				</div>
			</div>
		</div>
		<div class="spacer"></div>
		<div class="row">			
			<div class="col-md-12">
			<?php
				echo $this->Cms->convert_character_editor($page['Page']['body']);
			?>
			</div>
			<!--<div class="col-md-9">
				<div class="wpcf7" id="wpcf7-f5-o1" lang="en-US" dir="rtl">
					<form method="post" class="wpcf7-form" novalidate>
						<div class="row">
							<div class="col-xs-12  col-sm-4">
								<span class="wpcf7-form-control-wrap your-name">
									<input type="text" name="your-name" value="" size="40" class="wpcf7-form-control wpcf7-text" placeholder="نام شما"/>
								</span><br/>
								<span class="wpcf7-form-control-wrap your-email">
									<input type="email" name="your-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email" placeholder="آدرس ایمیل"/>
								</span><br/>
								<span class="wpcf7-form-control-wrap your-subject">
									<input type="text" name="your-subject" value="" size="40" class="wpcf7-form-control wpcf7-text" placeholder="موضوع"/>
								</span>
							</div>
							<div class="col-xs-12  col-sm-8">
								<span class="wpcf7-form-control-wrap your-message">
									<textarea name="your-message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" placeholder="پیام"></textarea>
								</span><br/>
								<input type="submit" value="ارسال پیام" class="wpcf7-form-control wpcf7-submit btn btn-primary"/>
							</div>
						</div>
					</form>
				</div>
			</div>-->
		</div>
	</div><!-- /container -->
</div>