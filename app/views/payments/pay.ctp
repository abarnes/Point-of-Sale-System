<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<?php
//do some math
$tax=$total*$s['tax']/100;
$tax = round($tax,'2');
$ntotal = $tax+$total;
$sp = explode('.',$ntotal);
if (isset($sp[1])) {
				if (strlen($sp[1])==1) {
								$ntotal = $ntotal.'0';
				}
} else {
				$ntotal = $ntotal.'.00';
}
$fifteen = $ntotal*.15;
$fifteen = round($fifteen,'2');
$sp = explode('.',$fifteen);
if (isset($sp[1])) {
				if (strlen($sp[1])==1) {
								$fifteen = $fifteen.'0';
				}
} else {
				$fifteen = $fifteen.'.00';
}
$twenty = $ntotal*.2;
$twenty = round($twenty,'2');
$sp = explode('.',$twenty);
if (isset($sp[1])) {
				if (strlen($sp[1])==1) {
								$twenty = $twenty.'0';
				}
} else {
				$twenty = $twenty.'.00';
}
?>

<style type="text/css">
#printable { display: none; }

    @media print
    {
        #non-printable { display: none; }
	#header { display: none; }
	#mid { display: none; }
        #printable { display: block; }
	body {background-color:white}
    }
</style>

<div id="non-printable">
			
<script type="text/javascript">
var balance = <?php echo $ntotal; ?>;

function complete(type){
                co = 1;	
			while (document.getElementById("PaymentAmount"+co).value!='') {
				co++;
			}
			if (co>5) {
				alert('You may only process five different payments on a ticket.');
                        } else {
				document.getElementById("PaymentEnable"+co).value = '1';
				document.getElementById("PaymentAmount"+co).value = window.balance;
				document.getElementById("PaymentType"+co).value = type;
				$('#pays').append('<table id="paym'+co+'"><tr><th>Transaction '+co+'<a href="#" onclick="remo('+co+','+window.balance+')" style="float:right;"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System')); ?></a></th></tr><tr><td id="p'+co+'">'+type.capitalize()+' $'+window.balance+'</td></tr></table>');
				$('#receipt').append('<p id="payr'+co+'" style="font-size:85%;"><span style="float:left;margin-left:100px;">'+type.capitalize()+'</span><span style="float:right;text-align:right;" id="r'+co+'">$'+window.balance+'</span><br/></p>');
				
				window.balance = 0;
				document.getElementById("balance").innerHTML = 0;
				
				if(type=='credit') {
					$('#dialog-tip').dialog('open');
				}
			}
}

function opend(type){
			document.getElementById(type+"-amt").value = window.balance.toFixed(2);
			$('#dialog-'+type).dialog('open');	
}

