<?php
    include 'backend/initialize.php';

    if (isset($_SESSION['userLoggedIn']))
    {
        redirect_to(url_for("home"));
    }else if (Login::isLoggedIn())
    {
        redirect_to(url_for("home"));
    }
?>
<?php include 'backend/shared/header.php'; ?>
<body>
    <div class="first__page">
        <div class="logo">
            <div class="logo__content">
                <div class="logo__content-find flex__item">
                    <i class="fas fa-search icon"></i>
                    <h2 class="content-find__descrip">Find your interests</h2>
                </div>
                <div class="logo__content-people flex__item">
                    <i class="fas fa-user-alt icon"></i>
                    <h2 class="content-people__descrip">Explore what people are talking about</h2>
                </div>
                <div class="logo__content-mess flex__item">
                    <i class="fas fa-comment icon"></i>
                    <h2 class="content-mess__descrip">Join the people</h2>
                </div>
            </div>
        </div>
        <div class="admin">
            <div class="admin__sign">
                <i class="fab fa-wolf-pack-battalion icon__twitter"></i>
                <h1 class="admin__sign-header">See what's happening in the world right now</h1>
                <h3 class="admin__sign-join">Join Twitter today</h3>
                <a href="signUp" class="admin__signUp sign">Sign Up</a>
                <a href="login" class="admin__logIn sign">Log in</a>
            </div>
        </div>
        <footer class="connect">
            <ul class="connect__list">
                <li class="connect__item">
                    <a href="#" class="connect__item-link">About</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Help Center</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Terms of Service</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Privacy Policy</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Cookie Policy</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Ads info</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Blog</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Status</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Careers</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Brand Resources</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Advertising</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Marketing</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Twitter for Business</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Developers</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Directory</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link">Settings</a>
                </li>
                <li class="connect__item">
                    <a href="#" class="connect__item-link"><?php echo twitter_copyright(2021); ?> Twitter, Inc</a>
                </li>
            </ul>
        </footer>
    </div>
</body>
</html>