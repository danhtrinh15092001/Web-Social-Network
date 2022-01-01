<?php
     if($_SERVER['REQUEST_METHOD']=="GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
         redirect_to(url_for("index"));
     }
    $user_id=$_SESSION['userLoggedIn'];
    if(isset($_SESSION['userLoggedIn'])){
        $verify->authOnly($user_id);
    }
    // $status=$verify->getVerifyStatus(["status"],$user_id);
    if (Login::isLoggedIn())
    {
        redirect_to(url_for("home"));
    }
    // else if(isset($_SESSION['userLoggedIn']) && $status->status=='1')
    // {
    //     redirect_to(url_for("home"));
    // }

    $errors=array();
    if (isset($_SESSION['userLoggedIn']))
    {
        $user_id=(int)($_SESSION['userLoggedIn']);
        $user=$loadFromUser->userData($user_id);
        $link=$verify->generateLink();
        $message="{$user->firstName}, Your account has been created, Please visit this link to verify your email <a href='http://localhost/Twitter/verification/$link'>Verify Link</a>";
        $subject="[TWITTER] Please verify your account";
        $verify->sendToMail($user->email,$message,$subject);
        $loadFromUser->create("verification",["user_id"=>$user_id,"code"=>$link]);
    }
    else
    {
        redirect_to(url_for("index"));
    }

    if (is_get_request())
    {
        if (isset($_GET['verify']))
        {
            $user_id=(int)($_SESSION['userLoggedIn']);
            $code=FormSanitizer::FormSanitizerString($_GET['verify']);
            $verifyCode=$verify->verifyCode(["*"],$code);

            if ($verifyCode)
            {
                if (date('Y-m-d',strtotime($verifyCode->createAt))<date('Y-m-d'))
                {
                    $errors['verify']="Your verification link has expired";
                }
                else{
                    $loadFromUser->update("verification",$user_id,array("code"=>$code,"status"=>1));
                    if (isset($_SESSION["rememberMe"]))
                    {
                        $tstrong=true;
                        $token=bin2hex(openssl_random_pseudo_bytes(64,$tstrong));
                        $loadFromUser->create("token",["user_id" => $user_id,"token"=>sha1($token)]);
                        setcookie('FBID', $token, time() + 60*60*24*7, "/",NULL,NULL,true);
                    }
                    redirect_to(url_for("home"));
                }
            }
            else{
                $errors['verify']="Invalid verification link";
            }
        }
    }
?>