function calc(type,num){
			document.getElementById(type+"-amt").value += num;	
}
function clr(type){
			var str = document.getElementById(type+"-amt");
			var news = str.value.substring(0, str.value.length-1);
			document.getElementById(type+"-amt").value = news; 	
}
function subm(type){
			co = 1;	
			while (document.getElementById("PaymentAmount"+co).value!='') {
				co++;
			}
			if (co>5) {
				alert('You may only process five different payments on a ticket.');
			} else {
				var str = document.getElementById(type+"-amt").value;
				document.getElementById("PaymentAmount"+co).value = str;
				document.getElementById("PaymentType"+co).value = type;
				document.getElementById("PaymentEnable"+co).value = '1';
				if (str!=window.balance) {
					if (str<window.balance){
						$('#dialog-'+type).dialog("close");
						if(type=='credit') {
									$('#dialog-tip').dialog('open');
						}
						$('#pays').append('<table id="paym'+co+'"><tr><th>Transaction '+co+'<a href="#" onclick="remo('+co+','+str+')" style="float:right;"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System')); ?></a></th></tr><tr><td id="p'+co+'">'+type.capitalize()+' $'+str+'</td></tr></table>');
				                $('#receipt').append('<p id="payr'+co+'" style="font-size:85%;"><span style="float:left;margin-left:100px;">'+type.capitalize()+'</span><span style="float:right;text-align:right;" id="r'+co+'">$'+str+'</span><br/></p>');
						
						window.balance-=str;
				                window.balance = Math.round(window.balance*100)/100;
						document.getElementById("balance").innerHTML = window.balance;
					} else {
						alert('You have tendered a greater amount than the total.');			
					}
				} else {
					$('#dialog-'+type).dialog("close");
					if(type=='credit') {
						$('#dialog-tip').dialog('open');
					}
					$('#pays').append('<table id="paym'+co+'"><tr><th>Transaction '+co+'<a href="#" onclick="remo('+co+','+str+')" style="float:right;"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System')); ?></a></th></tr><tr><td id="p'+co+'">'+type.capitalize()+' $'+str+'</td></tr></table>');
					$('#receipt').append('<p id="payr'+co+'" style="font-size:85%;"><span style="float:left;margin-left:100px;">'+type.capitalize()+'</span><span style="float:right;text-align:right;" id="r'+co+'">$'+str+'</span><br/></p>');
					
					window.balance-=str;
				        window.balance = Math.round(window.balance*100)/100;
					document.getElementById("balance").innerHTML = window.balance;
				}
			}
}
function tip(){
				co = 1;	
			while (document.getElementById("PaymentAmount"+co).value!='') {
				co++;
			}
			co = co-1;
		var str = document.getElementById('tip-amt').value;
                document.getElementById("PaymentTip"+co).value = str;
		$('#p'+co).append(' (Tip: $'+str+')');
		$('#r'+co).append('<br/> Tip: $'+str)
		$('#dialog-tip').dialog("close");		
}
function addtip(amt){
		document.getElementById('tip-amt').value = amt;		
}
function remo(num,str) {
				var child = document.getElementById('paym'+num);
				var parent = document.getElementById('pays');
				parent.removeChild(child);
				
				var child = document.getElementById('payr'+num);
				var parent = document.getElementById('receipt');
				parent.removeChild(child);
				
				document.getElementById("PaymentAmount"+co).value = '';
				document.getElementById("PaymentType"+co).value = '';
				document.getElementById("PaymentEnable"+co).value = '0';
				document.getElementById("PaymentTip"+co).value = '';
				
				window.balance+=str;
				window.balance = Math.round(window.balance*100)/100;
				document.getElementById("balance").innerHTML = window.balance;				
}

</script>

<script type="text/javascript">
                                $(function(){
                                // Dialog			
				$('#dialog-cash').dialog({
					autoOpen: false,
					width: 350,
					buttons: {
						"Submit": function() { 
							subm('cash'); 
						}//, 
						//"Cancel": function() { 
						//	$(this).dialog("close"); 
						//} 
					}
				});
                            });
				
			$(function(){
                                // Dialog			
				$('#dialog-credit').dialog({
					autoOpen: false,
					width: 350,
					buttons: {
						"Submit": function() { 
							subm('credit'); 
						} 
					}
				});
                            });
			
			$(function(){
                                // Dialog			
				$('#dialog-tip').dialog({
					autoOpen: false,
					width: 450,
					buttons: {
						"Submit": function() { 
							tip(); 
						} 
					}
				});
                            });
				
			$(function(){
                                // Dialog			
				$('#dialog-check').dialog({
					autoOpen: false,
					width: 350,
					buttons: {
						"Submit": function() { 
							subm('check'); 
						} 
					}
				});
                            });
</script>

<div id="dialog-cash" title="Cash Payment">
			<div>
						<form>
									<label>Amount: </label><input type="text" name="amount" value="" id="cash-amt"/>
						<div style="float:left;">
									<input onclick="calc('cash','1')" type="button" value="1" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('cash','2')" type="button" value="2" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('cash','3')" type="button" value="3" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('cash','4')" type="button" value="4" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('cash','5')" type="button" value="5" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('cash','6')" type="button" value="6" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('cash','7')" type="button" value="7" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('cash','8')" type="button" value="8" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('cash','9')" type="button" value="9" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('cash','.')" type="button" value="." style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('cash','0')" type="button" value="0" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="clr('cash')" type="button" value="clr" style="width:50px;height:50px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="subm('cash')"/>-->
						</form>						
			</div>
