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
else {
    echo 'Success!';
}


$props_query_str = "drop table properties";


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_DEFAULT);

oci_free_statement($props_query_stmt);

$props_query_str = "
create table properties(
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
)
";

$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_DEFAULT);

oci_free_statement($props_query_stmt);

echo 'Table Created!';

oci_close($conn);


?>