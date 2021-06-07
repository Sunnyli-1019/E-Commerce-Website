<?php include_once('header.php');?>

<body onload="restore_cart()">
        <div id=id_wrapper>

        <?php include_once('book_welcome.php');?>

                <div class="dropdown">
                    <button id="id_bold">Shopping List</button>
                    <div class="dropdown-content">
                    <p id ="icart">
                    </p>
                    <p id="subtotal">Sub total: $0</p>
                    <p><button type="button" onclick="checkout()">Check Out</button></p>     
                    </div>
                </div>

                <nav>
                    <p>
                        <a href="../../welcome.php">Home</a> >
                        <a href="../main.php">Main Page</a> >

                        <?php
                                $i = $_GET['catid'];
                                $catQ = mysqli_query($dbConnection, "SELECT * FROM `categories` WHERE `catid`= $i");
                                $cat = mysqli_fetch_assoc($catQ);
                                echo 
                                '<a href="../request_get.php?catid='.$i.'">'.$cat['name'].'</a> >';
                        ?>
                        
                        <a href="#">
                            <?php
                                $i = $_GET['pid'];
                                $productQ = mysqli_query($dbConnection, "SELECT * FROM `products` WHERE `pid`= $i");
                                $product = mysqli_fetch_assoc($productQ);
                                echo $product['name'];
                            ?>
                        </a>
                    </p>
                </nav>

                <div>
                    <?php 
                        $productQ = mysqli_query($dbConnection, "SELECT * FROM `products` order by `catid`");
                        
                        while ($product = mysqli_fetch_assoc($productQ)) {
                            if ($product['pid'] == $_GET['pid']) {
                                echo 
                                '<img src="../images/'.$product['pid'].'.jpg">
                                <p>'.$product['name'].' | HKD $'.$product['price'].' | <button type="button"  onclick="addToCart('.$product['pid'].')">ADD</button>
                            <button type="button"  onclick="dropToCart('.$product['pid'].')">DROP</button></p> 
                                <p>Book Details : <br>'.$product['description'].' </p>';
                            }
                        }
                    ?>
                </div>
            </div>

<?php include_once('footer.php');?>
