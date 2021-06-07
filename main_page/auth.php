<?php
#session_start();
#include_once('lib/db.inc.php');

function auth(){
    if(!empty($_SESSION['s4210']))
        return $_SESSION['s4210']['em'];
    if (!empty($_COOKIE['s4210'])) {
        //stripslashes() Return a string with backslashes stripped off.
        // (\'becomes ' and so on.)
        if ($t = json_decode(stripslashes($_COOKIE['s4210']),true)) {
            if (time() > $t['exp']) return false;
            global $db;
            #$db = ierg4210_DB();
            $q = $db->prepare('SELECT * FROM account WHERE email =  ?');
            $q->execute(array($t['em']));
            if ($r=$q->fetch()) {
                //expected format: $pw=hash_hmac('shal', $exp.$PW, $salt);
                $realk=hash_hmac('sha256', $t['exp'].$r['password'], $r['salt']);
                if ($realk == $t['k']) {
                    $_SESSION['s4210'] = $t;
                    return $t['em'];
                }
            }
        }
    }
    return false;
}

function checking(){
    if(!empty($_SESSION['s4210']))
        return $_SESSION['s4210']['em'];
    if (!empty($_COOKIE['s4210'])) {
        //stripslashes() Return a string with backslashes stripped off.
        // (\'becomes ' and so on.)
        if ($t = json_decode(stripslashes($_COOKIE['s4210']),true)) {
            if (time() > $t['exp']) return false;
            global $db;
            #$db = ierg4210_DB();
            $q = $db->prepare('SELECT * FROM account WHERE email =  ?');
            $q->execute(array($t['em']));
            if ($r=$q->fetch()) {
                //expected format: $pw=hash_hmac('shal', $exp.$PW, $salt);
                $realk=hash_hmac('sha256', $t['exp'].$r['password'], $r['salt']);
                if ($realk == $t['k']) {
                    $_SESSION['s4210'] = $t;
                    return $t['em'];
                }
            }
        }
    }
    return false;
}
?>