<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<div style="width:100%;margin-right:auto;margin-left:auto;text-align:center;">
    
    <table style="border:0px solid black;margin-right:auto;margin-left:auto;">
    
    <?php echo $form->create('User', array('action' => 'add')); ?>
    <tr><td style="text-align:right;font-size:80%;">First Name: </td><td><?php echo $form->input('first_name', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Last Name: </td><td><?php echo $form->input('last_name', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Username: </td><td><?php echo $form->input('username', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Password: </td><td><?php echo $form->input('password', array('label'=>'','value'=>'')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Retype Password: </td><td><?php echo $form->input('password2', array('type'=>'password','value'=>'','label'=>'')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Email: </td><td><?php echo $form->input('email', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Rate 1: $</td><td><?php echo $form->input('rate1', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Rate 2: $</td><td><?php echo $form->input('rate2', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Rate 3: $</td><td><?php echo $form->input('rate3', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Notes: </td><td><?php echo $form->input('notes', array( 'label' => '')); ?></td></tr>
    <tr><td></td><td>
    <?php echo $form->end('Add User'); ?>
    <br/>
</td></tr></table>
</div>



    