<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">

<!--
    demo of calling an Oracle stored function
    from PHP

    by: Sharon Tuttle
    last modified: 2018-03-13

    uses: hsu_conn.php, lect08-2.css, name-pwd-fieldset.html,
          328footer.html
    depends on: the tables created by create-bks.sql,
          stored function how_many (created by how_many.sql)
-->

<head>  
    <title> calling stored function </title>
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

<h1> Calling Oracle stored function </h1>

<?php
    // when 1st called, show an enter-how_many-parameter form

    if (! array_key_exists("username", $_POST))
    {
        // in this case, they need login-and-param form
        ?>

        <form method="post"
              action=
            "<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
        <fieldset>

        <?php
        require("name-pwd-fieldset.html");
        ?>

        <fieldset>
            <legend> Enter input parameters for function how_many:
            </legend>

            <!--
                SOMEONE noted a drop-down of titles would be even better
                here (sorry, do not remember who); and that
                is true! When we get to sessions, that would be
                a good change here.
            -->

            <label for="title_entry"> Title: </label>
            <input type="text" name="desired_title" 
                   id="title_entry" required="required" />
        </fieldset>

        <div class="submit">
            <input type="submit" value="Call it" />
        </div>
    </fieldset>
    </form>
    <?php
    }

    // IF get here, OK to try to grab argument and run function

    else
    {
        // strip tags, if any, from entered username

        $username = strip_tags($_POST["username"]);

        // I promise I am ONLY using the password to
        //    try to log in -- so leaving (gulp!) as is

        $password = $_POST["password"];

        $conn = hsu_conn($username, $password);

        // if I reach here -- I connected!
        //    so, OK to try to call function

        $how_many_call = 'begin :numcopies := how_many(:title); end;';

        $how_many_stmt = oci_parse($conn, $how_many_call);

        // set the bind variables

        $desired_title = strip_tags($_POST['desired_title']);

        // when a bind variable is for input purposes
        //    (input TO the data tier), only NEED 3
        //    arguments

        oci_bind_by_name($how_many_stmt, ":title", 
                         $desired_title);

        // for an "output" bind variable:
        //    *   the oci_bind_by_name 3rd argument is the PHP
        //        variable you want to be SET by the call!
        //    *   and, a 4th argument is required: the maximum
        //        size of what may be put INTO that variable
        //        by this call;
        
        oci_bind_by_name($how_many_stmt, ":numcopies",
                         $num_copies, 4);

        // now, executing!

        oci_execute($how_many_stmt, OCI_DEFAULT);
        ?>

        <p> how_many call for <?= $desired_title ?> <br />
            returned <?= $num_copies ?> copies </p>

        <?php

        // free statement, close connection!

        oci_free_statement($how_many_stmt);
        oci_close($conn);
    }
  
    require_once("328footer.html");
?>

</body>
</html>
