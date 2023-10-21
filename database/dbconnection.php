<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "se.2020.034";
    $connection = "";

    try {
        $connection = mysqli_connect($server, 
                                    $user, 
                                    $password, $database);
    }catch(mysqli_sql_exception) {
        echo "could not connect";
    }

?>