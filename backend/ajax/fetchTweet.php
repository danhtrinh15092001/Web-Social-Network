<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['fetchTweets']) && !empty($_POST['fetchTweets'])){
            $userid=ht($_POST['userID']);
            $limit=(int)trim($_POST['fetchTweets']);
            // echo $limit;
            $loadFromTweet->tweets($userid,$limit);
        }
    }