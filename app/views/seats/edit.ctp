<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->

<script type="text/javascript">
                                $(function(){
                                // Dialog			
				$('#editform').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						//"Ok": function() { 
						//	$(this).dialog("close"); 
						//}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#editform_link').click(function(){
					$('#editform').dialog('open');
					return false;
				});
                            });
</script>
<div id="editform" title="Update Ticket Details">
<?php echo $form->create('Ticket', array('action' => 'edit/'.$ticket['Ticket']['id'].'/'.$seats)); ?>
    <?php echo $form->input('Ticket.table', array( 'label' => 'Table: ','value'=>$ticket['Ticket']['table'])); ?>
    <?php echo $form->input('Ticket.type_id', array( 'label' => 'Type: ','value'=>$ticket['Ticket']['type_id'])); ?>
    <?php echo $form->input('Ticket.seats', array( 'label' => 'Number of Seats: ','value'=>$seats)); ?>
<?php echo $form->end('Update'); ?>
</div>

<div style="width:25%;float:right;">
<ul style="float:right;margin-top:5px;margin-bottom:8px;">
				<li style="display:inline;margin:0px 6px;"><input style="width:135px;height:40px;font-size:1em;position:relative;bottom:0px;margin:0px;" type="button" class="submits" value="Edit Ticket Details" id="editform_link"/></li>
				<li style="display:inline;margin:0px;"><a href="/tickets/view/<?php echo $id; ?>" onclick="return confirm('Are you sure you want to cancel editing this ticket?');"><input style="width:70px;height:40px;font-size:1em;position:relative;bottom:0px;margin:0px;" type="button" class="submits" value="Cancel"/></a></li>
</ul>
</div>

<script type="text/javascript">
			var newt;
			$(function(){
				// Tabs
				$('#tabs').tabs();
                                <?php
                                $co = 0;
                                while ($co!=$seats) { ?>
                                $('#cats<?php echo $co; ?>').tabs();
                                <?php
                                $co++;
                                }
                                ?>
			});
</script>

