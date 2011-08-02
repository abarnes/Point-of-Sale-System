<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<br/>
<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<h3>Setup Utility -- Create Categories</h3>
<p>Organize your items into categories to make them easier to manage.  Feel free to remove or edit the pre-loaded categories.</p><br/>

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
        <a href="#" onclick="openadd()">Add Category</a>
    </div>
    <br/>
    
    <div id="add" title="Add Category">
        <p>You can disable a category without deleting it by unchecking the "Enable" box.</p>
        <br/>
        
        <table style="border:0px solid black;margin-right:auto;margin-left:auto;">
    
        <?php echo $form->create('Category', array('action' => 'setup')); ?>
        <tr><td style="text-align:right;font-size:80%;">Name: </td><td><?php echo $form->input('name', array( 'label' => '')); ?></td></tr>
        <tr><td style="text-align:right;font-size:80%;">Enable: </td><td><?php echo $form->input('enable', array( 'label' => '','checked'=>true)); ?></td></tr>
        <tr><td></td><td>
        <?php echo $form->end('Add Category'); ?>
        <br/>
        </td></tr></table>
    </div>

        <table>
            <tr>
                <th>
                    <?php echo $this->Paginator->sort('Name', 'Category.name'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Enabled', 'Category.enable'); ?>
                </th>
                <th>
                    Number of Items
                </th>
                <th>
                    Action
                </th>
            </tr>
            <?php foreach ($cats as $u) { ?>
            <tr>
                <td>
                    <?php echo $u['Category']['name']; ?>
                </td>
                <td>
                    <?php
                    switch ($u['Category']['enable']) {
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
                    <?php echo count($u['Item']); ?>
                </td>
                <td>
                    <script type="text/javascript">
                        $(function(){
                                        // Dialog
                                        
                                            $('#dialog<?php echo $u['Category']['id']; ?>').dialog({
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
                    
                    <?php echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="View" onclick="opend('.$u['Category']['id'].')">'; ?>
                    <!--this div is what comes up when you click "view"-->
                        <div id="dialog<?php echo $u['Category']['id']; ?>" title="<?php echo $u['Category']['name']; ?>">
                            <table>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td><?php echo $u['Category']['name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Number of Items</b></td>
                                    <td><?php echo count($u['Item']); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Enabled</b></td>
                                    <td><?php if ($u['Category']['enable']==1) {
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
				    if(confirm('Are you sure you want to delete this category?')) location.href = url;
				}
				</SCRIPT>
				<?php
				echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Edit" onclick="parent.location=\'/categories/edit/'.$u['Category']['id'].'/1\'">';
				echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Delete" onclick="decision(\'/categories/delete/'.$u['Category']['id'].'/1\')">';
				?>
                    <?php //echo $html->link('Edit',array('action'=>'edit/'.$u['Category']['id'].'/1')); ?>
                    <?php /*echo $html->link(
                                        'Delete', 
                                        array('controller'=>'categories','action'=>'delete/'.$u['Category']['id'].'/1'), 
                                        null, 
                                        'Are You Sure You Want To Delete This Category?'
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
        
        <br/>
        <a style="float:left;vertical-align:bottom;margin-left:10px;" href="/types/setup"><input type="button" class="submits" value="Previous"></a>
        <a style="float:right;vertical-align:bottom;margin-right:10px;" href="/items/setup"><input type="button" class="submits" value="Next"></a>