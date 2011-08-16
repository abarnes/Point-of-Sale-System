<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<h3>Edit Item</h3>
        
        <div class="link">
        <?php if ($setup!=false) {
            $ac = $setup;
            echo $html->link('<< Back to Setup',array('controller'=>'items','action'=>'setup'));
        } else {
            $ac = "";
            echo $html->link('<< Manage Items',array('controller'=>'items','action'=>'index'));
        }?>
        </div><br/>

<div style="width:60%;float:left;">    
    
    <div class="label">
    <?php echo $form->create('Item', array('action' => 'edit/'.$id.'/'.$ac)); ?>
    <?php echo $form->input('name', array( 'label' => 'Name')); ?>
    <?php echo $form->input('short_name', array( 'label' => 'Short Name')); ?>
    <?php echo $form->input('price', array( 'label' => 'Price')); ?>
    <?php echo $form->input('category_id', array( 'label' => 'Category')); ?>
    <?php echo $form->input('Modifier', array( 'label' => 'Modifier')); ?>
    <?php echo $form->input('description', array( 'label' => 'Description')); ?>
    <?php echo $form->input('mods_on', array( 'label' => 'Prompt for Modifiers')); ?>
    <?php echo $form->input('enable', array( 'label' => 'Enabled')); ?>
    <?php echo $form->input('id', array( 'type'=>'hidden')); ?>
    <?php echo $form->end('Update Item'); ?>
    </div>

</div>

<div style="width:40%;float:right;">
    <h4>Item Name</h4>
    <p>This field is for the regular item name.</p>
    <br/><br/>
    <h4>Short Name</h4>
    <p>Input a short name for your item so it fits on buttons and on receipts (10 characters).  You may use the regular name if it's short enough.</p>
    <br/><br/>
    <h4>Price</h4>
    <p>No dollar sign ($) on price.</p>
    <br/><br/>
    <h4>Modifiers</h4>
    <p>Select all the modifiers applicable to this item.  Be sure to include "do not make" so items can be entered without being made. Hold the control key to select multiple items (command key on a Mac).</p>
    <br/><br/>
    <h4>Prompt for Modifiers</h4>
    <p>Checking this box will pull up modifiers by default when the item is selected.  This may be desireable for items like burgers, but not drinks.  The modifiers menu can always be pulled up by clicking on the item when it's been added.</p>
    <br/><br/>
    <h4>Enabled</h4>
    <p>Unchecking this box will remove the item from the order panel but will not delete the item permanently.</p>
    <br/>
</div>
    