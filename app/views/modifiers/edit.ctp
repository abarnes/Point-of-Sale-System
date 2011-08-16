<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<h3>Edit Modifier</h3>
        
        <div class="link">
        <?php if ($setup!=false) {
            $ac = $setup;
            echo $html->link('<< Back to Setup',array('controller'=>'modifiers','action'=>'setup'));
        } else {
            $ac = "";
            echo $html->link('<< Manage Modifiers',array('controller'=>'modifiers','action'=>'index'));
        }?>
        </div><br/>
    
<div style="width:60%;float:left;">    
    <div class="label">
    <?php echo $form->create('Modifier', array('action' => 'edit/'.$id.'/'.$ac)); ?>
    <?php echo $form->input('name', array( 'label' => 'Name')); ?>
    <?php echo $form->input('price', array( 'label' => 'Price')); ?>
    <?php echo $form->input('Item', array( 'label' => 'Items')); ?>
    <p>Hold the control key to select multiple items (command key on a Mac)</p>
    <?php echo $form->input('description', array( 'label' => 'Description')); ?>
    <?php echo $form->input('enable', array( 'label' => 'Enable')); ?>
    <?php echo $form->input('id', array( 'type'=>'hidden')); ?>
    <?php echo $form->end('Update Modifier'); ?>
    </div>

</div>

<div style="width:40%;float:right;">
    <h4>Price</h4>
    <p>No dollar sign ($) on price.</p>
    <br/><br/>
    <h4>Items</h4>
    <p>Select all the items this modifier applies to.  Hold the control key to select multiple items (command key on a Mac).</p>
    <br/><br/>
    <h4>Enabled</h4>
    <p>Unchecking this box will remove the item from the order panel but will not delete the modifier permanently.</p>
    <br/>
</div>
    