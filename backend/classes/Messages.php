<?php
    class Messages{
        private $pdo;

        public function __construct(){
            $this->pdo=Database::instance();
        }

        public function recentMessages($user_id){
            $stmt=$this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom`=`user_id` AND `messageID` IN (SELECT max(`messageID`) FROM `messages` WHERE `messageFrom`=`user_id`) WHERE `messageTo`=:user_id AND `messageFrom`=`user_id` GROUP BY `user_id` ORDER BY `messageID` DESC ");
            $stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function messageData($userid,$otherid){
            $stmt=$this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom`=`user_id` WHERE (messageTo=:userID AND messageFrom=:otherpersonid) OR (messageFrom=:userID AND messageTo=:otherpersonid) ORDER BY `messageOn` ASC ");
            $stmt->bindParam(":userID",$userid,PDO::PARAM_INT);
            $stmt->bindParam(":otherpersonid",$otherid,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function notification($userid){
            $stmt=$this->pdo->prepare("SELECT * FROM notification LEFT JOIN users ON notification.notificationFrom=users.user_id WHERE notification.notificationFor=:userid AND notification.notificationFrom !=:userid ORDER BY `notification`.notificationOn DESC");
            $stmt->bindParam(":userid",$userid,PDO::PARAM_INT);
            $stmt->execute();
            $notification=$stmt->fetchAll(PDO::FETCH_OBJ);
            if(!empty($notification)){
                foreach($notification as $notify){
                    $profileid=$notify->notificationFrom;
                    if($notify->type=='follow'){
                        echo '<div class="notify-container '.(($notify->status=='0') ? 'unread-notification' : 'read-notification').'" data-profileid="'.$profileid.'" data-notificationid="'.$notify->notificationID.'">
                                <div class="notify-user-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="p-icon" viewBox="0 0 24 24"><g><path d="M12.225 12.165c-1.356 0-2.872-.15-3.84-1.256-.814-.93-1.077-2.368-.805-4.392.38-2.826 2.116-4.513 4.646-4.513s4.267 1.687 4.646 4.513c.272 2.024.008 3.46-.806 4.392-.97 1.106-2.485 1.255-3.84 1.255zm5.849 9.85H6.376c-.663 0-1.25-.28-1.65-.786-.422-.534-.576-1.27-.41-1.968.834-3.53 4.086-5.997 7.908-5.997s7.074 2.466 7.91 5.997c.164.698.01 1.434-.412 1.967-.4.505-.985.785-1.648.785z"/></g></svg>
                                </div>
                                <div class="notify-wrapper-content">
                                    <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                                        <a href="'.url_for(ht(u($notify->username))).'">
                                            <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%"/>
                                        </a>
                                    </div>
                                    <div class="notify-content">
                                        <a href="'.url_for(ht(u($notify->username))).'" class="notify-content__name">
                                            '.$notify->firstName.' '.$notify->lastName.'
                                        </a>
                                        <div class="notify-content__text">
                                            Followed you
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }else if($notify->type=='like'){
                        echo '<div class="notify-like-container '.(($notify->status=='0') ? 'unread-notification' : 'read-notification').'" data-profileid="'.$profileid.'" data-tweetid="'.$notify->target.'" data-notificationid="'.$notify->notificationID.'">
                                <div class="notify-like-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z"/></g></svg>
                                </div>
                                <div class="notify-wrapper-content">
                                    <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                                        <a href="'.url_for(ht(u($notify->username))).'">
                                            <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%"/>
                                        </a>
                                    </div>
                                    <div class="notify-content">
                                        <a href="'.url_for(ht(u($notify->username))).'" class="notify-content__name">
                                            '.$notify->firstName.' '.$notify->lastName.'
                                        </a>
                                        <div class="notify-content__text">
                                            Like your tweet
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }else if($notify->type=='message'){
                        echo '<div class="notify-msg-container '.(($notify->status=='0') ? 'unread-notification' : 'read-notification').'" data-profileid="'.$profileid.'" data-tweetid="'.$notify->target.'" data-notificationid="'.$notify->notificationID.'">
                                <div class="notify-like-wrapper">
                                    
                                </div>
                                <div class="notify-wrapper-content">
                                    <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                                        <a href="'.url_for(ht(u($notify->username))).'">
                                            <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%"/>
                                        </a>
                                    </div>
                                    <div class="notify-content">
                                        <a href="'.url_for(ht(u($notify->username))).'" class="notify-content__name">
                                            '.$notify->firstName.' '.$notify->lastName.'
                                        </a>
                                        <div class="notify-content__text">
                                            Send you a message
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                }
            }
        }

        public function mentionNotification($userid){
            $stmt=$this->pdo->prepare("SELECT * FROM notification LEFT JOIN users ON notification.notificationFrom=users.user_id WHERE notification.notificationFor=:userid AND notification.notificationFrom !=:userid AND type='mention' ORDER BY `notification`.notificationOn DESC");
            $stmt->bindParam(":userid",$userid,PDO::PARAM_INT);
            $stmt->execute();
            $notification=$stmt->fetchAll(PDO::FETCH_OBJ);
            if(!empty($notification)){
                foreach($notification as $notify){
                    $profileid=$notify->notificationFrom;
                    if($notify->type=='mention'){
                        echo '<div class="notify-mention-container '.(($notify->status=='0') ? 'unread-notification' : 'read-notification').'" data-profileid="'.$profileid.'" data-notificationid="'.$notify->notificationID.'">
                                <div class="notify-user-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="p-icon" viewBox="0 0 24 24"><g><path d="M12.225 12.165c-1.356 0-2.872-.15-3.84-1.256-.814-.93-1.077-2.368-.805-4.392.38-2.826 2.116-4.513 4.646-4.513s4.267 1.687 4.646 4.513c.272 2.024.008 3.46-.806 4.392-.97 1.106-2.485 1.255-3.84 1.255zm5.849 9.85H6.376c-.663 0-1.25-.28-1.65-.786-.422-.534-.576-1.27-.41-1.968.834-3.53 4.086-5.997 7.908-5.997s7.074 2.466 7.91 5.997c.164.698.01 1.434-.412 1.967-.4.505-.985.785-1.648.785z"/></g></svg>
                                </div>
                                <div class="notify-wrapper-content">
                                    <div class="notify-wrapper-user" style="height:40px;width:40px;margin-bottom:10px;flex-shrink:0;">
                                        <a href="'.url_for(ht(u($notify->username))).'">
                                            <img src="'.url_for($notify->profileImage).'" style="height:100%;width:100%;object-fit:cover;border-radius:50%"/>
                                        </a>
                                    </div>
                                    <div class="notify-content">
                                        <a href="'.url_for(ht(u($notify->username))).'" class="notify-content__name">
                                            '.$notify->firstName.' '.$notify->lastName.'
                                        </a>
                                        <div class="notify-content__text">
                                            Mention you
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                }
            }
        }

        public function notificationCount($userid){
            $stmt=$this->pdo->prepare("SELECT * FROM notification LEFT JOIN users ON notification.notificationFrom=users.user_id WHERE notification.notificationFor=:userid AND notification.notificationCount='0' AND notification.notificationFrom !=:userid ORDER BY `notification`.notificationOn DESC");
            $stmt->bindParam(":userid",$userid,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function notificationCountReset($userId){
            $stmt=$this->pdo->prepare("UPDATE `notification` SET `notificationCount` ='1' WHERE `notificationFor`=:userid AND `notificationCount`='0'");
            $stmt->bindParam(":userid",$userId,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function notificationStatusUpdate($userid,$notificationid){
            $stmt=$this->pdo->prepare("UPDATE `notification` SET `status` ='1' WHERE `notificationFor`=:userid AND `notificationID`=:notificationid  AND `status`='0'");
            $stmt->bindParam(":userid",$userid,PDO::PARAM_INT);
            $stmt->bindParam(":notificationid",$notificationid,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>