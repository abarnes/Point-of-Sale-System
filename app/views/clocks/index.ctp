<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<script type="text/javascript">  
				function opend(id) {
				    $('#dialog'+id).dialog('open');
				}
    </script>
<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>

<h3>Daily Statistics - 
<?php if ($all=='0') { ?>
				Currently Clocked In Employees
<?php }else{ ?>
				All Shifts Today
<?php } ?>
</h3>
<p>View Clocked-In users and manage work time.</p><br/>

<div class="link">
<?php echo $html->link('<< Admin Panel',array('controller'=>'pages','action'=>'admin')); ?>
<?php if ($all=='0') { ?>
				<a href="/clocks/index/all" style="margin-left:15px;">View All Hours Today</a>
<?php }else{ ?>
				<a href="/clocks/index" style="margin-left:15px;">View Only Currently Clocked In Employees</a>
<?php } ?>
<!--<a href="#" onclick="openadd()" style="margin-left:15px;">Add User</a>-->				
<br/><br/>
</div>

<div class="link">
<?php //echo $html->link('Clock In',array('controller'=>'clocks','action'=>'in')); ?>
<?php //echo $html->link('Clock Out',array('controller'=>'clocks','action'=>'out')); ?>
</div>

<table style="width:45%;">
				<tr>
								<td>
									<b>Number of Tickets</b>
								</td>
								<td>
									<?php echo $ti; ?> (<?php echo $co; ?> Customers)
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Sales</b>
								</td>
								<td>
									$<?php echo $ts; ?>
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Hours Worked</b>			
								</td>
								<td>
									<?php echo $tt; ?>			
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Labor Cost</b>
								</td>
								<td>
									$<?php echo $tc; ?>
								</td>
				</tr>
</table>


<h4>Shifts</h4>
<table>
    <tr>
        <th>
            <?php echo $this->Paginator->sort('Name', 'User.last_name'); ?>
        </th>
        <th>
           <?php //echo $this->Paginator->sort('Time Clocked In', 'Clock.time'); ?>
	   Time Clocked In
        </th>
        <th>
            <?php //echo $this->Paginator->sort('Cost', 'Clock.cst'); ?>
	    Cost
        </th>
	<th>
	</th>
    </tr>
    <?php foreach ($clocks as $u) { ?>
    <tr>
        <td>
            <?php echo $html->link($u['User']['last_name'].', '.$u['User']['first_name'],array('action'=>'report/'.$u['User']['id'].'/2')); ?>
        </td>
        <td>
            <?php echo $u['Clock']['time']; ?>
        </td>
        <td>
            <?php echo '$'.$u['Clock']['cst']; ?>
        </td>
        <td>
            <script type="text/javascript">
		$(function(){
                                // Dialog
				
				    $('#dialog<?php echo $u['Clock']['id']; ?>').dialog({
					    autoOpen: false,
					    width: 600,
					    buttons: {
						    "Close": function() { 
							    $(this).dialog("close"); 
						    }
					    }
				    });
				});
	    </script>
	    
	    <a href="#" onclick="opend(<?php echo $u['Clock']['id']; ?>)">View</a>
	    <!--this div is what comes up when you click "view"-->
		<div id="dialog<?php echo $u['Clock']['id']; ?>" title="Shift Details">
		    <table>
			<tr>
			    <td><b>Name</b></td>
			    <td><?php echo $u['User']['last_name'].', '.$u['User']['first_name']; ?></td>
			</tr>
			<tr>
			    <td><b>Time</b></td>
			    <td><?php echo $u['Clock']['time']; ?></td>
			</tr>
			<tr>
			    <td><b>Time In</b></td>
			    <td><?php echo date('g:i a n-j-Y',strtotime($u['Clock']['in'])); ?></td>
			</tr>
			<?php if ($u['Clock']['complete']=='1') { ?>
			<tr>
			    <td><b>Time Out</b></td>
			    <td><?php echo date('g:i a n-j-Y',strtotime($u['Clock']['out'])); ?></td>
			</tr>
			<?php } ?>
			<tr>
			    <td><b>Rate</b></td>
			    <td>$<?php echo $u['Clock']['rate']; ?></td>
			</tr>
			<tr>
			    <td><b>Cost</b></td>
			    <td>$<?php echo $u['Clock']['cst']; ?></td>
			</tr>
		    </table>
		</div>
            <?php echo $html->link('Clock Out',array('controller'=>'clocks','action'=>'out/'.$u['User']['id'].'/h')); ?>
            <?php echo $html->link(
				'Delete', 
				array('controller'=>'clocks','action'=>'delete/'.$u['Clock']['id']), 
				null, 
				'Are You Sure You Want To Delete This?'
			); ?>
        </td>
    </tr>
    <?php } ?>
</table>
<div class="link" style="text-align:center;width:100%;">
    <!-- Shows the page numbers -->
    <?php echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next('Next >>', null, null, array('class' => 'disabled')); ?>
    <br/>
    <!-- prints X of Y, where X is current page and Y is number of pages -->
    <?php echo $this->Paginator->counter(); ?>
</div>