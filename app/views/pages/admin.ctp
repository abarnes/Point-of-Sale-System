<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<script type="text/javascript">
$(document).ready(function(){	
	$('#all').fadeIn(500);
});
</script>
<div id="all" style="display:none">

<h3>Admin Panel</h3>

<br/>
<h4>Statistics</h4>
<input onclick="parent.location='/clocks/index/all'" type="button" value="Daily Statistics" style="width:150px;font-size:1em;height:100px;" class="submits">
<input onclick="parent.location='/payments'" type="button" value="Transactions" style="width:150px;font-size:1em;height:100px;" class="submits">
<input onclick="parent.location='/clocks/report_all'" type="button" value="Shifts" style="width:150px;font-size:1em;height:100px;" class="submits">
<br/><br/>
<hr/>
<br/>
<h4>Manage</h4>
<input onclick="parent.location='/items'" type="button" value="Items" style="width:150px;font-size:1em;height:100px;" class="submits">
<input onclick="parent.location='/modifiers'" type="button" value="Modifiers" style="width:150px;font-size:1em;height:100px;" class="submits">				
<input onclick="parent.location='/categories'" type="button" value="Categories" style="width:150px;font-size:1em;height:100px;" class="submits">
<input onclick="parent.location='/discounts'" type="button" value="Discounts" style="width:150px;font-size:1em;height:100px;" class="submits">
<input onclick="parent.location='/types'" type="button" value="Ticket Types" style="width:150px;font-size:1em;height:100px;" class="submits">
<br/><br/> 
<input onclick="parent.location='/users'" type="button" value="Employees" style="width:150px;font-size:1em;height:100px;" class="submits">					
<input onclick="parent.location='/settings/edit'" type="button" value="General Settings" style="width:150px;font-size:1em;height:100px;" class="submits">
<input onclick="parent.location='/tickets/record_index'" type="button" value="Ticket Records" style="width:150px;font-size:1em;height:100px;" class="submits">
<input onclick="parent.location='/pages/setup'" type="button" value="Setup Utility" style="width:150px;font-size:1em;height:100px;" class="submits">
			
</div>