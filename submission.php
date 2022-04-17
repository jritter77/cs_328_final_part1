<?php

// get request params
$req = json_decode($_POST['req']);

foreach ($req as $col=>$val) {
    echo $col . ' ' . $val;
}




?>