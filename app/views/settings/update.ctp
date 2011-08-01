<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<br/>
<h3>System Update</h3>

            <div class="link"><a href="/pages/admin"><< Admin Panel</a></div><br/>
<p>Change the general settings for your system here.</p><br/>

<?php
$latest = file_get_contents('http://barnespos.com/version.php');
$current = file_get_contents('version.php');
if (ereg_replace("[A-Za-z]", "",$latest)<=ereg_replace("[A-Za-z]", "",$current)) {
	$string = 'Your Software is up-to-date (Version '.$current.')';			
} else {
	$string = 'Updates are available for your software.  Latest version: '.$latest.', current version: '.$current;			
}
?>

<h4><?php echo $string; ?></h4>

<?php //echo shell_exec('/Users/Schwamm/Sites/barnespossystem/update.sh'); ?>
<?php echo exec('./var/www/test.sh'); ?>