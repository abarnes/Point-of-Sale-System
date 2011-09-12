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
		<title>Printing...</title>
		
		<?php echo $html->css('cakeorig'); ?>
		<?php echo $html->css('customstyle'); ?>
		<?php echo $html->css('smoothness/jquery-ui-1.8.9.custom'); ?>
                
                <?php echo $html->script('jquery-1.4.4.min'); ?>
		<?php echo $html->script('jquery-ui-1.8.9.custom.min'); ?>
		
		<script type="text/javascript">
		    function trigger(){
		       window.open('/payments/receipt_print/<?php echo $id; ?>','_blank','width=50,height=50,menubar=0,status=0');
		       <?php if ($demo=='0') { ?>
			setTimeout("window.location='/tickets/menu';",1500);
		       <?php } else { ?>
		        setTimeout("window.location='/payments/gimmesample/<?php echo $id; ?>';",1500);
		       <?php } ?>
		    }
		</script>
		
	</head>
	<body onload="trigger()">
            
            <?php echo $content_for_layout; ?>
            
        </body>
</html>