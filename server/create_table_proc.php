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

execute immediate 'drop table properties';

execute immediate 'create table properties(
    date_submitted date,
    seller_name varchar(30),
    seller_phone varchar(12),
    seller_address varchar(50),
    building_name varchar(30),
    building_price number,
    building_address varchar(50),
    area varchar(20),
    type varchar(20),
    sqft number,
    height number,
    rooms number,
    floors number,
    year_built number
)';

end;
";

$create_table_stmt = oci_parse($conn, $create_table_str);

oci_execute($create_table_stmt, OCI_COMMIT_ON_SUCCESS);

oci_free_statement($create_table_stmt);

echo 'Table Created!';

oci_close($conn);


?>