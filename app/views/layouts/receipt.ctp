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
		
                <?php echo $html->script('jquery-1.4.4.min'); ?>
		<?php echo $html->script('jquery-ui-1.8.9.custom.min'); ?>
	</head>
	<body>
            
            <?php echo $content_for_layout; ?>
            
        </body>
</html>