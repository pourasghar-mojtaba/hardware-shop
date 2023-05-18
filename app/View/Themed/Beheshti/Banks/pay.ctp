<?php
$Pay_Info = $this->Session->read('Pay_Info');
$User_Info = $this->Session->read('User_Info');
?>


<div class="inner-head overlap">
	<div data-velocity="-.2"
		 style="background: url(<?php echo __SITE_URL . __THEME_PATH . 'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;"
		 class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __d(__GATEWAY_LOCALE,'select_getway'); ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->
<!-- Page Content-->
<form id="pay_form" name="pay_form">
<div class="container pb-4 mb-2">
	<div class="row">

			<!-- Checkout: Review-->
			<div class="col-xl-9 col-lg-8 pb-5 cart-total-box">
				<div class="wizard">

					<div class="wizard-body">


						<div class="row">
							<div class="col-sm-6">
								<h4 class="h6"><?php echo __d(__GATEWAY_LOCALE, 'send_to'); ?>:</h4>
								<ul class="list-unstyled">
									<li><span
											class="text-muted"><?php echo __('title') ?>:&nbsp;</span><?php echo $Pay_Info['title']; ?>
									</li>
									<li><span
											class="text-muted"><?php echo __('name') ?>:&nbsp;</span><?php echo $User_Info['name']; ?>
									</li>
									<li><span class="text-muted"><?php echo __d(__PRODUCT_LOCALE, 'other_price') ?>:&nbsp;</span><?php echo $Pay_Info['other_price']; ?>
									</li>
								</ul>
							</div>
							<div class="col-sm-6">
								<h4 class="h6"><?php echo __d(__PRODUCT_LOCALE, 'online_pay') ?></h4>
								<ul class="list-unstyled">
									<li>
										<?php
										//pr($banks);
										if (!empty($banks)) {
											foreach ($banks as $key => $value) {
												if ($value['Bank']['active'] == 1) {
													$image = $value['Bank']['image'];
													echo "
														 <a href='JavaScript:void(0);' onClick='set_bank(this);' id='" . $value['Bank']['id'] . "'
														  title='" . $value['Bank']['bank_name'] . "'>
														";
													echo $this->Html->image('/getway/img/icons/' . $image, array('width' => 64, 'height' => 64));
													echo "</a>";
												} else {
													$ext = pathinfo($value['Bank']['image'], PATHINFO_EXTENSION);
													$image = substr($value['Bank']['image'], 0, strlen($value['Bank']['image']) - 4) . '_gray.' . $ext;
													echo $this->Html->image('/getway/img/icons/' . $image, array('width' => 64, 'height' => 64, 'title' => $value['Bank']['bank_name']));
												}

											}
										}

										?>
									</li>
									<li>
										<div id="bank_name"><?php echo __d(__PRODUCT_LOCALE, 'select_bank') ?></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="wizard-footer d-flex justify-content-between">
						<a class="btn btn-secondary my-2" href="<?php echo __SITE_URL . 'products/basket' ?>">
							<i class="fe-icon-arrow-right"></i><span
								class="d-none d-sm-inline-block"><?php echo __d(__GATEWAY_LOCALE, 'back'); ?></span>
						</a>
						<a id="pay" class="btn btn-primary my-2 flat-btn"
						   href="javascript:void(0)"><?php echo __d(__GATEWAY_LOCALE, 'pay'); ?></a>
						<span id="pay_loading"></span>
					</div>
				</div>
			</div>
			<!-- Sidebar-->
			<div class="col-xl-3 col-lg-4 pb-4 mb-2">

				<div class="cart-total-box" style="margin-top: 10px">
					<h2 class="cart-head-title"><?php echo __d(__GATEWAY_LOCALE, 'order_detail'); ?></h2>
					<ul>
						<li><h3><?php echo __d(__PRODUCT_LOCALE, 'sum_price'); ?> :</h3> <span><?php echo number_format($Pay_Info['sum_price']) . ' ' . __('rial'); ?></span></li>
						<li><h3><?php echo __d(__PRODUCT_LOCALE, 'sum_item') ?> :</h3> <span><?php echo $Pay_Info['sum_item']; ?></span></li>

					</ul>
				</div>


			</div>

	</div>
