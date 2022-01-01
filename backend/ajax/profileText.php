<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['usernameText']) && !empty($_POST['usernameText'])){
            $usernameText=$_POST['usernameText'];
            $userId=ht($_POST['userid']);

            $loadFromUser->update('users',$userId,['username'=>$usernameText]);
        }

        if (isset($_POST['bioText']) && !empty($_POST['bioText'])){
            $bioText=$_POST['bioText'];
            $userId=ht($_POST['userid']);

            $loadFromUser->update('users',$userId,['bio'=>$bioText]);
            $loadFromUser->update('profile',$userId,['Bio'=>$bioText]);
        }

        if (isset($_POST['locationText']) && !empty($_POST['locationText'])){
            $locationText=$_POST['locationText'];
            $userId=ht($_POST['userid']);

            $loadFromUser->update('users',$userId,['country'=>$locationText]);
            $loadFromUser->update('profile',$userId,['country'=>$locationText]);
        }

        if (isset($_POST['websiteText']) && !empty($_POST['websiteText'])){
            $websiteText=$_POST['websiteText'];
            $userId=ht($_POST['userid']);

            $loadFromUser->update('users',$userId,['website'=>$websiteText]);
            $loadFromUser->update('profile',$userId,['website'=>$websiteText]);
        }

        if (isset($_POST['genderText']) && !empty($_POST['genderText'])){
            $userId=ht($_POST['userid']);
            $genderText=$_POST['genderText'];

            // $loadFromUser->update('users',$userId,['website'=>$websiteText]);
            $loadFromUser->update('profile',$userId,['gender'=>$genderText]);
        }

        if (isset($_POST['birthdayText']) && !empty($_POST['birthdayText'])){
            $userId=ht($_POST['userid']);
            $birthdayText=$_POST['birthdayText'];

            
            $loadFromUser->update('profile',$userId,['birthday'=>$birthdayText]);
        }

        if (isset($_POST['workText']) && !empty($_POST['workText'])){
            $userId=ht($_POST['userid']);
            $workText=$_POST['workText'];

            
            $loadFromUser->update('profile',$userId,['profession'=>$workText]);
        }
    }