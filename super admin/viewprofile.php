<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        
        header('location: ../account/index.php');
    }

    $fir_letter = substr($_SESSION['name'], 0, 1); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Profile</title>
</head>
<body>
    <div class="container">
        <?php include('header.html') ?>
        <div class="profile-box">
            <h1>Your profile</h1>
            <div>
            <div class="image"><?php echo $fir_letter; ?></div>
                <div class="details">
                    <div><span>Name</span>:<?php echo $_SESSION['name']; ?></div>
                    <div><span>Role</span>:<?php echo $_SESSION['type']; ?></div>
                    <div><span>Email</span>:<?php echo $_SESSION['email']; ?></div>
                    <div><span>Contact</span>:<?php echo $_SESSION['phone']; ?></div>
                    <div><input type="submit" value="Edit profile"></div>
                </div>
            </div>
            
        </div>
    </div>

    <?php include('footer.html') ?>
</body>
</html>