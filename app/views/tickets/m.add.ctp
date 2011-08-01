<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<?php
if (!isset($step)) {
    $back = '/tickets/menu';
} elseif ($step=='2') {
    $back = '/tickets/add';
} elseif ($step=='3') {
    $back = '/tickets/add/1/'.$type;
}?>

<div id="home">
    <div class="toolbar"><a class="back" href="<?php echo $back; ?>" rel="external">Back</a><h1>Place Order</h1></div>
    
    <?php if (!isset($step)) { ?>
        <ul class="metal">
        <?php foreach ($types as $t) { ?>
            <li class="arrow"><a href="/tickets/add/1/<?php echo $t['Type']['id']; ?>" rel="external"><small></small><?php echo $t['Type']['name']; ?></a></li>
        <?php } ?>
        
    <?php } elseif ($step=='2') { ?>
            <br/>
            <?php echo $form->create('Ticket', array('action' => 'add/2/'.$type)); ?>
            <?php echo $form->input('Ticket.type_id', array( 'label' => 'Order Type','type'=>'hidden','value'=>$type)); ?>
            <?php //echo $form->input('Ticket.table', array( 'label' => 'Table','type'=>'tel')); ?>
            <h3>Table</h3>
            <input name="data[Ticket][table]" maxlength="250" id="TicketTable" type="tel" style="width:100%;font-size:1.8em;" autofocus="autofocus"/>
            <br/><br/>
            <a class="grayButton" rel="external" onclick="document.forms['TicketAdd/2/<?php echo $type; ?>Form'].submit()"/>Submit</a>
            <?php //echo $form->end('Submit'); ?>
    <?php }elseif ($step=='3') { ?>
        <br/>
        <div class="label">
        <?php echo $form->create('Ticket', array('action' => 'add/3/'.$type.'/'.$table)); ?>
        <?php echo $form->input('Ticket.type_id', array( 'label' => 'Order Type','type'=>'hidden','value'=>$type)); ?>
        <?php //echo $form->input('Ticket.seats', array( 'label' => 'Number of Seats')); ?>
        <h3>Number of Seats</h3>
        <input name="data[Ticket][seats]" maxlength="250" id="TicketSeats" type="tel" style="width:100%;font-size:1.8em;" autofocus="autofocus"/>
        <br/><br/>
        <?php //echo $form->end('Submit'); ?>
        <a class="grayButton" rel="external" onclick="document.forms['TicketAdd/3/<?php echo $type.'/'.$table; ?>Form'].submit()"/>Submit</a>
        </div>  
    <?php } ?>
</div>

    