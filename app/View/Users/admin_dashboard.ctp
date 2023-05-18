<?php
    $AdminUser_Info=$this->Session->read('AdminUser_Info');
	 
?>
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo __('welcome_to_site_panel'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo __SITE_URL."admin"; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('dashboard'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <!--<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">CPU Traffic</span>
              <span class="info-box-number">90<small>%</small></span>
            </div>-->
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <!--<span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Likes</span>
              <span class="info-box-number">41,410</span>
            </div>-->
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
		 
		<?php $this->Plugin->run_hook('admin_info_box'); ?>	
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><?php echo __('all_users'); ?></span>
              <span class="info-box-number"><?php echo $user_count; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
	
	  <div class="row">
	  	
		<div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo __('users_in_30_days'); ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
               <?php 
			   		function convert_users($users,$cms){
						$str = '';
						foreach($users as $user)
						{
							$str = $str."['".$cms->show_persian_date("Y-m-j    ",strtotime($user['0']['created']))."',".$user['0']['qty']."],";
						}
						$str = substr($str,0,strlen($str)-1);
						echo $str;
					}			   			   		
			    ?>
			    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			    <script type="text/javascript">
			      google.charts.load('current', {'packages':['corechart']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['سال', 'تعداد' ],
			          <?php convert_users($chart_users,$this->Cms); ?>
			        ]);

			        var options = {
			          title: '',
			          curveType: 'function',
			          legend: { position: 'bottom' }
			        };

			        var chart = new google.visualization.LineChart(document.getElementById('users_chart'));

			        chart.draw(data, options);
			      }
			    </script>
			   
			    <div id="users_chart" style="width:100%;height:100%"></div>
  
            </div>
            <!-- /.box-body -->
          </div>
        </div>
		 
 		<?php $this->Plugin->run_hook('admin_charts'); ?>				
		
	  </div>
	  
	  <div class="row">
	  	  
		<div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo __('userlogins_in_7_days'); ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
               <?php 
			   		
					function convert_header_userlogins($users){
						$str = "['سال',";
						foreach($users as $user)
						{
							if(strpos($str,$user['User']['name'])>0){
								continue;
							}
							$str = $str."'".$user['User']['name']."',";
							$header_array[] = $user['User']['name'];
						}						
						$str = substr($str,0,strlen($str)-1);
						$str = $str."]";
						
						return $str;
					}
					
					$header_userlogin = convert_header_userlogins($chart_loginusers);
					$header_array = explode(',',$header_userlogin);
					 
					
					function convert_userlogins($users,$cms,$count){
						$str = '';
						$counter = 0;
						
						foreach($users as $user)
						{							 
							if(strpos($str,$cms->show_persian_date("Y-m-j    ",strtotime($user['0']['created'])))<=0){
								if(!empty($str) && $count != $counter){
									for($i = 1; $i <= $count - $counter; $i++){
										$str = $str.',0';
									}
									$str = $str."],";
								}
								$str = $str."['".$cms->show_persian_date("Y-m-j    ",strtotime($user['0']['created']))."'";								
								$counter = 0;
							} 
							$str = $str.",".$user['Userloglogin']['count_login'];
							$counter++;
							if($count == $counter){
								$str = $str."],";
							} 
						}
						$counter--;
						if($count != $counter-1){
							for($i = 1; $i <= $count - $counter-1; $i++){
								$str = $str.',0';
							}
							if($i>1) $str = $str."],";
						}
						
						$str = substr($str,0,strlen($str)-1);
						echo $str;
					}
					 
					//convert_userlogins($chart_loginusers,$this->Cms,count($header_array)-1);
								   			   		
			    ?>
			    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			    <script type="text/javascript">
			      google.charts.load('current', {'packages':['corechart']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          <?php echo $header_userlogin; ?>,
			          <?php convert_userlogins($chart_loginusers,$this->Cms,count($header_array)-1); ?>
			        ]);

			        var options = {
			          title: '',
			          curveType: 'function',
			          legend: { position: 'bottom' }
			        };

			        var chart = new google.visualization.LineChart(document.getElementById('userlogins_chart'));

			        chart.draw(data, options);
			      }
			    </script>
			   
			    <div id="userlogins_chart" style="width:100%;height:100%"></div>
  
            </div>
            <!-- /.box-body -->
          </div>
        </div>
		 
	  </div>	
	
       
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- <div class="col-md-4">
              
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Members</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger">8 New Members</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
               
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <li>
                      <img src="dist/img/user1-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Alexander Pierce</a>
                      <span class="users-list-date">Today</span>
                    </li>                  
                  </ul>
                   
                </div>
                
                <div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase">View All Users</a>
                </div>
                 
              </div>
              
            </div>-->
		
		
		<?php $this->Plugin->run_hook('admin_last_items'); ?>	 
        <div class="col-md-4">

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo __('entered_hosts'); ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
				<?php 
			   		function convert_site_info($siteinformations){
						$str = '';
						foreach($siteinformations as $siteinformation)
						{
							$str = $str."['".$siteinformation['Siteinformation']['referer_host']."',".$siteinformation['0']['qty']."],";
						}
						$str = substr($str,0,strlen($str)-1);
						echo $str;
					}
					 		   			   		
			    ?>
               
			  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			    <script type="text/javascript">
			      google.charts.load('current', {'packages':['corechart']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {

			        var data = google.visualization.arrayToDataTable([
			          ['موتور جستجو', 'تعداد'],
			          <?php convert_site_info($siteinformations); ?>
			        ]);

			        var options = {
			          title: ''
			        };

			        var chart = new google.visualization.PieChart(document.getElementById('siteinfo_chart'));

			        chart.draw(data, options);
			      }
			    </script>

                <div id="siteinfo_chart" style="width:100%;height:100%"></div>
              </div>
              <!-- /.row -->
             
            <!-- /.box-body -->
             
            <!-- /.footer -->
          </div>
          <!-- /.box -->
        </div>
		
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
   