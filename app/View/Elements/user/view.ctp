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

	<!-- BEGIN CONTAINER -->
	<div class="container min-hight">
		<!-- BEGIN ABOUT INFO -->
		<div class="row margin-bottom-30">
			<!-- BEGIN INFO BLOCK -->
			<div class="col-md-12 space-mobile">
				<?php
					echo $this->Cms->convert_character_editor($page['Page']['body']);
				?>
				<!-- BEGIN LISTS -->
				<div class="row front-lists-v1">
					<div class="col-md-6">
						<ul class="list-unstyled margin-bottom-20">
							<li>
								<i class="fa fa-check">
								</i> صنایع تولید شیشه
							</li>
							<li>
								<i class="fa fa-check">
								</i> طراحی دکوراسیون های شیشه ای
							</li>
							<li>
								<i class="fa fa-check">
								</i> پیاده سازی و اجرا
							</li>
						</ul>
					</div>
					<div class="col-md-6">
						<ul class="list-unstyled">
							<li>
								<i class="fa fa-check">
								</i> پشتیبانی
							</li>
							<li>
								<i class="fa fa-check">
								</i> فروش
							</li>
							<li>
								<i class="fa fa-check">
								</i> مدیریت
							</li>
						</ul>
					</div>
				</div>
				<!-- END LISTS -->
			</div>
			<!-- END INFO BLOCK -->

		</div>
		<!-- END ABOUT INFO -->

		<!-- BEGIN TESTIMONIALS AND PROGRESS BAR -->
		<div class="row margin-bottom-40">
			<!-- BEGIN TESTIMONIALS -->
			<div class="col-md-7 testimonials-v1">
				<h2 class="block">
					همراه با پرسنل شرکت
				</h2>
				<div class="carousel slide" id="myCarousel1">
					<!-- Carousel items -->
					<div class="carousel-inner">
						<div class="item active">
							<span class="testimonials-slide">
								تلاش ما در شرکت جام نمای فردوس ، رضایت خاطر شما مشتریان عزیز است. با این رویکرد تیمی متخصص و متعهد را شکل داده ایم تا پروژه های شما را به بهترین شکل ممکن انجام دهیم.اعتماد شما سرمایه حقیقی ماست...
							</span>
							<div class="carousel-info">
								<img alt="" src="assets/img/people/img3-small.jpg" class="pull-left">
								<div class="pull-left">
									<span class="testimonials-name">
										مهران شقفی
									</span>
									<span class="testimonials-post">
										مدیر فروش
									</span>
								</div>
							</div>
						</div>
						<div class="item">
							<span class="testimonials-slide">
								قیمت مناسب و کیفیت عالی ، ویژگی کلیدی محصولات ماست. بسته های پیشنهادی ما منحصربفرد می باشند.قطعا رضایت شما از خرید اولویت کلیدی ماست. در ضمن گارانتی و پشتیبانی از محصولات رویکرد اصلی ما در ارائه خدمات خواهد بود. انتخاب شما افتخارماست
							</span>
							<div class="carousel-info">
								<img alt="" src="assets/img/people/img2-small.jpg" class="pull-left">
								<div class="pull-left">
									<span class="testimonials-name">
										علی فتاح
									</span>
									<span class="testimonials-post">
										مدیر پشتیبانی
									</span>
								</div>
							</div>
						</div>
						<div class="item">
							<span class="testimonials-slide">
								ویژگی متمایز ما نسبت به سایرهمکارانمان تخصص و در عین حال تعهد تیم اجرایی ماست. بهترین های این صنعت را جمع کرده ایم تا محصولی شایسته شما مشتری عزیز را تولید و اجرا کنیم. لبخند رضایت شما، انرژی مضاعف به ما در ارائه خدمات بهتر خواهد داد...
							</span>
							<div class="carousel-info">
								<img alt="" src="assets/img/people/img5-small.jpg" class="pull-left">
								<div class="pull-left">
									<span class="testimonials-name">
										محمد
									</span>
									<span class="testimonials-post">
										ستوده
									</span>
								</div>
							</div>
						</div>
					</div>
					<!-- Carousel nav -->
					<a data-slide="prev" href="#myCarousel1" class="left-btn">
					</a>
					<a data-slide="next" href="#myCarousel1" class="right-btn">
					</a>
				</div>
			</div>
			<!-- END TESTIMONIALS -->

			<!-- BEGIN PROGRESS BAR -->
			<div class="col-md-5 front-skills space-mobile">
				<h2 class="block">
					مهارت های ما
				</h2>
				<span>
					تولید شیشه 90%
				</span>
				<div class="progress">
					<div role="progressbar" class="progress-bar" style="width: 90%;">
					</div>
				</div>
				<span>
					دکوراسیون 80%
				</span>
				<div class="progress">
					<div role="progressbar" class="progress-bar" style="width: 60%;">
					</div>
				</div>
				<span>
					شیشه های دوجداره 100%
				</span>
				<div class="progress">
					<div role="progressbar" class="progress-bar" style="width: 100%;">
					</div>
				</div>
			</div>
			<!-- END PROGRESS BAR -->
		</div>
		<!-- END TESTIMONIALS AND PROGRESS BAR -->

		<!-- BEGIN OUR TEAM -->
		<div class="row front-team">
			<ul class="list-unstyled">
				<li class="col-md-3 space-mobile">
					<div class="thumbnail">
						<img alt="" src="assets/img/people/img2-large.jpg">
						<h3>
							<a>
								علی رفیعی
							</a>
							<small>
								مدیرعامل / CEO
							</small>
						</h3>
						<p>
							بهترین محصولات را برای شما آماده کرده ایم...
						</p>
						<ul class="social-icons social-icons-color">
							<li>
								<a class="facebook" data-original-title="Facebook" href="#">
								</a>
							</li>
							<li>
								<a class="twitter" data-original-title="Twitter" href="#">
								</a>
							</li>
							<li>
								<a class="googleplus" data-original-title="Goole Plus" href="#">
								</a>
							</li>
							<li>
								<a class="linkedin" data-original-title="Linkedin" href="#">
								</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="col-md-3">
					<div class="thumbnail">
						<img alt="" src="assets/img/people/img5-large.jpg">
						<h3>
							<a>
								علی رفیعی
							</a>
							<small>
								مدیرعامل / CEO
							</small>
						</h3>
						<p>
							بهترین محصولات را برای شما آماده کرده ایم...
						</p>
						<ul class="social-icons social-icons-color">
							<li>
								<a class="facebook" data-original-title="Facebook" href="#">
								</a>
							</li>
							<li>
								<a class="twitter" data-original-title="Twitter" href="#">
								</a>
							</li>
							<li>
								<a class="googleplus" data-original-title="Goole Plus" href="#">
								</a>
							</li>
							<li>
								<a class="linkedin" data-original-title="Linkedin" href="#">
								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
		<!-- END OUR TEAM -->
	</div>
	<!-- END CONTAINER -->

</div>