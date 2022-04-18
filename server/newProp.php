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


$props_query_str = "
        create or replace procedure newDummyProp
        is 
        begin

        insert into properties
        values (
            sysdate,
            'John Smith',
            '555-555-555',
            '123 County ln',
            'Victorian',
            200000,
            '123 County ln',
            'Eureka',
            'Residential',
            15000,
            60,
            4,
            2,
            1920
        )
        
        end;
        /
";


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);


oci_free_statement($props_query_stmt);

$props_query_str = "
        begin
        newDummyProp();
        end;
        /
";


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);


oci_free_statement($props_query_stmt);



oci_close($conn);

echo 'Row added successfully'


?>