<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<h3>Edit User</h3>
        
        <div class="link">
        <?php if ($setup!=false) {
            $ac = $setup;
            echo $html->link('<< Back to Setup',array('controller'=>'users','action'=>'setup'));
        } else {
            $ac = "";
            echo $html->link('<< Manage Users',array('controller'=>'users','action'=>'index'));
        }?>
        <a href="/users/passwordchange/<?php echo $id; ?>" style="margin-left:20px;">Change Password</a>
        </div><br/>
    
    <div class="label" style="width:60%;float:left;">
    <?php echo $form->create('User', array('action' => 'edit/'.$id.'/'.$ac)); ?>
    <?php echo $form->input('first_name', array( 'label' => 'First Name')); ?>
    <?php echo $form->input('last_name', array( 'label' => 'Last Name')); ?>
    <?php echo $form->input('username', array( 'label' => 'Username')); ?>
    <?php echo $form->input('shortcut', array( 'label' => 'Quick Key')); ?>
    <?php echo $form->input('level', array( 'label' => 'Status','options'=>array('1'=>'Admin','2'=>'User'))); ?>
    <?php echo $form->input('email', array( 'label' => 'Email')); ?>
    <?php echo $form->input('rate1', array( 'label' => 'Rate 1')); ?>
    <?php echo $form->input('rate2', array( 'label' => 'Rate 2')); ?>
    <?php echo $form->input('rate3', array( 'label' => 'Rate 3')); ?>
    <?php echo $form->input('notes', array( 'label' => 'Notes')); ?>
    <?php echo $form->input('enable', array( 'label' => 'Allow Clock-In')); ?>
    <?php echo $form->input('id', array( 'type'=>'hidden')); ?>
    <!--------submit form----->
    <script type="text/javascript">
    function submitform() {
      document.getElementById('UserEdit<?php echo '/'.$id.'/'.$ac; ?>Form').submit();
    }
    </script>
    <br/>
    <a style="vertical-align:bottom;margin-left:0px;margin-right:20px;" href="#" onclick="submitform()"><input style="width:100%;margin-right:0px;height:44px;" type="button" class="submits" value="Submit"></a>
    <br/><br/>
    
    <?php //echo $form->end('Update User'); ?>
    </div>
    
    <div style="width:40%;float:right;">
        <h4>Username</h4>
        <p>The employee's username is used to clock in and must be unique.</p>
        <br/><br/>
        <h4>Quick Key</h4>
        <p>The Quick Key is used to quickly access a terminal after an employee is clocked in.  It must be at least 5 characters long and unique in the system</p>
        <br/><br/>
        <h4>Status</h4>
        <p>An employee can either be an admin or user.  Admins have access to all functions, including the administrative functions to add items, manage employees, etc.  Users only have access to ticket management and cash register functions.</p>
        <br/><br/>
        <h4>Rates</h4>
        <p>You can set up to 3 different rates for your employees, with rate 1 being the default.  Admins can alternately clock in users at rates 2 or 3 through the employees panel.  Do not add a dollar sign ($) to the rate.</p>
        <br/><br/>
        <h4>Allow Clock-In</h4>
        <p>Checking this box allows the employee to clock in.  If the employee no longer works here, you may uncheck this box to disable the employee's access to the system without corrupting any records.</p>
        <br/><br/>
    </div>