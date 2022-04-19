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
        create or replace function verifyPhone(phone IN varchar)
        return number is 
            is_valid number := 0;
        begin
            if length(phone) = 12 then
                is_valid := 1;
            end if;

            return is_valid;
        end;    
';


$props_query_stmt = oci_parse($conn, $props_query_str);

oci_execute($props_query_stmt, OCI_COMMIT_ON_SUCCESS);


oci_free_statement($props_query_stmt);





oci_close($conn);


?>