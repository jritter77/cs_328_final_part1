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


$create_table_str = "
begin

 create_table();

end;
";

$create_table_stmt = oci_parse($conn, $create_table_str);

oci_execute($create_table_stmt, OCI_COMMIT_ON_SUCCESS);

oci_free_statement($create_table_stmt);

echo 'Table Created!';

oci_close($conn);


?>