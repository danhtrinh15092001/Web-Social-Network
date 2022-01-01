<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['loadUserid']) && !empty($_POST['loadUserid'])){
            $userid=ht($_POST['loadUserid']);
            $otherid=ht($_POST['otheruserid']);

            $allusersmsg=$loadFromMessage->recentMessages($userid);
            foreach($allusersmsg as $user){
                $activeClass=($user->user_id==$otherid) ? "activeClass" : "";
                echo ' <li class="msg-user-name-wrap '.$activeClass.'" data-profileid="'.$user->user_id.'">
                <div class="msg-user-name-wrap">
                    <div class="msg-user-photo">
                        <img src="'.url_for($user->profileImage).'" alt="'.$user->firstName.' '.$user->lastName.'">
                    </div>
                    <div class="msg-user-name-text">
                        <div class="msg-user-new">
                            <div class="msg-user-name">
                                <h3>'.$user->firstName.' '.$user->lastName.'</h3>
                                <span class="msg-username">@'.$user->username.'</span>
                            </div>
                            <div class="msg-user-text">
                                <div class="msg-previ">
                                '.$user->message.'
                                </div>
                            </div>
                        </div>
                        <div class="msg-date-wrapper">
                            <div class="msg-date">'.$loadFromUser->timeAgo($user->messageOn).'</div>
                        </div>
                    </div>
                </div>
            </li>';
            }
        }

        if (isset($_POST['otherpersonid']) && !empty($_POST['otherpersonid'])){
            $userid=ht($_POST['userId']);
            $otherid=ht($_POST['otherpersonid']);

            $messageData=$loadFromMessage->messageData($userid,$otherid);
            if(!empty($messageData)){
                echo '<div class="past-data-count" datacount="'.count($messageData).'"></div>';
                foreach($messageData as $message){
                    if ($message->messageFrom==$userid){
                        echo '<div class="rigth-sender-msg">
                        <div class="right-sender-text-time">
                            <div class="right-sender-text-wrapper">
                                <div class="s-text">
                                    <div class="s-msg-text">
                                        '.$message->message.'
                                    </div>
                                </div>
                            </div>
                            <div class="sender-time">'.$loadFromUser->timeAgo($message->messageOn).'</div>
                        </div>
                    </div>';
                    }else{
                        echo '<div class="left-receiver-msg">
                        <a href="'.ht(u($message->username)).'" class="receiver-img">
                            <img src="'.url_for($message->profileImage).'" alt="'.$message->firstName.' '.$message->lastName.'">
                        </a>
                        <div class="receiver-text-time">
                            <div class="left-receiver-text-wrapper">
                                <div class="r-text">
                                    <div class="r-msg-text">
                                    '.$message->message.'
                                    </div>
                                </div>
                            </div>
                            <div class="receiver-time">'.$loadFromUser->timeAgo($message->messageOn).'</div>
                        </div>
                    </div>';
                    }
                }
            }
        }
    }