<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_FILES['croppedImage']) && !empty($_FILES['croppedImage'])){
            $file=($_FILES['croppedImage']);
            $userId=ht($_POST['user_id']);
            $folder=$loadFromUser->cropperImage($file,$userId);
            $loadFromUser->update("users",$userId,['profileImage'=>$folder]);
            $loadFromUser->update("profile",$userId,['user_id'=>$userId,'profileImage'=>$folder]);
        }

        if (isset($_FILES['croppedCoverImage']) && !empty($_FILES['croppedCoverImage'])){
            $file=($_FILES['croppedCoverImage']);
            $userId=ht($_POST['user_id']);
            $folder=$loadFromUser->cropperCoverImage($_FILES['croppedCoverImage'],$userId);
            $loadFromUser->update("users",$userId,['profileCover'=>$folder,'profileEdit'=>1]);
            $loadFromUser->update("profile",$userId,['user_id'=>$userId,'profileCover'=>$folder]);
        }
    }