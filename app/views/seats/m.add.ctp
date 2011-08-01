<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<?php
        //add divs for each seat
        $co = 0;
        while ($co!=$seats) {
				$sn = $co+1;
            ?>
	    <!---------------Each Seat-->
	    <div id="seatc<?php echo $sn; ?>">
		<div class="toolbar">
			<?php if ($ticket['Type']['use_seats']=='1') { ?>
				<a class="other" onclick="prev('<?php echo $sn; ?>')">Previous</a><h1>Seat <?php echo $sn; ?></h1><a class="button" onclick="next(<?php echo $sn; ?>)">Next</a>
			<?php } else { ?>
				<h1><?php echo $ticket['Type']['name']; ?></h1>
			<?php } ?>
		</div>
		
                    <!-------links for each category----->
                    <ul class="rounded">    
                    <?php foreach ($categories as $ct) { ?>
                        <li><a class="touch" href="#cats<?php echo $co; ?>-<?php echo $ct['Category']['id'].'-'.$sn; ?>"><?php echo $ct['Category']['name']; ?></a></li>
                    <?php } ?>
                    </ul>
	    
		    <!--current items for this seat--------->
				    <div id="sseat<?php echo $sn; ?>" style="margin:10px;" class="itemlist">
										    
				    </div>
                   
                    <a class="grayButton" style="font-size:.9em;" onclick="opts('<?php echo $sn; ?>')">Options</a> 
                    <br/><hr/><br/>                
                    <a onclick="document.forms['SeatAdd/<?php echo $id.'/'.$seats; ?>Form'].submit()" class="grayButton">Place Order</a>
                    <br/>
            </div>
            
		<!----------divs for each category--------->
		<?php foreach ($categories as $ct) { ?>
		    <div id="cats<?php echo $co; ?>-<?php echo $ct['Category']['id'].'-'.$sn; ?>">
                        <div class="toolbar"><a class="other" href="#seatc<?php echo $sn; ?>">Back</a><h1><?php echo $ct['Category']['name']; ?></h1></div>
								
			<!-----------------links for each item------->
			<ul class="rounded">
			<?php foreach($ct['Item'] as $i) { ?>
				<?php if ($i['enable']=='1') { ?>	
					<?php //see if item needs mods by default
					if ($i['mods_on']==1) { ?>
					    <li><a class="touch" href="#itm<?php echo $sn.'-'.$i['id']; ?>"><?php echo $i['short_name']; ?></a></li>
					<?php } else { ?>
					    <li><a class="touch" href="#" onclick="seat('<?php echo $sn; ?>','<?php echo $i['short_name']; ?>','<?php echo $i['id']; ?>','')"><?php echo $i['short_name']; ?></a></li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			</ul>
                    </div>
					     
		    <!-----divs for individual items-------------->
		    <?php foreach($ct['Item'] as $i) { ?>
			<?php if ($i['enable']=='1') { ?>
			<script type="text/javascript">
			    var t<?php echo $sn.'k'.$i['id']; ?> = '';
			    var tx<?php echo $sn.'k'.$i['id']; ?> = '';
			</script>
								
			<div id="itm<?php echo $sn.'-'.$i['id']; ?>">
			    <div class="toolbar"><a class="other" href="#cats<?php echo $co; ?>-<?php echo $ct['Category']['id'].'-'.$sn; ?>">Back</a><h1><?php echo $i['short_name']; ?></h1></div>
																
			    <!----------links for modifiers------------------>
			    <form name="frm<?php echo $sn.'-'.$i['id']; ?>">
			    <ul class="rounded">				
			    <?php foreach ($i['Modifier'] as $m) { ?>
				<?php if ($m['enable']=='1') { ?>
				<li><span style="color:white;"><?php echo $m['name']; ?></span><span class="toggle"><input type="checkbox" onclick="modifd('<?php echo $sn; ?>','<?php echo $i['id']; ?>','<?php echo $m['id']; ?>','<?php echo $m['name']; ?>')" id="<?php echo $m['id'].'m'.$sn.'k'.$i['id']; ?>"/></span></li>
				<?php } ?>
			    <?php } ?>
			    </ul>
                            </form>
			    
                            <a type="button" class="grayButton" onclick="finishd('<?php echo $sn; ?>','<?php echo $i['name']; ?>','<?php echo $i['id']; ?>')">Submit</a><br/>
			</div>
			<?php } ?>
		    <?php } ?>
                    
                    <!--------edit divs for items--------->
                    <?php foreach($ct['Item'] as $i) { ?>
			<?php if ($i['enable']=='1') { ?>
			<script type="text/javascript">
                            var tt<?php echo $sn.'k'.$i['id']; ?> = '';
                            var txx<?php echo $sn.'k'.$i['id']; ?> = '';
			</script>
								
			<div id="itmedit<?php echo $sn.'-'.$i['id']; ?>">
			    <div class="toolbar"><a class="other" href="#" onclick="backs('<?php echo $sn; ?>')">Back</a><h1><?php echo $i['name']; ?></h1></div>
																
			    <!----------links for modifiers (edit)------------------>
			    <form name="frmedit<?php echo $sn.'-'.$i['id']; ?>">
			    <ul class="rounded">				
			    <?php foreach ($i['Modifier'] as $m) { ?>
				<?php if ($m['enable']=='1') { ?>
				<li><span style="color:white;"><?php echo $m['name']; ?></span><span class="toggle"><input type="checkbox" onclick="modif_edit('<?php echo $sn; ?>','<?php echo $i['id']; ?>','<?php echo $m['id']; ?>','<?php echo $m['name']; ?>')" id="edit<?php echo $m['id'].'m'.$sn.'k'.$i['id']; ?>"/></span></li>
				<?php } ?>
			    <?php } ?>
			    </ul>
                            </form>
                            <span style="display:none;" id="<?php echo $sn; ?>edits<?php echo $i['id']; ?>"></span>
			    <span style="display:none;" id="<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>"></span>
			    
                            <a class="grayButton" type="button" onclick="finish_edit('<?php echo $sn; ?>','<?php echo $i['name']; ?>','<?php echo $i['id']; ?>')">Submit</a><br/>
			</div>
			<?php } ?>
		    <?php } ?>
                    
                 <?php } ?>
	    
            <!---------------End Seat--->
<?php $co++; } ?>

<!--------form that contains submitted data---------->
<div id="finish">
    <?php echo $form->create('Seat', array('action' => 'add/'.$id.'/'.$seats)); ?>
    <?php
    $c = 0;
    while ($c!=$seats) {
        echo $form->input('Seat.'.$c.'.items',array('value'=>'','type'=>'hidden'));
    $c++;
    } ?>
    
    <?php echo $form->end('Submit'); ?>
</div>



<!-----edit ticket info code------>
<div id="editform">
				<div class="toolbar"><a class="back" href="#seatc1">Back</a><h1>Edit</h1></div>				
				<?php echo $form->create('Ticket', array('action' => 'edit/'.$ticket['Ticket']['id'])); ?>
                                    <ul class="edit rounded">
				    <li><span style="color:white;float:left;">Table</span><span style="float:right;"><?php echo $form->input('Ticket.table', array( 'label' => '','placeholder'=>'Table','value'=>$ticket['Ticket']['table'])); ?></span></li>
				    <li><span style="color:white;float:left;">Type</span><span style="float:right;"><?php echo $form->input('Ticket.type_id', array( 'label' => '','placeholder'=>'Type','value'=>$ticket['Ticket']['type_id'])); ?></span></li>
				    <li><span style="color:white;float:left;">Seats</span><span style="float:right;"><?php echo $form->input('Ticket.seats', array( 'label' => '','placeholder'=>'Number of Seats','value'=>$seats)); ?></span></li>
                                    </ul><br/>
                                <a class="grayButton" rel="external" onclick="document.forms['TicketEdit/<?php echo $id; ?>Form'].submit()">Submit</a>    
				<?php //echo $form->end('Update'); ?>
</div>

<!----------------javascript global functions (open link, add without mods, remove)----------------->
<script type="text/javascript">
			var newt;
				function clicked(sn,id,vf) {
					window.newt = vf;
					var st = document.getElementById("p"+sn+"k"+id+"-"+vf).innerHTML;
					document.getElementById(sn+"edits"+id).innerHTML = st;
					document.getElementById(sn+"editsvf"+id).innerHTML = vf;
                                        
                                        var fifth = vf;
                                        var first = vf.length;
                                        if (first==0) {
                                            var jQT = new $.jQTouch();
                                            jQT.goTo('#itmedit'+sn+'-'+id);
                                        } else {
                                            var second = fifth.slice(0,first-1);
                                            if (second.indexOf(':')!=-1) {
                                                var third = second.split(":");
                                                var fourth = third.length;
                                                var sixth = fourth-1;
                                                var i=0;
                                                for (i=0;i<=sixth;i++) {
                                                    var txt = third[i];
                                                    //alert(txt);
                                                    document.getElementById("edit"+txt+"m"+sn+"k"+id).checked = true;
                                                    document.getElementById("edit"+txt+"m"+sn+"k"+id).value = '1';
                                                }   
                                            } else {
                                                document.getElementById("edit"+second+"m"+sn+"k"+id).checked = true;
                                                document.getElementById("edit"+second+"m"+sn+"k"+id).value = '1';
                                            }
                                            var jQT = new $.jQTouch();
                                            jQT.goTo('#itmedit'+sn+'-'+id);
                                        }
				}
</script>

<script type='text/javascript'>
function seat(sn,txt,id,mod) {
      var c = sn-1;
      $('#sseat'+sn).append('<div class="itemdiv" id="itemdiv'+sn+'k'+id+'-"><span id="'+sn+'k'+id+'-" class="iteml"><a href="#" onclick="clicked(\''+sn+'\',\''+id+'\',\''+mod+'\')">'+txt+'</a></span><a id="a'+sn+'k'+id+'-'+mod+'" onclick="remo(\''+sn+'\',\''+id+'('+mod+'),\',\''+sn+'k'+id+'-\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?><br/></a><p style="font-size:70%" id="p'+sn+'k'+id+'-'+mod+'"></p></div>');
      document.getElementById("Seat"+c+"Items").value += id+'('+mod+'),';
      var jQT = new $.jQTouch();
      jQT.goTo('#seatc'+sn);
}

function remo(sn,txt,t) {
			//remove item that's been added already
			//change form
			var c = sn-1;
			var old = document.getElementById("Seat"+c+"Items").value;
			var newtext = old.replace(txt,'');
			document.getElementById("Seat"+c+"Items").value = newtext;
			
			//change seats view
			var d = document.getElementById('sseat'+sn);
			var r = document.getElementById('itemdiv'+t);
			d.removeChild(r);
}
</script>

<script type="text/javascript">
												
    function modifd(sn,id,mod,name) {
	var fi = document.getElementById(mod+'m'+sn+'k'+id);
	if (fi.checked==true) {
            this["t"+sn+"k"+id]+=mod+':';
            this["tx"+sn+"k"+id]+=name+' ';
	} else {
            this["t"+sn+"k"+id] = this["t"+sn+"k"+id].replace(mod+':','');
	    this["tx"+sn+"k"+id] = this["tx"+sn+"k"+id].replace(name+' ','');
	}
    }
																
    function finishd(sn,txt,id) {
        var t = this["t"+sn+"k"+id];
        var tx = this["tx"+sn+"k"+id];
        var c = sn-1;
	$('#sseat'+sn).append('<div class="itemdiv" id="itemdiv'+sn+'k'+id+'-'+t+'"><span id="'+sn+'k'+id+'-'+t+'" class="iteml"><a href="#" onclick="clicked(\''+sn+'\',\''+id+'\',\''+t+'\')">'+txt+'</a><a id="a'+sn+'k'+id+'-'+t+'" href="#" onclick="remo(\''+sn+'\',\''+id+'('+t+'),\',\''+sn+'k'+id+'-'+t+'\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?></a></span><p style="font-size:70%" id="p'+sn+'k'+id+'-'+t+'">'+tx+'</p></div>');
	
        document.getElementById("Seat"+c+"Items").value += id+'('+t+'),';
        
        //deselect modifiers in case a second item is added
        var first = t.length;
        if (first!=0) {
            var second = t.slice(0,first-1);
            if (second.indexOf(':')!=-1) {
                var third = second.split(":");
                var fourth = third.length;
                var sixth = fourth-1;
                var i=0;
                for (i=0;i<=sixth;i++) {
                    var txt = third[i];
                    //alert(txt);
                    document.getElementById(txt+"m"+sn+"k"+id).checked = false;
                    document.getElementById(txt+"m"+sn+"k"+id).value = '0';
                }   
            } else {
                document.getElementById(second+"m"+sn+"k"+id).checked = false;
                document.getElementById(second+"m"+sn+"k"+id).value = '0';
            }
        }
        this["t"+sn+"k"+id]='';
        this["tx"+sn+"k"+id]='';
        
	var jQT = new $.jQTouch();
	jQT.goTo('#seatc'+sn);
    }
    
    //edit functions
    
    function modif_edit(sn,id,mod,name) {
        var fi = document.getElementById("edit"+mod+'m'+sn+'k'+id);
	if (fi.checked==true) {
	    //alert('true');
            this["tt"+sn+"k"+id]+=mod+':';
            this["txx"+sn+"k"+id]+=name+' ';
            document.getElementById(sn+"edits"+id).innerHTML+=name+' ';
	    document.getElementById(sn+"editsvf"+id).innerHTML+=mod+':';
	} else {
	    //alert('false');
            this["tt"+sn+"k"+id] = this["t"+sn+"k"+id].replace(mod+':','');
	    this["txx"+sn+"k"+id] = this["tx"+sn+"k"+id].replace(name+' ','');
            var findone = $('#'+sn+"edits"+id).html();
            var findtwo = $('#'+sn+"editsvf"+id).html();
            var newone = findone.replace(name+' ','');
	    var newtwo = findtwo.replace(mod+':','');
            $('#'+sn+"edits"+id).replaceWith('<span style="display:none;" id="'+sn+'edits'+id+'">'+newone+'</span>');
            $('#'+sn+"editsvf"+id).replaceWith('<span style="display:none;" id="'+sn+'editsvf'+id+'">'+newtwo+'</span>');
	}
    }
                                    
    function finish_edit(sn,txt,id) {
        var c = sn-1;				    
						
	var old = document.getElementById("Seat"+c+"Items").value;
	var newtext = old.replace(id+'('+window.newt+'),','');
	document.getElementById("Seat"+c+"Items").value = newtext;
	
        gt = document.getElementById(sn+"edits"+id).innerHTML;
	gtvf = document.getElementById(sn+"editsvf"+id).innerHTML;
        
        var d = document.getElementById('sseat'+sn);
	var r = document.getElementById('itemdiv'+sn+'k'+id+'-'+window.newt);
	d.removeChild(r);
        
	$('#sseat'+sn).append('<div class="itemdiv" id="itemdiv'+sn+'k'+id+'-'+gtvf+'"><span id="'+sn+'k'+id+'-'+gtvf+'" class="iteml"><a href="#" onclick="clicked(\''+sn+'\',\''+id+'\',\''+gtvf+'\')">'+txt+'</a><a id="a'+sn+'k'+id+'-'+gtvf+'" href="#" onclick="remo(\''+sn+'\',\''+id+'('+gtvf+'),\',\''+sn+'k'+id+'-'+gtvf+'\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?></a></span><p style="font-size:70%" id="p'+sn+'k'+id+'-'+gtvf+'">'+gt+'</p></div>');
        document.getElementById("Seat"+c+"Items").value += id+'('+gtvf+'),';
        
        //deselect modifiers in case a second item is added
        var first = gtvf.length;
        if (first!=0) {
            var second = gtvf.slice(0,first-1);
            if (second.indexOf(':')!=-1) {
                var third = second.split(":");
                var fourth = third.length;
                var sixth = fourth-1;
                var i=0;
                for (i=0;i<=sixth;i++) {
                    var txt = third[i];
                    //alert(txt);
                    document.getElementById("edit"+txt+"m"+sn+"k"+id).checked = false;
                    document.getElementById("edit"+txt+"m"+sn+"k"+id).value = '0';
                }   
            } else {
                document.getElementById("edit"+second+"m"+sn+"k"+id).checked = false;
                document.getElementById("edit"+second+"m"+sn+"k"+id).value = '0';
            }
        }
        this["tt"+sn+"k"+id]='';
        this["txx"+sn+"k"+id]='';
        
        var jQT = new $.jQTouch();
	jQT.goTo('#seatc'+sn);
    }
    
    function backs(sn){
        var jQT = new $.jQTouch();
	jQT.goTo('#seatc'+sn);
    }
    
    function prev(sn){
        if (sn=='1') {
            var ss = <?php echo $seats; ?>
        } else {
            var ss = sn-1;
        }
        //var ss = ss.toString;
        var jQT = new $.jQTouch();
	jQT.goTo('#seatc'+ss);
    }
    
    function next(sn){
        if (sn==<?php echo $seats; ?>) {
            var ff = 1;
        } else {
            var ff = sn+1;
        }
        //var ff = ff.toString;
        var jQT = new $.jQTouch();
	jQT.goTo('#seatc'+ff);
    }
    
    function opts(sn){
        var c = sn-1;
       document.getElementById('optsd').setAttribute('onclick','next('+c+')');
       
       var jQT = new $.jQTouch();
        jQT.goTo('#options'); 
    }
</script>
<!------------options section-------------->
<div id="options">
    <div class="toolbar"><a class="other" href="#" id="optsd" onclick="">Back</a><h1>Options</h1></div>
    <br/>
    <ul class="rounded">
        <li><a href="#editform">Edit Ticket Info</a></li>
        <li><?php
		echo $html->link(
					    'Cancel Ticket', 
					    array('controller'=>'tickets','action'=>'inc_delete/'.$id), 
					    array('rel'=>'external'), 
					    'Are You Sure You Want To Cancel This Ticket?'
				    );
	?></li>
    </ul>
</div>