</div>

<div id="dialog-credit" title="Credit Payment">
			<div>
						<form>
									<label>Amount: </label><input type="text" name="amount" value="" id="credit-amt"/>
						<div style="float:left;">
									<input onclick="calc('credit','1')" type="button" value="1" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('credit','2')" type="button" value="2" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('credit','3')" type="button" value="3" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('credit','4')" type="button" value="4" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('credit','5')" type="button" value="5" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('credit','6')" type="button" value="6" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('credit','7')" type="button" value="7" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('credit','8')" type="button" value="8" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('credit','9')" type="button" value="9" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('credit','.')" type="button" value="." style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('credit','0')" type="button" value="0" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="clr('credit')" type="button" value="clr" style="width:50px;height:50px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="subm('credit')"/>-->
						</form>						
			</div>
</div>

<div id="dialog-check" title="Check Payment">
			<div>
						<form>
									<label>Amount: </label><input type="text" name="amount" value="" id="check-amt"/>
						<div style="float:left;">
									<input onclick="calc('check','1')" type="button" value="1" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('check','2')" type="button" value="2" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('check','3')" type="button" value="3" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('check','4')" type="button" value="4" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('check','5')" type="button" value="5" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('check','6')" type="button" value="6" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('check','7')" type="button" value="7" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('check','8')" type="button" value="8" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('check','9')" type="button" value="9" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('check','.')" type="button" value="." style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('check','0')" type="button" value="0" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="clr('check')" type="button" value="clr" style="width:50px;height:50px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="subm('check')"/>-->
						</form>						
			</div>
</div>

<div id="dialog-tip" title="Add Tip">
			<div>
						<form>
									<label>Tip: </label><input type="text" name="amount" value="" id="tip-amt"/>
						<div style="float:left;width:100%;">
									<input onclick="calc('tip','1')" type="button" value="1" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('tip','2')" type="button" value="2" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('tip','3')" type="button" value="3" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="addtip('<?php echo $fifteen; ?>')" type="button" value="15% (<?php echo $fifteen; ?>)" style="width:110px;height:50px;font-size:1em;margin-left:20px;" class="submits">			
									<div style="height:0px;"></div>
									<input onclick="calc('tip','4')" type="button" value="4" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('tip','5')" type="button" value="5" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('tip','6')" type="button" value="6" style="width:50px;height:50px;font-size:1em;" class="submits">
								        <input onclick="addtip('<?php echo $twenty; ?>')" type="button" value="20% (<?php echo $twenty; ?>)" style="width:110px;height:50px;font-size:1em;margin-left:20px;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('tip','7')" type="button" value="7" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('tip','8')" type="button" value="8" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('tip','9')" type="button" value="9" style="width:50px;height:50px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('tip','.')" type="button" value="." style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="calc('tip','0')" type="button" value="0" style="width:50px;height:50px;font-size:1em;" class="submits">
									<input onclick="clr('tip')" type="button" value="clr" style="width:50px;height:50px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="tip()"/>-->
						</form>						
			</div>
</div>
				
<br/>

<div style="float:left;">
				<h3>Ticket <?php echo $ticket['Ticket']['dailyid']; ?>
				<?php if ($ticket['Type']['use_tables']=='1') { ?> 
				, Table <?php echo $ticket['Ticket']['table']; ?><?php } ?>
				</h3>
				
				<p>Server: <?php echo $ticket['User']['first_name']; ?></p><br/>
</div>
<br/>
<div style="float:right;margin-right:25px;">
									<h3>Balance: $<span id="balance"><?php echo $ntotal; ?></span></h3>
									<h4>Total: $<?php echo $ntotal; ?></h4>
</div>

<hr style="width:100%;float:left;"/><br/>

