<?php
    ob_start();

    date_default_timezone_set('Asia/Ho_Chi_Minh');

    require_once "config.php";
    include "classes/Exception.php";
    include "classes/PHPMailer.php";
    include "classes/SMTP.php";

    session_start();

    spl_autoload_register(function($class){
        require_once "classes/$class.php";
    });


    $loadFromUser=new User;
    $account=new Account;
    $verify=new Verify;
    $loadFromTweet=new Tweet;
    $tweetControls=new TweetControls;
    $loadFromFollow=new Follow;
    $loadFromMessage=new Messages;
    include "functions.php";
?>