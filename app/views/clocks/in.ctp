<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
    <h3>Clock In - <?php echo $user['User']['full_name']; ?></h3>

<div class="link">
<?php echo $html->link('<< Employees',array('controller'=>'users','action'=>'index')); ?>				
<br/><br/>
</div>
    
    <div class="label">
    <?php echo $form->create('Clock', array('action' => 'in/'.$user['User']['id'].'/h')); ?>
    <?php echo $form->input('in', array( 'label' => 'Time In: ')); ?>
    <?php echo $form->input('rate', array( 'label' => '','options'=>$opts)); ?>
    <?php echo $form->end('Clock In'); ?>
    </div>
    <br/>



    