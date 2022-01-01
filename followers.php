<?php

include 'backend/initialize.php';
if(Login::isLoggedIn()){
    $user_id=Login::isLoggedIn();
}else if(isset($_SESSION['userLoggedIn'])){
  $user_id=$_SESSION['userLoggedIn'];
  $verify->authOnly($user_id);
}else{
    redirect_to(url_for("index"));
}

if(is_get_request()){
    if(isset($_GET['username']) && !empty($_GET['username'])){
        $username=FormSanitizer::formSanitizerString($_GET['username']);
        $profileId=$loadFromUser->userIdByUsername($username);
        if(!$profileId){
            redirect_to(url_for("home"));
        }
        
    }else{
        $profileId=$user_id;
    }
}
$user=$loadFromUser->userData($user_id);
$notificationCount=$loadFromMessage->notificationCount($user_id);
$notificationCount=$loadFromMessage->notificationCount($user_id);
$profileData=$loadFromUser->userData($profileId);
$pageTitle='People followed by '.$profileData->firstName.' '.$profileData->lastName.'(@'.$profileData->username.') / Twitter';
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
    <main role="main">
        <section class="mainSectionContainer">
        <div class="header-top">
            <div class="go-back-arrow go-back-profile" aria-label="Back" role="button" data-focusable="true" tabindex="0">
                <svg viewBox="0 0 24 24" class="color-blue"><g><path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path></g></svg>
            </div>
            <div class="header-top-pro">
                <h4><?php  echo $profileData->firstName.' '.$profileData->lastName; ?></h4>
                
                <div class="tweet-no">@<?php echo $profileData->username; ?></div>
            </div> 
        </div>
        <div class="tabsContainer">
            <?php echo $loadFromTweet->createTab("Followers",url_for($profileData->username.'/followers'),true); ?>
            <?php echo $loadFromTweet->createTab("Following",url_for($profileData->username.'/following'),false); ?>
            <?php echo $loadFromTweet->createTab("Suggested Users",url_for($profileData->username.'/suggested'),false); ?>
        </div>
        <section aria-label="Timeline:Followers" class="resultsContainer">
        <?php $loadFromFollow->followerslists($profileId,$user_id); ?> 
        </section>
        
            
        </section>
        <aside role="Complementary"></aside>
    </main>
    </div>
    <script src="<?php echo url_for('./frontend/assets/js/common.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/fetchTweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/hashtag.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/likeTweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/retweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/reply.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/delete.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/follow.js'); ?>"></script>
</body>
</html>