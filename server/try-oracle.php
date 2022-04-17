<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">

<!--
    demo connecting from PHP on nrs-projects
    to the Oracle student database on cedar

    adapted from an example by Peter Johnson
    adapted by: Sharon Tuttle
    last modified: 2018-03-08
-->

<head>
    <title> Connecting to Oracle! </title>
    <meta charset="utf-8" />

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css" 
          type="text/css" rel="stylesheet" />
    <link href="try-oracle.css" type="text/css" rel="stylesheet" />
</head> 

<body>

<h1> Connecting PHP to Oracle </h1>

<?php
    // do you need to ask for username and password?

    if ( ! array_key_exists("username", $_POST) )
    {
        // no username in $_POST? they need a login form!
        ?>
  
        <form method="post" 
              action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
        <fieldset>
            <legend> Please enter Oracle username/password: </legend>

            <label for="username"> Username: </label>
            <input type="text" name="username" id="username" /> 

            <label for="password"> Password: </label>
            <input type="password" name="password" 
                   id="password" />

            <div class="submit">
                <input type="submit" value="Log in" />
            </div>
        </fieldset>
        </form>
    <?php
    }      

    // otherwise, handle the submitted login form 
    //    (or try to) -- and show the user some
    //    lovely employee information

    else
    {
        // I am a little paranoid -- I'm stripping
        //    tags from the username

        $username = strip_tags($_POST['username']);

        // the ONLY thing I am doing with this is
        //    trying to log in -- so I HOPE this is OK

        $password = $_POST['password'];

        // set up connection string

        $db_conn_str =
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

        // let's try to connect and log into Oracle using this

        $conn = oci_connect($username, $password, $db_conn_str);

        // exiting if connection/log in failed

        if (! $conn)
        {
            ?>
            <p> Could not log into Oracle, sorry </p>

            
</body>
</html>
            <?php
            exit;
        }

        // if I get here -- I connected!

        $password = NULL; // I won't be using this anymore

        // let's set up a SQL SELECT statement and ask the
        //     data tier to execute it for us

        $empl_query_str = 'select empl_last_name, hiredate, salary,
                                  commission
                           from empl';
        $empl_query_stmt = oci_parse($conn, $empl_query_str);

        oci_execute($empl_query_stmt, OCI_DEFAULT);
        ?>

        <table>
            <caption> Employee Information </caption>
            <tr> <th scope="col"> Employee Name </th>
                 <th scope="col"> Hire Date </th>
                 <th scope="col"> Salary </th>
                 <th scope="col"> Commission </th> </tr>

        <?php
            while (oci_fetch($empl_query_stmt))
            {
                $curr_empl_name = oci_result($empl_query_stmt, 'EMPL_LAST_NAME');
                $curr_hiredate = oci_result($empl_query_stmt, 'HIREDATE');
                $curr_salary = oci_result($empl_query_stmt, 'SALARY');
                $curr_commission = oci_result($empl_query_stmt, 'COMMISSION');

                if ($curr_commission === NULL)
                {
                    $curr_commission = "no commission";
                }

                ?>
                <tr> <td> <?= $curr_empl_name ?> </td>
                     <td> <?= $curr_hiredate ?> </td>
                     <td> <?= $curr_salary ?> </td>
                     <td> <?= $curr_commission ?> </td>
                </tr> 
                <?php
            }
            ?>
            </table>

            <?php

             // FREE your statement, CLOSE your connection!

             oci_free_statement($empl_query_stmt);
             oci_close($conn);
    }

?>  

</body>
</html>
