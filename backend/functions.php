<?php
    function ht($string=""){
        return htmlspecialchars($string);
    }

    function is_post_request()
    {
        return $_SERVER['REQUEST_METHOD']==='POST';
    }

    function is_get_request()
    {
        return $_SERVER['REQUEST_METHOD']==='GET';
    }

    function twitter_copyright($startYear){
        $currentyear=date("Y");
        if ($startYear<$currentyear){
            return "&copy; $startYear&ndash;$currentyear";
        }else{
            return "&copy; $startYear";
        }
    }

    function url_for($script)
    {
        return WWW_ROOT.$script;
    }

    function redirect_to($location)
    {
        header("Location:".$location);
        exit;
    }

    function u($string=""){
        return urlencode($string);
    }

    function log_out_user()
    {
        unset($_SESSION["userLoggedIn"]);
        session_destroy();
        return true;
    }

    function getInputValue($name)
    {
        if (isset($_POST[$name]))
        {
            echo $_POST[$name];
        }
    }
?>