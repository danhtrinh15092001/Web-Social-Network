<?php
    include_once 'backend/initialize.php';

    include_once 'backend/shared/register_handlers.php';
    $pageTitle='SignUp | Twitter';
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
                <h1 class="main__label-title">Create your account</h1>
                <form class="form__label" action="<?php echo ht($_SERVER["PHP_SELF"]);?>" method="POST">
                    <div class="form__label-input">
                        <?php echo $account->getError(Constant::$firstNameCharactters); ?>
                        <label for="firstName" class="label-input__head">First Name</label>
                        <input type="text" name="firstName" id="firstName" value="<?php getInputValue('firstName'); ?>" placeholder="First name" autocomplete="off" required>
                    </div>
                    <div class="form__label-input">
                        <?php echo $account->getError(Constant::$lastNameCharactters); ?>
                        <label for="lastName" class="label-input__head">Last Name</label>
                        <input type="text" name="lastName" id="lastName" value="<?php getInputValue('lastName'); ?>" placeholder="Last name" autocomplete="off" required>
                    </div>
                    <div class="form__label-input">
                        <?php echo $account->getError(Constant::$emailTaken); ?>
                        <?php echo $account->getError(Constant::$emailInvalid); ?>
                        <label for="Email" class="label-input__head">Email</label>
                        <input type="email" name="Email" id="Email" value="<?php getInputValue('Email'); ?>" placeholder="Email" autocomplete="off" required>
                    </div>
                    <div class="form__label-input">
                        <?php echo $account->getError(Constant::$diffentpass); ?>
                        <?php echo $account->getError(Constant::$shortpass); ?>
                        <?php echo $account->getError(Constant::$NotAlphapass); ?>
                        <label for="pass" class="label-input__head">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required>
                    </div>
                    <div class="form__label-input">
                        <label for="Confirmpassword" class="label-input__head">Confirm password</label>
                        <input type="password" name="Confirmpassword" id="Confirmpassword" placeholder="Confirm password" autocomplete="off" required>
                    </div>
                    <div class="s-password">
                        <input type="checkbox"  id="checkbox" name="s-password" onclick="showSignupPassword()">
                        <label for="s-password" class="checkbox__s-password">Show password</label>
                    </div>
                    <div class="form__label-btn">
                        <button class="btn__signUp">Sign Up</button>
                        <input type="checkbox"  id="checkbox" name="remember">
                        <label for="remember" class="checkbox__remember">Remember</label>
                    </div>
                </form>
                <div class="main__footer">
                    <p class="main__footer-descrip">Do you already have an account? If yes, please click"<a href="login" class="footer-descrip__link">login</a>".</p>
                </div>
            </div>
        </div>
    </div>
    <script src="frontend/assets/js/showPassword.js"></script>
    <script src="frontend/assets/js/common.js"></script>
</body>
</html>