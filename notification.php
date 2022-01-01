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
    $profileData=$loadFromUser->userData($profileId);
    $notificationCount=$loadFromMessage->notificationCount($user_id);
    $pageTitle='Notifications / Twitter';
    // var_dump($notificationCount);
?>
<?php include 'backend/shared/header.php'; ?>
<body>
    <div class="id" data-uid="<?php echo $user_id; ?>"></div>
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
                    <h4>Notifications</h4>
                    <svg xmlns="http://www.w3.org/2000/svg" class="color-blue" viewBox="0 0 24 24"><g><path d="M12 8.21c-2.09 0-3.79 1.7-3.79 3.79s1.7 3.79 3.79 3.79 3.79-1.7 3.79-3.79-1.7-3.79-3.79-3.79zm0 6.08c-1.262 0-2.29-1.026-2.29-2.29S10.74 9.71 12 9.71s2.29 1.026 2.29 2.29-1.028 2.29-2.29 2.29z"/><path d="M12.36 22.375h-.722c-1.183 0-2.154-.888-2.262-2.064l-.014-.147c-.025-.287-.207-.533-.472-.644-.286-.12-.582-.065-.798.115l-.116.097c-.868.725-2.253.663-3.06-.14l-.51-.51c-.836-.84-.896-2.154-.14-3.06l.098-.118c.186-.222.23-.523.122-.787-.11-.272-.358-.454-.646-.48l-.15-.014c-1.18-.107-2.067-1.08-2.067-2.262v-.722c0-1.183.888-2.154 2.064-2.262l.156-.014c.285-.025.53-.207.642-.473.11-.27.065-.573-.12-.795l-.094-.116c-.757-.908-.698-2.223.137-3.06l.512-.512c.804-.804 2.188-.865 3.06-.14l.116.098c.218.184.528.23.79.122.27-.112.452-.358.477-.643l.014-.153c.107-1.18 1.08-2.066 2.262-2.066h.722c1.183 0 2.154.888 2.262 2.064l.014.156c.025.285.206.53.472.64.277.117.58.062.794-.117l.12-.102c.867-.723 2.254-.662 3.06.14l.51.512c.836.838.896 2.153.14 3.06l-.1.118c-.188.22-.234.522-.123.788.112.27.36.45.646.478l.152.014c1.18.107 2.067 1.08 2.067 2.262v.723c0 1.183-.888 2.154-2.064 2.262l-.155.014c-.284.024-.53.205-.64.47-.113.272-.067.574.117.795l.1.12c.756.905.696 2.22-.14 3.06l-.51.51c-.807.804-2.19.864-3.06.14l-.115-.096c-.217-.183-.53-.23-.79-.122-.273.114-.455.36-.48.646l-.014.15c-.107 1.173-1.08 2.06-2.262 2.06zm-3.773-4.42c.3 0 .593.06.87.175.79.328 1.324 1.054 1.4 1.896l.014.147c.037.4.367.7.77.7h.722c.4 0 .73-.3.768-.7l.014-.148c.076-.842.61-1.567 1.392-1.892.793-.33 1.696-.182 2.333.35l.113.094c.178.148.366.18.493.18.206 0 .4-.08.546-.227l.51-.51c.284-.284.305-.73.048-1.038l-.1-.12c-.542-.65-.677-1.54-.352-2.323.326-.79 1.052-1.32 1.894-1.397l.155-.014c.397-.037.7-.367.7-.77v-.722c0-.4-.303-.73-.702-.768l-.152-.014c-.846-.078-1.57-.61-1.895-1.393-.326-.788-.19-1.678.353-2.327l.1-.118c.257-.31.236-.756-.048-1.04l-.51-.51c-.146-.147-.34-.227-.546-.227-.127 0-.315.032-.492.18l-.12.1c-.634.528-1.55.67-2.322.354-.788-.327-1.32-1.052-1.397-1.896l-.014-.155c-.035-.397-.365-.7-.767-.7h-.723c-.4 0-.73.303-.768.702l-.014.152c-.076.843-.608 1.568-1.39 1.893-.787.326-1.693.183-2.33-.35l-.118-.096c-.18-.15-.368-.18-.495-.18-.206 0-.4.08-.546.226l-.512.51c-.282.284-.303.73-.046 1.038l.1.118c.54.653.677 1.544.352 2.325-.327.788-1.052 1.32-1.895 1.397l-.156.014c-.397.037-.7.367-.7.77v.722c0 .4.303.73.702.768l.15.014c.848.078 1.573.612 1.897 1.396.325.786.19 1.675-.353 2.325l-.096.115c-.26.31-.238.756.046 1.04l.51.51c.146.147.34.227.546.227.127 0 .315-.03.492-.18l.116-.096c.406-.336.923-.524 1.453-.524z"/></g></svg>
                </div>
                <div class="tabsContainer">
                    <?php echo $loadFromTweet->createTab('All',url_for("i/notification"),true); ?>
                    <?php echo $loadFromTweet->createTab('Mention',url_for("notification/mention"),false); ?>

                </div>

                <section aria-label="Timeline:Notifications Timeline" class="resultsContainer">
                    <?php $loadFromMessage->notification($user_id); ?>
                </section>


            </section>
            <aside>

            </aside>
        </main>
    </div>
    <script src="<?php echo url_for('./frontend/assets/js/common.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/notify.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/fetchTweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/hashtag.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/likeTweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/retweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/reply.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/delete.js'); ?>"></script>
</body>
</html>
