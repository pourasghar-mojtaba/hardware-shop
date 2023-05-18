<?php
if (eregi("order_gateway.php", $_SERVER['PHP_SELF']))
 { 
	exit();
 }
   
?>

<title>city tomb <?php echo   $app->lang('gateway') ?> </title>


<meta name='keywords' content='<?php echo   $td['meta'] ?>' />


<link rel="stylesheet" href="<?php echo __THEME_URL.'/css/getway_'.$site_dir.'.css'; ?>" type="text/css" />


</head>
<body>
<div class="header" style="height:40px;margin-top:5px;">
	   <?php
		 include(__VIEW_PATH.'/search_form.php');
		?>
	  
	<div class="logo-small"></div>

</div>
<?php
		 
		 $tomb_user=new tomb_user;
		 if (!$tomb_user->logged_in())
		 {
			 echo "<script>showmsg('<span style=color:#F00>   ".$app->lang('login_in_site')." </span>');</script>";
			//header("Location:".__SITE_URL."/page/p_404");
			exit; 
		 }
 ?>

<!-- header end-->

<div id="getway">
  <div id="mainbox">
  
<?php

 if($_POST['token']!=$_SESSION["token"])
   {
	  echo "<script language='javascript' type='text/javascript'>
	  showmsg('<span style=color:#F00> ".$app->lang('not_valid_value')."  </span>');</script>";
	 // exit;  
?>
<script type="text/JavaScript">
<!--
 setTimeout("location.href = '<?php echo  __SITE_URL ?> ';",1800);
-->
</script>
<?php
  exit;
  }
?>   
<?php

if( $_SESSION['buy'.$ip]['buy_sum_num']==0 || $_SESSION['buy'.$ip]['buy_sum_num']=='') 
   {
	  echo "<script language='javascript' type='text/javascript'>
	  showmsg('<span style=color:#F00>".$app->lang('empety_value')."  </span>');</script>";
	 // exit;  
?>
<script type="text/JavaScript">
<!--
 setTimeout("location.href = '<?php echo  __SITE_URL ?> ';",1800);
-->
</script>
<?php
  exit;
  }

 
?>  
<div class="content">
  <div class="content2">
	<h1> <?php echo   $app->lang('end_pay') ?></h1>
	<table width="700" border="0" class="card_items_table" cellspacing="2" cellpadding="3" align="center"
	 dir="<?php echo   $site_dir ?>">
  <tr>
	<td><div id="title"><?php echo   $app->lang('title') ?> : </div></td>
	<td><?php echo   $_SESSION['buy'.$ip]['buy_title'] ?></td>
	<td><div id="title"><?php echo   $app->lang('sum_price') ?> : </div> </td>
	<td><?php echo   $_SESSION['buy'.$ip]['buy_sum_amnt'] ?></td>
  </tr>
  <tr>
	<td><div id="title"><?php echo   $app->lang('name') ?> : </div></td>
	<td><?php echo	$_SESSION['tomb_userinfo']['name'] ?></td>
	<td><div id="title"><?php echo   $app->lang('post_price') ?> : </div></td>
	<td><?php echo   $_SESSION['buy'.$ip]['buy_post'] ?></td>
  </tr>
  <tr>
	<td><div id="title"><?php echo   $app->lang('sum_item') ?> :</div></td>
	<td><?php echo   $_SESSION['buy'.$ip]['buy_sum_num'] ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
</table>

	<div class="addressForm">
	<form name="pay_form" id="pay_form" >
		<table width="700" border="0" cellpadding="5">
		  <tr>
			<td><strong> <?php echo   $app->lang('pay_online') ?>:</strong></td>
			<td></td>
		  </tr>
		  <tr>
			<td></td>
			<td>
			 <?php
			   foreach($td['bank_list'] as $key=>$value)
				 {
					if($value['active']==1)
					{
						$image=$value['image'];
						echo "
					 <a href='JavaScript:void(0);' onClick='set_bank(this);' id='$value[bank_id]'
					  title='".$value['bank_name']."'>
					 <img src='". __IMAGE_PATH ."/icon/$image' width='64' height='64' /></a>
					"; 
					}
					else
					{
						$ext = pathinfo($value['image'], PATHINFO_EXTENSION);
						$image= substr( $value['image'],0,strlen($value['image'])-4).'_gray.'.$ext;
						echo "
						<img src='". __IMAGE_PATH ."/icon/$image' width='64' height='64' title='".$value['bank_name']."' />
					"; 
					}
					
				 }
			 ?>
			
			</td>
		  </tr>
		  <tr>
			<td>
			<br />
			<br />

			</td>
			<td></td>
		  </tr>
		  <tr>
		   <td><?php echo   $app->lang('bank_selection') ?> :</td>
		   <td id="bank_name"> <?php echo   $app->lang('not_select_gateway') ?></td>
		  </tr>
		  <tr>
			<td colspan="2">
			  <input type="button" name="" id="pay"  value="<?php echo   $app->lang('payment') ?>" class="button"> 
				 <div id="pay_preview" style="float:right"></div>
				 <div id="pay_loading" style="float:right"></div>
			</td>
		  </tr>
		</table>
	  </form>
	  <div id="basket_bar">
	  	<img src="<?php echo   __IMAGE_PATH ?>/basket_icon.png" width="230" height="230" />
	  </div>
	</div>
	
</div>


<script>

$('#bank_list').slideUp('0', function() { });
$('#fish_list').slideUp('0', function() { });

 $('#with_bank').click(function() {
	  $('#bank_list').slideDown('slow', function() { });
	  $('#fish_list').slideUp('slow', function() { });
 });
 
 $('#with_fish').click(function() {
	  $('#fish_list').slideDown('slow', function() { });
	  $('#bank_list').slideUp('slow', function() { });
 }); 

function set_bank(obj)
{
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

//=================================================================

$('#pay').click(function (){

	
	/*var order_type = $('input[name=order_type]:checked', '#pay_form').val();
	
	if(order_type!='with_bank' && order_type!='with_fish')
	 {
	  showmsg('  <span style= color:#F00; ><?php echo   $app->lang('select_order_type') ?> </span>  ');
	  return;
	 }*/
	var bank_id = $('input[name=bank_id]', '#pay_form').val();
	if(bank_id==null)
	{
	 showmsg('  <span style= color:#F00; ><?php echo   $app->lang('select_bank') ?> </span>  ');
	 return;
	}
	  $("#pay_loading").html('<img src="+<?php echo   __IMAGE_PATH ?>+"/loader.gif">');
	$.ajax({
		type: "POST",
		url: '<?php echo  __HOST_DIR?>/ajax/order/pay.php',
		data: 'bank_id='+bank_id,
		cache: false,
		success: function(html)
		{  
		  $('#pay_preview').html(html);
		  $("#pay_loading").empty();	
		}
	
	  });
	
	
});
//==================================================================
 

</script>

