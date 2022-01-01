<?php
    class Tweet{
        private $pdo;
        private $user;
        private $commentControls;

        public function __construct()
        {
            $this->pdo=Database::instance();
            $this->user=new User;
            // $this->tweetControls=new TweetControls;
        }
        
        public function viewTweet($user_id,$tweet_id){
            $stmt=$this->pdo->prepare("SELECT * FROM tweets t LEFT JOIN users u ON t.tweetBy=u.user_id WHERE t.tweetID = :tweet_id ");
            $stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
            $stmt->execute();
            $comment=$stmt->fetchAll(PDO::FETCH_OBJ);
            // echo "<pre>";
            //     print_r($comment);
            // echo "</pre>";

            echo $this->itemTweet($user_id,is_array($comment) ? sizeof($comment) > 0 ? $comment[0] : null : null);

            
        }

        public function itemTweet($user_id,$comment){
            if ($comment!=null)
                $commentControls=new TweetControls;
                $controls=$commentControls->createdControls($comment->tweetID,$comment->tweetBy,$user_id);
                $retweet=$this->checkRetweet($user_id,$comment->tweetID);
                if (!empty($retweet)){
                    $retweetUserData=$this->user->userData($retweet->retweetBy);
                }
                echo '<article role="article" data-focusable="true" tabindex="0" class="post" data-tweetid="'.$comment->tweetID.'" data-tweetby="'.$comment->tweetBy.'">
                '.(((!empty($retweet->retweetBy))==$user_id) ? '<div class="retweet-header">
                    <div class="retweet-image"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg></div>
                    <div class="retweet-user-link">
                        <a href="'.url_for(ht(u($retweetUserData->username))).'" role="link" data-focusable="true" class="retweet-link">
                            <span>'.$retweetUserData->firstName.' '.$retweetUserData->lastName.'</span>
                        </a>
                    </div>               
                </div>'
                :
                '').'
                    <div class="main__Content-Container">
                        <a href="'.url_for(ht(u($comment->username))).'" role="link" class="userImageContainer">
                            <img src="'.url_for($comment->profileImage).'" alt="'.$comment->firstName.' '.$comment->lastName.'">
                        </a>
                        <div class="postContentContainer">
                            <div class="post-header">
                                <div class="post-header-info">
                                    <a href="'.url_for(ht(u($comment->username))).'" class="displayName">'.$comment->firstName.' '.$comment->lastName.'</a>
                                    <span class="username">@'.$comment->username.'</span>
                                    <span class="date">'.$this->user->timeAgo($comment->postedOn).'</span>
                                </div>
                                '.(($comment->tweetBy===$user_id) ? '<span class="dot deletePostButton" id="deletePostModal" data-tweet="'.$comment->tweetID.'" data-tweetby="'.$comment->tweetBy.'" data-user="'.$user_id.'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"><g><path d="M19.39 14.882c-1.58 0-2.862-1.283-2.862-2.86s1.283-2.862 2.86-2.862 2.862 1.283 2.862 2.86-1.284 2.862-2.86 2.862zm0-4.223c-.75 0-1.362.61-1.362 1.36s.61 1.36 1.36 1.36 1.362-.61 1.362-1.36-.61-1.36-1.36-1.36zM12 14.882c-1.578 0-2.86-1.283-2.86-2.86S10.42 9.158 12 9.158s2.86 1.282 2.86 2.86S13.578 14.88 12 14.88zm0-4.223c-.75 0-1.36.61-1.36 1.36s.61 1.362 1.36 1.362 1.36-.61 1.36-1.36-.61-1.363-1.36-1.363zm-7.39 4.223c-1.577 0-2.86-1.283-2.86-2.86S3.034 9.16 4.61 9.16s2.862 1.283 2.862 2.86-1.283 2.862-2.86 2.862zm0-4.223c-.75 0-1.36.61-1.36 1.36s.61 1.36 1.36 1.36 1.362-.61 1.362-1.36-.61-1.36-1.36-1.36z"/></g></svg>
                                </span>' : '').'
                            </div>
                            <div class="post-body">
                                <div>'.$comment->status.'</div>
                                '.((!empty($comment->tweetImage)) ? 
                                '<div class="postContentContainer_postImage">
                                    <img src="'.url_for($comment->tweetImage).'"/>
                                </div>' : '').' 
                            </div>
                            '.$controls.'
                        </div>
                    </div>
                </article>';
        }

        public function tweets($user_id,$num){
            $stmt=$this->pdo->prepare("SELECT * FROM tweets t LEFT JOIN users u ON t.tweetBy=u.user_id WHERE t.tweetBy=:user_id UNION SELECT * FROM tweets t LEFT JOIN users u ON t.tweetBy=u.user_id WHERE t.tweetBy IN(SELECT follow.receiver FROM follow WHERE follow.sender=:user_id) ORDER BY postedOn DESC LIMIT :num");
            $stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
            $stmt->bindParam(":num",$num,PDO::PARAM_INT);
            $stmt->execute();
            $comments=$stmt->fetchAll(PDO::FETCH_OBJ);
            foreach($comments as $comment){
                echo $this->itemTweet($user_id,$comment);
            }
        }

        public function profileTweet($profileId,$user_id,$num){
            $stmt=$this->pdo->prepare("SELECT * from `tweets`,`users` where `tweetBy`=`user_id` and `user_id`=:userId ORDER BY postedOn DESC LIMIT :num");
            $stmt->bindParam(":userId",$profileId,PDO::PARAM_INT);
            $stmt->bindParam(":num",$num,PDO::PARAM_INT);
            $stmt->execute();
            $comments=$stmt->fetchAll(PDO::FETCH_OBJ);
            foreach($comments as $comment){
                $commentControls=new TweetControls;
                $controls=$commentControls->createdControls($comment->tweetID,$comment->tweetBy,$user_id);
                $retweet=$this->checkRetweet($user_id,$comment->tweetID);
                if (!empty($retweet)){
                    $retweetUserData=$this->user->userData($retweet->retweetBy);
                }
                echo '<article role="article" data-focusable="true" tabindex="0" class="post" data-tweetid="'.$comment->tweetID.'" data-tweetby="'.$comment->tweetBy.'">
                '.(((!empty($retweet->retweetBy))==$user_id) ? '<div class="retweet-header">
                    <div class="retweet-image"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg></div>
                    <div class="retweet-user-link">
                        <a href="'.url_for(ht(u($retweetUserData->username))).'" role="link" data-focusable="true" class="retweet-link">
                            <span>'.$retweetUserData->firstName.' '.$retweetUserData->lastName.'</span>
                        </a>
                    </div>               
                </div>'
                :
                '').'
                    <div class="main__Content-Container">
                        <a href="'.url_for(ht(u($comment->username))).'" role="link" class="userImageContainer">
                            <img src="'.url_for($comment->profileImage).'" alt="'.$comment->firstName.' '.$comment->lastName.'">
                        </a>
                        <div class="postContentContainer">
                            <div class="post-header">
                                <div class="post-header-info">
                                    <a href="'.url_for(ht(u($comment->username))).'" class="displayName">'.$comment->firstName.' '.$comment->lastName.'</a>
                                    <span class="username">@'.$comment->username.'</span>
                                    <span class="date">'.$this->user->timeAgo($comment->postedOn).'</span>
                                </div> 
                                '.(($comment->tweetBy===$user_id) ? '<span class="dot deletePostButton" id="deletePostModal" data-tweet="'.$comment->tweetID.'" data-tweetby="'.$comment->tweetBy.'" data-user="'.$user_id.'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"><g><path d="M19.39 14.882c-1.58 0-2.862-1.283-2.862-2.86s1.283-2.862 2.86-2.862 2.862 1.283 2.862 2.86-1.284 2.862-2.86 2.862zm0-4.223c-.75 0-1.362.61-1.362 1.36s.61 1.36 1.36 1.36 1.362-.61 1.362-1.36-.61-1.36-1.36-1.36zM12 14.882c-1.578 0-2.86-1.283-2.86-2.86S10.42 9.158 12 9.158s2.86 1.282 2.86 2.86S13.578 14.88 12 14.88zm0-4.223c-.75 0-1.36.61-1.36 1.36s.61 1.362 1.36 1.362 1.36-.61 1.36-1.36-.61-1.363-1.36-1.363zm-7.39 4.223c-1.577 0-2.86-1.283-2.86-2.86S3.034 9.16 4.61 9.16s2.862 1.283 2.862 2.86-1.283 2.862-2.86 2.862zm0-4.223c-.75 0-1.36.61-1.36 1.36s.61 1.36 1.36 1.36 1.362-.61 1.362-1.36-.61-1.36-1.36-1.36z"/></g></svg>
                                </span>' : '').'
                            </div>
                            <div class="post-body">
                                <div>'.$comment->status.'</div>
                                '.((!empty($comment->tweetImage)) ? 
                                '<div class="postContentContainer_postImage">
                                    <img src="'.url_for($comment->tweetImage).'"/>
                                </div>' : '').'
                            </div>
                            '.$controls.'
                        </div>
                    </div>
                </article>';
            }
        }

        public function repliesTweet($profileId,$user_id,$num){
            $stmt=$this->pdo->prepare("SELECT * FROM `comment` LEFT JOIN `users` ON `commentBy`=`user_id` WHERE commentBy=:profileId ORDER BY commentAt DESC LIMIT :num");
            $stmt->bindParam(":profileId",$profileId,PDO::PARAM_INT);
            $stmt->bindParam(":num",$num,PDO::PARAM_INT);
            $stmt->execute();
            $comments=$stmt->fetchAll(PDO::FETCH_OBJ);
            foreach($comments as $comment){
                $tweetControls=new TweetControls;
                $controls=$tweetControls->createdControls($comment->commentID,$comment->commentBy,$user_id);
                echo '<article role="article" data-focusable="true" tabindex="0" class="post">
                    <div class="main__Content-Container">
                        <a href="'.url_for(ht(u($comment->username))).'" role="link" class="userImageContainer">
                            <img src="'.url_for($comment->profileImage).'" alt="'.$comment->firstName.' '.$comment->lastName.'">
                        </a>
                        <div class="postContentContainer">
                            <div class="post-header">
                                <div class="post-header-info">
                                    <a href="'.url_for(ht(u($comment->username))).'" class="displayName">'.$comment->firstName.' '.$comment->lastName.'</a>
                                    <span class="username">@'.$comment->username.'</span>
                                    <span class="date">'.$this->user->timeAgo($comment->commentAt).'</span>
                                </div>
                                '.(($comment->commentBy===$user_id) ? '<span class="dot deletePostButton" id="deletePostModal" data-comment="'.$comment->commentID.'" data-commentby="'.$comment->commentBy.'" data-user="'.$profileId.'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"><g><path d="M19.39 14.882c-1.58 0-2.862-1.283-2.862-2.86s1.283-2.862 2.86-2.862 2.862 1.283 2.862 2.86-1.284 2.862-2.86 2.862zm0-4.223c-.75 0-1.362.61-1.362 1.36s.61 1.36 1.36 1.36 1.362-.61 1.362-1.36-.61-1.36-1.36-1.36zM12 14.882c-1.578 0-2.86-1.283-2.86-2.86S10.42 9.158 12 9.158s2.86 1.282 2.86 2.86S13.578 14.88 12 14.88zm0-4.223c-.75 0-1.36.61-1.36 1.36s.61 1.362 1.36 1.362 1.36-.61 1.36-1.36-.61-1.363-1.36-1.363zm-7.39 4.223c-1.577 0-2.86-1.283-2.86-2.86S3.034 9.16 4.61 9.16s2.862 1.283 2.862 2.86-1.283 2.862-2.86 2.862zm0-4.223c-.75 0-1.36.61-1.36 1.36s.61 1.36 1.36 1.36 1.362-.61 1.362-1.36-.61-1.36-1.36-1.36z"/></g></svg>
                                </span>' : '').'
                            </div>
                            <div class="post-body">
                                <div>'.$comment->comment.'</div>
                            </div>
                            '.$controls.'
                        </div>
                    </div>
                </article>';
            }
        }

        public function getTrendByHash($hashtag){
            $stmt=$this->pdo->prepare("SELECT DISTINCT `hashtag` FROM `trends` WHERE `hashtag` LIKE :hashtag Limit 5");
            $stmt->bindValue(":hashtag",$hashtag.'%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getMention($mention){
            $stmt=$this->pdo->prepare("SELECT * FROM `users` WHERE `username` LIKE :mention OR `firstName` LIKE :mention OR `lastName` Limit 5");
            $stmt->bindValue(":mention",$mention.'%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function addTrend($hashtag,$commentID,$user_id)
        {
            preg_match_all("/#+([a-zA-Z0-9_]+)/i",$hashtag,$matches);
            if ($matches)
            {
                $result=array_values($matches[1]);
            }
            $sql="INSERT INTO `trends` (`hashtag`,`tweetID`,`user_id`,`createdOn`) VALUES (:hashtag,:tweetID,:userId,:dateOn)";
            foreach ($result as $trend){
                if ($stmt=$this->pdo->prepare($sql)){
                    $stmt->execute(array(':hashtag'=>$trend,':tweetID'=>$commentID,':userId'=>$user_id,'dateOn'=>date('Y-m-d H:i:s'))); 
                }
            }
        }

        public function addMention($status,$tweet_id,$user_id)
        {
            preg_match_all("/@+([a-zA-Z0-9_]+)/i",$status,$matches);
            if ($matches)
            {
                $result=array_values($matches[1]);
            }
            $sql="SELECT * FROM users WHERE `username`=:mention";
            foreach ($result as $trend){
                if ($stmt=$this->pdo->prepare($sql)){
                    $stmt->execute(array(':mention'=>$trend)); 
                    $data=$stmt->fetch(PDO::FETCH_OBJ);
                }
            }
            if(!empty($data)){
                if($data->user_id!=$user_id){
                    $this->user->create('notification',['notificationFor'=>$data->user_id,'notificationFrom'=>$user_id,'target'=>$tweet_id,'type'=>'mention','status'=>"0",'notificationCount'=>'0','notificationOn'=>date('Y-m-d H:i:s')]);
                }
            }
        }

        public function getLikes($postId){
            $stmt=$this->pdo->prepare("SELECT count(*) as `count` FROM `likes` WHERE `likeOn`=:tweetId");
            $stmt->bindParam(":tweetId",$postId,PDO::PARAM_INT);
            $stmt->execute();
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($data["count"]>0){
                return $data["count"];
            }
        }

        public function likes($user_id,$postId,$postedby){
            if ($this->wasLikedBy($user_id,$postId)){
                if($user_id!=$postedby)
                {
                    $this->user->delete('notification',['notificationFor'=>$postedby,'notificationFrom'=>$user_id,'target'=>$postId,'type'=>'like']);
                }
                $this->user->delete('likes',['likeBy'=>$user_id,'likeOn'=>$postId]);
                $result=["likes"=>-1];
                return json_encode($result);
            }else
            {
                if($user_id!=$postedby)
                {
                    $this->user->create('notification',['notificationFor'=>$postedby,'notificationFrom'=>$user_id,'target'=>$postId,'type'=>'like','status'=>"0",'notificationCount'=>'0','notificationOn'=>date('Y-m-d H:i:s')]);
                }
                $this->user->create('likes',['likeBy'=>$user_id,'likeOn'=>$postId]);
                $result=["likes"=>1];
                return json_encode($result);
            }
        }

        public function wasLikedBy($user_id,$postId)
        {
            $stmt=$this->pdo->prepare("SELECT * FROM `likes` WHERE `likeBy`=:userID AND `likeOn`=:postId");
            $stmt->bindParam(":userID",$user_id,PDO::PARAM_INT);
            $stmt->bindParam(":postId",$postId,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount()>0;

        }

        public function getRetweet($postId){
            $stmt=$this->pdo->prepare("SELECT count(*) as `count` FROM `retweet` WHERE `retweetFrom`=:tweetId");
            $stmt->bindParam(":tweetId",$postId,PDO::PARAM_INT);
            $stmt->execute();
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($data["count"]>0){
                return $data["count"];
            }
        }

        public function retweetCount($retweetBy,$commentID,$status,$postedby){
            if ($this->wasRetweetBy($retweetBy,$commentID)){
                if($retweetBy!=$postedby)
                {
                    $this->user->delete('notification',['notificationFor'=>$postedby,'notificationFrom'=>$retweetBy,'target'=>$commentID,'type'=>'retweet']);
                }
                $this->user->delete('retweet',['retweetBy'=>$retweetBy,'retweetFrom'=>$commentID]);
                $result=["retweet"=>-1];
                return json_encode($result);
            }else
            {
                if($retweetBy!=$postedby)
                {
                    $this->user->create('notification',['notificationFor'=>$postedby,'notificationFrom'=>$retweetBy,'target'=>$commentID,'type'=>'retweet','status'=>'0','notificationCount'=>'0','notificationOn'=>date('Y-m-d H:i:s')]);
                }
                $this->user->create('retweet',['retweetBy'=>$retweetBy,'retweetFrom'=>$commentID,'status'=>$status,'tweetOn'=>date('Y-m-d H:i:s')]);
                $result=["retweet"=>1];
                return json_encode($result);
            }
        }

        public function wasRetweetBy($retweetBy,$commentID){
            $stmt=$this->pdo->prepare("SELECT * FROM `retweet` WHERE `retweetBy`=:userID AND `retweetFrom`=:postId");
            $stmt->bindParam(":userID",$retweetBy,PDO::PARAM_INT);
            $stmt->bindParam(":postId",$commentID,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount()>0;
        }

        public function checkRetweet($user_id,$commentID){
            return $this->user->get("retweet",["*"],["retweetBy"=>$user_id,"retweetFrom"=>$commentID]);

        }

        public function getModalTweetData($commentID,$commentBy){
            $stmt=$this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON users.user_id=tweets.tweetBy WHERE `tweetBy`=:tweetBy AND `tweetID`=:tweetID");
            $stmt->bindParam(":tweetBy",$commentBy,PDO::PARAM_INT);
            $stmt->bindParam(":tweetID",$commentID,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function getModalCommentData($commentID,$commentBy){
            $stmt=$this->pdo->prepare("SELECT * FROM `comment` LEFT JOIN `users` ON users.user_id=comment.commentBy WHERE `commentBy`=:commentBy AND `commentID`=:commentID");
            $stmt->bindParam(":commentBy",$commentBy,PDO::PARAM_INT);
            $stmt->bindParam(":commentID",$commentID,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function getComments($postId){
            $stmt=$this->pdo->prepare("SELECT count(*) as `count` FROM `comment` WHERE `commentOn`=:tweetId");
            $stmt->bindParam(":tweetId",$postId,PDO::PARAM_INT);
            $stmt->execute();
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($data["count"]>0){
                return $data["count"];
            }
        }

        public function comment($commentBy,$commentOn,$comment,$postedby){
            if ($this->wasCommentBy($commentBy,$commentOn)){
                if($commentBy!=$postedby)
                {
                    $this->user->delete('notification',['notificationFor'=>$postedby,'notificationFrom'=>$commentBy,'target'=>$commentOn,'type'=>'comment']);
                }
                $this->user->delete('comment',['commentBy'=>$commentBy,'commentOn'=>$commentOn]);
                $result=["comment"=>-1];
                return json_encode($result);
            }else
            {
                if($commentBy!=$postedby)
                {
                    $this->user->create('notification',['notificationFor'=>$postedby,'notificationFrom'=>$commentBy,'target'=>$commentOn,'type'=>'comment','status'=>'0','notificationCount'=>'0','notificationOn'=>date('Y-m-d H:i:s')]);
                }
                $this->user->create('comment',['commentBy'=>$commentBy,'commentOn'=>$commentOn,'comment'=>$comment,'commentAt'=>date('Y-m-d H:i:s')]);
                $result=["comment"=>1];
                return json_encode($result);
            }
        }

        public function wasCommentBy($commentBy,$commentOn){
            $stmt=$this->pdo->prepare("SELECT * FROM `comment` WHERE `commentBy`=:userID AND `commentOn`=:postId");
            $stmt->bindParam(":userID",$commentBy,PDO::PARAM_INT);
            $stmt->bindParam(":postId",$commentOn,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount()>0;
        }

        public function delComment($commentBy,$commentOn,$postedby){
            if ($this->wasCommentBy($commentBy,$commentOn)){
                if($commentBy!=$postedby)
                {
                    $this->user->delete('notification',['notificationFor'=>$postedby,'notificationFrom'=>$commentBy,'target'=>$commentOn,'type'=>'comment']);
                }
                $this->user->delete('comment',['commentBy'=>$commentBy,'commentOn'=>$commentOn]);
                $result=["delComment"=>-1];
                return json_encode($result);
            }
        }

        public function tweetCounts($profileId){
            $stmt=$this->pdo->prepare("SELECT count('tweetID') as `tweetCounts` FROM `tweets` WHERE `tweetBy`=:tweetId");
            $stmt->bindParam(":tweetId",$profileId,PDO::PARAM_INT);
            $stmt->execute();
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($data["tweetCounts"]>0){
                return $data["tweetCounts"];
            }
        }

        public function createTab($name,$href,$isSelected){
            $className=$isSelected ? "tab active":"tab";
            return "<a href='$href' class='$className'>
                        <span>$name</span>
                    </a>";
        }
        public function trends(){
            $stmt=$this->pdo->prepare("SELECT * ,COUNT(t.tweetID) AS `tweetsCount` FROM trends t LEFT JOIN tweets p ON p.tweetID=t.tweetID AND status LIKE CONCAT('%#',`hashtag`,'%') GROUP BY `hashtag` ORDER BY `tweetsCount` DESC LIMIT 3");
            $stmt->execute();
            $trends=$stmt->fetchALL(PDO::FETCH_OBJ);
            if(!empty($trends)){
                foreach($trends as $trend){
                    echo '<div class="trends-content" data-trend="'.$trend->trendID.'">
                    <h2 aria-level="2" role="heading">#'.$trend->hashtag.'</h2>
                    <div class="trends-text"><span class="trends-count">'.$trend->tweetsCount.'</span> Tweets</div>
                 </div>';
                }
            }
        }
    }