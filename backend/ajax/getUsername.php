<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['profileid']) && !empty($_POST['profileid'])){
            $profileid=ht($_POST['profileid']);
             
            echo $loadFromUser->getUsername($profileid);
        }
    }