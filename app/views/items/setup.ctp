<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<script type="text/javascript">
$(document).ready(function(){	
	$('#all').fadeIn(600);
});
</script>
<div id="all" style="display:none">

<br/>
<?php if ($check==true) { ?>
    <!--Create first item--------------------------------->
    
    <h3>Setup Utility -- Add Items</h3>
    <p style="font-size:80%;">Create your first item and assign it to a category.  <br/><br/>The short name must be 10 or fewer characters, and is used on some buttons to conserve space.  You can temporarily disable an item without deleting it by unchecking the "Enable" box.  <br/><br/>"Options on Select" prompts a user to enter additional options after an item is selected.  This is usefull for items such as a burger (to add lettuce, tomato, etc.) but may not be for items like drinks.  <br/><br/>"Print to Kitchen" will send the item to the kitchen when submitted (may not be necessary for items such as drinks).</p><br/>
    
<table style="border:0px solid black;margin-right:auto;margin-left:auto;">
    
    <?php echo $form->create('Discount', array('action' => 'add')); ?>
    <tr><td style="text-align:right;font-size:80%;">Name: </td><td><?php echo $form->input('name', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Short Name: </td><td><?php echo $form->input('short_name', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Price: </td><td><?php echo $form->input('price', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Category: </td><td><?php echo $form->input('category_id', array( 'label' => '')); ?></td></tr>
    <!--<tr><td style="text-align:right;font-size:80%;">Options: </td><td><?php //echo $form->input('Modifier', array( 'label' => '')); ?>
    <p>Hold the control key to select multiple items (command key on a Mac)</p>
    </td></tr>-->
    <tr><td style="text-align:right;font-size:80%;">Description: </td><td><?php echo $form->input('description', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Options on Select: </td><td><?php echo $form->input('mods_on', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Enable: </td><td><?php echo $form->input('enable', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Print to Kitchen: </td><td><?php echo $form->input('kitchen_print', array( 'label' => '')); ?></td></tr>
    <tr><td></td><td>
    <?php echo $form->end('Add Item'); ?>
    <br/>
    </td></tr></table>

<?php } else { ?>
<!--Create Other items---------------------------------------->

    <h3>Setup Utility -- Add Items</h3>
    <p>Create your items and assign them to a category.  You can add scheduled discounts to items by clicking the "add discount" link next to an item.</p><br/>
    
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
    
    <div class="link">
        <a href="#" onclick="openadd()">Add Item</a>
    </div>
    <br/>
    
    <div id="add" title="Add Item">
        <table style="border:0px solid black;margin-right:auto;margin-left:auto;">
	    <p style="font-size:80%;">The short name must be 10 or fewer characters, and is used on some buttons to conserve space.  You can temporarily disable an item without deleting it by unchecking the "Enable" box.  <br/><br/>"Options on Select" prompts a user to enter additional options after an item is selected.  This is usefull for items such as a burger (to add lettuce, tomato, etc.) but may not be for items like drinks.  <br/><br/>"Print to Kitchen" will send the item to the kitchen when submitted (may not be necessary for items such as drinks).</p><br/>
    
        <?php echo $form->create('Item', array('action' => 'setup')); ?>
        <tr><td style="text-align:right;font-size:80%;">Name: </td><td><?php echo $form->input('name', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Short Name: </td><td><?php echo $form->input('short_name', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Price: </td><td><?php echo $form->input('price', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Category: </td><td><?php echo $form->input('category_id', array( 'label' => '')); ?></td></tr>
        <!--<tr><td style="text-align:right;font-size:80%;">Options: </td><td><?php //echo $form->input('Modifier', array( 'label' => '')); ?>
        <p>Hold the control key to select multiple items (command key on a Mac)</p>
        </td></tr>-->
        <tr><td style="text-align:right;font-size:80%;">Description: </td><td><?php echo $form->input('description', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Options on Select: </td><td><?php echo $form->input('mods_on', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Enable: </td><td><?php echo $form->input('enable', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Print to Kitchen: </td><td><?php echo $form->input('kitchen_print', array( 'label' => '')); ?></td></tr>
        <tr><td></td><td>
        <?php echo $form->end('Add Item'); ?>
        <br/>
        </td></tr></table>
    </div>

        <table>
            <tr>
                <th>
                    <?php echo $this->Paginator->sort('Name', 'Item.name'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Enabled', 'Item.enable'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Price', 'Item.price'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Category', 'Category.name'); ?>
                </th>
                <th>
                    Action
                </th>
            </tr>
            <?php foreach ($items as $u) { ?>
            <tr>
                <td>
                    <?php echo $u['Item']['name']; ?>
                </td>
                <td>
                    <?php
                    switch ($u['Item']['enable']) {
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
                    <?php if ($u['Item']['price']>0) { ?>
                        $<?php echo $u['Item']['price']; ?>		
                    <?php } else { ?>
                        free
                    <?php } ?>
                </td>
                <td>
                    <?php echo $u['Category']['name']; ?>
                <td>
                    <script type="text/javascript">
                        $(function(){
                                        // Dialog
                                        
                                            $('#dialog<?php echo $u['Item']['id']; ?>').dialog({
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
                    
                    <?php echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="View" onclick="opend('.$u['Item']['id'].')">'; ?>
                    <!--this div is what comes up when you click "view"-->
                        <div id="dialog<?php echo $u['Item']['id']; ?>" title="<?php echo $u['Item']['name']; ?>">
                            <table>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td><?php echo $u['Item']['name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Short Name</b></td>
                                    <td><?php echo $u['Item']['short_name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Price</b></td>
                                    <td>$<?php echo $u['Item']['price']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Category</b></td>
                                    <td><?php echo $u['Category']['name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Description</b></td>
                                    <td><?php echo $u['Item']['description']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Prompt for Modifiers</b></td>
                                    <td><?php if ($u['Item']['mods_on']==1) {
                                        echo 'yes';
                                    } else {
                                        echo 'no';
                                    } ?>
                                    </td>
                                </tr>
                                <!--<tr>
                                    <td><b>Modifiers</b></td>
                                    <td><?php
                                    /*$str = '';
                                    foreach ($u['Modifier'] as $m) {
                                        $str = $str.$m['name'].', ';
                                    }
                                    echo rtrim($str,', ');*/
                                    ?>
                                    </td>
                                </tr>-->
                                <tr>
                                    <td><b>Enabled</b></td>
                                    <td><?php if ($u['Item']['enable']==1) {
                                        echo 'yes';
                                    } else {
                                        echo 'no';
                                    } ?>
                                    </td>
                                </tr>
				<tr>
				    <td><b>Print to Kitchen</b></td>
				    <td><?php if ($u['Item']['kitchen_print']==1) {
					echo 'yes';
				    } else {
					echo 'no';
				    } ?>
				    </td>
				</tr>
                            </table>
			    <?php if (count($u['Discount'])>0) { ?>
				<h3 style="font-size:130%;">Discounts</h3>
				<?php foreach ($u['Discount'] as $d) { ?>
				<table>
					    <tr>
								<td>
												<b>Discount Price</b>
								</td>
								<td>
												$<?php echo $d['price']; ?>		
								</td>
					    </tr>
					    <tr>
								<td>
												<b>Enabled</b>
								</td>
								<td>
												<?php
												switch ($d['enable']) {
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
					    </tr>
					    <tr>
								<td><b>Days</b></td>
								<?php
								$str = '';
								$co = 0;
								if ($d['monday']=='1') {
								    $str = $str.'Monday, ';
								    $co++;
								}
								if ($d['tuesday']=='1') {
								    $str = $str.'Tuesday, ';
								    $co++;
								}
								if ($d['wednesday']=='1') {
								    $str = $str.'Wednesday, ';
								    $co++;
								}
								if ($d['thursday']=='1') {
								    $str = $str.'Thursday, ';
								    $co++;
								}
								if ($d['friday']=='1') {
								    $str = $str.'Friday, ';
								    $co++;
								}
								if ($d['saturday']=='1') {
								    $str = $str.'Saturday, ';
								    $co++;
								}
								if ($d['sunday']=='1') {
								    $str = $str.'Sunday, ';
								    $co++;
								}
								if ($co!=7) {
								    $str = substr($str,0,-2);
								} else {
								    $str = 'Every Day';
								}
								
								?>
								<td><?php echo $str; ?></td>
				                </tr>
					        <tr>
								<td><b>Time</b></td>
								<td><?php echo date('h:i a',strtotime($d['start_time'])).' - '.date('h:i a',strtotime($d['end_time'])); ?></td>
				                </tr>
						<tr>
						    <td>
							<b>Links</b>
						    </td>
						    <td>
							<?php echo $html->link('Edit',array('controller'=>'discounts','action'=>'edit/'.$d['id'])); ?>
							<?php echo $html->link(
									    'Delete', 
									    array('controller'=>'discounts','action'=>'delete/'.$d['id']), 
									    null, 
									    'Are You Sure You Want To Delete This Discount?'
								    ); ?>
						    </td>
						</tr>
				</table>
				<?php } ?>
			    <?php } ?>
                        </div>
			<SCRIPT type="text/javascript">
				function decision(url){
				    if(confirm('Are you sure you want to delete this item?')) location.href = url;
				}
				</SCRIPT>
			<?php
			echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Edit" onclick="parent.location=\'/items/edit/'.$u['Item']['id'].'/1\'">';
			echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Delete" onclick="decision(\'/items/delete/'.$u['Item']['id'].'/1\')">';
			echo '<input style="width:110px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Add Discount" onclick="parent.location=\'/discounts/add/'.$u['Item']['id'].'\'">';
			?>
                    <?php //echo $html->link('Edit',array('action'=>'edit/'.$u['Item']['id'].'/1')); ?>
                    <?php /*echo $html->link(
                                        'Delete', 
                                        array('controller'=>'items','action'=>'delete/'.$u['Item']['id'].'/1'), 
                                        null, 
                                        'Are You Sure You Want To Delete This Item?'
                                );*/ ?>
		    <?php //echo $html->link('Add Discount',array('controller'=>'discounts','action'=>'add/'.$u['Item']['id'])); ?>
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
    
<?php } ?>
        <br/>
        <a style="float:left;vertical-align:bottom;margin-left:10px;" href="/categories/setup"><input type="button" class="submits" value="Previous"></a>
        <a style="float:right;vertical-align:bottom;margin-right:10px;" href="/modifiers/setup"><input type="button" class="submits" value="Next"></a>
	<br/><br/><br/>
</div>

