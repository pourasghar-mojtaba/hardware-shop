<?php

$this->add_hook('admin_group_menu', 'blog_admin_menu');

function blog_admin_menu($arg)
{
	$active = NULL;
	$controllers = array('blogs');
	if (in_array($arg['arguments']['controller'], $controllers)) $active = 'active';
	echo "
		<li class='treeview " . $active . "'>
			<a href='#'>
				<i class='fa fa-book'>
				</i>
				<span>
					" . __d(__BLOG_LOCALE, 'blog_managment') . "
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
	$active = NULL;
	if ($arg['arguments']['controller'] == 'blogs') $active = 'class="active"';
	echo "
				<li " . $active . " >
					<a href='" . __SITE_URL . "admin/" . __BLOG . "/" . __BLOG_CONTROLLER . "/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__BLOG_LOCALE, 'blog_managment') . "
					</a>
				</li>";
	$active = NULL;

	echo "
			</ul>
		</li>
	";

}

$this->add_hook('user_menu', 'blog_user_menu');
function blog_user_menu($arg)
{
	echo "<li class='nav-item mega-dropdown-toggle'><a class='nav-link' href='" . __SITE_URL . __BLOG . "/blogs/last'>" . __d(__BLOG_LOCALE, 'blog') . "</a></li>";
}

$this->add_hook('mobile_user_menu', 'blog_mobile_user_menu');
function blog_mobile_user_menu($arg)
{
	echo "<div class='card'><div class='card-header'><a href='" . __SITE_URL . __BLOG . "/blogs/last' class='mobile-menu-link'>" . __d(__BLOG_LOCALE, 'blog') . "</a></div></div>";
}


