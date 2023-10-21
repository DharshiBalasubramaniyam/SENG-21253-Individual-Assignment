<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Header</title>
</head>
<body>

    <header>

        <h1 class="logo">ABC groups</h1>

        <ul>
            <li>
                <a href="./home.php"><span>Home</span><img src="../uploadImages/home.png" alt=""></a>
            </li>
            <li>
                <a href="#"><span>New</span> <img src="../uploadImages/add.png" alt=""></a>
                <ul>
                    <li><a href="./addproduct.php">Add product</a></li>
                    <li><a href="./adduser.php">Add user</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><span>You(Admin)</span><img src="../uploadImages/user.png" alt=""></a>
                <ul>
                    <li><a href="./viewprofile.php">View profile</a></li>
                    <li><a href="../account/logout.php">Log out</a></li>
                </ul>
            </li>
        </ul>

    </header>
    
</body>
</html>