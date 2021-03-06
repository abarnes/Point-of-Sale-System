<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<script type="text/javascript">
$(document).ready(function(){	
	$('#all').fadeIn(600);
});
</script>
<div id="all" style="display:none">
				
<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<script type="text/javascript">  
				function opend(id) {
				    $('#dialog'+id).dialog('open');
				}
                                
                                function openadd() {
				    $('#add').dialog('open');
				}
    </script>
    <script type="text/javascript">
                        $(function(){
                                        // Dialog
                                            $('#add').dialog({
                                                    autoOpen: false,
                                                    width: 600,
                                                    buttons: {
                                                            //"Ok": function() { 
                                                            //        $(this).dialog("close"); 
                                                            //}
                                                    }
                                            });
                                        });
    </script>

<br/>
<h3>Manage Order Types</h3>
<p>To help organize orders, you can separate them by type, such as Dine-in, Carry-out, and Drive-thru.  You can customize them however you like, but you must have at least one type.</p><br/>

<div class="link">
<?php echo $html->link('<< Admin Panel',array('controller'=>'pages','action'=>'admin')); ?><a href="#" onclick="openadd()" style="margin-left:15px;">Add Order Type</a>				
<br/><br/>
</div>

<div id="add" title="Add Order Type">
        <p>The "Use Seats" option allows you to split an order up into various seats, which can help keep food organized by person.  It may not be necessary for carry-out and drive-thru orders, etc.  You can disable an order type without deleting it by unchecking the "Enable" box.</p>
        <br/>
        
        <table style="border:0px solid black;margin-right:auto;margin-left:50px;width:500px;">
    
        <?php echo $form->create('Type', array('action' => 'setup')); ?>
        <tr><td style="text-align:right;font-size:80%;">Name: </td><td><?php echo $form->input('name', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Enable: </td><td><?php echo $form->input('enable', array( 'label' => '','checked'=>true)); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Use Seats: </td><td><?php echo $form->input('use_seats', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Use Tables: </td><td><?php echo $form->input('use_tables', array( 'label' => '')); ?></td></tr>
        <tr><td></td><td>
        <?php echo $form->end('Add Order Type'); ?>
        <br/>
        </td></tr></table>
    </div>

<table>
    <tr>
        <th>
            <?php echo $this->Paginator->sort('Name', 'Type.name'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Enabled', 'Type.enable'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Use Seats', 'Type.use_seats'); ?>
        </th>
	<th>
            <?php echo $this->Paginator->sort('Use Tables', 'Type.use_tables'); ?>
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach ($types as $u) { ?>
    <tr>
        <td>
            <?php echo $u['Type']['name']; ?>
        </td>
        <td>
            <?php
            switch ($u['Type']['enable']) {
                case 1:
                    $en = 'yes';
                    break;
                case 0:
                    $en = 'no';
                    break;
                default:
                    $en = 'no';
                    break;
            }
            echo $en; ?>
        </td>
        <td>
            <?php
            switch ($u['Type']['use_seats']) {
                case 1:
                    $ef = 'yes';
                    break;
                case 0:
                    $ef = 'no';
                    break;
                default:
                    $ef = 'no';
                    break;
            }
            echo $ef; ?>
        </td>
	<td>
            <?php
            switch ($u['Type']['use_tables']) {
                case 1:
                    $ef = 'yes';
                    break;
                case 0:
                    $ef = 'no';
                    break;
                default:
                    $ef = 'no';
                    break;
            }
            echo $ef; ?>
        </td>
        <td>
	    <script type="text/javascript">
		$(function(){
                                // Dialog
				
				    $('#dialog<?php echo $u['Type']['id']; ?>').dialog({
					    autoOpen: false,
					    width: 600,
					    buttons: {
						    "Ok": function() { 
							    $(this).dialog("close"); 
						    }
					    }
				    });
				});
	    </script>
	    
	    <?php echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="View" onclick="opend('.$u['Type']['id'].')">'; ?>
	    <!--this div is what comes up when you click "view"-->
		<div id="dialog<?php echo $u['Type']['id']; ?>" title="<?php echo $u['Type']['name']; ?>">
		    <table>
			<tr>
			    <td><b>Name</b></td>
			    <td><?php echo $u['Type']['name']; ?></td>
			</tr>
			<tr>
			    <td><b>Use Seats</b></td>
			    <td><?php if ($u['Type']['use_seats']==1) {
				echo 'yes';
			    } else {
				echo 'no';
			    } ?>
			    </td>
			</tr>
			<tr>
			    <td><b>Use Tables</b></td>
			    <td><?php if ($u['Type']['use_tables']==1) {
				echo 'yes';
			    } else {
				echo 'no';
			    } ?>
			    </td>
			</tr>
			<tr>
			    <td><b>Enabled</b></td>
			    <td><?php if ($u['Type']['enable']==1) {
				echo 'yes';
			    } else {
				echo 'no';
			    } ?>
			    </td>
			</tr>
		    </table>
		</div>
		<SCRIPT type="text/javascript">
				function decision(url){
				    if(confirm('Deleting this ticket type may corrupt existing tickets and records of this type.  It is recommended that you uncheck "enable" rather than delete this ticket type, unless it was created in error.  Are you sure you want to delete this ticket type?')) location.href = url;
				}
				</SCRIPT>
		<?php
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Edit" onclick="parent.location=\'/types/edit/'.$u['Type']['id'].'\'">';
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Delete" onclick="decision(\'/types/delete/'.$u['Type']['id'].'\')">';
		?>
		
            <?php //echo $html->link('Edit',array('action'=>'edit/'.$u['Type']['id'])); ?>
            <?php /*echo $html->link(
				'Delete', 
				array('controller'=>'types','action'=>'delete/'.$u['Type']['id']), 
				null, 
				'Are You Sure You Want To Delete This Ticket Type?'
			);*/ ?>
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