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
function decision(url){
    if(confirm('Are you sure you want to delete this ticket?')) location.href = url;
}
function voi(url){
    if(confirm('Are you sure you want to void this ticket?')) location.href = url;
}
function uvoi(url){
    if(confirm('Are you sure you want to revert this ticket\'s status to submitted?')) location.href = url;
}
$(document).ready(function(){	
	$('#all').fadeIn(400);
});
</script>
<div id="all" style="display:none;">

<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<h3>Tickets</h3>
<div class="link">
<?php
    if ($all=='0') {
	echo $html->link('View All Tickets',array('controller'=>'tickets','action'=>'index/all'));
    } else {
	echo $html->link('View My Open Tickets',array('controller'=>'tickets','action'=>'index'));
    }
?><br/><br/>
</div>

<table>
    <tr>
	<th>
	</th>
        <th>
            <?php echo $this->Paginator->sort('ID', 'Ticket.dailyid'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Table', 'Ticket.table'); ?>
        </th>
	<th>
            <?php echo $this->Paginator->sort('Server', 'User.full_name'); ?>
        </th>
	<th>
            <?php echo $this->Paginator->sort('Type', 'Type.name'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Status', 'Ticket.status'); ?>
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php echo $form->create("Ticket",array('url' => '/tickets/combine')); ?>
    <?php foreach ($tickets as $u) { ?>
    <tr>
	<td>
	    <?php echo $form->checkbox($u['Ticket']['id'], array('type' => 'checkbox','label'=>'')); ?>
	</td>
        <td>
            <?php echo $u['Ticket']['dailyid']; ?>
        </td>
	<td>
            <?php
	    if ($u['Ticket']['table']=='') {
		echo '-';
	    } else {
		echo $u['Ticket']['table'];
	    }
	    ?>
        </td>
	<td>
            <?php echo $u['User']['full_name']; ?>
        </td>
	<td>
            <?php echo $u['Type']['name']; ?>
        </td>
        <td>
            <?php
            switch ($u['Ticket']['status']) {
                case 0:
                    $en = 'Submitted';
                    break;
                case 1:
                    $en = 'Prepared';
                    break;
		case 2:
                    $en = 'Paid';
                    break;
		case 3:
                    $en = 'Void';
                    break;
		case 4:
                    $en = 'Exception';
                    break;
                default:
                    $en = 'no';
                    break;
            }
            echo $en; ?>
        </td>
        <td>
	<?php if ($admin==true) {
	    echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="View" onclick="parent.location=\'/tickets/view/'.$u['Ticket']['id'].'\'">';
	    //echo $html->link('View',array('action'=>'view/'.$u['Ticket']['id']));
	    if ($en != 'Paid' && $en !='Void') {
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Pay" onclick="parent.location=\'/payments/pay/'.$u['Ticket']['id'].'\'">';
		if (count($u['Seat'])>1) {
		    echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Split" onclick="parent.location=\'/tickets/split/'.$u['Ticket']['id'].'\'">';
		    //echo $html->link('Split',array('action'=>'split/'.$u['Ticket']['id']));
		}
		//echo $html->link('Pay',array('controller'=>'payments','action'=>'pay/'.$u['Ticket']['id']));
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Edit" onclick="parent.location=\'/seats/edit/'.$u['Ticket']['id'].'\'">';
		//echo $html->link('Edit',array('controller'=>'seats','action'=>'edit/'.$u['Ticket']['id'])); 
	    }
	    echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Status" onclick="opend('.$u['Ticket']['id'].')">';
	} else {
	    echo $html->link('View',array('action'=>'view/'.$u['Ticket']['id']));
	    if ($en != 'Paid' && $en !='Void') {
		echo $html->link('Pay',array('controller'=>'payments','action'=>'pay/'.$u['Ticket']['id']));
		echo $html->link('Edit',array('controller'=>'seats','action'=>'edit/'.$u['Ticket']['id']));
	    }
	    if (count($u['Seat'])>1) {
		echo $html->link('Split',array('action'=>'split/'.$u['Ticket']['id']));
	    }
	} ?>
	<script type="text/javascript">
		$(function(){
                                // Dialog
				
				    $('#dialog<?php echo $u['Ticket']['id']; ?>').dialog({
					    autoOpen: false,
					    width: 370,
					    buttons: {
						    "Ok": function() { 
							    $(this).dialog("close"); 
						    }
					    }
				    });
				});
	</script>
	<div id="dialog<?php echo $u['Ticket']['id']; ?>" title="Change Ticket Status - <?php echo $u['Ticket']['dailyid']; ?>">
	    <?php if ($all=='0') {
		if ($u['Ticket']['status']!='3') {
		    echo '<input style="width:150px;height:80px;font-size:1em;margin:0px 20px 0px 0px;" type="button" class="submits" value="Void" onclick="voi(\'/tickets/void/'.$u['Ticket']['id'].'/0\')"/>';
		} else {
		    echo '<input style="width:150px;height:80px;font-size:1em;margin:0px 20px 0px 0px;" type="button" class="submits" value="Undo Void" onclick="uvoi(\'/tickets/uvoid/'.$u['Ticket']['id'].'/0\')"/>';
		}
		echo '<input style="width:150px;height:80px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Delete" onclick="decision(\'/tickets/delete/'.$u['Ticket']['id'].'/0\')">';
		/*echo $html->link(
				    'Delete', 
				    array('controller'=>'tickets','action'=>'delete/'.$u['Ticket']['id'].'/0'), 
				    null, 
				    'Are You Sure You Want To Delete This Ticket?'
			    );*/
	     } else {
		if ($u['Ticket']['status']!='3') {
		    echo '<input style="width:150px;height:80px;font-size:1em;margin:0px 20px 0px 0px;" type="button" class="submits" value="Void" onclick="voi(\'/tickets/void/'.$u['Ticket']['id'].'/1\')"/>';
		} else {
		    echo '<input style="width:150px;height:80px;font-size:1em;margin:0px 20px 0px 0px;" type="button" class="submits" value="Undo Void" onclick="uvoi(\'/tickets/uvoid/'.$u['Ticket']['id'].'/1\')"/>';
		}
		echo '<input style="width:150px;height:80px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Delete" onclick="decision(\'/tickets/delete/'.$u['Ticket']['id'].'/1\')">';
		/*echo $html->link(
				'Delete', 
				array('controller'=>'tickets','action'=>'delete/'.$u['Ticket']['id'].'/1'), 
				null, 
				'Are You Sure You Want To Delete This Ticket?'
			);*/
	    } ?>
	</div>
        </td>
    </tr>
    <?php } ?>
</table>

<?php echo $form->end('Combine Selected Tickets'); ?>
<div class="link" style="text-align:center;width:100%;">
    <!-- Shows the page numbers -->
    <?php echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next('Next >>', null, null, array('class' => 'disabled')); ?>
    <br/>
    <!-- prints X of Y, where X is current page and Y is number of pages -->
    <?php echo $this->Paginator->counter(); ?>
</div>
<!--end all div-->
</div>