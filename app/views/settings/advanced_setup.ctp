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
	$('#all').fadeIn(600);
});
</script>
<div id="all" style="display:none">

<br/>
<script type="text/javascript">
function submitform() {
  //document.SettingEditForm.submit();
  $('#SettingAdvancedSetupForm').submit();
}

</script>

<h3>Additional Settings</h3>

        <div style="float:left;width:65%;border-right:1px solid white;" class="label">
<p>Enter settings for credit card processing and other services here.  These can be set later through the "additional settings" link on the general settings page.</p><br/>
            
				<?php echo $form->create('Setting', array('action' => 'advanced_setup')); ?>
                                <h3>Credit Card Processing</h3>
				<?php echo $form->input('cc_process', array( 'label' => 'Enable Authorize.net Credit Card Processing')); ?>
                                <?php echo $form->input('authorizenet_api_login_id', array( 'label' => 'Authorize.net API Login ID','type'=>'text')); ?>
                                <?php echo $form->input('authorizenet_transaction_key', array( 'label' => 'Authorize.net Transaction Key')); ?>
                                <h3>Gimme!</h3>
				<?php echo $form->input('use_gimme', array( 'label' => 'Enable Gimme!')); ?>
				<?php echo $form->input('locationid', array( 'label' => 'Location ID for Gimme!')); ?>
	</div>
	
	<div style="float:right;width:34%;">
				<div style="margin-left:10px;">
				<p>
                                        <h4>Credit Card Processing</h4>
                                        The Barnes POS System can process credit card transaction using <a href="http://www.authorize.net" style="color:white;">Authorize.net</a>, which requires your server to be connected to the internet.  To utilize this feature, you need to create an account on Authorize.net and enter your credentials here.   
                                        <br/><br/>
                                        
					<h4>Gimme! Customer Loyalty</h4>
					Info and link to Gimme! here.
					<br/><br/>
				</p>
				</div>
	</div>
<br/><br/>
<div style="width:100%;float:left;">
<a style="float:left;vertical-align:bottom;margin-left:10px;" href="/settings/setup"><input type="button" class="submits" value="Previous"></a>
<a style="float:right;vertical-align:bottom;margin-right:10px;" href="#" onclick="submitform()"><input type="button" class="submits" value="Next"></a>
<br/><br/><br/>
</div>

</div>