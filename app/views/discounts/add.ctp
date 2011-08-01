<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<h3>Add Discount - <?php echo $item['Item']['name']; ?></h3>
<div class="link">
<a href="/items"><< Back to Items</a>
<br/><br/>
<p>Select Days for which the discount is valid, and the start and end times on those days.  For different times on different days, create multple discounts with separate rules.</p>
<br/>
</div>

<div class="label" style="width:60%;">
    <?php echo $form->create('Discount', array('action' => 'add/'.$item['Item']['id'])); ?>
    
    <?php echo $form->input('monday', array( 'label' => 'Monday')); ?>
    <?php echo $form->input('tuesday', array( 'label' => 'Tuesday')); ?>
    <?php echo $form->input('wednesday', array( 'label' => 'Wednesday')); ?>
    <?php echo $form->input('thursday', array( 'label' => 'Thursday')); ?>
    <?php echo $form->input('friday', array( 'label' => 'Friday')); ?>
    <?php echo $form->input('saturday', array( 'label' => 'Saturday')); ?>
    <?php echo $form->input('sunday', array( 'label' => 'Sunday')); ?>
    
    <?php echo $form->input('start_time', array( 'label' => 'Start Time','selected' => array('hour' => '12', 'min' => '00', 'meridian' => 'am'))); ?>
    <?php echo $form->input('end_time', array( 'label' => 'End Time', 'selected' => array('hour' => '11', 'min' => '59', 'meridian' => 'pm'))); ?>
    <?php echo $form->input('price', array( 'label' => 'New Price: ')); ?>
    <?php echo $form->input('enable', array( 'label' => 'Enabled','checked'=>true)); ?>
    
    <?php echo $form->end('Add Discount'); ?>
    <br/>
</div>
