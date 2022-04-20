<?php


$db_conn_str =
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

$conn = oci_connect("jr550", "Wo0dabu9a", $db_conn_str);

if (!$conn) {
    echo 'Error connecting...';
}

$req = json_decode($_POST['req']);


$props_query_str = '
        select * 
        from properties
        where (date_submitted > :start_date) and (date_submitted < :end_date)
';


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_bind_by_name($props_query_stmt, ':start_date', $req->start_date);
oci_bind_by_name($props_query_stmt, ':end_date', $req->end_date);


oci_execute($props_query_stmt, OCI_DEFAULT);

$results = array();
while ($row = oci_fetch_array($props_query_stmt, OCI_ASSOC)) {
    array_push($results, $row);
}

echo json_encode($results);

oci_free_statement($props_query_stmt);





oci_close($conn);


?>