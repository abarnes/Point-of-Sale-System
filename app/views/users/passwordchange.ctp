<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<h3>Change Password -- <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></h3>
        
        <div class="link">
        <?php 
            echo $html->link('<< Manage Users',array('controller'=>'users','action'=>'index'));
        ?>
        </div><br/>
        
        <div class="label">
        <?php
    echo $form->create('User', array('action' => 'passwordchange'));
    echo $form->input('password', array('label'=>'New Password: ','type'=>'password','value'=>''));
    echo $form->input('password2', array('type'=>'password','value'=>'','label'=>'Retype New Password: '));
    echo $form->input('id', array('type'=>'hidden'));
    echo $form->end('Change Password');
?>
        </div>


