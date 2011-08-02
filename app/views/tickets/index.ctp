<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
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
            <?php echo $u['Ticket']['table']; ?>
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
	    <?php if ($en != 'Paid' && $en !='Void') { ?>
		<?php echo $html->link('Pay',array('controller'=>'payments','action'=>'pay/'.$u['Ticket']['id'])); ?>
	    <?php } ?>
            <?php echo $html->link('View',array('action'=>'view/'.$u['Ticket']['id'])); ?>
            <?php echo $html->link('Edit',array('controller'=>'seats','action'=>'edit/'.$u['Ticket']['id'])); ?>
	    <?php
	    if (count($u['Seat'])>1) {
		echo $html->link('Split',array('action'=>'split/'.$u['Ticket']['id']));
	    }
	    ?>
	    <?php
	    if ($all=='0') {
		echo $html->link(
				    'Delete', 
				    array('controller'=>'tickets','action'=>'delete/'.$u['Ticket']['id'].'/0'), 
				    null, 
				    'Are You Sure You Want To Delete This Ticket?'
			    );
	     } else {
		echo $html->link(
				'Delete', 
				array('controller'=>'tickets','action'=>'delete/'.$u['Ticket']['id'].'/1'), 
				null, 
				'Are You Sure You Want To Delete This Ticket?'
			);
	    }    
	    ?>
        </td>
    </tr>
    <?php } ?>
</table>

<?php echo $form->end('Combine Tickets'); ?>
<div class="link" style="text-align:center;width:100%;">
    <!-- Shows the page numbers -->
    <?php echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>
    <?php echo $this->Paginator->next('Next >>', null, null, array('class' => 'disabled')); ?>
    <br/>
    <!-- prints X of Y, where X is current page and Y is number of pages -->
    <?php echo $this->Paginator->counter(); ?>
</div>