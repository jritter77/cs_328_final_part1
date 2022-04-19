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
        create or replace procedure new_prop(
            seller_name in varchar,
            seller_phone in varchar,
            seller_address varchar,
            building_name varchar,
            building_price number,
            building_address varchar,
            area varchar,
            type varchar,
            sqft number,
            height number,
            rooms number,
            floors number,
            year_built number
        )
        AS
        begin
            if verifyPhone(seller_phone) = 1 then
                 insert into properties
                 values (
                    sysdate,
                    seller_name,
                    seller_phone,
                    seller_address,
                    building_name,
                    building_price,
                    building_address,
                    area,
                    type,
                    sqft,
                    height,
                    rooms,
                    floors,
                    year_built
                );
            end if;
        end;
";


$props_query_stmt = oci_parse($conn, $props_query_str);

echo oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);


oci_free_statement($props_query_stmt);





oci_close($conn);


?>