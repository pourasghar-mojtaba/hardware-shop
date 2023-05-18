<div class="page-container">

	<!-- BEGIN BREADCRUMBS -->
	<div class="row breadcrumbs margin-bottom-40">
		<div class="container">
			<div class="col-md-8 col-sm-8 ">
				<ul class="pull-left breadcrumb">
					<li>
						<?php echo $this->Html->link(__('home'),__SITE_URL) ?>
					</li>
					<li class="active">
						<?php echo $page['Page']['title']; ?>
					</li>
				</ul>
			</div>
			<div class="col-md-4 col-sm-4 text-center">
				<h1>
					<?php echo $page['Page']['title']; ?>
				</h1>
			</div>

		</div>
	</div>
	<!-- END BREADCRUMBS -->

	<!-- BEGIN GOOGLE MAP -->
	<div class="row">
		<div id="map" class="gmaps margin-bottom-40" style="height:400px;">
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1619.6114035850583!2d51.32162021239529!3d35.720738536692785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfa!2sir!4v1466106235595" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
	<!-- END GOOGLE MAP -->

	<!-- BEGIN CONTAINER -->
	<div class="container min-hight">
		<div class="row">
			<div class="col-md-9 col-sm-9">
				<h2>
					فرم تماس با ما
				</h2>
				<p>
					جهت ارسال سفارش، ارسال مطلب، نظرات و پیشنهادات خود می توانید از این فرم استفاده کنید
				</p>
				<div class="space20">
				</div>
				<!-- BEGIN FORM-->
				<form action="#" class="horizontal-form margin-bottom-40" role="form">
					<div class="form-group">
						<label class="control-label">
							نام
						</label>
						<div class="col-lg-12">
							<input type="text" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" >
							رایانامه
							<span class="color-red">
								*
							</span>
						</label>
						<div class="col-lg-12">
							<input type="text" class="form-control" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" >
							پیام
						</label>
						<div class="col-lg-12">
							<textarea class="form-control" rows="8">
							</textarea>
						</div>
					</div>
					<button type="submit" class="btn btn-default theme-btn">
						<i class="icon-ok">
						</i> ارسال
					</button>
					<button type="button" class="btn btn-default">
						لغو
					</button>
				</form>
				<!-- END FORM-->
			</div>

			<div class="col-md-3 col-sm-3">
				<?php
					echo $this->Cms->convert_character_editor($page['Page']['body']);
				?>
			</div>
		</div>
	</div>
	<!-- END CONTAINER -->

</div>

