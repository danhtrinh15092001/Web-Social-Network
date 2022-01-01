<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['unfollow']) && !empty($_POST['unfollow'])){
            $unfollow=ht($_POST['unfollow']);
            $userId=ht($_POST['userId']);
            $loadFromFollow->unfollow($unfollow,$userId);
        }

        if (isset($_POST['follow']) && !empty($_POST['follow'])){
            $follow=ht($_POST['follow']);
            $userId=ht($_POST['userId']);
            $loadFromFollow->follow($follow,$userId);

        }

    }