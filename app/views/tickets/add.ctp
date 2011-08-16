<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<script type="text/javascript">
function calc(type,num){
			document.getElementById('Ticket'+type).value += num;	
}
function clr(type){
			var str = document.getElementById('Ticket'+type);
			var news = str.value.substring(0, str.value.length-1);
			document.getElementById('Ticket'+type).value = news; 	
}
</script>

<script type="text/javascript">
$(document).ready(function(){	
	$('#all').fadeIn(600);
});
</script>
<div id="all" style="display:none">

<h3>Place Order</h3>

<?php if (!isset($step)) { ?>
<p>Select Order Type</p><br/>

<div style="width:100%;text-align:center;">
    <?php foreach ($types as $t) { ?>
        <a href="/tickets/add/1/<?php echo $t['Type']['id']; ?>"><input onclick="" type="button" value="<?php echo $t['Type']['name']; ?>" style="margin-bottom:25px;" class="submits menubox"/></a>
    <?php } ?>

</div>

<?php } elseif ($step=='2') { ?>
<div style="width:70%;float:left;">

    <div class="label">
    <?php echo $form->create('Ticket', array('action' => 'add/2/'.$type)); ?>
    <?php echo $form->input('Ticket.type_id', array( 'label' => 'Order Type','type'=>'hidden','value'=>$type)); ?>
    <?php echo $form->input('Ticket.table', array( 'label' => 'Table','value'=>$tab,'autofocus'=>'autofocus')); ?>
    <?php echo $form->input('Ticket.cont', array( 'type'=>'hidden','value'=>$value)); ?>
    <?php echo $form->end('Submit'); ?>
    </div>
    
</div>
<div style="width:30%;float:right;">
    <form>
						<div style="float:left;width:100%;">
									<input onclick="calc('Table','1')" type="button" value="1" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Table','2')" type="button" value="2" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Table','3')" type="button" value="3" style="width:65px;height:65px;font-size:1em;" class="submits">			
									<div style="height:0px;"></div>
									<input onclick="calc('Table','4')" type="button" value="4" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Table','5')" type="button" value="5" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Table','6')" type="button" value="6" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Table','7')" type="button" value="7" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Table','8')" type="button" value="8" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Table','9')" type="button" value="9" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Table','.')" type="button" value="." style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Table','0')" type="button" value="0" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="clr('Table')" type="button" value="clr" style="width:65px;height:65px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="tip()"/>-->
						</form>	
</div>
<?php }elseif ($step=='3') { ?>
<div style="width:70%;float:left;">

    <div class="label">
    <?php echo $form->create('Ticket', array('action' => 'add/3/'.$type.'/'.$table)); ?>
    <?php echo $form->input('Ticket.type_id', array( 'label' => 'Order Type','type'=>'hidden','value'=>$type)); ?>
    <?php echo $form->input('Ticket.seats', array( 'label' => 'Number of Seats','maxlength'=>'2','autofocus'=>'autofocus')); ?>
    <?php echo $form->end('Submit'); ?>
    </div>
    
</div>
<div style="width:30%;float:right;">
    <form>
						<div style="float:left;width:100%;">
									<input onclick="calc('Seats','1')" type="button" value="1" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Seats','2')" type="button" value="2" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Seats','3')" type="button" value="3" style="width:65px;height:65px;font-size:1em;" class="submits">			
									<div style="height:0px;"></div>
									<input onclick="calc('Seats','4')" type="button" value="4" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Seats','5')" type="button" value="5" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Seats','6')" type="button" value="6" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Seats','7')" type="button" value="7" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Seats','8')" type="button" value="8" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Seats','9')" type="button" value="9" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Seats','.')" type="button" value="." style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Seats','0')" type="button" value="0" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="clr('Seats')" type="button" value="clr" style="width:65px;height:65px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="tip()"/>-->
						</form>	
</div>    
<?php } ?>

</div>    