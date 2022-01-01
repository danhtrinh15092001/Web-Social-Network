<?php
    include_once 'backend/initialize.php';
    include_once 'backend/shared/login_handlers.php';
    $pageTitle='Login on Twitter | Twitter';
?>

<?php include 'backend/shared/header.php'; ?>
<body>
    <div class="signUp">
        <ul class="signUp__navbar__custom">
            <li class="icon">
                <i class="fab fa-wolf-pack-battalion icon__twitter"></i>    
            </li><li class="navbar__language-item">
                <a href="" class="navbar__item-link">About</a>
            </li>
            <li class="navbar__language-item"><a href="" class="navbar__language-link">Language: Eng</a></li>
        </ul>
        <div class="signUp__main">
            <div class="main__label">
                <h1 class="main__label-title">Log in to Twitter</h1>
                <form class="form__label" action="<?php echo ht($_SERVER["PHP_SELF"]);?>" method="POST">
                    <div class="form__label-input">
                        <?php echo $account->getError(Constant::$loginFailed); ?>
                        <label for="username" class="label-input__head">Username or email</label>
                        <input type="text" name="username" id="username" value="<?php getInputValue('username'); ?>" placeholder="Username or email" autocomplete="off" required>
                    </div>
                    <div class="form__label-input">
                        <label for="pass" class="label-input__head">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required>
                    </div>
                    <div class="s-password">
                        <input type="checkbox" name="checkbox" id="checkbox" name="s-password" onclick="showLoginPassword()">
                        <label for="s-password" class="checkbox__s-password">Show password</label>
                    </div>
                    <div class="form__label-btn">
                        <button class="btn__signUp">Log in</button>
                        <input type="checkbox" id="checkbox" name="remember">
                        <label for="remember" class="checkbox__remember">Remember</label>
                    </div>
                </form>
                <div class="main__footer">
                    <p class="main__footer-descrip">Create new to Twitter ? "<a href="signUp" class="footer-descrip__link">Sign up to Twitter</a>".</p>
                </div>
            </div>
        </div>
    </div>
    <script src="frontend/assets/js/showPassword.js"></script>
    <script src="frontend/assets/js/common.js"></script>
</body>
</html>