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
    $profileuserData=$loadFromUser->profileData($profileId);
    $date_joined=strtotime($profileData->signUpDate);
    // var_dump($notificationCount);
?>
<?php include 'backend/shared/header.php'; ?>
<body>
    <div class="id" data-uid="<?php echo $user_id; ?>"></div>
    <div class="wrapper">
        <header class="h-wrapper__heading">
            <div class="h-wrapper">
            <!-- <?php //include_once './header_category.php' ?> -->
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
                    <div class="go-back" id="go-back-profile" aria-label="Back" role="button" data-focusable="true" tabindex="0">
                        <svg viewBox="0 0 24 24" class="color-blue"><g><path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path></g></svg> 
                    </div>
                    <h4>Edit profile</h4>
                    <div class="p-btn" id="a-modal-save">
                        Save
                    </div>
                </div>
                <div class="body-edit__topcard">
                    <div class="edit-cover__topcard">
                        <img src="<?php echo url_for($profileData->profileCover); ?>" alt="<?php echo $profileData->firstName.' '.$profileData->lastName; ?>" class="user-cover__edit">
                        <div class="edit-pic__topcard">
                            <div class="user-pic__container">
                                <img src="<?php echo url_for($profileData->profileImage); ?>" alt="<?php echo $profileData->firstName.' '.$profileData->lastName; ?>" class="profile-pic_edit">
                            </div>
                            <div class="edit-btn-icon profile-edit-btn-icon">
                                <label for="edit_picPhoto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" id="camera-small" data-supported-dps="48x48">
                                        <path d="M46 8H30.52l-2.59-3.27a2.33 2.33 0 00-1.7-.73h-4.46a2.33 2.33 0 00-1.7.73L17 8H2a2.42 2.42 0 00-2 2v30a2.42 2.42 0 002 2h44a2.42 2.42 0 002-2V10a2.42 2.42 0 00-2-2z" fill="#56697a"/>
                                        <path fill="#788fa5" d="M0 10h48v30H0z"/>
                                        <path fill="#fbc2b2" d="M0 15h48v20H0z"/>
                                        <path d="M24 13a12 12 0 1012 12 12 12 0 00-12-12z" fill="#fff"/>
                                        <path d="M24 15a10 10 0 1010 10 10 10 0 00-10-10z" fill="#56697a"/>
                                        <path d="M24 19a6 6 0 106 6 6 6 0 00-6-6z" fill="#1d2226"/>
                                        <circle cx="24" cy="25" r="2" fill="#fdf9f3"/>
                                    </svg>
                                </label>
                                <input type="file" class="edit_picPhoto" name="edit_picPhoto" id="edit_picPhoto">
                            </div>
                        </div>
                    </div>
                    <div class="edit-btn-icon small-edit">
                        <label for="edit_filePhoto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" id="camera-small" data-supported-dps="48x48">
                                <path d="M46 8H30.52l-2.59-3.27a2.33 2.33 0 00-1.7-.73h-4.46a2.33 2.33 0 00-1.7.73L17 8H2a2.42 2.42 0 00-2 2v30a2.42 2.42 0 002 2h44a2.42 2.42 0 002-2V10a2.42 2.42 0 00-2-2z" fill="#56697a"/>
                                <path fill="#788fa5" d="M0 10h48v30H0z"/>
                                <path fill="#fbc2b2" d="M0 15h48v20H0z"/>
                                <path d="M24 13a12 12 0 1012 12 12 12 0 00-12-12z" fill="#fff"/>
                                <path d="M24 15a10 10 0 1010 10 10 10 0 00-10-10z" fill="#56697a"/>
                                <path d="M24 19a6 6 0 106 6 6 6 0 00-6-6z" fill="#1d2226"/>
                                    <circle cx="24" cy="25" r="2" fill="#fdf9f3"/>
                            </svg>
                        </label>
                        <input type="file" class="edit_Photo" name="edit_filePhoto" id="edit_filePhoto">
                    </div>
                    <div class="edit-info_text">
                        <div class="edit-text edit-username_text">
                            <label for="username_text">
                                <p class="label__text">
                                    Username
                                </p>
                                <input type="text" name="edit_username" class="edit_username" id="username_text" value="<?php echo $profileData->username;  ?>">
                            </label>
                        </div>
                        <div class="edit-text edit-bio_text">
                            <label for="bio_text">
                                <p class="label__text">
                                    Bio
                                </p>
                                <input type="text" name="edit_bio" class="edit_bio" id="bio_text" value="<?php echo $profileData->bio;  ?>">    
                            </label>
                        </div>
                        <div class="edit-text edit-location_text">
                            <label for="location_text">
                                <p class="label__text">
                                    Location
                                </p>
                                <input type="text" name="edit_location" class="edit_location" id="location_text" value="<?php echo $profileData->country;  ?>">  
                            </label>
                        </div>
                        <div class="edit-text edit-website_text">
                            <label for="website_text">
                                <p class="label__text">
                                    Website
                                </p>
                                <input type="text" name="edit_website" class="edit_website" id="website_text" value="<?php echo $profileData->website;  ?>">  
                            </label>
                        </div>

                        <div class="edit-text edit-gender_text">
                            <label for="gender_text">
                                <div class="gender-man_text">
                                    <p class="label__text label-gender__text">
                                        Nam
                                    </p>
                                    <?php if ($profileuserData==="Nam") { ?>
                                    <input type="radio" name="edit_gender" class="edit_gender-mail" id="gender_text" value="Nam" checked="checked">
                                    <?php } else { ?>
                                    <input type="radio" name="edit_gender" class="edit_gender-mail" id="gender_text" value="Nam">
                                    <?php }?> 
                                </div>
                                <div class="gender-girl_text">
                                    <p class="label__text label-gender__text">
                                        Nữ
                                    </p> 
                                    <?php if ($profileuserData==="Nữ") { ?>
                                    <input type="radio" name="edit_gender" class="edit_gender-femail" id="gender_text" value="Nữ" checked="checked">
                                    <?php } else { ?>
                                    <input type="radio" name="edit_gender" class="edit_gender-femail" id="gender_text" value="Nữ"> 
                                    <?php } ?>
                                </div>
                            </label>
                        </div>

                        <div class="edit-text edit-birthday_text">
                            <label for="birthday_text">
                                <p class="label__text">
                                    Birthday
                                </p>
                                <input type="date" name="edit_birthday" class="edit_birthday" id="birthday_text" value="<?php echo $profileuserData->birthday;  ?>">  
                            </label>
                        </div>

                        <div class="edit-text edit-work_text">
                            <label for="work_text">
                                <p class="label__text">
                                    Work
                                </p>
                                <input name="edit_work" class="edit_work" id="work_text" value="<?php echo $profileuserData->profession;  ?>">  
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-edit" id="modal-edit" style="display:none;">
                    <div class="modal-edit__container" role="dialog">
                        <div class="modal-edit-preview-container" style="display:none;">
                            <div class="preview-modal-edit-header-wrapper">
                                <div class="preview-edit-header-content">
                                    <div class="go-back-arrow" aria-label="Back" role="button" data-focusable="true" tabindex="0">
                                        <svg viewBox="0 0 24 24" class="color-blue"><g><path d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"></path></g></svg> 
                                    </div>
                                    <h2>Edit Media</h2>
                                </div>
                                <span class="submitEditProfileChange" id="imageEditUploadbutton">Apply</span>
                            </div>
                            <div class="preview-edit-modal-body">
                                <div class="modal-edit-body-profile-wrapper">
                                    <div class="imageEditPreviewContainer">
                                        <img src="" alt="" id="imageEditPreview">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                            
                
                <!-- <div class="tabsContainer">
                    <?php //echo $loadFromTweet->createTab('All',url_for("i/notification"),true); ?>
                    <?php //echo $loadFromTweet->createTab('Mention',url_for("notification/mention"),false); ?>

                </div>

                <section aria-label="Timeline:Notifications Timeline" class="resultsContainer">
                    <?php //$loadFromMessage->notification($user_id); ?>
                </section> -->


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
    <script src="<?php echo url_for('./frontend/assets/js/editProfile.js'); ?>"></script>
</body>
</html>
