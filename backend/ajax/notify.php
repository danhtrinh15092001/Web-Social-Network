<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['notificationUpdate']) && !empty($_POST['notificationUpdate'])){
            $uid=ht($_POST['notificationUpdate']);
            
            $notification=$loadFromMessage->notificationCount($uid);
            echo count($notification);
        }

        if (isset($_POST['notify']) && !empty($_POST['notify'])){
            $userId=ht($_POST['notify']);
            
            $loadFromMessage->notificationCountReset($userId);
        }

        if (isset($_POST['notificationStatusUpdate']) && !empty($_POST['notificationStatusUpdate'])){
            $userid=ht($_POST['notificationStatusUpdate']);
            $notificationid=ht($_POST['notificationid']);
            
            $loadFromMessage->notificationStatusUpdate($userid,$notificationid);
        }
    }