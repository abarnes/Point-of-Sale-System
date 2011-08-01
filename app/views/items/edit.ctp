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
    
    <div class="label">
    <?php echo $form->create('Item', array('action' => 'edit/'.$id.'/'.$ac)); ?>
    <?php echo $form->input('name', array( 'label' => 'Name')); ?>
    <?php echo $form->input('short_name', array( 'label' => 'Short Name')); ?>
    <?php echo $form->input('price', array( 'label' => 'Price')); ?>
    <?php echo $form->input('category_id', array( 'label' => 'Category')); ?>
    <?php echo $form->input('Modifier', array( 'label' => 'Modifier')); ?>
    <p>Hold the control key to select multiple items (command key on a Mac)</p>
    <?php echo $form->input('description', array( 'label' => 'Description')); ?>
    <?php echo $form->input('mods_on', array( 'label' => 'Use Modifiers')); ?>
    <?php echo $form->input('enable', array( 'label' => 'Enabled')); ?>
    <?php echo $form->input('id', array( 'type'=>'hidden')); ?>
    <?php echo $form->end('Update Item'); ?>
    </div>


    