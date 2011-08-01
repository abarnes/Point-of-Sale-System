<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<br/>
<h3>Additional Settings</h3>

        <div style="float:left;width:65%;border-right:1px solid white;" class="label">
            <div class="link"><a href="/settings/edit"><< General Settings</a></div><br/>
<p>Change the additional settings here to allow for credit card processing and other additional services.</p><br/>
            
				<?php echo $form->create('Setting', array('action' => 'advanced')); ?>
                                <h3>Credit Card Processing</h3>
				<?php echo $form->input('cc_process', array( 'label' => 'Enable Authorize.net Credit Card Processing')); ?>
                                <?php echo $form->input('authorizenet_api_login_id', array( 'label' => 'Authorize.net API Login ID','type'=>'text')); ?>
                                <?php echo $form->input('authorizenet_transaction_key', array( 'label' => 'Authorize.net Transaction Key')); ?>
                                <h3>Gimme!</h3>
				<?php echo $form->input('use_gimme', array( 'label' => 'Enable Gimme!')); ?>
				<?php echo $form->input('locationid', array( 'label' => 'Location ID for Gimme!')); ?>
				<?php echo $form->end('Save'); ?>
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