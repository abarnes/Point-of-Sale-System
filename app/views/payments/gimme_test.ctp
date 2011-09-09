<?php
echo $url.'<br/>';
//$url = 'http://173.246.103.0:9000/mobi/api/claimreceipt/57?uniqueid=5|57|17.471'; 
echo $this->Qrcode->url($url);
?>