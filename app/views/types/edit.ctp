<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<h3>Edit Order Type</h3>
        
        <div class="link">
        <?php if ($setup!=false) {
            $ac = $setup;
            echo $html->link('<< Back to Setup',array('controller'=>'types','action'=>'setup'));
        } else {
            $ac = "";
            echo $html->link('<< Manage Types',array('controller'=>'types','action'=>'index'));
        }?>
        </div><br/>
    
    <div class="label">
    <?php echo $form->create('Type', array('action' => 'edit/'.$id.'/'.$ac)); ?>
    <?php echo $form->input('name', array( 'label' => 'Name')); ?>
    <?php echo $form->input('enable', array( 'label' => 'Enable')); ?>
    <?php echo $form->input('use_seats', array( 'label' => 'Use Seats')); ?>
    <?php echo $form->input('id', array( 'type'=>'hidden')); ?>
    <?php echo $form->end('Update Ticket Type'); ?>
    </div>

    