<?php
    class Login{

        public static function isLoggedIn()
        {
            if (isset($_COOKIE['FBID']))
            {
                if (Database::query("SELECT `user_id` FROM token WHERE token=:token",[':token'=>sha1($_COOKIE['FBID'])]))
                {
                    $user_id=Database::query("SELECT `user_id` FROM token WHERE token=:token",[':token'=>sha1($_COOKIE['FBID'])])[0]["user_id"];
                    return $user_id;
                }
            }
        }
    }
?>