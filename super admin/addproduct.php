<?php

    session_start();

    if (!isset($_SESSION['email'])) {
        
        header('location: ../account/index.php');
    }
    include "../database/dbconnection.php";


    $nameError = $priceError = $descriptionError = $imageError = "";
    $name  = $price = $description = $image = "";

    if(isset($_POST['add'])) {

        if (isset($_POST['name']))  $name = sanitizeMySQL($connection,  $_POST['name']);
        if (isset($_POST['price']))  $price = sanitizeMySQL($connection,  $_POST['price']);
        if (isset($_POST['description']))   $description = sanitizeMySQL($connection,  $_POST['description']);
        if (isset($_FILES['image']) ) {
            $imageError = validate_image($_FILES['image']);
        }
        if ($imageError == "") {
            $image_path = "uploadImages/".basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../'.$image_path)) {
            }else {
                $imageError = "Ërror occured in uploading image";
            }
        }

        $nameError = validate_name($name);
        $priceError = validate_price($price);
        $descriptionError = validate_description($description);

        if ($nameError=="" && $priceError ==""  && $descriptionError =="" && $imageError == "") {
            $nameError = checkName($connection, $name);

            if ($nameError=="") {
                if(addProduct($connection, $name, $description, $price, $image_path)) {
                    $_SESSION['success'] = true;
                    $price = $description = "";
            }   
            }
        }    
    }

    if (isset($_GET['ok'])) {
        $_SESSION['success'] = false;$name = "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Add new product</title>
</head>
<body>
    <div class="container">
        <?php include('header.html'); ?>
        <form action="addproduct.php" method="post" enctype="multipart/form-data">
            <h1>Add new product</h1>
            <div class="box">
                <label for="name">Name</label><br>
                <input type="text" name="name" value="<?php echo $name; ?>"><br>
                <small class="error"><?php echo "$nameError"; ?></small>
            </div>
            <div class="box">
                <label for="price">Price</label><br>
                <input type="text" name="price" value="<?php echo $price; ?>"><br>
                <small class="error"><?php echo "$priceError"; ?></small>
            </div>
            <div class="box">
                <label for="image">Image</label><br>
                <input type="file" name="image" accept=".jpeg, .jpg, .png"><br>
                <small class="error"><?php echo "$imageError"; ?></small>
            </div>
            <div class="box">
                <label for="description">Description</label><br>
                <textarea name="description"cols="30" rows="10"><?php echo $description; ?></textarea><br>
                <small class="error"><?php echo "$descriptionError"; ?></small>
            </div>
            <div class="box">
                <input type="submit" value="Add" name="add">
            </div>
        </form>
    </div>

    <?php if (isset($_SESSION['success']) && $_SESSION['success']) { ?>
        <div class="pop-up-container">
            <div class="pop-up-box">
                <div class="pop-up-box">
                    <div class="image"></div>
                    <h2>Success</h2>
                    <p>New product "<?php echo $name ?>" successfully added to the system!</p>
                    <a href="addproduct.php?ok=true"><button type="submit">OK</button></a>
                </div>
            </div>
        </div>
    <?php } ?>


    <?php include('footer.html') ?>
    
</body>
</html>

<?php


    function validate_name($field) {
        if ($field == "") {
            return "Product name is required!";
        }
        else if ((preg_match("/[^a-zA-Z0-9 -]/", $field))) {
            return "Name cannot have special characters!";
        }
        return "";
    }

    function validate_description($field) {
        return ($field == "") ? "Description is required!" : "";
    }

    function validate_price($field) {
        if ($field == "") {
            return "Price is required!";
        }
        else if ((preg_match("/[^0-9.]/", $field))) {
            return "price cannot have letters or special characters";
        }
        return "";
    }

    function validate_image($image) {
        if($image['size']==0) {
            return 'image is required!';
        }
        else if ($image['error']==0) {
            $extension =strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)) ;
            if ($extension!='jpg' && $extension!='jpeg' && $extension!='png') {
                return "You can only upload .jpg, .jpeg, .png files only!";
            }
            return '';
        }else {
            return "An error occured";
        }
    }


    function sanitizeString($var) {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }
    function sanitizeMySQL($connection, $var){ 
        $var = mysqli_real_escape_string($connection, $var);
        $var = sanitizeString($var);
        return $var;
    }

    function addProduct($connection, $name, $description, $price, $image_path) {
        $id = getId($connection);

        $insertProductSql = "INSERT INTO  products (product_id, name, price, description)
                        VALUES($id, '$name', $price, '$description')";
        $result1 = mysqli_query($connection, $insertProductSql);

        $insertImageSql = "INSERT INTO  product_image VALUES($id, '$image_path')";
        $result2 = mysqli_query($connection, $insertImageSql);

        if ($result1 && $result2) {
            return true;
        }else {
            echo "cannot add user to the system!";
            return false;
        }
                
    }

    function checkName($connection, $field) {
        $sql = "SELECT name from products where name='$field'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result)>0) {
            return "This product already exists";
        }
        return "";
    }

    function getId($connection) {
        $sql = "select product_id from products order by product_id desc limit 1";

        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result)>0) {
            $id = mysqli_fetch_assoc($result)['product_id']+1;
        }else {
            $id = 1;
        }
        
        return $id;
    }

    

?>