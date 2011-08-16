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
			document.getElementById('Clock'+type).value += num;	
}
function clr(type){
			var str = document.getElementById('Clock'+type);
			var news = str.value.substring(0, str.value.length-1);
			document.getElementById('Clock'+type).value = news; 	
}
</script>

<div style="width:70%;float:left;">
    <h3>Shift Information</h3>
    <table style="width:450px;">
			<tr>
			    <td><b>Name</b></td>
			    <td><?php echo $u['User']['last_name'].', '.$u['User']['first_name']; ?></td>
			</tr>
			<tr>
			    <td><b>Time Worked</b></td>
			    <td><?php echo $u['Clock']['time']; ?></td>
			</tr>
			<tr>
			    <td><b>Time In</b></td>
			    <td><?php echo date('g:i a n-j-Y',strtotime($u['Clock']['in'])); ?></td>
			</tr>
			<?php if ($u['Clock']['complete']=='1') { ?>
			<tr>
			    <td><b>Time Out</b></td>
			    <td><?php echo date('g:i a n-j-Y',strtotime($u['Clock']['out'])); ?></td>
			</tr>
			<?php } ?>
			<tr>
			    <td><b>Rate</b></td>
			    <td><?php echo $u['Clock']['rt']; ?></td>
			</tr>
                        <tr>
                            <td><b>Credit Card Tips</b></td>
                            <td>$<?php echo $u['Clock']['ctips']; ?></td>
                        </tr>
			<!--<tr>
			    <td><b>Earnings (before tax)</b></td>
			    <td>$<?php// echo $u['Clock']['cost']; ?></td>
			</tr>-->
    </table>
    
    <div class="label" style="width:50%;">
    <?php
        echo $form->create('Clock', array('action' => 'over/'.$id));
        echo $form->input('tips', array('label'=>'Cash Tips: '));
        echo $form->end('Finish Clocking Out');
    ?>
    </div>

</div>
<div style="width:30%;float:right;">
    <form>
						<div style="float:left;width:100%;">
									<input onclick="calc('Tips','1')" type="button" value="1" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Tips','2')" type="button" value="2" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Tips','3')" type="button" value="3" style="width:65px;height:65px;font-size:1em;" class="submits">			
									<div style="height:0px;"></div>
									<input onclick="calc('Tips','4')" type="button" value="4" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Tips','5')" type="button" value="5" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Tips','6')" type="button" value="6" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Tips','7')" type="button" value="7" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Tips','8')" type="button" value="8" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Tips','9')" type="button" value="9" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Tips','.')" type="button" value="." style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Tips','0')" type="button" value="0" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="clr('Tips')" type="button" value="clr" style="width:65px;height:65px;font-size:1em;" class="submits">
						</div>
									
									<!--<input type="button" value="Submit" style="" onclick="tip()"/>-->
						</form>	
</div>

<br/>