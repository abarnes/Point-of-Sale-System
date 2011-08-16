<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<h3>Shift Report<br/><?php echo $user['User']['full_name']; ?> - <?php echo date('n-j-Y'); ?></h3>

<div class="link">
<?php echo $html->link('<< Menu',array('controller'=>'tickets','action'=>'menu')); ?>
<br/><br/>
</div>


<table style="width:45%;">
				<tr>
								<td>
									<b>Number of Tickets</b>
								</td>
								<td>
									<?php echo $ticket_count; ?> (<?php echo $cust_count; ?> Customers)
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Sales</b>
								</td>
								<td>
									$<?php echo $total_sales; ?> ($<?php echo $ratio; ?>/hour)
								</td>
				</tr>
				<tr>
								<td>
									<b>Time In</b>			
								</td>
								<td>
									<?php echo date('g:i a  n-j-Y',strtotime($clocks['Clock']['in'])); ?>			
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Time Worked</b>			
								</td>
								<td>
									<?php echo $clocks['Clock']['time']; ?>			
								</td>
				</tr>
				<tr>
								<td>
									<b>Rate</b>
								</td>
								<td>
									<?php echo $clocks['Clock']['rt']; ?>	
								</td>
				</tr>
				<tr>
								<td>
									<b>Credit Card Tips</b>			
								</td>
								<td>
									$<?php echo $clocks['Clock']['cctips']; ?>			
								</td>
				</tr>
</table>