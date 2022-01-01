<?php
    require_once "../initialize.php";

    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

    if (is_post_request()){
        if (isset($_POST['postId']) && !empty($_POST['postId'])){
            $postId=ht($_POST['postId']);
            $userId=ht($_POST['userId']);
            $postedBy=ht($_POST['tweetBy']);

            if ($userId==$postedBy){
                $loadFromUser->delete("tweets",["tweetBy"=>$userId,"tweetID"=>$postId]);
                // $loadFromUser->delete("comment",["commentOn"=>$postId])
            }
            $loadFromTweet->tweets($userId,5);
        }
    }