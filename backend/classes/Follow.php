<?php
    class Follow{
        private $pdo,$user;

        public function __construct(){
            $this->pdo=Database::instance();
            $this->user=new User;
        }

        public function checkFollow($followID,$user_id){
            $stmt=$this->pdo->prepare("SELECT * FROM `follow` WHERE `sender`=:userId AND `receiver`=:followID");
            $stmt->bindParam(":userId",$user_id,PDO::PARAM_INT);
            $stmt->bindParam(":followID",$followID,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function whoToFollow($user_id,$profileId){
            $stmt=$this->pdo->prepare("SELECT * FROM `users` WHERE `user_id` !=:user_id AND `user_id` NOT IN (SELECT `receiver` FROM `follow` WHERE `sender`=:user_id) ORDER BY rand() LIMIT 3");
            $stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
            $stmt->execute();
            $data=$stmt->fetchALL(PDO::FETCH_OBJ);
            if(!empty($data)){
                foreach($data as $user){
                    echo ' <div class="follow-user">
                            <div class="follow-user-img">
                            <img src="'.url_for($user->profileImage).'" alt="'.$user->firstName.' '.$user->lastName.'">
                            </div>
                            <div class="follow-user-info">
                            <h4><a href="'.url_for($user->username).'">'.$user->firstName.' '.$user->lastName.'</a></h4>
                            <p>@'.$user->username.'</p>
                            </div>
                            <button class="f-btn p-btn follow-btn" data-follow="'.$user->user_id.'" data-user="'.$user_id.'">Follow</button>
                        </div>';
                }
            }
        }
    

        public function profileBtn($profileId,$userId){
            $data=$this->checkFollow($profileId,$userId);
            $userData=$this->user->userData($userId);
            if ($profileId!=$userId){
                if (!empty($data['receiver'])==$profileId){
                    echo '<button class="p-btn" aria-label="Message" data-focusable="true" tabindex="0" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="p-btn-icon" viewBox="0 0 24 24"><g><path d="M19.25 3.018H4.75C3.233 3.018 2 4.252 2 5.77v12.495c0 1.518 1.233 2.753 2.75 2.753h14.5c1.517 0 2.75-1.235 2.75-2.753V5.77c0-1.518-1.233-2.752-2.75-2.752zm-14.5 1.5h14.5c.69 0 1.25.56 1.25 1.25v.714l-8.05 5.367c-.273.18-.626.182-.9-.002L3.5 6.482v-.714c0-.69.56-1.25 1.25-1.25zm14.5 14.998H4.75c-.69 0-1.25-.56-1.25-1.25V8.24l7.24 4.83c.383.256.822.384 1.26.384.44 0 .877-.128 1.26-.383l7.24-4.83v10.022c0 .69-.56 1.25-1.25 1.25z"/></g></svg>
                    </button>
                    <button class="f-btn p-btn unfollow-btn following-btn" data-follow="'.$profileId.'">Following</button>
                    ';
                }else{
                    echo '<button class="p-btn" aria-label="Message" data-focusable="true" tabindex="0" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="p-btn-icon" viewBox="0 0 24 24"><g><path d="M19.25 3.018H4.75C3.233 3.018 2 4.252 2 5.77v12.495c0 1.518 1.233 2.753 2.75 2.753h14.5c1.517 0 2.75-1.235 2.75-2.753V5.77c0-1.518-1.233-2.752-2.75-2.752zm-14.5 1.5h14.5c.69 0 1.25.56 1.25 1.25v.714l-8.05 5.367c-.273.18-.626.182-.9-.002L3.5 6.482v-.714c0-.69.56-1.25 1.25-1.25zm14.5 14.998H4.75c-.69 0-1.25-.56-1.25-1.25V8.24l7.24 4.83c.383.256.822.384 1.26.384.44 0 .877-.128 1.26-.383l7.24-4.83v10.022c0 .69-.56 1.25-1.25 1.25z"/></g></svg>
                    </button>
                    <button class="f-btn p-btn follow-btn" data-follow="'.$profileId.'">Follow</button>
                    ';
                    
                }
            }else{
                if ($userData->profileEdit==1){
                    echo '<button class="p-btn big-btn" role="button" id="edited-profile">Edit profile</button>';
                    echo '<button class="p-btn small-btn" role="button" id="edited-profile">Edit profile</button>';
                }else{
                    echo '<button class="profile__btn-edit" id="set-up-profile" role="button">Set up profile</button>';
                }

            }
        }

        public function follow($followID,$user_id){
            $this->user->create('notification',['notificationFor'=>$followID,'notificationFrom'=>$user_id,'type'=>'follow','status'=>'0','notificationCount'=>'0','notificationOn'=>date('Y-m-d H:i:s')]);
            $this->user->create("follow",["sender"=>$user_id,"receiver"=>$followID,"followStatus"=>1,"followOn"=>date('Y-m-d H:i:s')]);
            $this->addFollowCount($followID,$user_id);
            $stmt=$this->pdo->prepare("SELECT `following`,`followers` FROM `users` LEFT JOIN `follow` ON `sender`=:user_id AND CASE WHEN `receiver`=:user_id THEN `sender`=`user_id` END WHERE `user_id`=:followID");
            $stmt->execute(["user_id"=>$user_id,"followID"=>$followID]);
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
        }

        public function followerslists($profileId,$user_id){
            $stmt=$this->pdo->prepare("SELECT * FROM `users` LEFT JOIN `follow` ON `sender`=`user_id` AND CASE  WHEN  `receiver`=:userId THEN  `sender`=`user_id` END WHERE `receiver` IS NOT NULL ORDER BY followOn DESC");
            $stmt->bindParam(":userId",$profileId,PDO::PARAM_INT);
            $stmt->execute();
            $followings=$stmt->fetchALL(PDO::FETCH_OBJ);
            foreach($followings as $following){
                $data=$this->checkFollow($following->user_id,$user_id);
                echo '<li role="option" aria-selected="true">
                            <div role="button" tabindex="0" data-focusable="true" class="h-ment">
                                    <div class="ment-w-container">
                                        <div class="ment-profile-wrapper">
                                            <div class="ment-profile-pic">
                                                <img src="'.url_for($following->profileImage).'" alt="'.$following->firstName.' '.$following->lastName.'">
                                            </div>
                                            <div class="ment-profile-name">
                                                <div class="ment-user-fullName">
                                                    <span class="ment-user-fullName-text">'.$following->firstName.' '.$following->lastName.'</span>
                                                </div>
                                                <div class="ment-user-username">
                                                    <span class="ment-user-username-text">@'.$following->username.'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profileButtonContainer">
                                        '.(($following->user_id != $user_id) ? ''.((!empty($data['receiver'])==$following->user_id) ? '<button class="f-btn p-btn following-btn" role="button" data-follow="'.$following->user_id.'" data-user="'.$user_id.'">Following</button>' : '<button class="f-btn p-btn follow-btn" role="button" data-follow="'.$following->user_id.'" data-user="'.$user_id.'">Follow</button>').'' : '').'
                                        </div>
                                    </div>
                            </div>
                    </li>';
            }
        }

        public function followinglists($profileId,$user_id){
            $stmt=$this->pdo->prepare("SELECT * FROM `users` LEFT JOIN `follow` ON `receiver`=`user_id` AND CASE  WHEN  `sender`=:userId THEN  `receiver`=`user_id` END WHERE `sender` IS NOT NULL ORDER BY followOn DESC");
            $stmt->bindParam(":userId",$profileId,PDO::PARAM_INT);
            $stmt->execute();
            $followings=$stmt->fetchALL(PDO::FETCH_OBJ);
            foreach($followings as $following){
                $data=$this->checkFollow($following->user_id,$user_id);
                echo '<li role="option" aria-selected="true">
                            <div role="button" tabindex="0" data-focusable="true" class="h-ment">
                                    <div class="ment-w-container">
                                        <div class="ment-profile-wrapper">
                                            <div class="ment-profile-pic">
                                                <img src="'.url_for($following->profileImage).'" alt="'.$following->firstName.' '.$following->lastName.'">
                                            </div>
                                            <div class="ment-profile-name">
                                                <div class="ment-user-fullName">
                                                    <span class="ment-user-fullName-text">'.$following->firstName.' '.$following->lastName.'</span>
                                                </div>
                                                <div class="ment-user-username">
                                                    <span class="ment-user-username-text">@'.$following->username.'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profileButtonContainer">
                                        '.(($following->user_id != $user_id) ? ''.((!empty($data['receiver'])==$following->user_id) ? '<button class="f-btn p-btn following-btn" role="button" data-follow="'.$following->user_id.'" data-user="'.$user_id.'">Following</button>' : '<button class="f-btn p-btn follow-btn" role="button" data-follow="'.$following->user_id.'" data-user="'.$user_id.'">Follow</button>').'' : '').'
                                        </div>
                                    </div>
                            </div>
                    </li>';
            }
        }

        public function suggestedlists($profileId,$user_id){
            $stmt=$this->pdo->prepare("SELECT * FROM `users` LEFT JOIN `follow` ON `sender`=`user_id` AND CASE WHEN `receiver`=:userId THEN `sender`=`user_id` END WHERE user_id !=:userId AND receiver IS NULL INTERSECT SELECT * FROM `users` LEFT JOIN `follow` ON `receiver`=`user_id` AND CASE WHEN `sender`=:userId THEN `receiver`=`user_id` END WHERE user_id !=:userId AND sender IS NULL ORDER BY followOn DESC");
            $stmt->bindParam(":userId",$profileId,PDO::PARAM_INT);
            $stmt->execute();
            $followings=$stmt->fetchALL(PDO::FETCH_OBJ);
            foreach($followings as $following){
                $data=$this->checkFollow($following->user_id,$user_id);
                echo '<li role="option" aria-selected="true">
                            <div role="button" tabindex="0" data-focusable="true" class="h-ment">
                                    <div class="ment-w-container">
                                        <div class="ment-profile-wrapper">
                                            <div class="ment-profile-pic">
                                                <img src="'.url_for($following->profileImage).'" alt="'.$following->firstName.' '.$following->lastName.'">
                                            </div>
                                            <div class="ment-profile-name">
                                                <div class="ment-user-fullName">
                                                    <span class="ment-user-fullName-text">'.$following->firstName.' '.$following->lastName.'</span>
                                                </div>
                                                <div class="ment-user-username">
                                                    <span class="ment-user-username-text">@'.$following->username.'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profileButtonContainer">
                                        '.(($following->user_id != $user_id) ? ''.((!empty($data['receiver'])==$following->user_id) ? '<button class="f-btn p-btn following-btn" role="button" data-follow="'.$following->user_id.'" data-user="'.$user_id.'">Following</button>' : '<button class="f-btn p-btn follow-btn" role="button" data-follow="'.$following->user_id.'" data-user="'.$user_id.'">Follow</button>').'' : '').'
                                        </div>
                                    </div>
                            </div>
                    </li>';
            }
        }
    

        public function addFollowCount($followID,$user_id){
            $stmt=$this->pdo->prepare("UPDATE `users` SET `following`=`following`+1 WHERE user_id=:user_id;UPDATE `users` SET `followers`=`followers`+1 WHERE `user_id`=:followID");
            $stmt->execute(["user_id"=>$user_id,"followID"=>$followID]);
        }

        public function unfollow($followID,$user_id){
            $this->user->delete('notification',['notificationFor'=>$followID,'notificationFrom'=>$user_id,'type'=>'follow']);
            $this->user->delete("follow",["sender"=>$user_id,"receiver"=>$followID]);
            $this->removeFollowCount($followID,$user_id);
            $stmt=$this->pdo->prepare("SELECT `following`,`followers` FROM `users` LEFT JOIN `follow` ON `sender`=:user_id AND CASE WHEN `receiver`=:user_id THEN `sender`=`user_id` END WHERE `user_id`=:followID");
            $stmt->execute(["user_id"=>$user_id,"followID"=>$followID]);
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
        }


        public function removeFollowCount($followID,$user_id){
            $stmt=$this->pdo->prepare("UPDATE `users` SET `following`=`following`-1 WHERE user_id=:user_id;UPDATE `users` SET `followers`=`followers`-1 WHERE `user_id`=:followID");
            $stmt->execute(["user_id"=>$user_id,"followID"=>$followID]);
        }
    }
?>