<div style="width:75%;text-align:center;float:left;">
    
   <!-- <table style="border:0px solid black;margin-right:auto;margin-left:auto;"><tr><td>-->
        
    <form>
    
    <div id="tabs">
        <ul>
    <?php
    //add forms for each seat
    $co = 0;
    while ($co!=$seats) {
        ?>
	    
        <?php
        $sn = $co+1;
        //echo 'Seat '.$sn; ?>
	
        <?php if ($ticket['Type']['use_seats']=='1') { ?>
			<li><a href="#tabs-<?php echo $co; ?>">Seat <?php echo $sn; ?></a></li>
	<?php } else { ?>
			<li><a href="#tabs-<?php echo $co; ?>">Order</a></li>
	<?php } ?>

    <?php
    $co++;
    } ?>
        </ul>

        <?php
        //add divs for each tab
        $co = 0;
        while ($co!=$seats) {
            ?>
        <div id="tabs-<?php echo $co; ?>">
            <?php $sn = $co+1; ?>
            
           
        <div id="cats<?php echo $co; ?>">
                    <ul>    
           <?php foreach ($categories as $ct) { ?>
                        <li><a href="#cats<?php echo $co; ?>-<?php echo $ct['Category']['id'].'-'.$sn; ?>"><?php echo $ct['Category']['name']; ?></a></li>
            <?php } ?>
                    </ul>
                    
            <?php foreach ($categories as $ct) { ?>
                    <div id="cats<?php echo $co; ?>-<?php echo $ct['Category']['id'].'-'.$sn; ?>">
                    <?php //print_r($ct['Item']); ?>
                    
                    <?php foreach($ct['Item'] as $i) { ?>
			<?php if ($i['enable']=='1') { ?>
                    
                        <?php
                        //see if item needs mods by default
                        if ($i['mods_on']==1) { ?>
                        
                            <script type="text/javascript">
                                $(function(){
                                // Dialog			
				$('#dialog-<?php echo $sn.'-'.$i['id']; ?>').dialog({
					autoOpen: false,
					width: 660,
					buttons: {
						//"Ok": function() { 
						//	$(this).dialog("close"); 
						//}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog-<?php echo $sn.'-'.$i['id']; ?>_link').click(function(){
					document.getElementById("<?php echo $sn; ?>mods<?php echo $i['id']; ?>").innerHTML = '';
					 window.t<?php echo $sn.'k'.$i['id']; ?> = '';
			                 window.tx<?php echo $sn.'k'.$i['id']; ?> = '';
					$('#dialog-<?php echo $sn.'-'.$i['id']; ?>').dialog('open');
					return false;
				});
                            });
				
				$(function(){
                                // Dialog			
				$('#dialogg-<?php echo $sn.'-'.$i['id']; ?>').dialog({
					autoOpen: false,
					width: 660,
					buttons: {
						//"Ok": function() { 
						//	$(this).dialog("close"); 
						//}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
                            });
                            </script>
			  
                            <input onclick="" type="button" value="<?php echo $i['short_name']; ?>" style="width:100px;height:80px;margin-bottom:14px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits" id="dialog-<?php echo $sn.'-'.$i['id']; ?>_link">
			    
                            <div id="dialog-<?php echo $sn.'-'.$i['id']; ?>" title="Options">
                                <script type="text/javascript">
                                    var t<?php echo $sn.'k'.$i['id']; ?> = '';
                                    var tx<?php echo $sn.'k'.$i['id']; ?> = '';
                                </script>
				    <span style="display:none;" id="<?php echo $sn; ?>mods<?php echo $i['id']; ?>"></span>
                                    <?php foreach ($i['Modifier'] as $m) { ?>
						<?php if ($m['enable']=='1') { ?>
                                        <input onclick="modifd('<?php echo $sn; ?>','<?php echo $i['id']; ?>','<?php echo $m['id']; ?>','<?php echo $m['name']; ?>')" type="button" value="<?php echo $m['name']; ?>" style="width:100px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits" id="<?php echo $m['id'].'m'.$sn.'k'.$i['id']; ?>">
						<?php } ?>
                                    <?php } ?>
                                    <br/>
                                    <input type="button" onclick="finishd('<?php echo $sn; ?>','<?php echo $i['name']; ?>','<?php echo $i['id']; ?>')" value="Finish">
                            </div>
    
			<div id="dialogg-<?php echo $sn.'-'.$i['id']; ?>" title="Options">
                                <script type="text/javascript">
                                    var tt<?php echo $sn.'k'.$i['id']; ?> = '';
                                    var txx<?php echo $sn.'k'.$i['id']; ?> = '';
                                </script>
				    <span style="display:none;" id="<?php echo $sn; ?>edits<?php echo $i['id']; ?>"></span>
                                    <?php foreach ($i['Modifier'] as $m) { ?>
						<?php if ($m['enable']=='1') { ?>
                                        <input onclick="modif_edit('<?php echo $sn; ?>','<?php echo $i['id']; ?>','<?php echo $m['id']; ?>','<?php echo $m['name']; ?>')" type="button" value="<?php echo $m['name']; ?>" style="width:100px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits" id="<?php echo $m['id'].'mm'.$sn.'k'.$i['id']; ?>">
						<?php } ?>
                                    <?php } ?>
                                    <br/>
				    <span style="display:none;" id="<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>"></span>
                                    <input type="button" onclick="finish_edit('<?php echo $sn; ?>','<?php echo $i['name']; ?>','<?php echo $i['id']; ?>')" value="Finish">
                            </div>
                                  
                        <?php } else { ?>
                            <input onclick="seat('<?php echo $sn; ?>','<?php echo $i['name']; ?>','<?php echo $i['id']; ?>','')" type="button" value="<?php echo $i['short_name']; ?>" style="width:100px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits">
			    
			    <script type="text/javascript">
				$(function(){
                                // Dialog			
				$('#dialogg-<?php echo $sn.'-'.$i['id']; ?>').dialog({
					autoOpen: false,
					width: 660,
					buttons: {
						//"Ok": function() { 
						//	$(this).dialog("close"); 
						//}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
                            });
                            </script>
			    
			    <div id="dialogg-<?php echo $sn.'-'.$i['id']; ?>" title="Options">
                                <script type="text/javascript">
                                    var tt<?php echo $sn.'k'.$i['id']; ?> = '';
                                    var txx<?php echo $sn.'k'.$i['id']; ?> = '';
                                </script>
				    <span style="display:none;" id="<?php echo $sn; ?>edits<?php echo $i['id']; ?>"></span>
                                    <?php foreach ($i['Modifier'] as $m) { ?>
						<?php if ($m['enable']=='1') { ?>
                                        <input onclick="modif_edit('<?php echo $sn; ?>','<?php echo $i['id']; ?>','<?php echo $m['id']; ?>','<?php echo $m['name']; ?>')" type="button" value="<?php echo $m['name']; ?>" style="width:100px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits" id="<?php echo $m['id'].'mm'.$sn.'k'.$i['id']; ?>">
					<?php } ?>
                                    <?php } ?>
                                    <br/>
				    <span style="display:none;" id="<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>"></span>
                                    <input type="button" onclick="finish_edit('<?php echo $sn; ?>','<?php echo $i['name']; ?>','<?php echo $i['id']; ?>')" value="Finish">
                            </div>
                        <?php } ?>
			
			<?php } ?>
                    <?php } ?>
                    
                    </div>
                    
                    <!--<input onclick="seat<?php //echo $co+1; ?>('<?php //echo $i['name']; ?>','<?php //echo $i['id']; ?>','')" type="button" value="<?php //echo $i['name']; ?>" style="width:100px;height:80px;margin-bottom:14px;">-->
           <?php } ?>
    </div>
       
       
       
    </div>
    <?php
    $co++;
    } ?>
</div>
    
    </form>
    <br/>
<!--</td></tr></table>-->
</div>


			<div style="width:25%;min-width:200px;float:right;">
						
			     <?php
			    //construct overview div
			    $cn = 0;
			    $sn = $cn+1;
			    foreach ($sts as $s) { ?>
			    <?php //die(print_r($s)); ?>
			    <table class="sseat<?php echo $cn+1; ?>">
				<tr>
				    <td>
					<?php if ($ticket['Type']['use_seats']=='1') { ?>	
						<h4>Seat <?php echo $sn; ?></h4>
			                <?php } else { ?>
						<h4>Order</h4>
					<?php } ?>
				    </td>
				</tr>
				<tr>
						<td>
									<div id="sseat<?php echo $cn+1; ?>">
									<?php foreach ($s['item'] as $i) {
												echo '<span id="'.$sn.'k'.$i[key($i)]['id'].'-'.$i[key($i)]['mo'].'"><a href="#" onclick="clicked(\''.$sn.'\',\''.$i[key($i)]['id'].'\',\''.$i[key($i)]['mo'].'\')">'.key($i).'</a><a href="#" onclick="remo'.$sn.'(\''.$i[key($i)]['id'].'('.$i[key($i)]['mo'].')\',\''.$sn.'k'.$i[key($i)]['id'].'-'.$i[key($i)]['mo'].'\')">'.$html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')).'</a><br/></span>';
												echo '<p style="font-size:70%" id="p'.$sn.'k'.$i[key($i)]['id'].'-'.$i[key($i)]['mo'].'">';
												$str = '';
												if (count($i[key($i)]['mods'])==0) {
													//echo '<br/>';		
												} else {
															foreach ($i[key($i)]['mods'] as $m) { 
															    $str = $str.$m.', '; 
															}
															echo rtrim($str,', ');
												}
												echo '</p><div style="height:5px;"></div>';
									} ?>
									</div>
						</td>
				</tr>
			    </table>
			    
			    <?php
			    $cn++;
			    $sn++;
			    } ?>
			    
			</div>


<div class="div3"></div>


<script type="text/javascript">
<?php
$c = 0;
while ($c!=$seats) {
	$sn = $c+1;		?>
function seat<?php echo $c+1; ?>(txt,id,mod) {
      $('#sseat<?php echo $c+1; ?>').append('<span id="<?php echo $sn.'k'; ?>'+id+'-"><a href="#" onclick="clicked(\'<?php echo $sn; ?>\',\''+id+'\',\''+mod+'\')">'+txt+'</a></span><a id="a<?php echo $sn.'k'; ?>'+id+'-'+mod+'" href="#" onclick="remo<?php echo $sn; ?>(\''+id+'('+mod+'),\',\'<?php echo $sn.'k'; ?>'+id+'-\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?><br/></a><p style="font-size:70%" id="p<?php echo $sn.'k'; ?>'+id+'-'+mod+'"></p>');
      document.getElementById("Seat<?php echo $c; ?>Items").value += id+'('+mod+'),';   
    }

function remo<?php echo $c+1; ?>(txt,t) {
			//remove item that's been added already
			//change form
			var old = document.getElementById("Seat<?php echo $c; ?>Items").value;
			var newtext = old.replace(txt,'');
			document.getElementById("Seat<?php echo $c; ?>Items").value = newtext;
			
			//change seats view
			var d = document.getElementById('sseat<?php echo $c+1; ?>');
			var r = document.getElementById(t);
			d.removeChild(r);
			var r3 = document.getElementById('a'+t);
			if (r3 != null) {
						d.removeChild(r3);
			}
			var r2 = document.getElementById('p'+t);
			if (r2 != null) {
						d.removeChild(r2);
			}
}
    
<?php
$c++;
} ?>
</script>

<script type="text/javascript">
function submitform() {
  //$('#SeatAdd<?php echo '/'.$id.'/'.$seats; ?>Form').submit();
  document.getElementById('SeatEdit<?php echo '/'.$id.'/'.$seats; ?>Form').submit();
}
</script>

<?php echo $form->create('Seat', array('action' => 'edit/'.$id.'/'.$seats)); ?>

<?php
$c = 0;
while ($c!=$seats) {
    echo $form->input('Seat.'.$c.'.items',array('value'=>$data['Seat'][$c]['items'],'type'=>'hidden'));
    echo $form->input('Seat.'.$c.'.id',array('value'=>$data['Seat'][$c]['id'],'type'=>'hidden'));
$c++;
} ?>

<?php //echo $form->end('Submit'); ?>
<a style="vertical-align:bottom;margin-left:0px;" href="#" onclick="submitform()"><input style="width:75%;" type="button" class="submits" value="Submit"></a>

<!----------------javascript global functions (open link, add without mods, remove)----------------->
<script type="text/javascript">
			var newt;
				function clicked(sn,id,vf) {
					window.newt = vf;
					var st = document.getElementById("p"+sn+"k"+id+"-"+vf).innerHTML;
					document.getElementById(sn+"edits"+id).innerHTML = st+' ';
					document.getElementById(sn+"editsvf"+id).innerHTML = vf;
					
					var fifth = vf;
                                        var first = vf.length;
                                        if (first==0) {
                                            $('#dialogg-'+sn+'-'+id).dialog('open');
                                        } else {
                                            var second = fifth.slice(0,first-1);
                                            if (second.indexOf(':')!=-1) {
                                                var third = second.split(":");
                                                var fourth = third.length;
                                                var sixth = fourth-1;
                                                var i=0;
                                                for (i=0;i<=sixth;i++) {
                                                    var txt = third[i];
						    $('#'+txt+'mm'+sn+'k'+id).removeClass('submits');
						    $('#'+txt+'mm'+sn+'k'+id).addClass('submits2');
                                                    //alert(txt);
                                                }   
                                            } else {
				                $('#'+second+'mm'+sn+'k'+id).removeClass('submits');
				                $('#'+second+'mm'+sn+'k'+id).addClass('submits2');
                                                //document.getElementById("edit"+second+"m"+sn+"k"+id).checked = true;
                                                //document.getElementById("edit"+second+"m"+sn+"k"+id).value = '1';
                                            }
                                            $('#dialogg-'+sn+'-'+id).dialog('open');
                                        }
				}
</script>

<script type='text/javascript'>
function seat(sn,txt,id,mod) {
      var c = sn-1;
      $('#sseat'+sn).append('<span id="'+sn+'k'+id+'-"><a href="#" onclick="clicked(\''+sn+'\',\''+id+'\',\''+mod+'\')">'+txt+'</a></span><a id="a'+sn+'k'+id+'-'+mod+'" onclick="remo(\''+sn+'\',\''+id+'('+mod+'),\',\''+sn+'k'+id+'-\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?><br/></a><p style="font-size:70%" id="p'+sn+'k'+id+'-'+mod+'"></p><div style="height:6px;"></div>');
      document.getElementById("Seat"+c+"Items").value += id+'('+mod+'),';
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
			//alert(t);
			var r = document.getElementById(t);
			d.removeChild(r);
			var r3 = document.getElementById('a'+t);
			if (r3 != null) {
						d.removeChild(r3);
			}
			var r2 = document.getElementById('p'+t);
			if (r2 != null) {
						d.removeChild(r2);
			}
}
</script>

<script type="text/javascript">
												
    function modifd(sn,id,mod,name) {
	//var fi = document.getElementById(mod+'m'+sn+'k'+id);
	if ($('#'+mod+'m'+sn+'k'+id).hasClass('submits')==true) {
            this["t"+sn+"k"+id]+=mod+':';
            this["tx"+sn+"k"+id]+=name+' ';
	    $('#'+mod+'m'+sn+'k'+id).removeClass('submits');
	    $('#'+mod+'m'+sn+'k'+id).addClass('submits2');
	} else {
            this["t"+sn+"k"+id] = this["t"+sn+"k"+id].replace(mod+':','');
	    this["tx"+sn+"k"+id] = this["tx"+sn+"k"+id].replace(name+' ','');
	    $('#'+mod+'m'+sn+'k'+id).removeClass('submits2');
	    $('#'+mod+'m'+sn+'k'+id).addClass('submits');
	}
    }
																
    function finishd(sn,txt,id) {
        var t = this["t"+sn+"k"+id];
        var tx = this["tx"+sn+"k"+id];
        var c = sn-1;
	$('#sseat'+sn).append('<span id="'+sn+'k'+id+'-'+t+'"><a href="#" onclick="clicked(\''+sn+'\',\''+id+'\',\''+t+'\')">'+txt+'</a><a id="a'+sn+'k'+id+'-'+t+'" href="#" onclick="remo(\''+sn+'\',\''+id+'('+t+'),\',\''+sn+'k'+id+'-'+t+'\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?></a></span><p style="font-size:70%" id="p'+sn+'k'+id+'-'+t+'">'+tx+'</p><div style="height:5px;"></div>');
	
        document.getElementById("Seat"+c+"Items").value += id+'('+t+'),';
        
        this["t"+sn+"k"+id]='';
        this["tx"+sn+"k"+id]='';
	$('#dialog-'+sn+'-'+id).dialog("close");
    }
    
    //edit functions
    
    function modif_edit(sn,id,mod,name) {
        //var fi = document.getElementById("edit"+mod+'m'+sn+'k'+id);
	if ($('#'+mod+'mm'+sn+'k'+id).hasClass('submits')==true) {
	    //alert('add');
            this["tt"+sn+"k"+id]+=mod+':';
            this["txx"+sn+"k"+id]+=name+' ';
	    $('#'+mod+'mm'+sn+'k'+id).removeClass('submits');
	    $('#'+mod+'mm'+sn+'k'+id).addClass('submits2');
            document.getElementById(sn+"edits"+id).innerHTML+=name+' ';
	    document.getElementById(sn+"editsvf"+id).innerHTML+=mod+':';
	    //document.getElementById(sn+"edits"+id).innerHTML += '<a href="#" onclick="modifd(\''+sn+'\',\''+id+'\',\''+mod+'\',\''+name+'\',\'1\')">'+name+'</a>';
	} else {
            this["tt"+sn+"k"+id] = this["tt"+sn+"k"+id].replace(mod+':','');
	    this["txx"+sn+"k"+id] = this["txx"+sn+"k"+id].replace(name+' ','');
	    
	    $('#'+mod+'mm'+sn+'k'+id).removeClass('submits2');
	    $('#'+mod+'mm'+sn+'k'+id).addClass('submits');
	    
	    var first = document.getElementById(sn+"edits"+id).innerHTML
	    var second = first.replace(name+' ','');
            document.getElementById(sn+"edits"+id).innerHTML = second;
	    
	    var third = document.getElementById(sn+"editsvf"+id).innerHTML
	    var fourth = third.replace(mod+':','');
            document.getElementById(sn+"editsvf"+id).innerHTML = fourth;
	    
	    /*var nw = document.getElementById(sn+"edits"+id).innerHTML;
	    var nt = nw.replace('<a href="#" onclick="modifd(\''+sn+'\',\''+id+'\',\''+mod+'\',\''+name+'\',\'1\')">'+name+'</a>','');
	    document.getElementById(sn+"edits"+id).innerHTML = nt;  */
	}
	//alert(document.getElementById(sn+"edits"+id).innerHTML);
    }
                                    
    function finish_edit(sn,txt,id) {
        var c = sn-1;				    
						
	var old = document.getElementById("Seat"+c+"Items").value;
	var newtext = old.replace(id+'('+window.newt+'),','');
	document.getElementById("Seat"+c+"Items").value = newtext;
	
        gt = document.getElementById(sn+"edits"+id).innerHTML;
	gtvf = document.getElementById(sn+"editsvf"+id).innerHTML;
        
        //change seats view
			var d = document.getElementById('sseat'+sn);
			var r = document.getElementById(sn+'k'+id+'-'+window.newt);
			d.removeChild(r);
			var r3 = document.getElementById('a'+sn+'k'+id+'-'+window.newt);
			if (r3 != null) {
						d.removeChild(r3);
			}
			var r2 = document.getElementById('p'+sn+'k'+id+'-'+window.newt);
			if (r2 != null) {
						d.removeChild(r2);
			}
        
	$('#sseat'+sn).append('<span id="'+sn+'k'+id+'-'+gtvf+'"><a href="#" onclick="clicked(\''+sn+'\',\''+id+'\',\''+gtvf+'\')">'+txt+'</a><a id="a'+sn+'k'+id+'-'+gtvf+'" href="#" onclick="remo(\''+sn+'\',\''+id+'('+gtvf+'),\',\''+sn+'k'+id+'-'+gtvf+'\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?></a></span><p style="font-size:70%" id="p'+sn+'k'+id+'-'+gtvf+'">'+gt+'</p><div style="height:5px;"></div>');
        document.getElementById("Seat"+c+"Items").value += id+'('+gtvf+'),';

        this["tt"+sn+"k"+id]='';
        this["txx"+sn+"k"+id]='';
	$('#dialogg-'+sn+'-'+id).dialog("close");
    }
</script>