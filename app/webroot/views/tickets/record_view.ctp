<!------------------------------------------------------------------------------
All code copyright 2011 Barnes Point of Sale Systems, unless otherwise noted.

You may alter this code with the following limitations:
1. Remaining free technical support is voided, and we cannot guarantee we can solve problems involving customized code.
2. You may not copy any portions of the code outside of your single installation of the system, unless you obtain written permission from Barnes Point of Sale Systems.  Additional copies of the software must be purchased.

Barnes POS Systems
www.barnespos.com
------------------------------------------------------------------------------->
<h3><?php if ($ticket['Type']['use_tables']=='1') {
	echo 'Table '.$ticket['Ticket']['table'].' ';
} ?>
ID <?php echo $ticket['Ticket']['dailyid']; ?>
</h3>

<div style="float:left;width:35%;">

<script type="text/javascript">
function del(id){
	var r=confirm('Are you sure you want to delete this ticket?');
	if (r==true) {
		parent.location='/record_tickets/delete/'+id;
	}
}
</script>

<ul class="horiz_list" style="text-align:center;">
	<li><input onclick="parent.location='/tickets/record_index'" type="button" value="Back to Records" style="width:120px;font-size:1em;height:30px;margin:2px;" class="submits"></li>
	<li><input onclick="del('<?php echo $ticket['Ticket']['id']; ?>')" type="button" value="Delete" style="width:80px;font-size:1em;height:30px;margin:2px;" class="submits"></li>
</ul>
<br/>
    
<table>
    <tr>
        <td>ID</td>
        <td><?php echo $ticket['Ticket']['dailyid']; ?></td>
    </tr>
    <tr>
        <td>Type</td>
        <td><?php echo $ticket['Type']['name']; ?></td>
    </tr>
    <?php if ($ticket['Type']['use_tables']=='1') { ?>
    <tr>
        <td>Table</td>
        <td><?php echo $ticket['Ticket']['table']; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td>Server</td>
        <td><?php echo $ticket['User']['full_name']; ?></td>
    </tr>
    <tr>
        <td>Status</td>
        <td><?php
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
        </td>
    </tr>
    <tr>
        <td>Total</td>
        <td>$<?php echo $total; ?></td>
    </tr>
    <tr>
        <td>Submitted</td>
        <td><?php echo date('m-d-Y g:i a',strtotime($ticket['Ticket']['created'])); ?></td>
    </tr>
</table>

<?php if (count($ticket['Payment'])>0) { ?>
	<h3>Payments</h3>
	<p>Processed <?php echo date('m-d-Y g:i a',strtotime($ticket['Payment'][0]['created'])); ?></p>
	<br/>
	
	<?php foreach ($ticket['Payment'] as $p) { ?>
		<table>
			<tr>
				<td>Type</td>
				<td><?php echo $p['type']; ?></td>
			</tr>
			<tr>
				<td>Amount</td>
				<td>$<?php echo $p['amount']; ?></td>
			</tr>
			<?php if ($p['tip']!=0) { ?>
			<tr>
				<td>Tip</td>
				<td>$<?php echo $p['tip']; ?></td>
			</tr>
			<?php } ?>
		</table>
	<?php } ?>
	
<?php } ?>

</div>


<div style="float:right;width:58%;margin-right:50px;">
    <?php foreach ($seats as $s) { ?>
    <table>
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
	    <span style="float:left;"><?php echo key($data); ?></span><span style="float:right;"><?php //echo $data[key($data)]['price']; ?></span>
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
</div>