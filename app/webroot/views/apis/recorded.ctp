<table>
    <tr>
        <th>
            Data
        </th>
        <th>
            Created
        </th>
<?php
foreach ($apis as $a) { ?>
<tr>
    <td>
        <?php echo $a['Api']['results']; ?>
    </td>
    <td>
        <?php echo $a['Api']['created']; ?>
    </td>
</tr>
<?php } ?>
</table>