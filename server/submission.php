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

$empl_query_str = 'select empl_last_name, hiredate, salary,
commission
from empl';
$empl_query_stmt = oci_parse($conn, $empl_query_str);

oci_execute($empl_query_stmt, OCI_DEFAULT);

while(oci_fetch($empl_query_stmt)) {
    echo oci_result($empl_query_stmt, 'HIREDATE');
}

$props_query_str = '

    drop table props;

    create table props(
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
    );';


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_DEFAULT);

echo 'Table Created!';

$props_query_str = "

insert into props 
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
);


insert into props 
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
);


insert into props 
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
);";

    
$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_DEFAULT);

echo 'Table Populated!';


$props_query_str = '
    select *
    from props;
    ';


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_DEFAULT);

while (oci_fetch($props_query_stmt)) {
    echo oci_result($props_query_stmt, 'SELLER_NAME');
}

oci_free_statement($props_query_stmt);
oci_close($conn);


?>