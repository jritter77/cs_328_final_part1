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



$props_query_str = "
        begin
            verifyPhone('555-555-5555');
        end;
";


$props_query_stmt = oci_parse($conn, $props_query_str);

echo oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);


oci_free_statement($props_query_stmt);





oci_close($conn);


?>