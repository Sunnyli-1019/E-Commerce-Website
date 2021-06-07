<?php
session_start();
include_once('auth.php');
include_once('csrf.php');
require __DIR__.'/lib/db.inc.php';

#echo auth();

if (auth() != "admnin@gmail.com" || csrf_verifyNonce($_GET['action'],$_POST['nonce'])) {
    header("Location: /main_page/login.php");
}

$res = ierg4210_cat_fetchall();
$options = '';

foreach ($res as $value){
    $options .= '<option value="'.$value["catid"].'"> '.$value["name"].' </option>';
}
?>

<html>
<strong>Admin Panel</strong>
    <fieldset>
        <legend> New Category</legend>
        <form id="cat_insert" method="POST" action="admin-process.php?action=<?php echo ($action = 'cat_insert'); ?>"
        enctype="multipart/form-data">
        <label for="cat_name"> Name </label>
            <div> <input id="cat_name" type="text" name="cat_name" required="required" pattern="^[\w\-]+$"/></div>
            <input type="submit" value="Submit"/>
            <input type="hidden" name = "nonce" value="<?php echo csrf_getNonce($action);?>" />
            
        </form>
    </fieldset>
    
    <fieldset>
        <legend> New Product</legend>
        <form id="prod_insert" method="POST" action="admin-process.php?action=<?php echo ($action = 'prod_insert'); ?>"
        enctype="multipart/form-data">
            <label for="prod_catid"> Category </label>
            <div> <select id="prod_catid" name="catid"><?php echo $options; ?></select></div>
            
            <label for="prod_name"> Name </label>
            <div> <input id="prod_name" type="text" name="name" required="required" /></div>
            
            <label for="prod_price"> Price </label>
            <div> <input id="prod_price" type="text" name="price" required="required" pattern="^[1-9]\d{0,7}(?:\.\d{1,4})?$"/></div>
            
            <label for="prod_desc"> Description </label>
            <div> <textarea cols="50" rows="10" id="prod_desc" type="text" name="description"></textarea> </div>
            
            <label for="prod_image"> Image </label>
            <div> <input type="file" name="file" required="true" accept="image/jpeg.gif.png\\\"/> </div>
            <br>
            <input type="submit" value="Submit"/>
            <input type="hidden" name = "nonce" value="<?php echo csrf_getNonce($action);?>" />
        </form>
    </fieldset>
    <a href="main.php">Back to Main Page</a>
</html>
