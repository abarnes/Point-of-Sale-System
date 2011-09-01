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


				<div style="background-color:white;">
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
												} ?>
												
												
								</span>
								</div>
								
								<div style="margin:9px;">
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
												
												<table style="font-size:85%;;">
												    <tr>
													<th">Seat <?php echo $ss['seat']; ?>
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
								
												
										<p style="font-size:85%;width:100%;margin-left:0px;">
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
											<?php foreach ($ticket['Payment'] as $p) { ?>
												<p style="font-size:85%;margin-left:0px;"><span style="float:left;margin-left:100px;"><?php echo ucfirst($p['type']); ?></span><span style="float:right;text-align:right;">$<?php echo $p['amount']; ?></span><br/></p>
											<?php } ?>
										</div>
										<br/>
										
										<div id="gimme">
												<?php echo $this->Qrcode->url($url); ?>
										</div>
								
								</span>				
								</div>
				</div>