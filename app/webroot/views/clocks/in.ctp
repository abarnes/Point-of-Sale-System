<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
    <table style="border:0px solid black;margin-right:auto;margin-left:auto;">
    
    <?php echo $form->create('Clock', array('action' => 'in/'.$user['User']['id'])); ?>
    <tr><td style="text-align:right;font-size:80%;">Rate: </td><td><?php echo $form->input('rate', array( 'label' => '','options'=>$opts)); ?></td></tr>
    <tr><td></td><td>
    <?php echo $form->end('Clock In'); ?>
    <br/>
</td></tr></table>



    