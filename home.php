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

    $user=$loadFromUser->userData($user_id);
    $notificationCount=$loadFromMessage->notificationCount($user_id);
    $pageTitle='Home | Twitter';
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
                <?php if (!isset($_GET['viewTweet'])): ?>
                <div class="header__top">
                    <h4>Home</h4>
                    <img src="<?php echo url_for("frontend/assets/images/star.svg"); ?>" width="40px" height="40px" alt="">
                </div>
                <div class="header__post">
                    <a href="<?php echo url_for(ht(u($user->username))); ?>" role="link"  class="userImageContainer" aria-label="<?php echo $user->firstName.' '.$user->lastName; ?>">
                        <img src="<?php echo url_for($user->profileImage); ?>" alt="<?php echo $user->firstName.' '.$user->lastName; ?>">
                    </a>
                    <form class="textareaContainer">
                        <textarea id="postTextarea" placeholder="What's happening?" aria-label="What's happening?" autofocus></textarea>
                        <div class="hash__box">
                            <div class="hash__box-list" role="listbox" aria-multiselectable="false">
                                <ul>
                                </ul>
                            </div>
                        </div>
                        <div aria-label="Media" role="group" class="postImageContainer">
                            <div class="postImageContainer__wrapper">
                                    <img src="" draggable="false" alt="" id="postImageItem">
                            </div>
                        </div>
                        <div class="blank_hr"></div>
                        <div class="add__wrapper" aria-label="Add Photo" role="button" data-focusable="true" tabindex="0" class="add-photo">
                            <div aria-label="Add Photo" role="button" data-focusble="true" tabindex="0" class="add-photo"> 
                                <label for="addPhoto" title="Upload Photo">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="photo-icon" viewBox="0 0 24 24"><g><path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z"/><circle cx="8.868" cy="8.309" r="1.542"/></g></svg>
                                </label>
                                <input type="file" name="addPhoto" id="addPhoto">
                            </div>
                        </div>
                        <div class="buttonsContainer">
                            <input type="submit" id="submitPostButton" disabled="true" value="POST">
                            <div class="w-count-wrapper">
                                <div id="count">200</div>
                                <div class="vertical-pipe"></div>
                            </div>
                        </div>
                    </form>
                </div>

                <section aria-label="Timeline:Your home Timeline" class="postContainer">
                    <?php $loadFromTweet->tweets($user_id,5); ?>
                </section>

                <div class="reply-wrapper">
                   
                </div>

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
                <?php elseif (isset($_GET['viewTweet'])): ?>
                    <div class="header__top">
                    <h4>View Tweet</h4>
                    <img src="<?php echo url_for("frontend/assets/images/star.svg"); ?>" width="40px" height="40px" alt="">
                    </div>
                    <section aria-label="Timeline:Your home Timeline" class="postContainer">
                        <?php $tweetid=ht($_GET['viewTweet']);?>
                        <?php $loadFromTweet->viewTweet($user_id,$tweetid); ?>
                    </section>
                <?php endif; ?>
            </section>
            <aside role="Complementary" class="right-rail">
                <div id="search-area">
                    <form id="search-form" aria-label="Search Twitter" role="search">
                    <input type="text" name="main-search" id="main-search" placeholder="Search Twitter" role="searchbox">
                    <svg viewBox="0 0 24 24" class="search-icon"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
                    </form>
                    <div id="search-show">
                        <div class="search-result">
                            <div class="search-title" style="">
                                <div class="search-header">
                                    <h3>Try searching for people, topics, or keywords</h3>
                                </div>
                            </div>
                            <!-- <ul id="suggestion">
                            
                            </ul> -->
                            
                        </div>
                    </div>
                </div>
                <div class="aside-fixed">
                    <section class="trends" aria-labelledby="accessible-list-0" role="region">
                        <div class="trends-container">
                            <div class="trends-container__header">
                                    <h1 aria-level="1" role="heading">Trends for you</h1>
                            </div>
                            <div class="trends-body" aria-label="Timeline: Trending now">
                                <?php $loadFromTweet->trends(); ?>
                            </div>
                        </div>

                    </section>
                    <div class="follow">
                        <h3 class="follow-heading">Who to follow</h3>
                        <?php $loadFromFollow->whoToFollow($user_id,$user_id); ?>
                        <!-- -->
                    
                        <footer class="follow-footer">
                        <ul>
                                <li><a href="#">Terms</a></li>
                                <li><a href="#">Privacy policy</a></li>
                                <li><a href="#">Cookies</a></li>
                                <li><a href="#">About</a></li>
                                <li><a href="#">More</a></li>
                        </ul>
                        </footer>
                    </div>
                </div>
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
    <script src="<?php echo url_for('./frontend/assets/js/follow.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/liveSearch.js'); ?>"></script>
</body>
</html>
