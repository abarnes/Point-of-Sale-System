<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<style>
	.droppable { width: 224px; height: 400px; padding: 0.5em; float: left; margin: 6px; }
	</style>
	<script>
        var newt = <?php echo $seatnum; ?>;
        
	$(function() {
		$( "#droppable1" ).droppable({
			drop: function( event, ui ) {
                            var id = $(ui.draggable).attr("id");
                            drp('1',id);
				$( this )
					.addClass( "ui-state-highlight" )
					//.find( "p" )
					//	.html( "Dropped!" );
                                
			},
                        out: function(event, ui) {
                            var i = $(ui.draggable).attr("id");
                            var id = i.replace('draggable','');
                            var old = document.getElementById("TicketTicket1").value;
                            var newtext = old.replace(id+',','');
                            document.getElementById("TicketTicket1").value = newtext;
                        }
		});
	});
        
        $(function() {
		$( "#droppable2" ).droppable({
			drop: function( event, ui ) {
                            var id = $(ui.draggable).attr("id");
                            drp('2',id);
				$( this )
					.addClass( "ui-state-highlight" )
					//.find( "p" )
					//	.html( "Dropped!" );
                                
			},
                        out: function(event, ui) {
                            var i = $(ui.draggable).attr("id");
                            var id = i.replace('draggable','');
                            var old = document.getElementById("TicketTicket2").value;
                            var newtext = old.replace(id+',','');
                            document.getElementById("TicketTicket2").value = newtext;
                        }
		});
	});
        
        function drp(ticket,id){
            var newtext = id.replace('draggable','');
            document.getElementById("TicketTicket"+ticket).value += newtext+',';
        }
        
        function add(){
            var num = 1;
            while(num==num) {
                if($('#droppable'+num).length) {
                    num++;
                } else {
                    break;
                }
            }
            
            var newdiv = document.createElement('div');
            newdiv.innerHTML = "<input type='hidden' name='data['Ticket']['ticket"+num+"']' value='' id='TicketTicket"+num+"'/>";
            document.getElementById("TicketSplit/<?php echo $id; ?>Form").appendChild(newdiv);
            $('.demo').append('<div id="droppable'+num+'" class="ui-widget-header droppable"><p style="float:left;">Ticket '+num+'</p><span style="float:right;"><a href="#" onclick="remo('+num+')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System')); ?></a></span></div>');
            $( "#droppable"+num).droppable({
			drop: function( event, ui ) {
                            var id = $(ui.draggable).attr("id");
                            drp(num,id);
				$( this )
					.addClass( "ui-state-highlight" )
					//.find( "p" )
					//	.html( "Dropped!" );
			},
                        out: function(event, ui) {
                            var i = $(ui.draggable).attr("id");
                            var id = i.replace('draggable','');
                            var old = document.getElementById("TicketTicket"+num).value;
                            var newtext = old.replace(id+',','');
                            document.getElementById("TicketTicket"+num).value = newtext;
                        }
            });
        }
        
        function remo(id){
            var child = document.getElementById('droppable'+id);
	    var parent = document.getElementById('demos');
	    parent.removeChild(child);
            
            $('#TicketTicket'+id).remove();
        }
	</script>

<div id="droparea">
	<h5>Drag the seat boxes into the ticket boxes to split the ticket into new tickets.  Click "Add Ticket" to create additional new tickets.</h5>
	<input style="width:90px;height:28px;font-size:1em;margin:10px 4px 10px 0px;" type="button" class="submits" value="Back" onclick="parent.history.back();">
	<hr style="width:100%;"/>
	
        <div style="width:100%;min-height:140px;">
		
		<div style="float:left;margin-right:10px;margin-bottom:8px;">
		<h3>Split Ticket <?php echo $ticket['Ticket']['dailyid']; ?>
		<?php if ($ticket['Type']['use_tables']=='1') { ?><br/> Table <?php echo $ticket['Ticket']['table']; ?><?php } ?></h3>        

			<div class="link">
			    <a href="#" onclick="add()"><input type="button" class="submits" value="Add Ticket"/></a>
			</div>
		</div>
		
            <?php foreach ($seats as $s) { ?>
            <script>
            $(function() {
                    $( "#draggable<?php echo $s['seat']; ?>" ).draggable();
            });
            </script>
            
            <div id="draggable<?php echo $s['seat']; ?>" style="width: 200px; padding: 0.5em; float: left; margin: 10px 10px 10px 0;" class="ui-widget-content">
                        <table style="font-size:75%;">
			<tr>
			    <th>Seat <?php echo $s['seat']; ?>
				<?php if ($s['orig_seat']!='0' && $s['orig_seat']!=$s['seat']) {
				    echo '(Originally Seat '.$s['orig_seat'].')';
				} ?>
				<span style="float:right;">$<?php echo $s['total']?></span>
			    </th>
			</tr>
			<?php foreach ($s['item'] as $data) { ?>
			<tr>
			    <td>
			    <span style="float:left;"><?php echo key($data); ?></span><span style="float:right;">$<?php echo $data[key($data)]['price']; ?></span>
			    <!--<br/>  Leave out mods for space
			    <p style="font-size:70%">
			    <?php /*
				$str = '';
				foreach ($data[key($data)]['mods'] as $m) { 
				    $str = $str.$m.', '; 
				}
				echo rtrim($str,', ');
				  */ ?>
			    </p>-->
			    </td>
			</tr>
			<?php } ?>
			</table>
            </div>
            <?php } ?>
        </div>
        <hr style="width:100%;"/>
	
        <div style="100%;float:left;" id="demos" class="demo">
    
        <div id="droppable1" class="ui-widget-header droppable">
                <p style="float:left;">Ticket 1</p><span style="float:right;"><a href="#" onclick="remo('1')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System')); ?></a></span>
        </div>
        
        <div id="droppable2" class="ui-widget-header droppable">
                <p style="float:left;">Ticket 2</p><span style="float:right;"><a href="#" onclick="remo('2')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System')); ?></a></span>
        </div>
    
        </div>
</div>


<div style="width:100%;float:left;">
    <form id="TicketSplit/<?php echo $id; ?>Form" method="post" action="/tickets/split/<?php echo $id; ?>" accept-charset="utf-8" class="theform">
                        <?php //echo $form->create('Payment', array('action' => 'split/'.$id)); ?>
                            <?php echo $form->input('Ticket.ticket1',array('value'=>'','type'=>'hidden')); ?>
                            <?php echo $form->input('Ticket.ticket2',array('value'=>'','type'=>'hidden')); ?>
			<div style="float:left;"><?php echo $form->end('Submit'); ?></div>
</div>