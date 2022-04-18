<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">

<!--
    demo of calling an Oracle stored procedure
    from PHP 

    by: Sharon Tuttle
    last modified: 2018-03-13

    uses: hsu_conn.php, lect08-2.css, name-pwd-fieldset.html,
          328footer.html
    depends on: the tables created by set-up-ex-tbls.sql,
          stored procedure new_dept (created by new_dept.sql)
-->

<head>  
    <title> calling stored procedure </title>
    <meta charset="utf-8" />

    <?php
        // include PHP function used below

        require_once("hsu_conn.php");
    ?>

    <link href=
          "http://users.humboldt.edu/smtuttle/styles/normalize.css" 
          type="text/css" rel="stylesheet" />
    <link href="lect08-2.css"
          type="text/css" rel="stylesheet" />
</head> 

<body> 

<h1> Calling Oracle stored procedure </h1>

<?php
    // when 1st called, show an enter-department-info form

    if (! array_key_exists("username", $_POST))
    {
        // in this case, they need login-and-params form
        ?>

        <form method="post"
              action=
            "<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
        <fieldset>

        <?php
        require("name-pwd-fieldset.html");
        ?>

        <fieldset>
            <legend> Enter input parameters for procedure new_dept:
            </legend>

            <label for="new_dept_name"> New dept name: </label>
            <input type="text" name="dept_name" id="new_dept_name"
                   required="required" />

            <label for="new_dept_loc"> New dept loc: </label>
            <input type="text" name="dept_loc" id="new_dept_loc" 
                   required="required" />
        </fieldset>

        <div class="submit">
            <input type="submit" value="Call it" />
        </div>
    </fieldset>
    </form>
    <?php
    }

    // IF get here, OK to try to grab arguments and run procedure

    else
    {
        // strip tags, if any, from entered username

        $username = strip_tags($_POST["username"]);

        // I promise I am ONLY using the password to
        //    try to log in -- so leaving (gulp!) as is

        $password = $_POST["password"];

        $conn = hsu_conn($username, $password);

        // if I reach here -- I connected!
        //    so, OK to try to call procedure

        $new_dept_call = 'begin new_dept(:new_dept_name,
                                         :new_dept_loc); end;';

        $new_dept_stmt = oci_parse($conn, $new_dept_call);

        // set the bind variables

        $desired_new_name = strip_tags($_POST['dept_name']);
        $desired_new_loc = strip_tags($_POST['dept_loc']);

        // when a bind variable is for input purposes
        //    (input TO the data tier), oci_bind_by_name 
        //    only NEEDS 3 arguments

        oci_bind_by_name($new_dept_stmt, ":new_dept_name",
                         $desired_new_name);
        oci_bind_by_name($new_dept_stmt, ":new_dept_loc",
                         $desired_new_loc);
           
        // now, executing! (and committing -- changed database,
        //     and want to commit that change;)

        oci_execute($new_dept_stmt, OCI_DEFAULT);
        oci_commit($conn);

        // done with THIS statement

        oci_free_statement($new_dept_stmt);

        // decide I'd like SOME feedback for user --
        //     how many rows does dept NOW have?

        $quant_query = "select count(*)
                        from dept";

        $quant_stmt = oci_parse($conn, $quant_query);

        oci_execute($quant_stmt, OCI_DEFAULT);
    
        // even for a single-row query, must call oci_fetch
        //     before I can reach that row

        oci_fetch($quant_stmt);
        $num_dept_rows = oci_result($quant_stmt, "COUNT(*)");

        ?>

        <p> <code>dept</code> table now has: <strong>
            <?= $num_dept_rows ?> </strong> rows </p>     

        <?php

        // free select statement, close connection!

        oci_free_statement($quant_stmt);
        oci_close($conn);
    }

    require_once("328footer.html");
?>

</body>
</html>
