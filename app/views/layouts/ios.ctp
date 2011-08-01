 <!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
 <?php
 /*
  header("Cache-Control: no-cache, must-revalidate");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  flush();
 */
  ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
		<meta name="apple-mobile-web-app-capable" content="yes">
	        <meta name="apple-mobile-web-app-status-bar-style" content="black">
                    
		<title>Barnes POS System</title>
		
		<?php echo $html->script('jquery-1.4.4.min'); ?>
		<?php echo $html->script('jqtouch'); ?>
		
		<?php echo $html->css('i.themes/jqt/theme'); ?>
		<?php echo $html->css('jqtouch.css'); ?>
		
		<script type="text/javascript" charset="utf-8">
		    $.jQTouch({
			 useAnimations: false,
			 preloadImages: [
			     '/css/i.themes/jqt/img/back_button_clicked.png',
			     '/css/i.themes/jqt/img/button_clicked.png'
			     ]
		     });
		</script>
		
		<script type="application/x-javascript">
		 addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		 
		 function hideURLbar(){
		 window.scrollTo(0,1);
		 }
		 </script>
	</head>
	
	<body style="margin-left:10px;margin-right:10px;min-height:480px;height:100%;" class="landscape">
	 <div id="jqt">
		<?php echo $content_for_layout; ?>
		<p style="position:absolute;bottom:3px;text-align:center;width:100%;font-size:80%;">&copy; 2011 Barnes Point of Sale Systems</p>
                <div id="progress" style="min-height: 100%; display: none;background-color: black;"></div>
                
	 </div>
        </body>
</html>