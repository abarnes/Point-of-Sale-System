        <?php
        //add divs for each tab
        $co = 0;
        while ($co!=$seats) {
				$sn = $co+1;
            ?>
	    
	    <?php if ($co==0) { ?>
				<div id="home">
            <?php } else { ?>
				<div id="seatc<?php echo $sn; ?>">
	    <?php } ?>
	    <form>
				<div class="toolbar"><a class="back" href="#seat1">seat 1</a><h1>Table <?php echo $ticket['Ticket']['table']; ?></h1><a class="button slideup" href="#seat2">Edit</a></div>   
           
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
                                    
                                    function modif<?php echo $sn.'k'.$i['id']; ?>(id,mod,name) {
                                        t<?php echo $sn.'k'.$i['id']; ?>+=mod+':';
                                        tx<?php echo $sn.'k'.$i['id']; ?>+=name+' ';
					document.getElementById("<?php echo $sn; ?>mods<?php echo $i['id']; ?>").innerHTML += ' '+name;
                                        //$('#'+mod+'<?php echo 'm'.$sn.'k'.$i['id']; ?>').removeClass('submits');
                                        //$('#'+mod+'<?php echo 'm'.$sn.'k'.$i['id']; ?>').addClass('submits2');
                                        
                                    }
                                    
                                    function finish<?php echo $sn.'k'.$i['id']; ?>(txt,id) {
						var sn = <?php echo $sn; ?>;
						var i = <?php echo $i['id']; ?>;
                                        $('#sseat<?php echo $sn; ?>').append('<span id="<?php echo $sn.'k'.$i['id']; ?>-'+t<?php echo $sn.'k'.$i['id']; ?>+'"><a href="#" onclick="clicked(\''+sn+'\',\''+i+'\',\''+t<?php echo $sn.'k'.$i['id']; ?>+'\')">'+txt+'</a><a id="a<?php echo $sn.'k'.$i['id']; ?>-'+t<?php echo $sn.'k'.$i['id']; ?>+'" href="#" onclick="remo<?php echo $sn; ?>(\''+id+'('+t<?php echo $sn.'k'.$i['id']; ?>+'),\',\'<?php echo $sn.'k'.$i['id']; ?>-'+t<?php echo $sn.'k'.$i['id']; ?>+'\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?></a></span><p style="font-size:70%" id="p<?php echo $sn.'k'.$i['id']; ?>-'+t<?php echo $sn.'k'.$i['id']; ?>+'">'+tx<?php echo $sn.'k'.$i['id']; ?>+'</p>');
                                        document.getElementById("Seat<?php echo $co; ?>Items").value += id+'('+t<?php echo $sn.'k'.$i['id']; ?>+'),';
                                        $('#dialog-<?php echo $sn.'-'.$i['id']; ?>').dialog("close"); 
                                    }

                                </script>
                                    <?php foreach ($i['Modifier'] as $m) { ?>
                                        <input onclick="modif<?php echo $sn.'k'.$i['id']; ?>('<?php echo $i['id']; ?>','<?php echo $m['id']; ?>','<?php echo $m['name']; ?>')" type="button" value="<?php echo $m['name']; ?>" style="width:100px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits" id="<?php echo $m['id'].'m'.$sn.'k'.$i['id']; ?>">
                                    <?php } ?>
                                    <br/>
				    <h5><span id="<?php echo $sn; ?>mods<?php echo $i['id']; ?>"></span></h5>
                                    <input type="button" onclick="finish<?php echo $sn.'k'.$i['id']; ?>('<?php echo $i['name']; ?>','<?php echo $i['id']; ?>')" value="Finish">
                            </div>
    
			<div id="dialogg-<?php echo $sn.'-'.$i['id']; ?>" title="Options">
                                <script type="text/javascript">
                                    var tt<?php echo $sn.'k'.$i['id']; ?> = '';
                                    var txx<?php echo $sn.'k'.$i['id']; ?> = '';
                                    
                                    function modiff<?php echo $sn.'k'.$i['id']; ?>(id,mod,name) {
                                        tt<?php echo $sn.'k'.$i['id']; ?>+=mod+':';
                                        txx<?php echo $sn.'k'.$i['id']; ?>+=name+' ';
					document.getElementById("<?php echo $sn; ?>edits<?php echo $i['id']; ?>").innerHTML+=name+' ';
					document.getElementById("<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>").innerHTML+=mod+':';;
                                        //$('#'+mod+'<?php echo 'mm'.$sn.'k'.$i['id']; ?>').removeClass('submits');
						//alert(mod+'<?php echo 'm'.$sn.'k'.$i['id']; ?>');
                                        //$('#'+mod+'<?php echo 'mm'.$sn.'k'.$i['id']; ?>').addClass('submits2');
                                        
                                    }
                                    
                                    function finishh<?php echo $sn.'k'.$i['id']; ?>(txt,id) {
						var sn = <?php echo $sn; ?>;
						var i = <?php echo $i['id']; ?>;
						
						var old = document.getElementById("Seat<?php echo $sn-1; ?>Items").value;
						var newtext = old.replace(id+'('+window.newt+'),','');
						document.getElementById("Seat<?php echo $sn-1; ?>Items").value = newtext;
						
						//change seats view
						var d = document.getElementById('sseat<?php echo $sn; ?>');
						var r = document.getElementById('<?php echo $sn.'k'.$i['id']; ?>-'+window.newt);
						d.removeChild(r);
						var r3 = document.getElementById('a<?php echo $sn.'k'.$i['id']; ?>-'+window.newt);
						if (r3 != null) {
									d.removeChild(r3);
						}
						var r2 = document.getElementById('p<?php echo $sn.'k'.$i['id']; ?>-'+window.newt);
						if (r2 != null) {
									d.removeChild(r2);
						}
						gt = document.getElementById("<?php echo $sn; ?>edits<?php echo $i['id']; ?>").innerHTML;
						gtvf = document.getElementById("<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>").innerHTML;
					$('#sseat<?php echo $sn; ?>').append('<span id="<?php echo $sn.'k'.$i['id']; ?>-'+gtvf+'"><a href="#" onclick="clicked(\''+sn+'\',\''+i+'\',\''+gtvf+'\')">'+txt+'</a><a id="a<?php echo $sn.'k'.$i['id']; ?>-'+gtvf+'" href="#" onclick="remo<?php echo $sn; ?>(\''+id+'('+gtvf+'),\',\'<?php echo $sn.'k'.$i['id']; ?>-'+gtvf+'\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?></a></span><p style="font-size:70%" id="p<?php echo $sn.'k'.$i['id']; ?>-'+gtvf+'">'+gt+'</p>');
                                        document.getElementById("Seat<?php echo $co; ?>Items").value += id+'('+gtvf+'),';
                                        $('#dialogg-<?php echo $sn.'-'.$i['id']; ?>').dialog("close"); 
                                    }

                                </script>
				
                                    <?php foreach ($i['Modifier'] as $m) { ?>
                                        <input onclick="modiff<?php echo $sn.'k'.$i['id']; ?>('<?php echo $i['id']; ?>','<?php echo $m['id']; ?>','<?php echo $m['name']; ?>')" type="button" value="<?php echo $m['name']; ?>" style="width:100px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits" id="<?php echo $m['id'].'mm'.$sn.'k'.$i['id']; ?>">
                                    <?php } ?>
                                    <br/>
				    <h5><span id="<?php echo $sn; ?>edits<?php echo $i['id']; ?>"></span></h5>
				    <span style="display:none;" id="<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>"></span>
                                    <input type="button" onclick="finishh<?php echo $sn.'k'.$i['id']; ?>('<?php echo $i['name']; ?>','<?php echo $i['id']; ?>')" value="Finish">
                            </div>
                                  
                        <?php } else { ?>
                            <input onclick="seat<?php echo $co+1; ?>('<?php echo $i['name']; ?>','<?php echo $i['id']; ?>','')" type="button" value="<?php echo $i['short_name']; ?>" style="width:100px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits">
			    
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
                                    
                                    function modiff<?php echo $sn.'k'.$i['id']; ?>(id,mod,name) {
                                        tt<?php echo $sn.'k'.$i['id']; ?>+=mod+':';
                                        txx<?php echo $sn.'k'.$i['id']; ?>+=name+' ';
					document.getElementById("<?php echo $sn; ?>edits<?php echo $i['id']; ?>").innerHTML+=name+' ';
					document.getElementById("<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>").innerHTML+=mod+':';;
                                        //$('#'+mod+'<?php echo 'mm'.$sn.'k'.$i['id']; ?>').removeClass('submits');
						//alert(mod+'<?php echo 'm'.$sn.'k'.$i['id']; ?>');
                                        //$('#'+mod+'<?php echo 'mm'.$sn.'k'.$i['id']; ?>').addClass('submits2');
                                        
                                    }
                                    
                                    function finishh<?php echo $sn.'k'.$i['id']; ?>(txt,id) {
						var sn = <?php echo $sn; ?>;
						var i = <?php echo $i['id']; ?>;
						
						var old = document.getElementById("Seat<?php echo $sn-1; ?>Items").value;
						var newtext = old.replace(id+'('+window.newt+'),','');
						document.getElementById("Seat<?php echo $sn-1; ?>Items").value = newtext;
						
						//change seats view
						var d = document.getElementById('sseat<?php echo $sn; ?>');
						var r = document.getElementById('<?php echo $sn.'k'.$i['id']; ?>-'+window.newt);
						d.removeChild(r);
						var r3 = document.getElementById('a<?php echo $sn.'k'.$i['id']; ?>-'+window.newt);
						if (r3 != null) {
									d.removeChild(r3);
						}
						var r2 = document.getElementById('p<?php echo $sn.'k'.$i['id']; ?>-'+window.newt);
						if (r2 != null) {
									d.removeChild(r2);
						}
						gt = document.getElementById("<?php echo $sn; ?>edits<?php echo $i['id']; ?>").innerHTML;
						gtvf = document.getElementById("<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>").innerHTML;
					$('#sseat<?php echo $sn; ?>').append('<span id="<?php echo $sn.'k'.$i['id']; ?>-'+gtvf+'"><a href="#" onclick="clicked(\''+sn+'\',\''+i+'\',\''+gtvf+'\')">'+txt+'</a><a id="a<?php echo $sn.'k'.$i['id']; ?>-'+gtvf+'" href="#" onclick="remo<?php echo $sn; ?>(\''+id+'('+gtvf+'),\',\'<?php echo $sn.'k'.$i['id']; ?>-'+gtvf+'\')"><?php echo $html->image('close.png',array('alt'=>'Barnes POS System','style'=>'float:right;')); ?></a></span><p style="font-size:70%" id="p<?php echo $sn.'k'.$i['id']; ?>-'+gtvf+'">'+gt+'</p>');
                                        document.getElementById("Seat<?php echo $co; ?>Items").value += id+'('+gtvf+'),';
                                        $('#dialogg-<?php echo $sn.'-'.$i['id']; ?>').dialog("close"); 
                                    }

                                </script>
				
                                    <?php foreach ($i['Modifier'] as $m) { ?>
                                        <input onclick="modiff<?php echo $sn.'k'.$i['id']; ?>('<?php echo $i['id']; ?>','<?php echo $m['id']; ?>','<?php echo $m['name']; ?>')" type="button" value="<?php echo $m['name']; ?>" style="width:100px;height:80px;margin-bottom:14px;font-size:.9em;" class="submits" id="<?php echo $m['id'].'mm'.$sn.'k'.$i['id']; ?>">
                                    <?php } ?>
                                    <br/>
				    <h5><span id="<?php echo $sn; ?>edits<?php echo $i['id']; ?>"></span></h5>
				    <span style="display:none;" id="<?php echo $sn; ?>editsvf<?php echo $i['id']; ?>"></span>
                                    <input type="button" onclick="finishh<?php echo $sn.'k'.$i['id']; ?>('<?php echo $i['name']; ?>','<?php echo $i['id']; ?>')" value="Finish">
                            </div>
                        <?php } ?>

                    <?php } ?>
                    
                    </div>
                    
                    <!--<input onclick="seat<?php //echo $co+1; ?>('<?php //echo $i['name']; ?>','<?php //echo $i['id']; ?>','')" type="button" value="<?php //echo $i['name']; ?>" style="width:100px;height:80px;margin-bottom:14px;">-->
           <?php } ?>
    
       
       
       
    </div>
    <?php
    $co++;
    } ?>
    
    </form>
    <br/>

