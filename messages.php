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

    if(!isset($_GET['message'])){
        $otheruserid="";
        $pageTitle = 'Messages / Twitter';
    }else{
        $otheruserid=ht($_GET['message']);
        $otheruserData=$loadFromUser->userData($otheruserid);
        if (!$otheruserData){
            redirect_to(url_for("home"));
        }
        $pageTitle = $otheruserData->firstName . ' ' . $otheruserData->lastName . ' / Twitter';
    }

    $user=$loadFromUser->userData($user_id);
    $notificationCount=$loadFromMessage->notificationCount($user_id);
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
            <section class="main__Section-Container main__Section-Message" id="small-header-message">
                <div class="header__top">
                    <h4>Messages</h4>
                    <a href="<?php echo url_for('messages?q=composeNewMessage'); ?>" class="m-icon-wrapper msg-btn" role="button" data-focusable="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="color-blue" viewBox="0 0 24 24"><g><path d="M23.25 3.25h-2.425V.825c0-.414-.336-.75-.75-.75s-.75.336-.75.75V3.25H16.9c-.414 0-.75.336-.75.75s.336.75.75.75h2.425v2.425c0 .414.336.75.75.75s.75-.336.75-.75V4.75h2.425c.414 0 .75-.336.75-.75s-.336-.75-.75-.75zm-3.175 6.876c-.414 0-.75.336-.75.75v8.078c0 .414-.337.75-.75.75H4.095c-.412 0-.75-.336-.75-.75V8.298l6.778 4.518c.368.246.79.37 1.213.37.422 0 .844-.124 1.212-.37l4.53-3.013c.336-.223.428-.676.204-1.012-.223-.332-.675-.425-1.012-.2l-4.53 3.014c-.246.162-.563.163-.808 0l-7.586-5.06V5.5c0-.414.337-.75.75-.75h9.094c.414 0 .75-.336.75-.75s-.336-.75-.75-.75H4.096c-1.24 0-2.25 1.01-2.25 2.25v13.455c0 1.24 1.01 2.25 2.25 2.25h14.48c1.24 0 2.25-1.01 2.25-2.25v-8.078c0-.415-.337-.75-.75-.75z"/></g></svg>
                    </a>
                </div>
                
                <?php if (strpos($_SERVER['REQUEST_URI'],'?q=composeNewMessage')): ?>
                <div class="popup-msg-container" >
                    <div class="popup-msg-wrapper" role="dialog" aria-modal="true">
                        <div class="popup-msg-header">
                            <div class="popup-msg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="color-blue" viewBox="0 0 16 16" data-supported-dps="16x16" fill="currentColor" class="mercado-match" width="16" height="16" focusable="false">
                                    <path d="M14 3.41L9.41 8 14 12.59 12.59 14 8 9.41 3.41 14 2 12.59 6.59 8 2 3.41 3.41 2 8 6.59 12.59 2z"/>
                                </svg>
                            </div>
                            <h2 class="popup-msg-modal-header" role="heading" aria-label="2">New message</h2>
                        </div>
                        <form action="#" aria-label="Search peope" role="search">
                            <div class="s-wrapper">
                                <div class="s-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"/></g></svg>
                                </div>
                                <div class="s-bar">
                                    <input type="text" aria-label="Search query" placeholder="Search query" role="combox" autocomplete="off" class="s-user">
                                </div>
                            </div>
                            <div class="s-wrapper-user-container">
                                <ul class="s-result-user">
                                    
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>  
                <?php endif; ?>

                <div class="msg-user-wrapper"  style="overflow-y:auto;height:90%;">
                    <ul class="msg-user-add">
                       
                    </ul>
                </div>
            </section>
            
            <?php if (isset($_GET['message'])): ?>
                <script>
                    document.getElementById("small-header-message").classList.add("main__Section-Message");
                    document.getElementById("small-header-message").classList.add("main__Medium-Message");
                    document.getElementById("nav__main-small").classList.add("main__Section-Message");
                </script>
                
                <section class="chatsMessageContainer small-message" aria-labelledby="detail header" aria-header="Section header" role="region">
                        <div class="chat-header-top">
                            <div class="chat-header-left">
                                <a href="<?php echo url_for(ht(u($otheruserData->username))); ?>" class="chat-header-image-wrapper">
                                    <img src="<?php echo url_for($otheruserData->profileImage); ?>" alt="<?php echo $otheruserData->firstName.' '.$otheruserData->lastName; ?>">
                                </a>
                                <div class="chat-header-name-wrapper">
                                    <h3><?php echo $otheruserData->firstName.' '.$otheruserData->lastName; ?></h3>
                                    <span class="chat-header-username">
                                    @<?php echo $otheruserData->username; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="chat-header-right">
                                <svg viewBox="0 0 24 24" class="color-blue"><g><path d="M12 18.042c-.553 0-1-.447-1-1v-5.5c0-.553.447-1 1-1s1 .447 1 1v5.5c0 .553-.447 1-1 1z"></path><circle cx="12" cy="8.042" r="1.25"></circle><path d="M12 22.75C6.072 22.75 1.25 17.928 1.25 12S6.072 1.25 12 1.25 22.75 6.072 22.75 12 17.928 22.75 12 22.75zm0-20C6.9 2.75 2.75 6.9 2.75 12S6.9 21.25 12 21.25s9.25-4.15 9.25-9.25S17.1 2.75 12 2.75z"></path></g></svg>
                            </div>
                        </div>

                        <div class="chatPageContainer">
                            <div class="mainChatContainer">
                                <div class="mssg-details">
                                    <div class="msg-show-wrap">
                                        <div class="user-info" data-userid="<?php echo $user_id ?>" data-otherid="<?php echo $otheruserData->user_id; ?>"></div>
                                        <div class="msg-empty-space">
                                            <div class="msg-box">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <aside class="chat-footer chat-footer-small" aria-label="Start a new message" role="complementary">
                                    <input type="text" name="messageInput" id="small_statusMes" placeholder="Start a new message" aria-label="Start a new message">
                                    <button role="button" class="msg-send-btn" id="sendMsgBtn">
                                        <svg viewBox="0 0 24 24" class="msg-send color-blue"><g><path d="M21.13 11.358L3.614 2.108c-.29-.152-.64-.102-.873.126-.23.226-.293.577-.15.868l4.362 8.92-4.362 8.92c-.143.292-.08.643.15.868.145.14.333.212.523.212.12 0 .24-.028.35-.087l17.517-9.25c.245-.13.4-.386.4-.664s-.155-.532-.4-.662zM4.948 4.51l12.804 6.762H8.255l-3.307-6.76zm3.307 8.26h9.498L4.948 19.535l3.307-6.763z"></path></g></svg>
                                    </button>
                                </aside>
                            </div>
                        </div>
                    </section>
            <?php else: ?>
                <script>
                    document.getElementById("small-header-message").classList.remove("main__Section-Message");
                    document.getElementById("nav__main-small").classList.remove("main__Section-Message");
                </script>
            <?php  endif; ?>
            
                
            <aside role="complementary" class="right-msg">
                <?php if (!isset($_GET['message'])): ?>
                <div class="no-msg-container">
                    <div class="n-msg-wrapper">
                        <h2>You don't have a message selected</h2>
                        <p>Choose one from your existing messages or start a new one.</p>
                        <a href="<?php echo url_for('messages?q=composeNewMessage'); ?>" class="n-msg msg-btn" role="button" data-focusable="true">New message</a>
                    </div>
                </div>
                <?php elseif (isset($_GET['message'])): ?>
                    <section class="chatsMessageContainer" aria-labelledby="detail header" aria-header="Section header" role="region">
                        <div class="chat-header-top">
                            <div class="chat-header-left">
                                <a href="<?php echo url_for(ht(u($otheruserData->username))); ?>" class="chat-header-image-wrapper">
                                    <img src="<?php echo url_for($otheruserData->profileImage); ?>" alt="<?php echo $otheruserData->firstName.' '.$otheruserData->lastName; ?>">
                                </a>
                                <div class="chat-header-name-wrapper">
                                    <h3><?php echo $otheruserData->firstName.' '.$otheruserData->lastName; ?></h3>
                                    <span class="chat-header-username">
                                    @<?php echo $otheruserData->username; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="chat-header-right">
                                <svg viewBox="0 0 24 24" class="color-blue"><g><path d="M12 18.042c-.553 0-1-.447-1-1v-5.5c0-.553.447-1 1-1s1 .447 1 1v5.5c0 .553-.447 1-1 1z"></path><circle cx="12" cy="8.042" r="1.25"></circle><path d="M12 22.75C6.072 22.75 1.25 17.928 1.25 12S6.072 1.25 12 1.25 22.75 6.072 22.75 12 17.928 22.75 12 22.75zm0-20C6.9 2.75 2.75 6.9 2.75 12S6.9 21.25 12 21.25s9.25-4.15 9.25-9.25S17.1 2.75 12 2.75z"></path></g></svg>
                            </div>
                        </div>

                        <div class="chatPageContainer">
                            <div class="mainChatContainer">
                                <div class="mssg-details">
                                    <div class="msg-show-wrap">
                                        <div class="user-info" data-userid="<?php echo $user_id ?>" data-otherid="<?php echo $otheruserData->user_id; ?>"></div>
                                        <div class="msg-empty-space">
                                            <div class="msg-box">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <aside class="chat-footer" aria-label="Start a new message" role="complementary">
                                    <input type="text" name="messageInput" id="statusMes" placeholder="Start a new message" aria-label="Start a new message">
                                    <button role="button" class="msg-send-btn" id="sendMsgBtn">
                                        <svg viewBox="0 0 24 24" class="msg-send color-blue"><g><path d="M21.13 11.358L3.614 2.108c-.29-.152-.64-.102-.873.126-.23.226-.293.577-.15.868l4.362 8.92-4.362 8.92c-.143.292-.08.643.15.868.145.14.333.212.523.212.12 0 .24-.028.35-.087l17.517-9.25c.245-.13.4-.386.4-.664s-.155-.532-.4-.662zM4.948 4.51l12.804 6.762H8.255l-3.307-6.76zm3.307 8.26h9.498L4.948 19.535l3.307-6.763z"></path></g></svg>
                                    </button>
                                </aside>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
            </aside>
        </main>
    </div>
    <script>
        $uid = $(".id").data("uid");
        $(document).ready(function(){

            $("#statusMes").emojioneArea({
                pickerPosition: "top",
                spellcheck:true
            });
            $("#small_statusMes").emojioneArea({
                pickerPosition: "top",
                spellcheck:true
            });
            


            $(document).on("click",".msg-user-name-wrap",function(){
                var otherid=$(this).data("profileid");
                if (otherid!=""  && otherid!=undefined){
                    window.location.href="http://localhost/twitter/messages/"+otherid;
                }
            })

            function userLoad(){
                var otheruserid='<?php echo $otheruserid; ?>';
                $.post('http://localhost/twitter/backend/ajax/mesgFetch.php',{loadUserid:$uid,otheruserid:otheruserid},function(data){
                    $("ul.msg-user-add").html(data);
                })
            }

            var otherpersonid='<?php if(!empty($otheruserid)){echo $otheruserid;} ?>';
            if (otherpersonid!="" && otherpersonid!=null){
                $.post('http://localhost/twitter/backend/ajax/mesgFetch.php',{userId:$uid,otherpersonid:otherpersonid},function(data){
                    $(".msg-box").html(data);
                    // alert(data);
                })
            }

            userLoad();

            var userid=$(".user-info").data("userid");
            var otherid=$(".user-info").data("otherid");
            var useridForAjax,otheridForAjax;

            function xyz(name,surname,callback){
                if (typeof callback=='function'){
                    callback(name,surname);
                }else{
                    alert("Not");
                }
            }

            function abc(var1,var2){
                if(var1==undefined || var2==undefined){
                    return useridForAjax=userid,otheridForAjax=otherid;
                }else{
                    return useridForAjax=var1,otheridForAjax=var2;
                }
            }

            setTimeout(function(){
                $(document).on("keyup",".emojionearea-editor",function(e){
                    var ThisEl=$(this);
                    var rawMsg=$(this).html();   
                        if(e.which==13 || e.keyCode==13){
                            if(useridForAjax===undefined){
                                xyz(useridForAjax,otheridForAjax,abc);
                            }
                            // console.log(rawMsg,useridForAjax,otheridForAjax);
                            $.ajax({
                                type:"POST",
                                url:"http://localhost/twitter/backend/ajax/message.php",
                                data:{
                                    useridForAjax:useridForAjax,
                                    otheridForAjax:otheridForAjax,
                                    msg:rawMsg
                                },
                                success:function(data){
                                    $(".emojionearea-editor").html("");
                                    userLoad();
                                    $(".msg-box").html(data);
                                }
                            })
                        }
                })
                
            }, 500);
            
            $(document).on("click","#sendMsgBtn",function(e){
                var rawMsg=$(".emojionearea-editor").text();  
                        if(useridForAjax===undefined){
                            xyz(useridForAjax,otheridForAjax,abc);
                        }
                            // console.log(rawMsg,useridForAjax,otheridForAjax);
                        $.ajax({
                            type:"POST",
                            url:"http://localhost/twitter/backend/ajax/message.php",
                            data:{
                                useridForAjax:useridForAjax,
                                otheridForAjax:otheridForAjax,
                                msg:rawMsg
                            },
                            success:function(data){
                                // alert(data);
                                $(".emojionearea-editor").text("");
                                userLoad();
                                $(".msg-box").html(data);
                            }
                        })
            })

            function loadMessage(){
                $.ajax({
                    type:"POST",
                            url:"http://localhost/twitter/backend/ajax/message.php",
                            data:{
                                yourid:userid,
                                showmsg:otherid
                            },
                            success:function(data){
                                userLoad();
                                $(".msg-box").html(data);
                            }
                })
            }

            var loadTimer=setInterval(() => {
                userLoad();
                loadMessage();
            }, 1000);

        })
    </script>
    <script src="<?php echo url_for('./frontend/assets/dist/emojionearea.min.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/common.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/fetchTweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/hashtag.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/likeTweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/retweet.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/reply.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/message.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/delete.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/search.js'); ?>"></script>
    <script src="<?php echo url_for('./frontend/assets/js/notify.js'); ?>"></script>
</body>
</html>
