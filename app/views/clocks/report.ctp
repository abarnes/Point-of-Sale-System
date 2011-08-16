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
                                                                    document.forms["PaymentReportForm"].submit(); 
                                                            }
                                                    }
                                            });
                                        });
</script>

<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<h3><?php echo $user['User']['full_name']; ?> - <?php echo $start.' to '.$end; ?></h3>

<div class="link">
<?php if ($red=='1') {				
				echo $html->link('<< Users',array('controller'=>'users','action'=>'index'));
} elseif ($red=='2') {
				echo $html->link('<< Daily Statistics',array('controller'=>'clocks','action'=>'index/all'));
} else {
				echo $html->link('<< Shifts',array('controller'=>'clocks','action'=>'report_all'));
}?>
<br/><br/>
</div>

<a style="float:left;margin-bottom:8px;margin-right:5px;" href="#" onclick="openadd()"><input type="button" class="submits" value="Filter"></a>

<div id="filter" title="Filter Records">
    <script>
	$(function() {
		$( "#ClockStartdate" ).datepicker();
		$( "#ClockEnddate" ).datepicker();
	});
    </script>
    <?php echo $form->create('Clock', array('action' => 'report/'. $user['User']['id'].'/'.$red)); ?>
    <?php echo $form->input('startdate', array( 'label' => 'Start Date: ','value'=>$start)); ?>
    <?php echo $form->input('enddate', array( 'label' => 'End Date: ','value'=>$end)); ?>
</div>

<p>Filter results by using the "Filter" button.</p>


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
			<tr>
			    <td><b>Total Tips</b></td>
			    <td>$<?php echo $u['Clock']['tips']; ?></td>
			</tr>
		    </table>
		</div>
            <?php echo $html->link(
				'Delete', 
				array('controller'=>'clocks','action'=>'record_delete/'.$u['Clock']['id'].'/'.$u['Clock']['user_id']), 
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