</div>
</form>
<script>
    _url = '<?php echo __SITE_URL  ?>';
    function set_bank(obj) {
        $('#bank_name').html(obj.title);
        $('#bank_id').remove();
        var form = document.getElementById("pay_form");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("name", "bank_id");
        hiddenField.setAttribute("id", "bank_id");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("value", obj.id);
        form.appendChild(hiddenField);
    }

    $('#pay').click(function () {

        var bank_id = $('input[name=bank_id]', '#pay_form').val();

        if (bank_id == null) {
            show_warning_msg("<?php echo __d(__GATEWAY_LOCALE,'please_select_bank'); ?>");
            return;
        }


        if (bank_id == 1) {
            bank_url = _url + 'getway/bankpasargads/call?cn=' + '<?php echo $cn; ?>' + '&ac=' + '<?php echo $ac; ?>';
        }
        /*switch(bank_id)
		{
			case 1:
			   bank_url=_url+'getway/bankmellats/call';
			  break;
			case 2:
			  //
			  break;
			default:
			  //
		}*/

        $("#pay_loading").html('<img width="24" src="' + _url + 'img/loader/5.gif" >');
        $('#pay').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: bank_url,
            data: '',
            dataType: "json",
            success: function (response) {
                if (response.success == true) {
                    var form = document.createElement('form');
                    form.setAttribute('method', 'POST');
                    form.setAttribute('action', 'https://pep.shaparak.ir/gateway.aspx');
                    form.setAttribute('target', '_self');

                    var hiddenField = document.createElement('input');
                    hiddenField.setAttribute('name', 'invoiceNumber');
                    hiddenField.setAttribute('value', response.invoiceNumber);
                    form.appendChild(hiddenField);

                    var hiddenField1 = document.createElement('input');
                    hiddenField1.setAttribute('name', 'invoiceDate');
                    hiddenField1.setAttribute('value', response.invoiceDate);
                    form.appendChild(hiddenField1);

                    var hiddenField2 = document.createElement('input');
                    hiddenField2.setAttribute('name', 'amount');
                    hiddenField2.setAttribute('value', response.amount);
                    form.appendChild(hiddenField2);

                    var hiddenField3 = document.createElement('input');
                    hiddenField3.setAttribute('name', 'terminalCode');
                    hiddenField3.setAttribute('value', response.terminalCode);
                    form.appendChild(hiddenField3);

                    var hiddenField4 = document.createElement('input');
                    hiddenField4.setAttribute('name', 'merchantCode');
                    hiddenField4.setAttribute('value', response.merchantCode);
                    form.appendChild(hiddenField4);

                    var hiddenField5 = document.createElement('input');
                    hiddenField5.setAttribute('name', 'redirectAddress');
                    hiddenField5.setAttribute('value', response.redirectAddress);
                    form.appendChild(hiddenField5);

                    var hiddenField6 = document.createElement('input');
                    hiddenField6.setAttribute('name', 'timeStamp');
                    hiddenField6.setAttribute('value', response.timeStamp);
                    form.appendChild(hiddenField6);

                    var hiddenField7 = document.createElement('input');
                    hiddenField7.setAttribute('name', 'action');
                    hiddenField7.setAttribute('value', response.action);
                    form.appendChild(hiddenField7);

                    var hiddenField8 = document.createElement('input');
                    hiddenField8.setAttribute('name', 'sign');
                    hiddenField8.setAttribute('value', response.sign);
                    form.appendChild(hiddenField8);

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                } else {
                    if (response.message) {
                        show_warning_msg(response.message);
                    }
                }

                $('#ajax_result').html(response);
                $('#pay').removeAttr('disabled');
                $("#pay_loading").empty();
            }

        });


        /*
		$("#pay_loading").html('<img src="+<?php echo __IMAGE_PATH ?>+"/loader.gif">');
	$.ajax({
		type: "POST",
		url: '<?php echo __HOST_DIR?>/ajax/order/pay.php',
		data: 'bank_id='+bank_id,
		cache: false,
		success: function(html)
		{
		  $('#pay_preview').html(html);
		  $("#pay_loading").empty();
		}

	  });
	*/

    });

</script>