<table style="width:100%;background-color:transparent;border-color:transparent;"><tr><td style="width:670px;background-color:transparent;border-color:transparent;">
<!--<div style="margin-right:336px;">-->
        <div style="border-right:0px solid white;width:670px;float:left;" class="label">
			<h4>Payment Type</h4> 
			<input onclick="opend('cash')" type="button" value="Cash" style="width:200px;font-size:1em;height:160px;" class="submits">
			<input onclick="opend('credit')" type="button" value="Credit" style="width:200px;font-size:1em;height:160px;" class="submits">
			<input onclick="opend('check','<?php echo $ntotal; ?>')" type="button" value="Check" style="width:200px;font-size:1em;height:160px;" class="submits">
			<br/><br/><hr/><br/>
			<h4>Pay in Full</h4>
			<input onclick="complete('cash')" type="button" value="Quick Cash" style="width:200px;font-size:1em;height:160px;" class="submits">
			<input onclick="complete('credit')" type="button" value="Quick Credit" style="width:200px;font-size:1em;height:160px;" class="submits">
			<input onclick="complete('check')" type="button" value="Quick Check" style="width:200px;font-size:1em;height:160px;" class="submits">
			<br/><br/><hr/>
			
			
                        <?php echo $form->create('Payment', array('action' => 'pay/'.$ticket['Ticket']['id'])); ?>
			<?php echo $form->input('Payment.enable1',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.amount1',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.tip1',array('value'=>'0','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.type1',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.enable2',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.amount2',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.tip2',array('value'=>'0','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.type2',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.enable3',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.amount3',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.tip3',array('value'=>'0','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.type3',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.enable4',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.amount4',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.tip4',array('value'=>'0','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.type4',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.enable5',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.amount5',array('value'=>'','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.tip5',array('value'=>'0','type'=>'hidden')); ?>
			<?php echo $form->input('Payment.type5',array('value'=>'','type'=>'hidden')); ?>
				<!--------submit form----->
				<script type="text/javascript">
				function submitfr() {
				  if (window.balance==0) {
					document.getElementById('PaymentPay<?php echo '/'.$ticket['Ticket']['id']; ?>Form').submit();
					//window.open('/payments/receipt_print/<?php echo $ticket['Ticket']['id']; ?>','_blank','width=300,menubar=0,status=0');
				  } else {
				        alert('The full amount has not be tendered (Balance: $'+window.balance+')');
				  }
				  //window.print();			
				  //document.getElementById('PaymentPay<?php echo '/'.$ticket['Ticket']['id']; ?>Form').submit();
				}
				</script>
			<br/>
			<a style="vertical-align:bottom;margin-left:0px;" href="#" onclick="submitfr()"><input style="width:650px;height:44px;" type="button" class="submits" value="Submit"></a>
	</div>
</td><td style="background-color:transparent;border-color:transparent;">
<!--</div>-->
	
	<div style="min-width:320px;float:left;">
				<div id="pays" style="background-color:inherit;">
								<h3>Payments</h3>
							
				</div>
				<div style="background-color:white;">
						<br/>
								<div style="text-align:center;display:none">
								<span style="color:black;">
									<b><?php echo $s['business_name']; ?></b><br/>
												<?php
												if ($s['address1']!='') {
													echo $s['address1'].'<br/>';			
												}
												if ($s['address2']!='') {
													echo $s['address2'].'<br/>';			
												}
												if ($s['address3']!='') {
													echo $s['address3'].'<br/>';			
												} ?>
												<div style="height:5px;"></div>
												<?php
												if ($s['phone1']!='') {
													echo $s['phone1'].'<br/>';			
												}
												if ($s['phone2']!='') {
													echo $s['phone2'].'<br/>';			
												} ?>
												<div style="height:5px;"></div>
												
												<?php
												if ($s['website']!='') {
													echo $s['website'].'<br/>';			
												} ?>
												
												
								</span>
								</div>
								
								<div style="margin:9px;">
								<span style="color:black;">
												
												<p style="font-size:85%;width:100%;">
												    <span style="float:left;">ID: <?php echo $ticket['Ticket']['dailyid']; ?><br/>
												    <?php echo $ticket['Type']['name']; ?><br/>
												    <?php if ($ticket['Type']['use_tables']=='1') { ?> 
												    Table: <?php echo $ticket['Ticket']['table']; ?><br/>
												    <?php } ?>
												    Server: <?php echo $ticket['User']['username']; ?>
												    </span>
												    <span style="float:right;text-align:right;">
																<?php echo date("m-d-Y",strtotime($ticket['Ticket']['created'])); ?><br/>
																<?php echo date("g:i a",strtotime($ticket['Ticket']['created'])); ?>
												    </span>
												</p>
												
								<?php if ($ticket['Type']['use_seats']=='1') { ?>
								
												<?php foreach ($seats as $ss) { ?>
												<table style="font-size:85%;">
												    <tr>
													<th>Seat <?php echo $ss['seat']; ?>
													    <?php if ($ss['orig_seat']!='0' && $ss['orig_seat']!=$ss['seat']) {
														echo '(Originally Seat '.$ss['orig_seat'].')';
													    } ?>
													    <!--<span style="float:right;">$<?php //echo $ss['total']?></span>-->
													</th>
												    </tr>
												    <?php foreach ($ss['item'] as $data) { ?>
												    <tr>
													<td>
													<span style="float:left;"><?php echo key($data); ?></span><span style="float:right;">$<?php echo $data[key($data)]['price']; ?></span>
													<br/>
													<p style="font-size:70%">
													<?php
													    $sstr = '';
													    foreach ($data[key($data)]['mods'] as $m) { 
														$sstr = $sstr.$m.', '; 
													    }
													    echo rtrim($sstr,', ');
													    ?>
													</p>
													</td>
												    </tr>
												    <?php } ?>
												</table>
												<div style="text-align:right;margin-right:5px;font-size:85%;">
												Seat <?php echo $ss['seat']; ?> Total: $<?php echo $ss['total']; ?>
												</div>
												
												<?php } ?>
				
								<?php } else { ?>
												<?php foreach ($seats as $ss) { ?>
												<table style="font-size:85%;">
												    <tr>
													<th>Order</th>
												    </tr>
												    <?php foreach ($ss['item'] as $data) { ?>
												    <tr>
													<td>
													<span style="float:left;"><?php echo key($data); ?></span><span style="float:right;">$<?php echo $data[key($data)]['price']; ?></span>
													<br/>
													<p style="font-size:70%">
													<?php
													    $sstr = '';
													    foreach ($data[key($data)]['mods'] as $m) { 
														$sstr = $sstr.$m.', '; 
													    }
													    echo rtrim($sstr,', ');
													    ?>
													</p>
													</td>
												    </tr>
												    <?php } ?>
												</table>
												
												<?php } ?>
												
								<?php } ?>
								<br/>
												
										<p style="font-size:85%;width:100%;">
												    <span style="float:left;margin-left:100px;">Subtotal: <br/>
												    Tax (<?php echo trim(rtrim($s['tax'],'0'),'0'); ?>%):<br/>
												    Total:<br/>
												    </span>
												    <span style="float:right;">
																$<?php echo $total; ?><br/>
																$<?php echo $tax; ?><br/>
																$<?php echo $ntotal; ?>
												    </span>	    
										</p>
										
										<br/><br/><br/>		    
								                <div id="receipt">
										</div>
										<br/>
								
								</span>				
								</div>
				</div>
	</div>
        
<br/>

</div>

</td></tr></table>
</div>
<?php /*-----------------------print view */?>
		<div style="width:253px;margin:0px;" id="printable">
						<div style="text-align:center;">
								<span style="color:black;">
									<br/>
									<b><?php echo $s['business_name']; ?></b><br/>
												<?php
												if ($s['address1']!='') {
													echo $s['address1'].'<br/>';			
												}
												if ($s['address2']!='') {
													echo $s['address2'].'<br/>';			
												}
												if ($s['address3']!='') {
													echo $s['address3'].'<br/>';			
												} ?>
												<div style="height:5px;"></div>
												<?php
												if ($s['phone1']!='') {
													echo $s['phone1'].'<br/>';			
												}
												if ($s['phone2']!='') {
													echo $s['phone2'].'<br/>';			
												} ?>
												<div style="height:5px;"></div>
												
												<?php
												if ($s['website']!='') {
													echo $s['website'].'<br/>';			
												} ?><br/>
												
												
								</span>
						</div>
								
						<div style="margin:0px;">
								<span style="color:black;">
												
												<p style="font-size:85%;width:100%;margin-left:0px;">
												    <span style="float:left;">ID: <?php echo $ticket['Ticket']['dailyid']; ?><br/>
												    <?php echo $ticket['Type']['name']; ?><br/>
												    <?php if ($ticket['Type']['use_tables']=='1') { ?> 
												    Table: <?php echo $ticket['Ticket']['table']; ?><br/>
												    <?php } ?>
												    Server: <?php echo $ticket['User']['username']; ?>
												    </span>
												    <span style="float:right;text-align:right;">
																<?php echo date("m-d-Y",strtotime($ticket['Ticket']['created'])); ?><br/>
																<?php echo date("g:i a",strtotime($ticket['Ticket']['created'])); ?>
												    </span>
												</p>
												
								<?php if ($ticket['Type']['use_seats']=='1') { ?>
								
												<?php foreach ($seats as $ss) { ?>
												<table style="font-size:85%;margin:0px;">
												    <tr>
													<th>Seat <?php echo $ss['seat']; ?>
													    <?php if ($ss['orig_seat']!='0' && $ss['orig_seat']!=$ss['seat']) {
														echo '(Originally Seat '.$ss['orig_seat'].')';
													    } ?>
													    <!--<span style="float:right;">$<?php //echo $ss['total']?></span>-->
													</th>
												    </tr>
												    <?php foreach ($ss['item'] as $data) { ?>
												    <tr>
													<td>
													<span style="float:left;"><?php echo key($data); ?></span><span style="float:right;">$<?php echo $data[key($data)]['price']; ?></span>
													<br/>
													<p style="font-size:70%">
													<?php
													    $sstr = '';
													    foreach ($data[key($data)]['mods'] as $m) { 
														$sstr = $sstr.$m.', '; 
													    }
													    echo rtrim($sstr,', ');
													    ?>
													</p>
													</td>
												    </tr>
												    <?php } ?>
												</table>
												<div style="text-align:right;margin-right:5px;font-size:85%;">
												Seat <?php echo $ss['seat']; ?> Total: $<?php echo $ss['total']; ?>
												</div>
												
												<?php } ?>
				
								<?php } else { ?>
												<?php foreach ($seats as $ss) { ?>
												<table style="font-size:85%;margin:0px;">
												    <tr>
													<th>Order</th>
												    </tr>
												    <?php foreach ($ss['item'] as $data) { ?>
												    <tr>
													<td>
													<span style="float:left;"><?php echo key($data); ?></span><span style="float:right;">$<?php echo $data[key($data)]['price']; ?></span>
													<br/>
													<p style="font-size:70%">
													<?php
													    $sstr = '';
													    foreach ($data[key($data)]['mods'] as $m) { 
														$sstr = $sstr.$m.', '; 
													    }
													    echo rtrim($sstr,', ');
													    ?>
													</p>
													</td>
												    </tr>
												    <?php } ?>
												</table>
												
												<?php } ?>
												
								<?php } ?>
								<br/>
												
										<p style="font-size:85%;width:100%;">
												    <span style="float:left;margin-left:50px;">Subtotal: <br/>
												    Tax (<?php echo trim(rtrim($s['tax'],'0'),'0'); ?>%):<br/>
												    Total:<br/>
												    </span>
												    <span style="float:right;">
																$<?php echo $total; ?><br/>
																$<?php echo $tax; ?><br/>
																$<?php echo $ntotal; ?>
												    </span>	    
										</p>
										
										<br/><br/><br/>		    
								                <div id="receipt">
										</div>
										<br/>
										
										<div id="gimme" style="text-align:center;">
											<div style="border:0px solid black;text-align:center;">
												<p><?php echo $s['gimme_text']; ?></p>
												<?php echo $this->Qrcode->url($url); ?>
											</div>
											<br/>
										</div>
								
								</span>				
						</div>
		</div>