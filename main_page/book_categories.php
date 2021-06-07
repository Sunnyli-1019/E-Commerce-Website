<div id="list1" class="link-list">
                <ul>
                    Book Categories:
                    <?php
                    $catQ = mysqli_query($dbConnection, "SELECT * FROM `categories`");
                    while ($cat = mysqli_fetch_assoc($catQ)) {
                    $name = $cat['name'];
                    $catid = $cat['catid'];
                    echo
                    '<li><a href="request_get.php?catid='.$catid.'">'.$name.'</a></li>';
                    }
                    ?>
                </ul>
            </div>
