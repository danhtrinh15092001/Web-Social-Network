<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['Statustext']) && !empty($_POST['Statustext'])){
            $userid=ht($_POST['userid']);
            $card='<div><li><ul><h1><h2><h3><p><br><em>';
            $statusText=strip_tags($_POST['Statustext'],$card);
            $lastId=$loadFromUser->create("tweets",["status"=>$statusText,"tweetBy"=>$userid,"postedOn"=>date('Y-m-d H:i:s')]);
            preg_match_all("/#+([a-zA-Z0-9_]+)/i",$statusText,$hashtag);
            if (!empty($hashtag))
            {
                $loadFromTweet->addTrend($statusText,$lastId,$userid);
            }
            $loadFromTweet->addMention($statusText,$lastId,$userid);
            $loadFromTweet->tweets($userid,5);
        }
    }

    if(!empty($_FILES['postImage'])){
        $postImage=$_FILES['postImage'];
        $userid=ht($_POST['user_id']);

        $postImagePath=$loadFromUser->uploadPostImage($postImage);
        

        $loadFromUser->create("tweets",["tweetBy"=>$userid,"tweetImage"=>$postImagePath,"postedOn"=>date('Y-m-d H:i:s')]);
       $loadFromTweet->tweets($userid,10);

    }

    if(!empty($_POST['fetchHashtag'])){
         $loadFromTweet->trends(); 
    
    }

    if(isset($_POST['postText']) && !empty($_FILES['postImageText'])){
        $text=FormSanitizer::formSanitizerString($_POST['postText']);
        $postImage=$_FILES['postImageText'];
        $userid=ht($_POST['user_id']);
        $postImagePath=$loadFromUser->uploadPostImage($postImage);

    $lastId=$loadFromUser->create("tweets",["status"=>$text,"tweetBy"=>$userid,"tweetImage"=>$postImagePath,"postedOn"=>date('Y-m-d H:i:s')]);
    preg_match_all("/#+([a-zA-Z0-9_]+)/i",$text,$hashtag);
    if(!empty($hashtag)){
        $loadFromTweet->addTrend($text,$lastId,$userid);
    }
    $loadFromTweet->tweets($userid,10);

    }
?>