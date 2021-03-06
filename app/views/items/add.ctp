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
    
    <?php echo $form->create('Item', array('action' => 'add')); ?>
    <tr><td style="text-align:right;font-size:80%;">Name: </td><td><?php echo $form->input('name', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Short Name: </td><td><?php echo $form->input('short_name', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Price: </td><td><?php echo $form->input('price', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Category: </td><td><?php echo $form->input('category_id', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Options: </td><td><?php echo $form->input('Modifier', array( 'label' => '')); ?>
    <p>Hold the control key to select multiple items (command key on a Mac)</p>
    </td></tr>
    <tr><td style="text-align:right;font-size:80%;">Description: </td><td><?php echo $form->input('description', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Options on Select: </td><td><?php echo $form->input('mods_on', array( 'label' => '')); ?></td></tr>
    <tr><td style="text-align:right;font-size:80%;">Enable: </td><td><?php echo $form->input('enable', array( 'label' => '')); ?></td></tr>
    <tr><td></td><td>
    <?php echo $form->end('Add Item'); ?>
    <br/>
</td></tr></table>
</div>


    