<?php

    include('../database/dbconnection.php');

    $query1 = "SELECT * from products";
    $result1 = mysqli_query($connection, $query1);
    
    $records = array();
    if (mysqli_num_rows($result1)!=0){
        while ($row = mysqli_fetch_assoc($result1)) {
            $id = $row['product_id'];
            $query2 = "SELECT image_url from product_image where product_id=$id";
            $result2 = mysqli_query($connection, $query2);
            $image_path = mysqli_fetch_assoc($result2)['image_url'];
            $row['image_path'] = $image_path; 
            $records[] = $row;
        }
    }

?>