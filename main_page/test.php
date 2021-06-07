<?php
session_start();
echo ($salt=mt_rand())."<br/>";
echo hash_hmac('sha256', '1234', $salt)."<br/>";
echo ($salt2=mt_rand())."<br/>";
echo hash_hmac('sha256', '0123', $salt2)."<br/>";
print_r($_SESSION);
?>