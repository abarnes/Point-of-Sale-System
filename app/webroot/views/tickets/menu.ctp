<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<?php if ($login=='0') { ?>
    <h3>Main Menu</h3>
    
    <div style="width:100%;text-align:center;">
        <input onclick="parent.location='/tickets/add'" type="button" value="Place Order" class="submits menubox">
        <input onclick="parent.location='/tickets'" type="button" value="Tickets" class="submits menubox">
        <input onclick="parent.location='/payments/enter'" type="button" value="Pay" class="submits menubox">
        <br/><br/><br/><br/>
        <input onclick="parent.location='/clocks/shift'" type="button" value="Daily Statistics" class="submits menubox">
        <input onclick="parent.location='/users/logout'" type="button" value="Clock Out" class="submits menubox">
    </div>
    <br/><br/>
<?php } else { ?>
    <script type="text/javascript">
    function calc(type,num){
                            document.getElementById('User'+type).value += num;	
    }
    function clr(type){
                            var str = document.getElementById('User'+type);
                            var news = str.value.substring(0, str.value.length-1);
                            document.getElementById('User'+type).value = news; 	
    }
    </script>


    <div style="width:70%;float:left;">

    <div class="label">
    <?php echo $form->create('Users', array('action' => 'quick_in')); ?>
    <?php echo $form->input('User.shortcut', array( 'label' => '','value'=>'','autofocus'=>'autofocus')); ?>
    <?php echo $form->end('Submit'); ?>
    </div>
    
</div>
<div style="width:30%;float:right;">
    <form>
						<div style="float:left;width:100%;">
									<input onclick="calc('Shortcut','1')" type="button" value="1" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Shortcut','2')" type="button" value="2" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Shortcut','3')" type="button" value="3" style="width:65px;height:65px;font-size:1em;" class="submits">			
									<div style="height:0px;"></div>
									<input onclick="calc('Shortcut','4')" type="button" value="4" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Shortcut','5')" type="button" value="5" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Shortcut','6')" type="button" value="6" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Shortcut','7')" type="button" value="7" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Shortcut','8')" type="button" value="8" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Shortcut','9')" type="button" value="9" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Shortcut','.')" type="button" value="." style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Shortcut','0')" type="button" value="0" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="clr('Shortcut')" type="button" value="clr" style="width:65px;height:65px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="tip()"/>-->
						</form>	
</div>
<?php } ?>
				
