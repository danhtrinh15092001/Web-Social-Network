<?php
    require_once "../initialize.php";
    $loadFromUser->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
    if (is_post_request()){
        if (isset($_POST['tweetID']) && !empty($_POST['tweetID'])){
            $userid=ht($_POST['userid']);
            $tweetID=ht($_POST['tweetID']);
            $tweetBy=ht($_POST['tweetBy']);
            $user=$loadFromUser->userData($userid);

            $tweetData=$loadFromTweet->getModalTweetData($tweetID,$tweetBy);
            $commentData=$loadFromTweet->getModalCommentData($tweetID,$tweetBy);
            if (!empty($tweetData)){
            ?>
             <div class="reply-modal-content">
                        <div class="reply-modal-header">
                            <span class="close" aria-label="Close" data-focusable="true" role="button" tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="close-icon" viewBox="0 0 16 16" data-supported-dps="16x16" fill="currentColor" class="mercado-match" width="16" height="16" focusable="false">
                                    <path d="M14 3.41L9.41 8 14 12.59 12.59 14 8 9.41 3.41 14 2 12.59 6.59 8 2 3.41 3.41 2 8 6.59 12.59 2z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="reply-modal-body">
                            <div class="reply-container">
                                <div class="reply-wrapper-image">
                                    <img width="30px" height="30px" src="<?php echo url_for($tweetData->profileImage); ?>" alt="<?php echo $tweetData->firstName.' '.$tweetData->lastName; ?>">
                                </div>
                                <div class="reply-wrapper-content">
                                    <div class="reply-content-desc">
                                        <div class="reply-user-fullName">
                                            <?php echo $tweetData->firstName.' '.$tweetData->lastName; ?>
                                        </div>
                                        <div class="reply-username">
                                            @<?php echo $tweetData->username; ?>
                                        </div>
                                        <div class="reply-date">
                                            <span class="reply-date-time">
                                                .
                                            </span>
                                            <?php echo $loadFromUser->timeAgo($tweetData->postedOn); ?>
                                        </div>
                                    </div>
                                    <div class="reply-desc-text">
                                        <?php echo $tweetData->status; ?>
                                    </div>
                                    <div class="reply-to-desc">
                                        <span class="reply-to">Reply to</span><a href="<?php echo url_for(ht(u($tweetData->username))); ?>" class="reply-username-link"> @<?php echo $tweetData->username; ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-pip">
                            
                            </div>
                            <div class="reply-user-msg">
                                <div class="reply-wrapper-image">
                                    <img width="30px" height="30px" src="<?php echo url_for($user->profileImage); ?>" alt="<?php echo $user->firstName.' '.$user->lastName; ?>">
                                </div>
                                <textarea id="replyInput" placeholder="Tweet your reply" autofocus></textarea>
                            </div>
                        </div>
                        <div class="reply-modal-footer">
                            <button class="reply-btn" id="replyBtn" role="button" data-focusable="true" tabindex="0" disabled="true">Reply</button>
                        </div>
                    </div>
            <?php
            }else if(!empty($commentData)){
                ?>
                <div class="reply-modal-content">
                        <div class="reply-modal-header">
                            <span class="close" aria-label="Close" data-focusable="true" role="button" tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="close-icon" viewBox="0 0 16 16" data-supported-dps="16x16" fill="currentColor" class="mercado-match" width="16" height="16" focusable="false">
                                    <path d="M14 3.41L9.41 8 14 12.59 12.59 14 8 9.41 3.41 14 2 12.59 6.59 8 2 3.41 3.41 2 8 6.59 12.59 2z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="reply-modal-body">
                            <div class="reply-container">
                                <div class="reply-wrapper-image">
                                    <img width="30px" height="30px" src="<?php echo url_for($commentData->profileImage); ?>" alt="<?php echo $commentData->firstName.' '.$commentData->lastName; ?>">
                                </div>
                                <div class="reply-wrapper-content">
                                    <div class="reply-content-desc">
                                        <div class="reply-user-fullName">
                                            <?php echo $commentData->firstName.' '.$commentData->lastName; ?>
                                        </div>
                                        <div class="reply-username">
                                            @<?php echo $commentData->username; ?>
                                        </div>
                                        <div class="reply-date">
                                            <span class="reply-date-time">
                                                .
                                            </span>
                                            <?php echo $loadFromUser->timeAgo($commentData->commentAt); ?>
                                        </div>
                                    </div>
                                    <div class="reply-desc-text">
                                        <?php echo $commentData->comment; ?>
                                    </div>
                                    <div class="reply-to-desc">
                                        <span class="reply-to">Reply to</span><a href="<?php echo url_for(ht(u($commentData->username))); ?>" class="reply-username-link"> @<?php echo $commentData->username; ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-pip">
                            
                            </div>
                            <div class="reply-user-msg">
                                <div class="reply-wrapper-image">
                                    <img width="30px" height="30px" src="<?php echo url_for($user->profileImage); ?>" alt="<?php echo $user->firstName.' '.$user->lastName; ?>">
                                </div>
                                <textarea id="replyInput" placeholder="Tweet your reply" autofocus></textarea>
                            </div>
                        </div>
                        <div class="reply-modal-footer">
                            <button class="reply-btn" id="replyBtn" role="button" data-focusable="true" tabindex="0" disabled="true">Reply</button>
                        </div>
                    </div>
                <?php
            }
            
        }

        if (isset($_POST['comment']) && !empty($_POST['comment'])){
            $commentBy=ht($_POST['commentBy']);
            $postedBy=ht($_POST['tweetBy']);
            $commentOn=$_POST['commentOn'];

            $card='<div><li><ul><h1><h2><h3><p><br><em>';
            $comment=strip_tags($_POST['comment'],$card);

            // echo $statusText;

            echo $loadFromTweet->comment($commentBy,$commentOn,$comment,$postedBy);
        }

        if (isset($_POST['delCommentOn']) && !empty($_POST['delCommentOn'])){
            $commentBy=ht($_POST['commentBy']);
            $commentOn=ht($_POST['delCommentOn']);
            $postedBy=ht($_POST['tweetBy']);


            echo $loadFromTweet->delComment($commentBy,$commentOn,$postedBy);

        }
    }

?>