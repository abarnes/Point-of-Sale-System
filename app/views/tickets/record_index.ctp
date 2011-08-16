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
                                                                    document.forms["TicketRecordIndexForm"].submit(); 
                                                            }
                                                    }
                                            });
                                        });
</script>

<script type="text/javascript">
$(document).ready(function(){	
	$('#all').fadeIn(600);
});
</script>
<div id="all" style="display:none">

<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<h3>Records</h3>

<div class="link">
<?php echo $html->link('<< Admin Panel',array('controller'=>'pages','action'=>'admin')); ?><br/><br/>
</div>

<a style="float:left;margin-bottom:8px;margin-right:5px;" href="#" onclick="openadd()"><input type="button" class="submits" value="Filter"></a>

<div id="filter" title="Filter Records">
    <script>
	$(function() {
		$( "#TicketDate" ).datepicker();
	});
    </script>
    <?php echo $form->create('Ticket', array('action' => 'record_index')); ?>
    <?php echo $form->input('dailyid', array( 'label' => 'ID: ')); ?>
    <?php echo $form->input('date', array( 'label' => 'Date: ')); ?>
    <?php echo $form->input('table', array( 'label' => 'Table: ')); ?>
    <?php echo $form->input('server', array( 'label' => 'Server: ')); ?>
</div>

<p>Click a column title to sort the table.  You can limit the results using the filter button.</p>

<table>
    <tr>
	<th>
	    <?php echo $this->Paginator->sort('Date', 'Ticket.created'); ?>
	</th>
        <th>
            <?php echo $this->Paginator->sort('ID', 'Ticket.dailyid'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Table', 'Ticket.table'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Status', 'Ticket.status'); ?>
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach ($tickets as $u) { ?>
    <tr>
	<td>
	    <?php echo date('m-d-Y g:i a',strtotime($u['Ticket']['created'])); ?>
	</td>
        <td>
            <?php echo $u['Ticket']['dailyid']; ?>
        </td>
	<td>
            <?php echo $u['Ticket']['table']; ?>
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
            <?php echo $html->link('View',array('action'=>'record_view/'.$u['Ticket']['id'])); ?>
            <?php echo $html->link(
				'Delete', 
				array('controller'=>'tickets','action'=>'record_delete/'.$u['Ticket']['id']), 
				null, 
				'Are You Sure You Want To Delete This Ticket Record?'
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

</div>