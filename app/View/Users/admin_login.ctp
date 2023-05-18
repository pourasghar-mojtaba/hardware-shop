<div class="login-box">
	<div class="login-logo">
		<b>
			پنل مديريت
		</b>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<?php  echo $this->Session->flash(); ?>
		<p class="login-box-msg">
			براي ورود نام کاربري و رمز عبور را وارد نماييد
		</p>

		<?php echo $this->Form->create('User', array('method'=> 'post')); ?>
		<div class="form-group has-feedback">

			<?php echo $this->Form->input('login_email',array("label"      =>false,'div'        =>false,"type"       =>"email","class"      =>"form-control","placeholder"=>__("email")));?>
			<span class="glyphicon glyphicon-envelope form-control-feedback">
			</span>
		</div>
		<div class="form-group has-feedback">
			<?php echo $this->Form->input('login_password',array("label"      =>false,'div'        =>false,"type"       =>"password","class"      =>"form-control","placeholder"=>__("password")));?>
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<center>
				<img id="captcha" src="<?php echo __SITE_URL ?>captcha/advanced-captcha.php" alt="" />
				<a href="#" onclick='$("#captcha").attr("src", "<?php echo __SITE_URL ?>captcha/advanced-captcha.php?" + (new Date()).getTime())'><img src="<?php echo __SITE_URL.'img/icons/refresh.gif' ?>"  /></a>
			</center>
			<?php echo $this->Form->input('captcha',array("label"      =>false,'div'        =>false,"type"       =>"text","class"      =>"form-control","placeholder"=>__("captcha"),"size"=>30));?>

		</div>
		<div class="row">
			<div class="col-xs-4">
				<?php echo $this->Form->input(__("login"),array("label"=>false,'div'  =>false,"type" =>"submit","class"=>"btn btn-primary btn-block btn-flat"));?>
			</div>
			<div class="col-xs-12">

			</div>
			<!-- /.col -->

			<!-- /.col -->
		</div>
		<?php echo $this->Form->end(); ?>

		<!-- /.social-auth-links -->


	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<?php
/*	$User_Info= $this->Session->read('User_Info');
if(!empty($User_Info)){
?>
<script>
setTimeout("location.href = '<?php echo __SITE_URL ?>';");
</script>

<?php
}*/

?>




