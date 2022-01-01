<?php
    include_once 'backend/initialize.php';
    include_once 'backend/shared/verify_handlers.php';
    $pageTitle='Verify your account';
?>
<?php include 'backend/shared/header.php'; ?>
<body>
    <div class="signUp">
        <div class="signUp__navbar">
            <ul class="navbar__list">
                <li class="navbar__item">
                    <i class="fab fa-twitter icon__twitter"></i>
                    <a href="" class="navbar__item-link">Home</a>
                </li>
                <li class="navbar__item">
                    <a href="" class="navbar__item-link">About</a>
                </li>
            </ul>
            <ul class="navbar__language">
                <li class="navbar__language-item"><a href="" class="navbar__language-link">Language: English</a></li>
            </ul>
        </div>
        <div class="signUp__main">
            <div class="main__label">
                <?php if (isset($_GET['verify']) || !empty($_GET['verify'])){
                    if (isset($errors['verify'])){
                        echo '<h1 class="main__label-title"> '.$errors['verify'].'</h1>';
                    }
                    }else{
                    ?>
                    <h1 class="main__label-title">A verification email has been sent to <?php echo $user->email; ?>, please check your <?php echo $user->email; ?> to verify your account.</h1>

                    <?php } ?>
            </div>
        </div>
    </div>
</body>
</html> 