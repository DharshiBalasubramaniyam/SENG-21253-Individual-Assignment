<?php

    session_start();

    if (!isset($_SESSION['email'])) {
        
        header('location: ../account/index.php');
    }

    include('../database/products.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Home</title>
</head>
<body>

    <div class="container" style="justify-content: flex-start;">
        <?php include('header.html') ?>
        <div class="products">
            <h1>Latest Products</h1>
            <div class="products-box">

                <?php  
                    if (count($records)==0) {
                        echo '<p>No products found!</p>';
                    }
                    else {
                        foreach($records as $record) {  ?>
                            <div class="box">
                                <img src="../uploadImages/show.png" class="right">
                                <img src="../uploadImages/trash-can.png" class="left">
                                <img src="<?php echo '../' . $record['image_path'] ?>"  class="product">
                                <h2><?php echo $record['name'] ?></h2>
                                <p> <?php echo $record['description'] ?> </p>
                                <h2> <?php echo 'Rs.' . $record['price'] ?> </h2>
                                <button>Update product</button>
                            </div>
                    <?php  } } ?> 

            </div>
        </div>
    </div>

    <?php include('footer.html') ?>

    <script src="../js/script.js"></script>
    
</body>
</html>