<?php 
    include_once 'backend/initialize.php';
    if (Login::isLoggedIn())
    {
        $userid=Login::isLoggedIn();
    }
    else if (isset($_SESSION['userLoggedIn']))
    {
        log_out_user();
        redirect_to(url_for("index"));
    }
    else
    {
        redirect_to(url_for("index"));
    }

    $loadFromUser->delete("token",["user_id"=>$userid]);

    if (isset($_COOKIE['FBID'])){
        unset($_COOKIE['FBID']);
        header('Refresh:0');
    }