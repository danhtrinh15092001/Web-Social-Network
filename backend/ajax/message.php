<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['otheridForAjax']) && !empty($_POST['otheridForAjax'])){
            $userid=ht($_POST['useridForAjax']);
            $otherid=ht($_POST['otheridForAjax']);
            $msg=$_POST["msg"];
            // echo $msg;

            $lastMsgId=$loadFromUser->create("messages",["message"=>$msg,"messageFrom"=>$userid,"messageTo"=>$otherid,"messageOn"=>date('Y-m-d H:i:s')]);

            if($userid!=$otherid){
                $loadFromUser->create('notification',['notificationFor'=>$otherid,'notificationFrom'=>$userid,'target'=>$lastMsgId,'type'=>'message','status'=>'0','notificationCount'=>'0','notificationOn'=>date('Y-m-d H:i:s')]);
            }

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

        if (isset($_POST['showmsg']) && !empty($_POST['showmsg'])){
            $userid=ht($_POST['yourid']);
            $otherid=ht($_POST['showmsg']);


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