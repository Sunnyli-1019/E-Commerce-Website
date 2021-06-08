<?php include_once('header.php');?>

<body onload="restore_cart()">
        <div id=id_wrapper>

        <?php include_once('book_categories.php');?>

            <div id="main">
                
                <?php include_once('welcome_note.php');?>
                
                <div class="dropdown">
                    <button id="id_bold">Shopping List</button>
                    <div class="dropdown-content">

                    <p id ="icart"></p> <!-- List of shopping cart -->

                    <p id="subtotal">Sub total: $0</p>
                    <p><button type="button" onclick="checkout()">Check Out</button></p>     
                    </div>
                </div>

                <nav>
                    <p>
                        <a href="../welcome.php">Home</a> >
                        <a href="main.php">Main Page</a> >
                        <a href="#">
                            <?php
                                $i = $_GET['catid'];
                                $catQ = mysqli_query($dbConnection, "SELECT * FROM `categories` WHERE `catid`= $i");
                                $cat = mysqli_fetch_assoc($catQ);
                                echo $cat['name'];
                            ?>
                        </a>
                    </p>
                </nav>

                <div class="grid-container">
                    <?php 
                        $productQ = mysqli_query($dbConnection, "SELECT * FROM `products` order by `catid`");
                        
                        while ($product = mysqli_fetch_assoc($productQ)) {
                            if ($product['catid'] == $_GET['catid']) {
                                echo '<section id="id_photo">
                                <a href="Product page/products_get.php?pid='.$product['pid'].'&catid='.$product['catid'].'"><img id=id_thumbnail src="images/'.$product['pid'].'.jpg"></a>
                                <p> Book Title：'.$product['name'].' | HKD $'.$product['price'].' | <button type="button"  onclick="addToCart('.$product['pid'].')">ADD</button>
                                <button type="button"  onclick="dropToCart('.$product['pid'].')">DROP</button></p>
                                </section>';
                            }
                        }
                    ?>
                </div>
            </div>

<?php include_once('footer.php');?>