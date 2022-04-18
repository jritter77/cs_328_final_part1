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
        insert into properties
        values (
            get_date()
            :seller_name,
            :seller_phone,
            :seller_address,
            :building_name,
            :building_price,
            :building_address,
            :area,
            :type,
            :sqft,
            :height,
            :rooms,
            :floors,
            :year_built
        )
';


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_bind_by_name($props_query_stmt, ':seller_name', $req->seller_name);
oci_bind_by_name($props_query_stmt, ':seller_phone', $req->seller_phone);
oci_bind_by_name($props_query_stmt, ':seller_address', $req->seller_address);
oci_bind_by_name($props_query_stmt, ':building_name', $req->building_name);
oci_bind_by_name($props_query_stmt, ':building_price', $req->building_price);
oci_bind_by_name($props_query_stmt, ':building_address', $req->building_address);
oci_bind_by_name($props_query_stmt, ':area', $req->area);
oci_bind_by_name($props_query_stmt, ':type', $req->type);
oci_bind_by_name($props_query_stmt, ':sqft', $req->sqft);
oci_bind_by_name($props_query_stmt, ':height', $req->height);
oci_bind_by_name($props_query_stmt, ':rooms', $req->rooms);
oci_bind_by_name($props_query_stmt, ':floors', $req->floors);
oci_bind_by_name($props_query_stmt, ':year_built', $req->year_built);

oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);


oci_free_statement($props_query_stmt);





oci_close($conn);

echo 'Row added successfully'


?>