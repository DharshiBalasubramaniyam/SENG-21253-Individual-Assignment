<?php
    include "../database/dbconnection.php";

    $error = "";
    $email = $password = "";

    if(isset($_POST['submit'])) {

        if (isset($_POST['email']))   $email = sanitizeMySQL($connection,  $_POST['email']);
        if (isset($_POST['password']))  $password = sanitizeMySQL($connection,  $_POST['password']);

        $error = validate($connection, $email, $password);

        if ($error==="") {
            session_start();

            $result = getUser($connection, $email, $password);
            $user = mysqli_fetch_assoc($result);

            $_SESSION['name'] = $user['name'];
            $_SESSION['id'] = $user['user_id'];
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $user['password'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['type'] = $user['type'];
            
            if ($_SESSION['type'] == 'super admin') {
                header("location: ../super admin/home.php");
            }else if ($_SESSION['type'] == 'admin') {
                header("location: ../admin/home.php");
            }else if ($_SESSION['type'] == 'customer') {
                header("location: ../customer/home.php");
            }
            
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <?php include('header.html') ?>
        <form action="index.php" method="post" onclick="return fun">
            <h1>Login</h1>
            <?php if (!empty($error)) { ?>
                <div class="error-box"><?php echo $error; ?></div>
            <?php } ?>
            <div class="box">
                <label for="email">Email</label><br>
                <input type="text" name="email" value="<?php echo $email; ?>"><br>
            </div>
            <div class="box">
                <label for="password">Password</label><br>
                <input type="password" name="password" value= "<?php echo $password; ?>" id="password">
                <div class="view"></div><br>
            </div>
            <div class="box">
                <a href="#">Forgot Password?</a>
            </div>
            <div class="box">
                <input type="submit" value="Login" name="submit">
            </div>

            <div class="box">
                New member? <a href="./register.php">Register now</a>
            </div>
            
        </form>
    </div>
    <?php include('footer.html') ?>

    <script src="../js/script.js"></script>
</body>
</html>

<?php

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

    function validate($connection, $email, $password) {

        $result = getUser($connection, $email, $password);
        
        if (mysqli_num_rows($result)==0) {
            return "Invalid email or password!";
        }
        return "";

    }

    function getUser($connection, $email, $password) {
        // $hash_pass = hash('ripemd128', $password);
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($connection, $sql);
        return $result;
    }




?>