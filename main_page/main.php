<?php include_once('header.php');?>

<body onload="restore_cart()">
        <div id=id_wrapper>

        <?php include_once('book_categories.php');?>

            <div id="main">
                <form action="login.php">
                    <input type="submit" value="Login" />
                </form>
                
                <form id="logout" method="POST" action="auth-process.php?action=logout"
                enctype="multipart/form-data">
                <input type="submit" value="Logout" />
                </form>

                <?php
                    include_once('auth.php');
                    if ($user = checking()) {
                        echo "<div> User: ".$user."</div>";
                    }
                    else {
                        echo "<div> User: Guest</div>";
                    }
                ?>

                <?php include_once('welcome_note.php');?>
                
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
                        <a href="../welcome.php">Home</a> >
                        <a href="#">Main Page</a>
                    </p>
                </nav>

                <div class="grid-container">
                    <?php 
                        $productQ = mysqli_query($dbConnection, "SELECT * FROM `products` order by `catid`");
                        
                        while ($product = mysqli_fetch_assoc($productQ)) {
                            $name = strval($product['name']); 
                            $price = $product['price'];
                            echo 
                            '<section id="id_photo">
                            <a href="Product page/products_get.php?pid='.$product['pid'].'&catid='.$product['catid'].'"><img id=id_thumbnail src="images/'.$product['pid'].'.jpg"></a>
                            <p> Book Title：'.$product['name'].' | HKD $'.$product['price'].' | <button type="button"  onclick="addToCart('.$product['pid'].')">ADD</button>
                            <button type="button"  onclick="dropToCart('.$product['pid'].')">DROP</button></p>
                            </section>';
                        }
                    ?>
                </div>
            </div>

<?php include_once('footer.php');?>