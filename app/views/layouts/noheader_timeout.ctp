<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
 <?php
 
  header("Cache-Control: no-cache, must-revalidate");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  flush();
 
  ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Barnes POS System</title>
		
		<?php echo $html->css('cakeorig'); ?>
		<?php echo $html->css('customstyle'); ?>
		<?php echo $html->css('keyboard'); ?>
		<?php echo $html->css('smoothness/jquery-ui-1.8.9.custom'); ?>
		<?php //echo $html->script('jquery-core'); ?>
		<?php echo $html->script('prototype'); ?>
		<?php echo $html->script('jquery-1.4.4.min'); ?>
		<?php echo $html->script('jquery-ui-1.8.9.custom.min'); ?>
		<?php echo $html->script('jquery.keyboard'); ?>
		
		<script type="text/javascript">
		window.onload = function() {
		/*	set your parameters(
		number to countdown from, 
		pause between counts in milliseconds, 
		function to execute when finished
		) 
		*/
		startCountDown(60, 1000, redir);
		}
		
		function startCountDown(i, p, f) {
		//	store parameters
		var pause = p;
		var fn = f;
		//	make reference to div
		var countDownObj = document.getElementById("countDown");
		if (countDownObj == null) {
		//	error
		alert("div not found, check your id");
		//	bail
		return;
		}
		countDownObj.count = function(i) {
		//	write out count
		countDownObj.innerHTML = i;
		if (i == 0) {
		//	execute function
		fn();
		//	stop
		return;
		}
		setTimeout(function() {
		//	repeat
		countDownObj.count(i - 1);
		},
		pause
		);
		}
		//	set it going
		countDownObj.count(i);
		}
		
		function redir() {
		  parent.location='/users/quick_in';
		}
		</script>

	</head>
	<body style="margin-left:10px;margin-right:10px;">
		<h6><?php echo $session->flash('auth'); ?></h6>
		<h6><?php echo $session->flash(); ?></h6>
		
		<?php echo $content_for_layout; ?>
		<div style="width:98%;text-align:center;position:absolute;bottom:10px;">Redirecting to Quick Key In after <span id="countDown"></span> seconds</div>

        </body>
</html>