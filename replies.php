<?php
    include 'backend/initialize.php';
    if (isset($_SESSION['userLoggedIn']))
    {
        $user_id=$_SESSION['userLoggedIn'];
        $verify->authOnly($user_id);
    }else if (Login::isLoggedIn())
    {
        $user_id=Login::isLoggedIn();
    }else{
        redirect_to(url_for("index"));
    }

    if (is_get_request()){
        if (isset($_GET['username'])&&!empty($_GET['username'])){
            $username=FormSanitizer::FormSanitizerString($_GET['username']);
            $profileId=$loadFromUser->userIdByUserName($username);
            if (!$profileId){
                redirect_to(url_for("index"));
            }
        }else{
            $profileId=$user_id;
        }
    }

    $user=$loadFromUser->userData($user_id);
    $notificationCount=$loadFromMessage->notificationCount($user_id);
    $profileData=$loadFromUser->userData($profileId);
    $date_joined=strtotime($profileData->signUpDate);
    $profileuserData=$loadFromUser->profileData($profileId);
    $pageTitle='Tweets with replies by '.$profileData->firstName.' '.$profileData->lastName.'(@'.$profileData->username.') / Twitter';
?>
<?php include 'backend/shared/header.php'; ?>
<body>
    <div class="id" data-uid="<?php echo $user_id; ?>" data-pid="<?php echo $profileId; ?>"></div>
    <div class="wrapper">
        <header class="h-wrapper__heading">
            <div class="h-wrapper">
            <?php include_once './header_category.php' ?>
            </div>

            <div id="myLogoutModal" class="logout__modal">
                <div class="logout__wrapper">
                    <div class="logout__container">
                        <svg viewBox="0 0 24 24" class="down" style="width:24px;"><g><path d="M12.538 6.478c-.14-.146-.335-.228-.538-.228s-.396.082-.538.228l-9.252 9.53c-.21.217-.27.538-.152.815.117.277.39.458.69.458h18.5c.302 0 .573-.18.69-.457.118-.277.058-.598-.152-.814l-9.248-9.532z"></path></g></svg>
                        <div class="logout__modal-body">
                            <div class="logout__modal-header" tabindex="0" data-focusable="true">
                                <div class="wrapper__image">
                                    <img src="<?php echo url_for($user->profileImage); ?>" alt="<?php echo $user->firstName.' '.$user->lastName; ?>">
                                </div>
                                <div class="user__name">
                                    <span class="user__fullName">
                                        <?php echo $user->firstName.' '.$user->lastName ?>;
                                    </span>
                                    <span class="user__screenName">
                                        @<?php echo $user->username; ?>
                                    </span>
                                </div>
                                <img class="check" src="<?php echo url_for('frontend/assets/images/check.svg'); ?>" alt="" width="20px";>
                            </div>
                            <a href="<?php echo url_for('logout'); ?>" class="logout__modal-footer">
                                <i class="fa fa-sign-out-alt"></i> Logout @<?php echo $user->username; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="main__Section-Container">
                <div class="header__top">
                    <div class="go-back-arrow" id="go-back-home" aria-label="Back" role="button" data-focusable="true" tabindex="0">
                        <svg viewBox="0 0 24 24" class="color-blue"><g><path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path></g></svg> 
                    </div>
                    <div class="header-top-pro">
                        <h4><?php echo $profileData->firstName.' '.$profileData->lastName; ?></h4>
                        <?php if(!empty($loadFromTweet->tweetCounts($profileId))){ ?>
                        <div class="tweet-no"><?php echo $loadFromTweet->tweetCounts($profileId); ?> Tweets</div>
                        <?php } ?>
                    </div>
                    
                </div>

                           
                <section class="profileHeaderContainer">
                    <div class="coverPhotoContainer">
                        <img src="<?php echo url_for($profileData->profileCover); ?>" alt="<?php echo $profileData->firstName.' '.$profileData->lastName; ?>" aria-label="Profile Cover Image" class="cover-photo-user-me">
                        <div class="userImageContainer">
                            <img src="<?php echo url_for($profileData->profileImage); ?>" alt="<?php echo $profileData->firstName.' '.$profileData->lastName; ?>" class="profile-pic-me" aria-label="Profile Pic Image">
                        </div>
                    </div>
                    <div class="profile__button-Container">
                        <?php $loadFromFollow->profileBtn($profileId,$user_id); ?>
                    </div>
                    <div class="userDetailsContainer">
                    <span class="displayName">
                            <?php echo $profileData->firstName.' '.$profileData->lastName; ?>
                        </span>
                        <span class="username">
                            @<?php echo $profileData->username; ?>
                        </span>
                        <span class="bio">
                            <?php echo $profileData->bio; ?>
                        </span>
                        <span class="location">
                            <svg viewBox="0 0 24 24" aria-hidden="true" class="location"><g><path d="M12 14.315c-2.088 0-3.787-1.698-3.787-3.786S9.913 6.74 12 6.74s3.787 1.7 3.787 3.787-1.7 3.785-3.787 3.785zm0-6.073c-1.26 0-2.287 1.026-2.287 2.287S10.74 12.814 12 12.814s2.287-1.025 2.287-2.286S13.26 8.24 12 8.24z"></path><path d="M20.692 10.69C20.692 5.9 16.792 2 12 2s-8.692 3.9-8.692 8.69c0 1.902.603 3.708 1.743 5.223l.003-.002.007.015c1.628 2.07 6.278 5.757 6.475 5.912.138.11.302.163.465.163.163 0 .327-.053.465-.162.197-.155 4.847-3.84 6.475-5.912l.007-.014.002.002c1.14-1.516 1.742-3.32 1.742-5.223zM12 20.29c-1.224-.99-4.52-3.715-5.756-5.285-.94-1.25-1.436-2.742-1.436-4.312C4.808 6.727 8.035 3.5 12 3.5s7.192 3.226 7.192 7.19c0 1.57-.497 3.062-1.436 4.313-1.236 1.57-4.532 4.294-5.756 5.285z"></path></g></svg>
                            <?php echo $profileData->country; ?>
                        </span>
                        <span class="website">
                            <svg viewBox="0 0 24 24" aria-hidden="true" class="website"><g><path d="M11.96 14.945c-.067 0-.136-.01-.203-.027-1.13-.318-2.097-.986-2.795-1.932-.832-1.125-1.176-2.508-.968-3.893s.942-2.605 2.068-3.438l3.53-2.608c2.322-1.716 5.61-1.224 7.33 1.1.83 1.127 1.175 2.51.967 3.895s-.943 2.605-2.07 3.438l-1.48 1.094c-.333.246-.804.175-1.05-.158-.246-.334-.176-.804.158-1.05l1.48-1.095c.803-.592 1.327-1.463 1.476-2.45.148-.988-.098-1.975-.69-2.778-1.225-1.656-3.572-2.01-5.23-.784l-3.53 2.608c-.802.593-1.326 1.464-1.475 2.45-.15.99.097 1.975.69 2.778.498.675 1.187 1.15 1.992 1.377.4.114.633.528.52.928-.092.33-.394.547-.722.547z"></path><path d="M7.27 22.054c-1.61 0-3.197-.735-4.225-2.125-.832-1.127-1.176-2.51-.968-3.894s.943-2.605 2.07-3.438l1.478-1.094c.334-.245.805-.175 1.05.158s.177.804-.157 1.05l-1.48 1.095c-.803.593-1.326 1.464-1.475 2.45-.148.99.097 1.975.69 2.778 1.225 1.657 3.57 2.01 5.23.785l3.528-2.608c1.658-1.225 2.01-3.57.785-5.23-.498-.674-1.187-1.15-1.992-1.376-.4-.113-.633-.527-.52-.927.112-.4.528-.63.926-.522 1.13.318 2.096.986 2.794 1.932 1.717 2.324 1.224 5.612-1.1 7.33l-3.53 2.608c-.933.693-2.023 1.026-3.105 1.026z"></path></g></svg>
                            <a href="<?php echo $profileData->website; ?>" class="website-link">
                                <?php echo $profileData->website; ?>
                            </a>
                        </span>
                        <span class="description">
                            <svg viewBox="0 0 24 24" class=""><g><path d="M19.708 2H4.292C3.028 2 2 3.028 2 4.292v15.416C2 20.972 3.028 22 4.292 22h15.416C20.972 22 22 20.972 22 19.708V4.292C22 3.028 20.972 2 19.708 2zm.792 17.708c0 .437-.355.792-.792.792H4.292c-.437 0-.792-.355-.792-.792V6.418c0-.437.354-.79.79-.792h15.42c.436 0 .79.355.79.79V19.71z"></path><circle cx="7.032" cy="8.75" r="1.285"></circle><circle cx="7.032" cy="13.156" r="1.285"></circle><circle cx="16.968" cy="8.75" r="1.285"></circle><circle cx="16.968" cy="13.156" r="1.285"></circle><circle cx="12" cy="8.75" r="1.285"></circle><circle cx="12" cy="13.156" r="1.285"></circle><circle cx="7.032" cy="17.486" r="1.285"></circle><circle cx="12" cy="17.486" r="1.285"></circle></g></svg>
                            <span class="join">
                                Joined
                            </span>
                            <span class="desciption__date"><?php echo date("F Y",$date_joined); ?></span>
                        </span>
                        <div class="followersContainer">
                            <a href="<?php echo url_for($profileData->username.'/following'); ?>">
                                <span class="value count-following"><?php echo $profileData->following; ?></span>
                                <span>Following</span>
                            </a>
                            <a href="<?php echo url_for($profileData->username.'/followers'); ?>">
                                <span class="value count-followers"><?php echo $profileData->followers; ?></span>
                                <span>Followers</span>
                            </a>
                        </div>
                    </div>
                </section>

                <div class="tabsContainer">
                    <?php echo $loadFromTweet->createTab('Posts',url_for($profileData->username),false); ?>
                    <?php echo $loadFromTweet->createTab('Replies',url_for($profileData->username.'/replies'),true); ?>

                </div>

                <section aria-label="Timeline:Your Profile Replies Timeline" class="repliesPostsContainer">
                    <?php $loadFromTweet->repliesTweet($profileId,$user_id,5); ?>
                </section>

                <div class="reply-wrapper">
                   
                </div>

                <?php include 'backend/shared/modal_profile.php'; ?>

                <div class="d-wrapper-container">
                    <div class="d-wrapper">
                        <div class="d-content" id="del-content">
                            <div class="d-image"> 
                                <svg viewBox="0 0 24 24" class="del-icon"><g><path d="M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z"></path><path d="M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z"></path></g></svg>
                            </div>
                            <span class="d-text">
                                Delete
                            </span>
                        </div>
                        <div class="d-content" id="pin-content">
                            <div class="d-image"> 
                                <svg viewBox="0 0 24 24" class="pin-icon"><g><path d="M20.472 14.738c-.388-1.808-2.24-3.517-3.908-4.246l-.474-4.307 1.344-2.016c.258-.387.28-.88.062-1.286-.218-.406-.64-.66-1.102-.66H7.54c-.46 0-.884.254-1.1.66-.22.407-.197.9.06 1.284l1.35 2.025-.42 4.3c-1.667.732-3.515 2.44-3.896 4.222-.066.267-.043.672.222 1.01.14.178.46.474 1.06.474h3.858l2.638 6.1c.12.273.39.45.688.45s.57-.177.688-.45l2.638-6.1h3.86c.6 0 .92-.297 1.058-.474.265-.34.288-.745.228-.988zM12 20.11l-1.692-3.912h3.384L12 20.11zm-6.896-5.413c.456-1.166 1.904-2.506 3.265-2.96l.46-.153.566-5.777-1.39-2.082h7.922l-1.39 2.08.637 5.78.456.153c1.355.45 2.796 1.78 3.264 2.96H5.104z"></path></g></svg>
                            </div>
                            <span class="d-text">
                                Pin to your profile
                            </span>
                        </div>
                    </div>
                </div>

                <div class="del-post-wrapper-container">
                    <div class="del-post-wrapper">
                        <div class="del-post-content">
                            <h2 class="del-post-content-header">
                                Delete post?
                            </h2>
                            <p>Are you sure you want to delete this post?</p>
                            <div class="del-btn-wrapper">
                                <button class="del-btn" id="cancel" type="button">Cancel</button>
                                <button class="del-btn" id="delete-post-btn" type="button">Delete</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </section>
            <aside>

            </aside>
        </main>
    </div>
    <script src="<?php echo url_for('./frontend/assets/js/common.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/fetchTweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/hashtag.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/likeTweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/retweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/reply.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/delete.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/profile.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/follow.js'); ?>"></script>
</body>
</html>
