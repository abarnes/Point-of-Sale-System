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
                                                                    document.forms["PaymentIndexForm"].submit(); 
                                                            }
                                                    }
                                            });
                                        });
</script>

<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<h3>Transactions - <?php echo $start.' to '.$end; ?></h3>
<p>Search payment records for payments processed on previous days (before midnight last night).  Filter results using the "Filter" button.</p>
<br/>
<div class="link">
<?php echo $html->link('<< Admin Panel',array('controller'=>'pages','action'=>'admin')); ?><br/><br/>
</div>

<div class="link">
<?php /* if ($red=='1') {				
				echo $html->link('<< Users',array('controller'=>'users','action'=>'index'));
} elseif ($red=='2') {
				echo $html->link('<< Daily Statistics',array('controller'=>'clocks','action'=>'index/all'));
} else {
				echo $html->link('<< Shifts',array('controller'=>'clocks','action'=>'report_all'));
}*/ ?>
</div>

<a style="float:left;margin-bottom:8px;margin-right:5px;" href="#" onclick="openadd()"><input type="button" class="submits" value="Filter"></a>

<div id="filter" title="Filter Records">
    <script>
	$(function() {
		$( "#PaymentStartdate" ).datepicker();
		$( "#PaymentEnddate" ).datepicker();
	});
    </script>
    <?php echo $form->create('Payment', array('action' => 'index')); ?>
    <?php echo $form->input('ticket_type', array( 'label' => 'Ticket Type: ','value'=>$ttype,'options'=>$types)); ?>
    <?php echo $form->input('method', array( 'label' => 'Payment Method: ','value'=>$mthd,'options'=>array('any'=>'any','cash'=>'cash','credit'=>'credit','check'=>'check'))); ?>
    <?php echo $form->input('startdate', array( 'label' => 'Start Date: ','value'=>$start)); ?>
    <?php echo $form->input('enddate', array( 'label' => 'End Date: ','value'=>$end)); ?>
</div>

<p>Filter results by using the "Filter" button.</p>


<table style="width:45%;">
				<tr>
								<td>
									<b>Total Amount</b>
								</td>
								<td>
									$<?php echo $data['total']; ?>
								</td>
				</tr>
				<tr>
								<td>
									<b>Number of Payments</b>
								</td>
								<td>
									<?php echo count($payments); ?>
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Cash</b>			
								</td>
								<td>
									$<?php echo $data['cash']; ?>			
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Credit</b>			
								</td>
								<td>
									$<?php echo $data['credit']; ?>			
								</td>
				</tr>
				<tr>
								<td>
									<b>Total Check</b>			
								</td>
								<td>
									$<?php echo $data['check']; ?>			
								</td>
				</tr>
</table>


<h4>Transactions</h4>
<table>
    <tr>
        <th>
            <?php echo $this->Paginator->sort('Time & Date', 'Ticket.created'); ?>
        </th>
        <th>
           <?php echo $this->Paginator->sort('Type', 'Payment.type'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Amount', 'Payment.amount'); ?>
        </th>
	<th>
            <?php echo $this->Paginator->sort('Processed By', 'User.full_name'); ?>		
	</th>
	<th>
		Actions		
	</th>
    </tr>
    <?php foreach ($payments as $u) { ?>
    <tr>
        <td>
            <?php echo date('g:i a n-j-Y',strtotime($u['Ticket']['created'])); ?>
        </td>
        <td>
            <?php echo $u['Payment']['type']; ?>
        </td>
        <td>
            <?php echo '$'.$u['Payment']['amount']; ?>
        </td>
	<td>
            <?php echo $u['User']['full_name']; ?>
        </td>
        <td>
            <script type="text/javascript">
		$(function(){
                                // Dialog
				
				    $('#dialog<?php echo $u['Payment']['id']; ?>').dialog({
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
	    
	    <a href="#" onclick="opend(<?php echo $u['Payment']['id']; ?>)">Payment Details</a>
	    <!--this div is what comes up when you click "view"-->
		<div id="dialog<?php echo $u['Payment']['id']; ?>" title="Payment Details">
		    <table>
                        <tr>
			    <td><b>Ticket ID</b></td>
			    <td><?php echo $u['Ticket']['dailyid']; ?></td>
			</tr>
			<?php if ($u['Ticket']['table']!='' && $u['Ticket']['table']!='0') { ?>
			<tr>
			    <td><b>Table</b></td>
			    <td><?php echo $u['Ticket']['table']; ?></td>
			</tr>
			<?php } ?>
			<tr>
			    <td><b>Ticket Created</b></td>
			    <td><?php echo date('g:i a n-j-Y',strtotime($u['Ticket']['created'])); ?></td>
			</tr>
			<tr>
			    <td><b>Payment Processed</b></td>
			    <td><?php echo date('g:i a n-j-Y',strtotime($u['Payment']['created'])); ?></td>
			</tr>
			<tr>
			    <td><b>Payment Method</b></td>
			    <td><?php echo $u['Payment']['type']; ?></td>
			</tr>
			<tr>
			    <td><b>Amount</b></td>
			    <td><?php echo '$'.$u['Payment']['amount']; ?></td>
			</tr>
			<?php if ($u['Payment']['type']=='credit') { ?>
			<tr>
			    <td><b>Tip</b></td>
			    <td><?php echo '$'.$u['Payment']['tip']; ?></td>
			</tr>
			<?php } ?>
			<tr>
			    <td><b>Processed By</b></td>
			    <td><?php echo $u['User']['full_name']; ?></td>
			</tr>

		    </table>
		</div>
            <?php echo $html->link('View Ticket',array('controller'=>'tickets','action'=>'record_view/'.$u['Payment']['ticket_id'].'/payments')); ?>
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