<!--------------------------------------------------->

<div style="width:25%;min-width:200px;float:right;">
						
			    <?php
			    //construct overview div
			    $cn = 0;
			    while ($cn!=$seats) { ?>
			    <table class="sseat<?php echo $cn+1; ?>">
				<tr>
				    <td>
					<h4>Seat <?php echo $cn+1; ?></h4>
				    </td>
				</tr>
				<tr>
						<td>
									<div id="sseat<?php echo $cn+1; ?>">
						
									</div>
						</td>
				</tr>
			    </table>
			    
			    <?php
			    $cn++;
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

<?php echo $form->create('Seat', array('action' => 'add/'.$id.'/'.$seats)); ?>

<?php
$c = 0;
while ($c!=$seats) {
    echo $form->input('Seat.'.$c.'.items',array('value'=>'','type'=>'hidden'));
$c++;
} ?>

<?php echo $form->end('Submit'); ?>

</div>

<div id="editform">
<div class="toolbar"><a class="back" href="#home">Back</a><h1>Edit</h1></div>				
<?php echo $form->create('Ticket', array('action' => 'edit/'.$ticket['Ticket']['id'])); ?>
    <?php echo $form->input('Ticket.table', array( 'label' => 'Table: ','type'=>'tel','value'=>$ticket['Ticket']['table'])); ?>
    <?php echo $form->input('Ticket.type_id', array( 'label' => 'Type: ','value'=>$ticket['Ticket']['type_id'])); ?>
    <?php echo $form->input('Ticket.seats', array( 'label' => 'Number of Seats: ','value'=>$seats)); ?>
<?php echo $form->end('Update'); ?>
</div>

<script type="text/javascript">
			var newt;

			 // Dialog Link2
				function clicked(sn,id,vf) {
						window.newt = vf;
					$('#dialogg-'+sn+'-'+id).dialog('open');
					var st = document.getElementById("p"+sn+"k"+id+"-"+vf).innerHTML;
					//alert(window.newt);
					document.getElementById(sn+"edits"+id).innerHTML = st;
					document.getElementById(sn+"editsvf"+id).innerHTML = vf;
					//return false;
				}
</script>