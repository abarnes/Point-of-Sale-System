<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<script type="text/javascript">  
                                function openadd() {
				    $('#filter').dialog('open');
				}
</script>
<script type="text/javascript">
                        $(function(){
                                        // Dialog
                                            $('#filter').dialog({
                                                    autoOpen: false,
                                                    width: 600,
                                                    buttons: {
                                                            "Submit": function() { 
                                                                    document.forms["ClockReport/<?php echo $user['User']['id'].'/'.$red; ?>Form"].submit(); 
                                                            }
                                                    }
                                            });
                                        });
</script>

<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<h3><?php echo $user['User']['full_name']; ?> - <?php echo date('n-j-Y'); ?></h3>

<div class="link">
<?php echo $html->link('<< Menu',array('controller'=>'pages','action'=>'menu')); ?>
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
									<b>Total Time Worked</b>			
								</td>
								<td>
									<?php echo $total_time; ?>			
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Labor Cost</b>
								</td>
								<td>
									$<?php echo $total_cost; ?>
								</td>
				</tr>
</table>


<h4>Shifts</h4>
<table>
    <tr>
        <th>
            <?php echo $this->Paginator->sort('Date', 'Clock.in'); ?>
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
            <?php echo date('n-j-Y',strtotime($u['Clock']['in'])); ?>
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
            <?php echo $html->link(
				'Delete', 
				array('controller'=>'clocks','action'=>'delete/'.$u['Clock']['id'].'/'.$u['Clock']['user_id']), 
				null, 
				'Are You Sure You Want To Delete This?'
			); ?>
        </td>
    </tr>
    <?php } ?>
</table>
<script type="text/javascript">  
				function opend(id) {
				    $('#dialog'+id).dialog('open');
				}
</script>

<div class="link" style="text-align:center;width:100%;">
    <!-- Shows the page numbers -->
    <?php echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next('Next >>', null, null, array('class' => 'disabled')); ?>
    <br/>
    <!-- prints X of Y, where X is current page and Y is number of pages -->
    <?php echo $this->Paginator->counter(); ?>
</div>