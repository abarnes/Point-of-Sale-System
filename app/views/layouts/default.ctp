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
		
		<?php echo $html->css('cake.generic'); ?>
		<?php echo $html->css('customstyle'); ?>
		<?php echo $html->css('smoothness/jquery-ui-1.8.9.custom'); ?>
		<?php //echo $html->script('jquery-core'); ?>
		<?php echo $html->script('prototype'); ?>
		<?php echo $html->script('jquery-1.4.4.min'); ?>
		<?php echo $html->script('jquery-ui-1.8.9.custom.min'); ?>

	</head>
	<body style="margin-left:10px;margin-right:10px;">
		<div id="header">
		<?php if ($aut==true) { ?>
			<?php if ($admin==true) { ?>
				<ul class="top-nav">
					<li><span style="color: #993;font-family:'Gill Sans','lucida grande', helvetica, arial, sans-serif;font-size: 165%;"><?php echo $name; ?></span></li>
					<li><?php echo $html->link('Place Order',array('controller'=>'tickets','action'=>'add')); ?></li>
					<li><?php echo $html->link('Tickets',array('controller'=>'tickets','action'=>'index/all')); ?></li>
					<li><?php echo $html->link('Menu',array('controller'=>'tickets','action'=>'menu')); ?></li>
					<li><?php echo $html->link('Admin',array('controller'=>'pages','action'=>'admin')); ?></li>
					<li><?php echo $html->link('Clock Out',array('controller'=>'users','action'=>'logout')); ?></li>
				</ul>
			<?php } else { ?>
				<ul class="top-nav">
					<li><span style="color: #993;font-family:'Gill Sans','lucida grande', helvetica, arial, sans-serif;font-size: 165%;"><?php echo $name; ?></span></li>
					<li><?php echo $html->link('Place Order',array('controller'=>'tickets','action'=>'add')); ?></li>
					<li><?php echo $html->link('Tickets',array('controller'=>'tickets','action'=>'index')); ?></li>
					<li><?php echo $html->link('Menu',array('controller'=>'tickets','action'=>'menu')); ?></li>
					<li><?php echo $html->link('Clock Out',array('controller'=>'users','action'=>'logout')); ?></li>
				</ul>
			<?php } ?>
			  <input style="float:right;width:85px;height:40px;font-size:1em;position:relative;bottom:14px;" type="button" class="submits" value="Exit" onclick="parent.location='/users/quick_in'"/>
		<?php } else { ?>
		   <ul class="top-nav">
			   <li><?php echo $html->link('Home',array('controller'=>'pages','action'=>'home')); ?></li>
			   <li><?php echo $html->link('Login',array('controller'=>'users','action'=>'login')); ?></li>
			   <li><?php echo $html->link('Setup Utility',array('controller'=>'pages','action'=>'setup')); ?></li>
		   </ul>
		<?php } ?>
		</div>
		
		<div id="mid">
		<hr style="margin-right:30px;"/>
		<h6><?php echo $session->flash('auth'); ?></h6>
		<h6><?php echo $session->flash(); ?></h6>
		</div>
		
		<?php echo $content_for_layout; ?>
        

        </body>
</html>