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
<h3>Manage Modifiers</h3>
<p>Manage your modifiers.  These are options that can be applied to your items, such as ketchup on a hot dog.  Click a column name to sort the table.</p><br/>

<div class="link">
<?php echo $html->link('<< Admin Panel',array('controller'=>'pages','action'=>'admin')); ?><a href="#" onclick="openadd()" style="margin-left:15px;">Add Modifier</a>				
<br/><br/>
</div>

<div id="add" title="Add Option">
        <p>You can choose the items for which the option is available, and temporarily disable an option by unchecking the "Enable" box.</p><br/>
        
        <table style="border:0px solid black;margin-right:auto;margin-left:auto;">
    
        <?php echo $form->create('Modifier', array('action' => 'add')); ?>
        <tr><td style="text-align:right;font-size:80%;">Name: </td><td><?php echo $form->input('name', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Price: $</td><td><?php echo $form->input('price', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Items: </td><td><?php echo $form->input('Item', array( 'label' => '')); ?>
        <p style="font-size:80%;">Hold the control key to select multiple items (command key on a Mac)</p>
        </td></tr>
        <tr><td style="text-align:right;font-size:80%;">Description: </td><td><?php echo $form->input('description', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Enable: </td><td><?php echo $form->input('enable', array( 'label' => '','checked'=>true)); ?></td></tr>
        <tr><td></td><td>
        <?php echo $form->end('Add Modifier'); ?>
        <br/>
        </td></tr></table>
    </div>

<table>
    <tr>
        <th>
            <?php echo $this->Paginator->sort('Name', 'Modifier.name'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Enabled', 'Modifier.enable'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Price', 'Modifier.price'); ?>
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach ($modifiers as $u) { ?>
    <tr>
        <td>
            <?php echo $u['Modifier']['name']; ?>
        </td>
        <td>
            <?php
            switch ($u['Modifier']['enable']) {
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
	    <?php if ($u['Modifier']['price']>0) { ?>
		$<?php echo $u['Modifier']['price']; ?>		
	    <?php } else { ?>
		free
	    <?php } ?>
        </td>
        <td>
            <script type="text/javascript">
		$(function(){
                                // Dialog
				
				    $('#dialog<?php echo $u['Modifier']['id']; ?>').dialog({
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
	    
	   <?php echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="View" onclick="opend('.$u['Modifier']['id'].')">'; ?>
	    <!--this div is what comes up when you click "view"-->
		<div id="dialog<?php echo $u['Modifier']['id']; ?>" title="<?php echo $u['Modifier']['name']; ?>">
		    <table>
			<tr>
			    <td><b>Name</b></td>
			    <td><?php echo $u['Modifier']['name']; ?></td>
			</tr>
			<tr>
			    <td><b>Price</b></td>
			    <td><?php if ($u['Modifier']['price']>0) { ?>
				    $<?php echo $u['Modifier']['price']; ?>		
				<?php } else { ?>
				    free
				<?php } ?>
			    </td>
			</tr>
			<tr>
			    <td><b>Number of Items</b></td>
			    <td><?php echo count($u['Item']); ?></td>
			</tr>
			<tr>
			    <td><b>Enabled</b></td>
			    <td><?php if ($u['Modifier']['enable']==1) {
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
				    if(confirm('Deleting this modifier may corrupt tickets and records containing it.  It is recommended that you uncheck "enable" rather than delete this modifier, unless it was created in error.  Are you sure you want to delete this modifier?')) location.href = url;
				}
				</SCRIPT>
		<?php
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Edit" onclick="parent.location=\'/modifiers/edit/'.$u['Modifier']['id'].'\'">';
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Delete" onclick="decision(\'/modifiers/delete/'.$u['Modifier']['id'].'\')">';
		?>
            <?php //echo $html->link('Edit',array('action'=>'edit/'.$u['Modifier']['id'])); ?>
            <?php /*echo $html->link(
				'Delete', 
				array('action'=>'delete/'.$u['Modifier']['id']), 
				null, 
				'Are You Sure You Want To Delete This Modifier?'
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