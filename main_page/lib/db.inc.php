<?php
function ierg4210_DB() {
    $servername = "localhost";
    $username = "root";
    $password = "";

	// TODO: change the following path if needed
    try {
        $db = new PDO("mysql:host=$servername;dbname=php_shop", $username, $password);
        $db->query('PRAGMA foreign_keys = ON;');
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        #echo "Connected successfully";
        return $db;
      } 

      catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
	// FETCH_ASSOC:
	// Specifies that the fetch method shall return each row as an
	// array indexed by column name as returned in the corresponding
	// result set. If the result set contains multiple columns with
	// the same name, PDO::FETCH_ASSOC returns only a single value
	// per column name.

}

function ierg4210_cat_fetchall() {
    // DB manipulation
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM categories LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}

// Since this form will take file upload, we use the tranditional (simpler) rather than AJAX form submission.
// Therefore, after handling the request (DB insert and file copy), this function then redirects back to admin.html
function ierg4210_prod_insert() {
    // input validation or sanitization

    // DB manipulation
    global $db;
    $db = ierg4210_DB();

    // TODO: complete the rest of the INSERT command if needed
    if (!preg_match('/^\d*$/', $_POST['catid']))
        throw new Exception("invalid-catid");
    $_POST['catid'] = (int) $_POST['catid'];

    if (!preg_match('/^[\w\- ]+$/', $_POST['name']))
        throw new Exception("invalid-name");

    if (!preg_match('/^[\d\.]+$/', $_POST['price']))
        throw new Exception("invalid-price");

    if (!preg_match('/^[\w\- ]+$/', $_POST['description']))
        throw new Exception("invalid-text");

    $sql="INSERT INTO products VALUES (null,?, ?, ?, ?)";
    $q = $db->prepare($sql);

    // Copy the uploaded file to a folder which can be publicly accessible at incl/img/[pid].jpg
    if ($_FILES["file"]["error"] == 0
        && $_FILES["file"]["type"] == "image/jpeg"
        && mime_content_type($_FILES["file"]["tmp_name"]) == "image/jpeg"
        && $_FILES["file"]["size"] < 10000000) {

        $sql="INSERT INTO products VALUES (null,?, ?, ?, ?);";
        $q = $db->prepare($sql);

        $catid = $_POST["catid"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $desc = $_POST["description"];

        $q->bindParam(1, $catid);
        $q->bindParam(2, $name);
        $q->bindParam(3, $price);
        $q->bindParam(4, $desc);
        $q->execute();
        $lastId = $db->lastInsertId();

        // Note: Take care of the permission of destination folder (hints: current user is apache)
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "C:\laragon\www\web\main_page\images\\" . $lastId . ".jpg")) {
            // redirect back to original page; you may comment it during debug
            //header('Location: admin.php');
            header('Content-Type: text/html; charset=utf-8');
            echo 'Done.<br/><a href="main.php">Back to Main Page.</a>';
            exit();
        }
    }
    // Only an invalid file will result in the execution below
    // To replace the content-type header which was json and output an error message
    header('Content-Type: text/html; charset=utf-8');
    echo 'Invalid file detected. <br/><a href="javascript:history.back();">Back to admin panel.</a>';
    exit();
}


function ierg4210_cat_insert() {
    // TODO: complete the code of this function to handle category insert
    global $db;
    $db = ierg4210_DB();

    $sql="INSERT INTO categories VALUES (null, ?);";
    $q = $db->prepare($sql);
    $name = $_POST["cat_name"];
    $q->bindParam(1, $name);
    $q->execute();
    header('Content-Type: text/html; charset=utf-8');
    echo 'Done.<br/><a href="main.php">Back to Main Page.</a>';
    exit();

}
function ierg4210_cat_edit(){
    // TODO: complete the code of this function to handle category edit
}
function ierg4210_cat_delete(){
    // TODO: complete the code of this function to handle category deletion
}
function ierg4210_prod_delete_by_catid(){
    // TODO: complete the code of this function to handle products deletion
}
function ierg4210_prod_fetchAll(){
    // TODO: complete the code of this function to fetch all products from the database
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM products LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}
function ierg4210_prod_fetchOne(){
    // TODO: complete the code of this function to fetch one specific product from the database global $db;
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM products LIMIT 1;");
    if ($q->execute())
        return $q->fetch();
}
function ierg4210_prod_edit(){
    // TODO: complete the code of this function to handle product information edit
}
function ierg4210_prod_delete(){
    // TODO: complete the code of this function to handle product deletion
}

function ierg4210_login_fetchall() {
    // DB manipulation
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM account LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}