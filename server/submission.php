<?php

// get request params
$req = json_decode($_POST['req']);

$conn = oci_connect("jr550", "Wo0dabu9a");

if (!$conn) {
    echo 'Error connecting...';
}
else {
    echo 'Success!';
}






?>