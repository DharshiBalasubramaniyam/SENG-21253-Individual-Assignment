<?php
    include "../database/dbconnection.php";


    $nameError = $emailError = $passwordError = $cpasswordError = $phoneError = "";
    $name = $type = $email = $password = $cpassword = $phone = "";

    if(isset($_POST['register'])) {

        if (isset($_POST['name']))  $name = sanitizeMySQL($connection,  $_POST['name']);
        if (isset($_POST['email']))   $email = sanitizeMySQL($connection,  $_POST['email']);
        if (isset($_POST['password']))  $password = sanitizeMySQL($connection,  $_POST['password']);
        if (isset($_POST['cpassword']))   $cpassword = sanitizeMySQL($connection,  $_POST['cpassword']);
        if (isset($_POST['phone']))  $phone = sanitizeMySQL($connection,  $_POST['phone']);


        $nameError = validate_name($name);
        $emailError = validate_email($email);
        $passwordError = validate_password($password);
        $cpasswordError = validate_cpassword($password, $cpassword);
        $phoneError = validate_phone($phone);


        if ($nameError==""  && $emailError =="" && $passwordError=="" && $cpasswordError =="" && $phoneError =="") {
            // $pass = hash('ripemd128', $password);
            $emailError = checkEmail($connection, $email);

            if ($emailError =="") {
                if(addUser($connection, $name, $email, "customer", $password, $phone)) {
                    $_SESSION['success'] = true;
                    $name = $email = $password = $cpassword = $phone = "";
                }   
            }
        }    
    }

    if (isset($_GET['ok'])) {
        $_SESSION['success'] = false;
        if (!$_SESSION['success']) {
            header("location: index.php");
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <?php include('header.html'); ?>
        <form action="register.php" method="post" id="form" onsubmit="return validate()">
            <h1>Register</h1>
            <div class="box">
                <label for="name">Name</label><br>
                <input type="text" name="name" value="<?php echo "$name"; ?>" id="name"><br>
                <small class="error"><?php echo "$nameError"; ?></small>
            </div>
            <div class="box">
                <label for="email">Email</label><br>
                <input type="text" name="email" value="<?php echo "$email"; ?>" id="email"><br>
                <small class="error"><?php echo "$emailError"; ?></small>
            </div>
            <div class="box">
                <label for="phone">Phone number</label><br>
                <input type="text" name="phone" value="<?php echo "$phone"; ?>" id="phone"><br>
                <small class="error"><?php echo "$phoneError"; ?></small>
            </div>
            <div class="box">
                <label for="password">Password</label><br>
                <input type="password" name="password" value="<?php echo "$password"; ?>" id="password">
                <div class="view"></div><br>
                <small class="error"><?php echo "$passwordError"; ?></small>
            </div>
            <div class="box">
                <label for="password">Confirm Password</label><br>
                <input type="password" name="cpassword" value="<?php echo "$cpassword"; ?>" id="cpassword">
                <div class="view"></div><br>
                <small class="error"><?php echo "$cpasswordError"; ?></small>
            </div>
            <div class="box">
                <input type="submit" value="Register" name="register">
            </div>
            <div class="box">
                By clicking Register, you are agree to our user agreement and privacy policy. <br> <br>
                Already a member? <a href="./index.php">Login now</a>
            </div>
        </form>
    </div>

    <?php if (isset($_SESSION['success']) && $_SESSION['success']) { ?>
        <div class="pop-up-container">
            <div class="pop-up-box">
                <div class="image"></div>
                <h2>All done!</h2>
                <p>Your account created successfully and ready to start</p>
                <a href="register.php?ok=true"><button type="submit">Login now</button></a>
            </div>
        
        </div>
    <?php } ?>

    <?php include('footer.html') ?>
    <script src="../js/script.js"></script>

    
</body>
</html>

<?php


    function validate_name($field) {
        if ($field == "") {
            return "Name is required!";
        }
        else if ((preg_match("/[^a-zA-Z ]/", $field))) {
            return "Name cannot have special characters or numbers!";
        }
        return "";
    }

    function validate_email($field) {
        if ($field == "") {
            return "Email is required!";
        }
        else if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
            return "Invalid Email format";
        }
        return "";
    }

    function validate_password($field) {
        if ($field == "") {
            return "Password is required!";
        }
        else if (!((preg_match("/[a-z]/", $field)) &&
                (preg_match("/[0-9]/", $field)) &&
                (preg_match("/[^a-zA-Z0-9]/", $field)))) {
            return "Password must contain atleast one lower case letter, one digit and  one symbol!";
        }
        else if (strlen($field)<8) {
            return "Password must contain atleast 8 characters!";
        }
        return "";
    }

    function validate_cpassword($pass, $cpass) {
        if ($cpass == "") {
            return "Confirm password is required!";
        }
        else if (!((preg_match("/[a-z]/", $cpass)) &&
                (preg_match("/[0-9]/", $cpass)) &&
                (preg_match("/[^a-zA-Z0-9]/", $cpass)))) {
            return "Password must contain atleast one lower case letter, one digit and  one symbol!";
        }
        else if (strlen($cpass)<8) {
            return "Password must contain atleast 8 characters!";
        }
        else if ($pass != $cpass) {
            return "Confirm password does not match!";
        }
        return "";
    }

    function validate_phone($field) {
        if ($field == "") {
            return "Phone number is required!";
        }
        else if (preg_match("/[^0-9]/", $field)) {
            return "Phone number can have only digits!";
        }
        else if (strlen($field)!=10) {
            return "Password must have 10 digits";
        }
        return "";
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

    function checkEmail($connection, $field) {
        $sql = "SELECT email from users where email='$field'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result)>0) {
            return "Given Email already exists";
        }
        return "";
    }

    function addUser($connection, $name, $email, $type, $password, $phone) {
        $insertSql = "INSERT INTO users (name, email, phone, type, password)
                    VALUES('$name', '$email', '$phone','$type', '$password')";
        $result = mysqli_query($connection, $insertSql);
        if ($result) {
            return true;
        }else {
            echo "cannot add user to the system!";
            return false;
        }
                
    }

?>