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
                            document.getElementById('User'+type).value += num;	
    }
    function clr(type){
                            var str = document.getElementById('User'+type);
                            var news = str.value.substring(0, str.value.length-1);
                            document.getElementById('User'+type).value = news; 	
    }
    </script>
<br/>
<h3>Quick Key In</h3>

    <div style="width:70%;float:left;">

    <div class="label">
    <?php echo $form->create('Users', array('action' => 'quick_in')); ?>
    <?php echo $form->input('User.quick', array( 'label' => '','value'=>'','autofocus'=>'autofocus')); ?>
    <?php echo $form->end('Submit'); ?>
    </div>
    
    <div style="height:100px;">
    </div>
    <p>Not clocked in yet?</p>
    <a href="/users/login" style="float:left;"><input type="button" value="Clock In" style="width:130px;font-size:1em;height:50px;" class="submits"/></a>
    
    <br/><br/><br/>
    <p style="float:left;">For demo users: **Once clocked in as "demo", you can use the quick key 11111 to access the system</p>
    
</div>
<div style="width:30%;float:right;">
    <form>
						<div style="float:left;width:100%;">
									<input onclick="calc('Quick','1')" type="button" value="1" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Quick','2')" type="button" value="2" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Quick','3')" type="button" value="3" style="width:65px;height:65px;font-size:1em;" class="submits">			
									<div style="height:0px;"></div>
									<input onclick="calc('Quick','4')" type="button" value="4" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Quick','5')" type="button" value="5" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Quick','6')" type="button" value="6" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Quick','7')" type="button" value="7" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Quick','8')" type="button" value="8" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Quick','9')" type="button" value="9" style="width:65px;height:65px;font-size:1em;" class="submits">
									<div style="height:0px;"></div>
									<input onclick="calc('Quick','.')" type="button" value="." style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="calc('Quick','0')" type="button" value="0" style="width:65px;height:65px;font-size:1em;" class="submits">
									<input onclick="clr('Quick')" type="button" value="clr" style="width:65px;height:65px;font-size:1em;" class="submits">
						</div>
									
									
						</form>
</div>