$this->add_hook('last_blogs', 'last_blogs');
function last_blogs($arg)
{


	App::uses(__BLOG_PLUGIN . 'AppModel', __BLOG_PLUGIN . '.Model');
	App::uses('Blog', __BLOG_PLUGIN . '.Model');

	App::uses('CmsHelper', 'AppHelper');

	$lang = $arg['arguments']['lang'];

	$Cms = new CmsHelper(new View());

	$blog = new Blog();
	$blog->recursive = -1;
	$options['fields'] = array(
		'Blog.id',
		'Blogtranslation.title',
		'Blogtranslation.little_detail',
		'Blog.num_viewed',
		'Blog.created',
		'Blog.image',
	);

	$options['joins'] = array(
		array('table' => 'blogtranslations',
			'alias' => 'Blogtranslation',
			'type' => 'left',
			'conditions' => array(
				'Blog.id = Blogtranslation.blog_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'inner',
			'conditions' => array(
				'Language.id = Blogtranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Blog.status' => 1,
		'Language.code' => $lang
	);

	$options['limit'] = 4;
	$blogs = $blog->find('all', $options);


	if (!empty($blogs)) {
		$counter = 0;
		foreach ($blogs as $blog) {
			?>


			<div class="col-md-6">
				<div class="blog-post">
					<div class="post-thumb">
						<img src="<?php echo __SITE_URL . __BLOG_IMAGE_URL . '/' . $blog['Blog']['image']; ?>" alt="<?php echo $blog['Blogtranslation']['title']; ?>" />
						<div class="post-detail">
							<h2><a href="<?php echo __SITE_URL . __BLOG . "/blogs/view/" . $blog['Blog']['id'] . "/" . str_replace(' ', '-', $blog['Blogtranslation']['title']); ?>" title=""><?php echo $blog['Blogtranslation']['title']; ?></a></h2>
							<span><i class="fa fa-calendar-o"></i>
								<?php
									echo  $Cms->show_persian_date("j", strtotime($blog['Blog']['created']));
									echo $Cms->show_persian_date("F", strtotime($blog['Blog']['created']));

								?>
							</span>
							<p><?php echo $blog['Blogtranslation']['little_detail']; ?></p>
						</div>
					</div>

				</div><!-- Blog Post -->
			</div>

			<?php
		}
	}
}

$this->add_hook('admin_last_items', 'admin_last_blogs');
function admin_last_blogs()
{

	App::uses(__BLOG_PLUGIN . 'AppModel', __BLOG_PLUGIN . '.Model');
	App::uses('Blog', __BLOG_PLUGIN . '.Model');

	$blog = new Blog();
	$blog->recursive = -1;
	$options['fields'] = array(
		'Blog.id',
		'Blogtranslation.title',
		'Blog.image'
	);
	$options['joins'] = array(
		array('table' => 'blogtranslations',
			'alias' => 'Blogtranslation',
			'type' => 'left',
			'conditions' => array(
				'Blog.id = Blogtranslation.blog_id'
			)
		)
	);
	$options['conditions'] = array(
		"Blogtranslation.language_id" => 1
	);
	$options['limit'] = 5;
	$blogs = $blog->find('all', $options);


	echo "

		<div class='col-md-4'>
          <!-- PRODUCT LIST -->
          <div class='box box-primary'>
            <div class='box-header with-border'>
              <h3 class='box-title'>" . __d(__BLOG_LOCALE, 'last_blogs') . "</h3>

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

	foreach ($blogs as $blog) {
		echo "
			<li class='item'>
                  <div class='product-img'>
                    <img src='" . __SITE_URL . __BLOG_IMAGE_URL . __UPLOAD_THUMB . '/' . $blog['Blog']['image'] . "' alt='" . $blog['Blogtranslation']['title'] . "'>
                  </div>
                  <div class='product-info'>
                    <a href='" . __SITE_URL . "admin/blog/blogs/edit/" . $blog['Blog']['id'] . "'>" . $blog['Blogtranslation']['title'] . "</a>
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
              <a href='<?php echo __SITE_URL; ?>admin/blog/blogs/index' class='uppercase'><?php echo __('view_all_blogs'); ?></a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
	";
}

$this->add_hook('admin_charts', 'admin_blog_chart');

function convert($blogs, $cms)
{
	$str = '';
	foreach ($blogs as $blog) {
		$str = $str . "['" . $cms->show_persian_date("Y-m-j    ", strtotime($blog['0']['created'])) . "'," . $blog['0']['qty'] . "],";
	}
	$str = substr($str, 0, strlen($str) - 1);
	echo $str;
}

function admin_blog_chart()
{


	App::uses(__BLOG_PLUGIN . 'AppModel', __BLOG_PLUGIN . '.Model');
	App::uses('Blog', __BLOG_PLUGIN . '.Model');

	App::uses('CmsDateComponent', 'Component');

	$CmsDate = new CmsDateComponent(new ComponentCollection());

	App::uses('CmsHelper', 'AppHelper');

	$Cms = new CmsHelper(new View());

	$blog = new Blog();
	$blog->recursive = -1;

	$options = array();
	$options['fields'] = array(
		'date(Blog.created) as created',
		'count(*) as qty',
	);
	$options['conditions'] = array(
		'Blog.status' => 1,
		'Blog.created BETWEEN ? AND ?' => array($CmsDate->subdayWithoutTime(date("Y-m-d"), 30), $CmsDate->adddayWithoutTime(date("Y-m-d"), 1))
	);
	$options['group'] = 'date(Blog.created)';
	$chart_blogs = $blog->find('all', $options);


	echo "

		<div class='col-md-6'>
          <div class='box box-info'>
            <div class='box-header with-border'>
              <h3 class='box-title'>" . __('blogs_in_30_days') . "</h3>

              <div class='box-tools pull-right'>
                <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i>
                </button>
                <button type='button' class='btn btn-box-tool' data-widget='remove'><i class='fa fa-times'></i></button>
              </div>
            </div>
            <div class='box-body chart-responsive'>";
	?>
	<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
	<script type='text/javascript'>
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['سال', 'تعداد'],
				<?php convert($chart_blogs, $Cms); ?>
            ]);

            var options = {
                title: '',
                curveType: 'function',
                legend: {position: 'bottom'}
            };

            var chart = new google.visualization.LineChart(document.getElementById('blogs_chart'));

            chart.draw(data, options);
        }
	</script>
	<?php
	echo "			   
			    <div id='blogs_chart' style='width:100%;height:100%'></div>
  
            </div>
            <!-- /.box-body -->
          </div>
        </div>
	";

}

$this->add_hook('admin_info_box', 'admin_blog_box');

function admin_blog_box()
{

	App::uses(__BLOG_PLUGIN . 'AppModel', __BLOG_PLUGIN . '.Model');
	App::uses('Blog', __BLOG_PLUGIN . '.Model');

	$blog = new Blog();
	$blog->recursive = -1;

	$options['conditions'] = array(
		'Blog.status' => 1,
	);
	$blog_count = $blog->find('count', $options);

	echo "
		<div class='col-md-3 col-sm-6 col-xs-12'>
          <div class='info-box'>
            <span class='info-box-icon bg-green'><i class='ion ion-social-twitter'></i></span>

            <div class='info-box-content'>
              <span class='info-box-text'>" . __('all_blogs') . "</span>
              <span class='info-box-number'>" . $blog_count . "</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
	";


}

?>
