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



$props_query_str = '
        select * 
        from properties
        where date_submitted >= sysdate - 1 and <= sysdate + 1
';


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_DEFAULT);

$results = array();
while ($row = oci_fetch_array($props_query_stmt, OCI_ASSOC)) {
    array_push($results, $row);
}

echo json_encode($results);

oci_free_statement($props_query_stmt);





oci_close($conn);


?>