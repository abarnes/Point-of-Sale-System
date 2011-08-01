<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<div id="home">    
    <div class="toolbar"><a class="back" href="/tickets" rel="external">Back</a><h1>Table <?php echo $ticket['Ticket']['table']; ?></h1><a class="button slideup" href="#links">Actions</a></div>
    
    <ul class="rounded">
	<li style="color:white;">ID: <span style="float:right;"><?php echo $ticket['Ticket']['dailyid']; ?></span></li>
	<li style="color:white;">Type: <span style="float:right;"><?php echo $ticket['Type']['name']; ?></span></li>
	<li style="color:white;">Server: <span style="float:right;"><?php echo $ticket['User']['first_name']; ?></span></li>
	<li style="color:white;">Status: <span style="float:right;">
	<?php
            switch ($ticket['Ticket']['status']) {
                case 0:
                    $en = 'Submitted';
                    break;
                case 1:
                    $en = 'Prepared';
                    break;
		case 2:
                    $en = 'Paid';
                    break;
		case 3:
                    $en = 'Void';
                    break;
		case 4:
                    $en = 'Exception';
                    break;
                default:
                    $en = 'no';
                    break;
            }
            echo $en; ?>
	</span></li>
	<li style="color:white;">Total: <span style="float:right;">$<?php echo $total; ?></span></li>
    </ul>

    <?php foreach ($seats as $s) { ?>
    <table style="background-color:gray;width:96%;margin:6px;">
	<tr>
	    <th style="border-bottom:1px solid white;"><span style="float:left;">Seat <?php echo $s['seat']; ?></span>
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
	    <br/>
	    <p style="font-size:70%">
	    <?php
		$str = '';
		foreach ($data[key($data)]['mods'] as $m) { 
		    $str = $str.$m.', '; 
		}
		echo rtrim($str,', ');
		?>
	    </p>
	    </td>
	</tr>
	<?php } ?>
	</table>
    <?php } ?>
    <br/>
</div>

<div id="links">
	<div class="toolbar"><a class="back" href="#home" rel="external">Back</a><h1>Actions</h1></div>
	<br/>
	<ul class="rounded">
	    <li><?php echo $html->link('Edit',array('controller'=>'seats','action'=>'edit/'.$ticket['Ticket']['id']),array('rel'=>'external')); ?></li>
	    <li><?php
		echo $html->link(
					    'Delete', 
					    array('controller'=>'tickets','action'=>'delete/'.$ticket['Ticket']['id']), 
					    array('rel'=>'external'), 
					    'Are You Sure You Want To Delete This Ticket?'
				    );
	?></li>
	<?php
	if (count($seats)>1) {
	    //echo '<li>'.$html->link('Split Ticket',array('controller'=>'tickets','action'=>'split/'.$ticket['Ticket']['id']),array('rel'=>'external')).'</li>';
	    echo '<li>'.$html->link(
					'Split Seats into Individual Tickets', 
					array('controller'=>'tickets','action'=>'split_indiv/'.$ticket['Ticket']['id']), 
					array('rel'=>'external'), 
					'Are You Sure You Want To Split This Ticket?'
				).'</li>';
	}
	?>    
	</ul>
</div>