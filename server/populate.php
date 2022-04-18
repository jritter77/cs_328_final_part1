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
insert into properties
values (
    'John Smith',
    '555-555-5555',
    '123 County Ln, Eureka CA 95501',
    'Old Victorian',
    120000,
    '123 County Ln, Eureka CA 95501',
    'Eureka',
    'Residential',
    1500,
    50,
    3,
    2,
    1937
)
";


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);

oci_free_statement($props_query_stmt);


$props_query_str = "
insert into properties
values (
    'Jane Doe',
    '555-555-5555',
    '555 Alley way, Eureka CA 95501',
    'Fixer Upper',
    80000,
    '555 Alley way, Eureka CA 95501',
    'Eureka',
    'Residential',
    800,
    30,
    2,
    1,
    1962
)
";


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);

oci_free_statement($props_query_stmt);



$props_query_str = "
insert into properties
values (
    'John Smith',
    '555-555-5555',
    '123 County Ln, Eureka CA 95501',
    'Barn',
    100000,
    '131 County Ln, Eureka CA 95501',
    'Eureka',
    'Commercial',
    1000,
    50,
    0,
    2,
    1948
)
";


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);

oci_free_statement($props_query_stmt);



echo 'Table Populated!';


$props_query_str = '
        select * from properties
';


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_DEFAULT);

while (oci_fetch($props_query_stmt)) {
    echo oci_result($props_query_stmt, 'SELLER_NAME');
}

oci_free_statement($props_query_stmt);


oci_close($conn);


?>