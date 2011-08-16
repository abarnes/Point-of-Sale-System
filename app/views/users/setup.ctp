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
    
<script type="text/javascript">
$(document).ready(function(){	
	$('#all').fadeIn(600);
});
</script>
<div id="all" style="display:none">

<?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<br/>
<?php if ($check==true) { ?>
    <!--Create first admin user---------------------------------->
    
    <h3>Create your first Admin Account</h3>
    <p>This will be an account with full access to configure the system.  You can add more admins and regular users once the first admin account is created.</p><br/>
    
    <table style="border:0px solid black;margin-right:auto;margin-left:50px;width:500px;">
    
    <?php echo $form->create('User', array('action' => 'setup')); ?>
    <tr><td style="text-align:right;font-size:80%;">First Name* </td><td><?php echo $form->input('first_name', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Last Name* </td><td><?php echo $form->input('last_name', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Username* </td><td><?php echo $form->input('username', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Password* </td><td><?php echo $form->input('password', array('label'=>'','value'=>'')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Retype Password* </td><td><?php echo $form->input('password2', array('type'=>'password','value'=>'','label'=>'')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Quick Key* </td><td><?php echo $form->input('shortcut', array('label'=>'','value'=>'')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Email </td><td><?php echo $form->input('email', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Rate 1* $</td><td><?php echo $form->input('rate1', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Rate 2 $</td><td><?php echo $form->input('rate2', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Rate 3 $</td><td><?php echo $form->input('rate3', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Notes </td><td><?php echo $form->input('notes', array( 'label' => '')); ?></td></tr>
    <tr><td></td><td>
    <?php echo $form->input('level',array('type'=>'hidden','value'=>'1')); ?>
    <?php echo $form->end('Add User'); ?>
    <br/>
    </td></tr></table>

<?php } else { ?>
<!--Create Other Users---------------------------------------->

    <h3>Setup Utility -- Users</h3>
    
    <p>Create additional users, or continue to the next step.</p>
    <br/>
    
    <div class="link">
        <a href="#" onclick="openadd()">Add User</a>
    </div>
    <br/>

        <table>
            <tr>
                <th>
                    <?php echo $this->Paginator->sort('Name', 'User.last_name'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Status', 'User.level'); ?>
                </th>
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
                    
                    <a href="#" onclick="opend(<?php echo $u['User']['id']; ?>)">View</a>
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
                    <?php echo $html->link('Edit',array('action'=>'edit/'.$u['User']['id'].'/1')); ?>
                    <?php echo $html->link(
                                        'Delete', 
                                        array('controller'=>'users','action'=>'delete/'.$u['User']['id'].'/1'), 
                                        null, 
                                        'Are You Sure You Want To Delete This User?'
                                ); ?>
                    <?php //echo $html->link('Change Password',array('action'=>'passwordchange/'.$u['User']['id'])); ?>
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
        <a style="float:left;vertical-align:bottom;margin-left:10px;" href="/pages/setup"><input type="button" class="submits" value="Previous"></a>
        <a style="float:right;vertical-align:bottom;margin-right:10px;" href="/settings/setup"><input type="button" class="submits" value="Next"></a>
	<br/><br/><br/>
<?php } ?>

 <div id="add" title="Add User">
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
        <tr><td></td><td>
        <?php echo $form->end('Add User'); ?>
        <br/>
        </td></tr></table>
    </div>

</div>