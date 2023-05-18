<div class="inner-head overlap">
	<div data-velocity="-.2"
		 style="background: url(<?php echo __SITE_URL . __THEME_PATH . 'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;"
		 class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __('login') ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->
<section class="block ">
	<div class="container">
		<div class="row">
			<div class="col-md-8 column">
				<form class="wizard needs-validation contactform" novalidate method="post">
					<div class="cart-total-box">
						<h2 class="cart-head-title"><?php echo __d(__USER_LOCAL, 'enter_sent_mobile_code') ?></h2>

						<ul>
							<li>
								<input class="input-text" type="number" required id="email-for-pass"
									   name="data[User][register_key]">
								<input value="<?php echo $mobile; ?>" type="hidden" name="data[User][mobile]">
							</li>
							<li><h3>
									<a href="javascript:void(0)" id="resend_sms" class="btn btn-secondary btn-sm "
									   disabled="disabled">
										<?php echo __('resend_sms') ?>
									</a>
								</h3> <span class="timerCounter">ا00</span></li>
							<li>
								<button class="btn btn-primary flat-btn" type="submit"><?php echo __('send') ?></button>
							</li>
						</ul>

					</div>
				</form>
			</div>

		</div>
	</div>
</section>

<script>
    var timer2 = "00:30";
    var interval = setInterval(function () {


        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('.timerCounter').html(minutes + ':' + seconds);
        if (minutes < 0) clearInterval(interval);
        //check if both minutes and seconds are 0
        if ((seconds <= 0) && (minutes <= 0)) clearInterval(interval);
        timer2 = minutes + ':' + seconds;
        if (seconds == 0) {
            $('#resend_sms').removeAttr('disabled');
            $('#resend_sms').attr("href", '<?php echo __SITE_URL ?>' + "users/resend_sms/" + '<?php echo $mobile; ?>');
        }
    }, 1000);


</script>
