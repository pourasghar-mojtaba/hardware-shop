


<footer>
	<section class="block">
		<div data-velocity="-.2" style="background: url(<?php echo __SITE_URL.__THEME_PATH.'img'; ?>/resource/parallax2.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax blackish"></div><!-- PARALLAX BACKGROUND IMAGE -->
		<div class="container">
			<div class="row">
				<div class="col-md-3 column">
					<div class="about_widget widget">
						<div class="logo">
							<a href="#" title="">
								<i class="fa fa-laptop"></i>
								<span>سایت فروش سخت افزار</span>
								<strong>دانشگاه شهید بهشتی</strong>
							</a>
						</div><!-- LOGO -->
						<p>
							<!-- about -->
						</p>
					</div>
				</div>
				<div class="col-md-3 column">
					<div class="about_widget widget">

						<ul class="social-btns">

						</ul>
						<span><i class="fa fa-envelope"></i>info@brandimo.ir</span>
						<span><i class="fa fa-phone"></i>0912-0788374</span>
						<span><i class="fa fa-location-arrow"></i> آدرس:تهران، ولنجک، بلوار دانشجو، میدان یاسمن، دانشگاه شهید بهشتی</span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="bottom-line">
		<div class="container">
				<span>
حق چاپ برای 1401 محفوظ است <a href="https://brandimo.ir/" title="">Brandimo</a></span>

		</div>
	</div>
</footer>


<?php

echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/modernizr.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/jquery-2.1.1.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/script.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/bootstrap.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/owl.carousel.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/html5lightbox.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/scrolltopcontrol.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/scrolly.js');

echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/jquery.themepunch.tools.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/jquery.themepunch.revolution.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.actions.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.carousel.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.kenburn.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.layeranimation.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.migration.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.navigation.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.parallax.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.slideanims.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'revolution/js/extensions/revolution.extension.video.min.js');

?>
<script type="text/javascript">
    var tpj=jQuery;
    var revapi4;
    tpj(document).ready(function() {
        if(tpj("#rev_slider_4_1").revolution == undefined){
            revslider_showDoubleJqueryError("#rev_slider_4_1");
        }else{
            revapi4 = tpj("#rev_slider_4_1").show().revolution({
                sliderType:"standard",
                jsFileLocation:"revolution/js/",
                dottedOverlay:"none",
                delay:9000,
                sliderLayout:"fullscreen",
                navigation: {
                    keyboardNavigation:"off",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation:"off",
                    onHoverStop:"off",
                    touch:{
                        touchenabled:"on",
                        swipe_threshold: 75,
                        swipe_min_touches: 1,
                        swipe_direction: "horizontal",
                        drag_block_vertical: false
                    }
                    ,
                    arrows: {
                        style:"zeus",
                        enable:true,
                        hide_onmobile:true,
                        hide_under:600,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:1200,
                        tmp:'<div class="tp-title-wrap">  	<div class="tp-arr-imgholder"></div> </div>',
                        left: {
                            h_align:"left",
                            v_align:"center",
                            h_offset:30,
                            v_offset:0
                        },
                        right: {
                            h_align:"right",
                            v_align:"center",
                            h_offset:30,
                            v_offset:0
                        }
                    }
                    ,
                    bullets: {
                        enable:true,
                        hide_onmobile:true,
                        hide_under:600,
                        style:"metis",
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:1200,
                        direction:"horizontal",
                        h_align:"center",
                        v_align:"bottom",
                        h_offset:0,
                        v_offset:30,
                        space:5,
                        tmp:'<span class="tp-bullet-img-wrap">  <span class="tp-bullet-image"></span></span><span class="tp-bullet-title">{{title}}</span>'
                    }
                },
                viewPort: {
                    enable:true,
                    outof:"pause",
                    visible_area:"80%"
                },
                responsiveLevels:[1240,1024,778,480],
                gridwidth:[1240,1024,778,480],
                gridheight:[600,600,500,400],
                lazyType:"none",
                parallax: {
                    type:"mouse",
                    origo:"slidercenter",
                    speed:2000,
                    levels:[2,3,4,5,6,7,12,16,10,50],
                },
                shadow:0,
                spinner:"off",
                stopLoop:"off",
                stopAfterLoops:-1,
                stopAtSlide:-1,
                shuffle:"off",
                autoHeight:"on",
                hideThumbsOnMobile:"off",
                hideSliderAtLimit:0,
                hideCaptionAtLimit:0,
                hideAllCaptionAtLilmit:0,
                debugMode:false,
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            });
        }
    });	/*ready*/
</script>

<script type="text/javascript">
    $(document).ready(function() {

        "use strict";

        $(".carousel").owlCarousel({
            autoplay:true,
            autoplayTimeout:3000,
            smartSpeed:2000,
            loop:false,
            dots:false,
            nav:true,
            margin:0,
            items:1,
            singleItem:true
        });

    });
</script>
