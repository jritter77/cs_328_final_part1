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



$check_date_func = '
        create or replace function checkDate(start IN date, end IN date) return integer
        is inPeriod integer;

        begin
            inPeriod := 1;
            return inPeriod;
        end;
        begin
            checkDate(sysdate, sysdate+1);
        end;
        /

';


$check_date_stmt = oci_parse($conn, $check_date_func);

oci_execute($check_date_stmt, OCI_DEFAULT);

$results = array();
while (oci_fetch($check_date_stmt)) {
    echo 
}

echo json_encode($results);

oci_free_statement($check_date_stmt);





oci_close($conn);


?>