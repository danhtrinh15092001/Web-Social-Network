<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['tweetID']) && !empty($_POST['tweetID'])){
            $likeBy=ht($_POST['likeBy']);
            $tweetID=ht($_POST['tweetID']);
            $postedBy=ht($_POST['likeOn']);

            echo $loadFromTweet->likes($likeBy,$tweetID,$postedBy);
        }
    }