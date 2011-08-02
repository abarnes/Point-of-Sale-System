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
<h3>Manage Employees</h3>
<p>Add employees to your system. "Admins" have full control over the system, while "users" can only manage tickets, as well as a few other non-administrative actions.</p><br/>

<div class="link">
<?php echo $html->link('<< Admin Panel',array('controller'=>'pages','action'=>'admin')); ?><a href="#" onclick="openadd()" style="margin-left:15px;">Add Employee</a>				
<br/><br/>
</div>

<div id="add" title="Add Employee">
        <table style="border:0px solid black;margin-right:auto;margin-left:50px;width:500px;">
    
        <?php echo $form->create('User', array('action' => 'setup')); ?>
        <tr><td style="text-align:right;font-size:80%;">First Name* </td><td><?php echo $form->input('first_name', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Last Name* </td><td><?php echo $form->input('last_name', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Username* </td><td><?php echo $form->input('username', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Password* </td><td><?php echo $form->input('password', array('label'=>'','value'=>'')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Retype Password* </td><td><?php echo $form->input('password2', array('type'=>'password','value'=>'','label'=>'')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Quick Key* </td><td><?php echo $form->input('shortcut', array('label'=>'','value'=>'')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Status </td><td><?php echo $form->input('level', array( 'label' => '','options'=>array('1'=>'Admin','2'=>'User'))); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Email </td><td><?php echo $form->input('email', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Rate 1* $</td><td><?php echo $form->input('rate1', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Rate 2 $</td><td><?php echo $form->input('rate2', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Rate 3 $</td><td><?php echo $form->input('rate3', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Notes </td><td><?php echo $form->input('notes', array( 'label' => '')); ?></td></tr>
	<tr><td style="text-align:right;font-size:80%;">Allow Clock-In </td><td><?php echo $form->input('enable', array( 'label' => '','checked'=>true)); ?></td></tr>
        <tr><td></td><td>
        <?php echo $form->end('Add User'); ?>
        <br/>
        </td></tr></table>
    </div>

<table>
    <tr>
        <th>
            <?php echo $this->Paginator->sort('Name', 'User.last_name'); ?>
        </th>
        <th>
            <?php echo $this->Paginator->sort('Status', 'User.level'); ?>
        </th>
	<th>Clocked In</th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach ($users as $u) { ?>
    <tr>
        <td>
            <?php echo $u['User']['last_name'].', '.$u['User']['first_name']; ?>
        </td>
        <td>
            <?php
            switch ($u['User']['level']) {
                case "1":
                    $role = 'Admin';
                    break;
                case "2":
                    $role = 'User';
                    break;
                default:
                    $role = 'User';
                    break;
            }
            echo $role;
            ?>
        </td>
	<td style="text-align:center;">
            <?php if ($u['User']['in']=='1') {
		echo $html->image('checkmark.png',array('alt'=>'Barnes Point of Sale Systems'));		
	    } ?>
	</td>
        <td>
            <script type="text/javascript">
		$(function(){
                                // Dialog
				
				    $('#dialog<?php echo $u['User']['id']; ?>').dialog({
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
	    
	    <?php echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="View" onclick="opend('.$u['User']['id'].')">'; ?>
	    <!--this div is what comes up when you click "view"-->
		<div id="dialog<?php echo $u['User']['id']; ?>" title="<?php echo $u['User']['first_name'].' '.$u['User']['last_name']; ?>">
                            <table>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td><?php echo $u['User']['last_name'].', '.$u['User']['first_name']; ?></td>
                                </tr>
				<tr>
                                    <td><b>Username</b></td>
                                    <td><?php echo $u['User']['username']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Status</b></td>
                                    <td><?php switch ($u['User']['level']==1) {
                                        case 1:
                                            echo 'Admin';
                                            break;
                                        case 2:
                                            echo 'User';
                                            break;
                                        default:
                                            echo 'User';
                                            break;
                                    } ?>
                                    </td>
                                </tr>
				<tr>
                                    <td><b>Email</b></td>
                                    <td><?php echo $u['User']['email']; ?></td>
                                </tr>
				<tr>
                                    <td><b>Rate 1</b></td>
                                    <td>$<?php echo $u['User']['rate1']; ?></td>
                                </tr>
				<?php if ($u['User']['rate2']!='') { ?>
				<tr>
                                    <td><b>Rate 2</b></td>
                                    <td>$<?php echo $u['User']['rate2']; ?></td>
                                </tr>
				<?php }
				if ($u['User']['rate3']!='') { ?>
				<tr>
                                    <td><b>Rate 3</b></td>
                                    <td>$<?php echo $u['User']['rate3']; ?></td>
                                </tr>
				<?php } ?>
				<tr>
                                    <td><b>Notes</b></td>
                                    <td><?php echo $u['User']['notes']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Enabled</b></td>
                                    <td><?php if ($u['User']['enable']==1) {
                                        echo 'yes';
                                    } else {
                                        echo 'no';
                                    } ?>
                                    </td>
                                </tr>
				<tr>
                                    <td><b>Added</b></td>
                                    <td><?php echo date('m-d-Y',strtotime($u['User']['created'])); ?></td>
                                </tr>
                            </table>
                        </div>
            <?php echo '<input style="width:90px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Report" onclick="parent.location=\'/clocks/report/'.$u['User']['id'].'\'">';
	    //echo $html->link('Employee Report',array('controller'=>'clocks','action'=>'report/'.$u['User']['id'].'/2')); ?>
	    <SCRIPT type="text/javascript">
				function decision(url){
				    if(confirm('Warning! It is not recommended to delete users unless they were created in error.  Even if this person no longer works for you, they need to remain in the system in order for your records to display correctly.  Please uncheck "Allow Clock-In" instead.  Are you sure you want to delete this user?')) location.href = url;
				}
				</SCRIPT>
		<?php
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Edit" onclick="parent.location=\'/users/edit/'.$u['User']['id'].'\'">';
		echo '<input style="width:70px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Delete" onclick="decision(\'/users/delete/'.$u['User']['id'].'\')">';
		?>
            <?php //echo $html->link('Edit',array('action'=>'edit/'.$u['User']['id'])); ?>
            <?php /*echo $html->link(
				'Delete', 
				array('controller'=>'users','action'=>'delete/'.$u['User']['id']), 
				null, 
				'Warning! It is not recommended to delete users unless they were created in error.  Even if this person no longer works for you, they need to remain in the system in order for your records to display correctly.  Please uncheck "Allow Clock-In" instead.  Are you sure you want to delete this user?'
			);*/ ?>
	    <?php echo '<input style="width:135px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Change Password" onclick="parent.location=\'/users/passwordchange/'.$u['User']['id'].'\'">'; ?>		
            <?php //echo $html->link('Change Password',array('action'=>'passwordchange/'.$u['User']['id'])); ?>
	    <?php if ($u['User']['in']=='1') {
				echo '<input style="width:90px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Clock Out" onclick="parent.location=\'/clocks/out/'.$u['User']['id'].'\'">';
				//echo $html->link('Clock Out',array('controller'=>'clocks','action'=>'out/'.$u['User']['id']));			
            } else {
				echo '<input style="width:90px;height:28px;font-size:1em;margin:0px 4px 0px 0px;" type="button" class="submits" value="Clock In" onclick="parent.location=\'/clocks/in/'.$u['User']['id'].'\'">';
				//echo $html->link('Clock In',array('controller'=>'clocks','action'=>'in/'.$u['User']['id']));				
            } ?>
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