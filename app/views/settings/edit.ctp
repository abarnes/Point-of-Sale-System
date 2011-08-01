<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<br/>
<h3>General Settings</h3>

        <div style="float:left;width:65%;border-right:1px solid white;" class="label">
            <div class="link"><a href="/pages/admin"><< Admin Panel</a><a href="/settings/advanced" style="margin-left:20px;">Additional Settings</a></div><br/>
<p>Change the general settings for your system here.</p><br/>
            
				<?php echo $form->create('Setting', array('action' => 'edit')); ?>
				<?php echo $form->input('business_name', array( 'label' => 'Business Name: ')); ?>
				<?php echo $form->input('address1', array( 'label' => 'Address Line 1: ')); ?>
				<?php echo $form->input('address2', array( 'label' => 'Address Line 2: ')); ?>
				<?php echo $form->input('address3', array( 'label' => 'Address Line 3: ')); ?>
				<?php echo $form->input('phone1', array( 'label' => 'Phone Number 1: ')); ?>
				<?php echo $form->input('phone2', array( 'label' => 'Phone Number 2: ')); ?>
				<?php echo $form->input('website', array( 'label' => 'Website: ')); ?>
				<?php //echo $form->input('cc_process', array( 'label' => 'Enable Credit Card Processing')); ?>
				<?php echo $form->input('tax', array( 'label' => 'Tax Rate: ')); ?>
                                <?php echo $form->input('kitchen_printer', array( 'label' => 'Kitchen Printer Name: ')); ?>
				<?php echo $form->end('Save'); ?>
	</div>
	
	<div style="float:right;width:35%;">
				<div style="margin-left:10px;">
				<p>
								<h4>Receipt Layout</h4>
								The name, address, phone numbers, and website will appear on your receipts as they appear here.  You can leave any of these fields blank and they will not appear on your receipts.
								<br/><br/>
								Your receipt header follows the following format:<br/>
								<div style="height:5px;"></div>
								<table>
												<tr>
																<td>
								<div style="text-align:center;style="width:50%;float:left;">
												<p>
												<b>Business Name</b><br/>
												Address Line 1<br/>
												Address Line 2<br/>
												Address Line 3<br/>
												<div style="height:5px;"></div>
												Phone Number 1<br/>
												Phone Number 2<br/>
												<div style="height:5px;"></div>
												Website<br/></p>
								</div></td>
																<td>
								<div style="text-align:center;style="width:50%;float:right;">
												<p>
												<b>Ben's Burgers</b><br/>
												100 Main Street<br/>
												Building 6<br/>
												Waco, Texas<br/>
												<div style="height:5px;"></div>
												Phone: 222-555-7777<br/>
												Fax: 222-555-7778<br/>
												<div style="height:5px;"></div>
												bensburgerswaco.com<br/></p>
								</div>
																</td>
												</tr>
								</table>
								<br/>
								<h4>Phone Numbers</h4>
								You can put any text in the phone number fields.  For example, phone number 2 can be set as "Fax: (222) 555-6655" similar to the above example.
								<br/><br/>
								<!--<h4>Credit Card Processing</h4>
								Enabling this utilizes the Barnes POS System's built-in credit card processing, which requires a PayPal account and setup.  Alternately, you can use your existing credit card processing setup.
								<br/><br/>-->
								<h4>Tax Rate</h4>
								Enter a tax rate for the Barnes POS System to calculate tax on your tickets.  Do not add a percent sign (%) or non-numeric characters other than a decimal.  For a rate of 8.25%, simply enter "8.25".
                                                                <br/><br/>
								<h4>Kitchen Printer Name</h4>
								Enter the system's name for your kitchen printer.  In Ubuntu, click on "System" in the top menu bar, go to "Administration," and click "Printing."  If your kitchen printer is already installed and connected to your server, you should see it listed.  Enter the name of the kitchen printer here exactly as it appears in the printing settings.
                                                                <h4>Additional Settings</h4>
                                                                Click this link to change credit card processing settings as well as Gimme! Customer Loyalty services.
                                                                <br/><br/>
				</p>
				</div>
	</div>