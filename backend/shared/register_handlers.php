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
        if(isset($_POST['firstName'])&&!empty($_POST['firstName']))
        {
            $fname=FormSanitizer::formSanitizerName($_POST['firstName']);
            $lname=FormSanitizer::formSanitizerName($_POST['lastName']);
            $email=FormSanitizer::formSanitizerString($_POST['Email']);
            $pass=FormSanitizer::formSanitizerString($_POST['password']);
            $repass=FormSanitizer::formSanitizerString($_POST['Confirmpassword']);
            $username="TODO";

            $username=$account->createUsername($fname,$lname);

            $wasSuccessfull=$account->register($fname,$lname,$username,$email,$pass,$repass);
            if ($wasSuccessfull)
            {   
                $user_id=$wasSuccessfull;
                $_SESSION['userLoggedIn']=$wasSuccessfull;
                if (isset($_POST['remember']))
                {
                   $_SESSION['rememberMe']=$_POST['remember'];
                }
                redirect_to(url_for("verification"));
            }
        }
    }
?>