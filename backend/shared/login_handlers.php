<?php

    if($_SERVER['REQUEST_METHOD']=="GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
        redirect_to(url_for("index"));
    }
    if (isset($_SESSION['userLoggedIn']))
    {
        redirect_to(url_for("home"));
    }else if (Login::isLoggedIn())
    {
        redirect_to(url_for("home"));
    }

    if (is_post_request())
    {
        if(isset($_POST['username'])&&!empty($_POST['username']))
        {
            $username=FormSanitizer::formSanitizerString($_POST['username']);
            $pass=FormSanitizer::formSanitizerString($_POST['password']);


            $wasSuccessfull=$account->login($username,$pass);
            if ($wasSuccessfull)
            {
                $user_id=$wasSuccessfull;
                $_SESSION['userLoggedIn']=$wasSuccessfull;
                if (isset($_POST['remember']))
                {
                    $tstrong=true;
                    $token=bin2hex(openssl_random_pseudo_bytes(64,$tstrong));
                    $loadFromUser->create("token",["user_id" => $user_id,"token"=>sha1($token)]);
                    setcookie('FBID', $token, time() + 60*60*24*7, "/",NULL,NULL,true);
                }
                redirect_to(url_for("home"));
            }
        }
    }
?>