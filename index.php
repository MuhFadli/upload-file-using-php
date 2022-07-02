<?php

@include 'config.php';


if(isset($_POST['add_product']))
 {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.;

    if(empty($product_name) || empty($product_price) || empty($product_image)) {
        $message[] = 'please fill out the form';
    } else {
        $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
        $upload = mysqli_query($conn, $insert);
        if($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'succes adding new product';
        } else {
            $message[] = 'adding new product does not succed';
        }
    }  
 }

 if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products where id = $id");
    header('location:index.php');
 }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample a simple Products</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>

<?php

@include 'config.php';


if(isset($message))
 {
    foreach($message as $message) {
        echo '<span class="msg">'.$message.'</span>';
    }
 }

?>


    <div class="container">
        <div class="admin-product-form-container">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Add New Product here</h3>
                <input type="text" placeholder="what's the product name?" name="product_name"
                class="box"
                >
                <input type="number" placeholder="how about the price?" name="product_price"
                class="box"
                >
                <input type="file" placeholder="what's the name of product" name="product_image"
                class="box" accept="image/png, image/jpg, image/jpeg"
                >
                <input type="button" value="add a product" name="add_product"
                class="btn"
                >
            </form>
        </div>

        <?php
            $select = mysqli_query($conn, "SELECT * FROM products");
        ?>

        <div class="show-product">
            <table class="table">
                <thead>
                    <tr>
                        </th>>product image</th>
                        <th>product name</th>
                        <th>product price</th>
                        <th colspan="2">action</th>
                    </tr>
                </thead>

                <?php
                    while($row = mysqli_fetch_assoc($select)) {
                ?>
                    <tr>
                        <td><img src="uploaded_img/<?php $row=['image'];?>" alt="image_product"
                            height="100"></td>
                        <td><?php $row=['name'];?></td>
                        <td><?php $row=['price'];?></td>
                        <td colspan="2">
                            <a href="update.php?edit= <?php echo $row=['id'];?>" class="btn">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="index.php?delete= <?php echo $row=['id'];?>" class="btn">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php
                    };
                ?>

            </table>
        </div>
    </div>
</body>

</html>