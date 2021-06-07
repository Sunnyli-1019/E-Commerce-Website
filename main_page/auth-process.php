<?php
session_start();
include_once('lib/db.inc.php');
include_once('csrf.php');

if($_GET['action'] == 'login' && csrf_verifyNonce($_GET['action'],$_POST['nonce'])){
    ierg4210_login();
}
if($_GET['action'] == 'logout'){
    ierg4210_logout();
}
if($_GET['action'] == 'change' && csrf_verifyNonce($_GET['action'],$_POST['nonce'])){
    ierg4210_changepw();
}

function ierg4210_login(){
    //apply server-side validations here
    if (empty($_POST['email']) || empty($_POST['pw'])
    || !preg_match("/^[\w\/-][\w'\/\.-]*@[\w-]+(\.[\w-]+)*(\.[\w]{2,6})$/", $_POST['email'])
    || !preg_match("/^[\w@#$^&*-]+$/", $_POST['pw']))
    {
        throw new Exception("Wrong Credentials");
    }

    $email = $_POST['email'];
    #var_dump($email);
    $pwd = $_POST['pw'];
    #echo $pwd;
    #$nonce = $_POST['nonce'];
    // DB manipulation
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare('SELECT * FROM account WHERE email = ?');
    $q->execute(array($email));
    if ($r=$q->fetch()) {
        //Check if the hash of the password equals the one saved in database
        //If yes, create authentication information in cookies and session
        $saltedPwd = hash_hmac('sha256', $pwd, $r['salt']);
        if ($saltedPwd == $r['password']) {
            $exp = time() + 3600 * 24 * 3; //3days
            $token = array(
                'em'=>$r['email'],
                'exp'=>$exp,
                'k'=>hash_hmac('sha256', $exp.$r['password'], $r['salt'])
            );
            setcookie('s4210', json_encode($token), $exp,'','',true,true);
            $_SESSION['s4210'] = $token;
            $login_success = true;
            if ($r['flag'] == 1) {
                $adminpass = true;
            }
        }
        else {
        throw new Exception("Wrong Credentials");
        }

        if ($login_success && $adminpass) {
        header('Location: /main_page/admin.php', true, 302);
        exit();
        }
        else {
            header('Location: /main_page/main.php', true, 302);
            exit();
        }
    }
}

function ierg4210_logout()
{    
    //clear session
    session_start();
    session_unset();
    session_destroy();
    //clear cookies 
    setcookie("s4210",'', time()-3600);
    //return
    header('Location: /main_page/main.php',true,302);
    exit();
}

function ierg4210_changepw()
{

    //apply server-side validations here
    if (empty($_POST['change_email']) || empty($_POST['old_pw']) || empty($_POST['new_pw'])
    || !preg_match("/^[\w\/-][\w'\/\.-]*@[\w-]+(\.[\w-]+)*(\.[\w]{2,6})$/", $_POST['change_email'])
    || !preg_match("/^[\w@#$^&*-]+$/", $_POST['old_pw'])
    || !preg_match("/^[\w@#$^&*-]+$/", $_POST['new_pw']))
    {
        throw new Exception("Wrong Credentials");
    }
    $email = $_POST['change_email'];
    $old_pw = $_POST['old_pw'];
    $new_pw = $_POST['new_pw'];
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare('SELECT * FROM account WHERE email = ?');
    $q->execute(array($email));
    if ($r=$q->fetch()) {
        //Check if the hash of the password equals the one saved in database
        //If yes, create authentication information in cookies and session
        $saltedPwd = hash_hmac('sha256', $old_pw, $r['salt']);
        if ($saltedPwd == $r['password']) {
            $change = hash_hmac('sha256', $new_pw, $r['salt']);
            $q = $db->prepare('UPDATE account SET `password` = ? WHERE email = ?');
            $q->bindParam(1, $change);
            $q->bindParam(2, $email);
            $q->execute();
            ierg4210_logout();
        }
        else{
            throw new Exception("Wrong Credentials");
        }
    }
}

