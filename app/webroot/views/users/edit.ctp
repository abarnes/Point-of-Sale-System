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
        </div><br/>
    
    <div class="label">
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
    <?php echo $form->input('enable', array( 'label' => 'Enable')); ?>
    <?php echo $form->input('id', array( 'type'=>'hidden')); ?>
    <?php echo $form->end('Update User'); ?>
    </div>

    