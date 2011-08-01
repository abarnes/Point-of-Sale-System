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
                            document.getElementById('Payment'+type).value += num;	
    }
    function clr(type){
                            var str = document.getElementById('Payment'+type);
                            var news = str.value.substring(0, str.value.length-1);
                            document.getElementById('Payment'+type).value = news; 	
    }
    </script>


    <div style="width:60%;float:left;">

    <div class="label">
    <?php echo $form->create('Payment', array('action' => 'enter')); ?>
    <?php echo $form->input('dayid', array( 'label' => 'Ticket ID','autofocus'=>'autofocus')); ?>
    <?php echo $form->end('Submit'); ?>
    </div>
    
</div>
<div style="width:30%;min-width:280px;float:right;">
    <form>
						<div style="float:left;width:100%;">
									<input onclick="calc('Dayid','1')" type="button" value="1" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Dayid','2')" type="button" value="2" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Dayid','3')" type="button" value="3" style="width:65px;height:65px;font-size:1em;" class="submits">			
									<div style="height:0px;"></div>
									<input onclick="calc('Dayid','4')" type="button" value="4" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Dayid','5')" type="button" value="5" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Dayid','6')" type="button" value="6" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Dayid','7')" type="button" value="7" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Dayid','8')" type="button" value="8" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Dayid','9')" type="button" value="9" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Dayid','.')" type="button" value="." style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Dayid','0')" type="button" value="0" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="clr('Dayid')" type="button" value="clr" style="width:65px;height:65px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="tip()"/>-->
						</form>	
</div>
				
