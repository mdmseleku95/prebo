<?php

include('classes/DB.php');
include('classes/Login.php');
$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));


if (Login::isLoggedIn()) {
    $userid = Login::isLoggedIn();
    
    echo 'You are already logged in';
    header('Location: index.php');
}

if(isset($_POST['resetPassword'])){ 
    
    $cstrong = true;
    $id = 0;
    $email = $_POST['email'];
    
    $user_id = DB::query('SELECT id FROM accounts WHERE email=:email', array(':email'=>$email))[0]['id'];
    
    DB::query('INSERT INTO password_tokens VALUES (:id, :token, :user_id)', array(':id'=> $id, ':token' => sha1($token), ':user_id' => $user_id));
    
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar" style="padding-bottom:10px;">
        <div class="container"><a class="navbar-brand logo" href="#"><img src="assets/img/PreboDigitalLogo.png" style="width:300px;"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="home.html" style="padding:8px;">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="features.html">Features</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="pricing.html">Pricing</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="about-us.html">About Us</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="contact-us.html">Contact Us</a></li>
                    <li class="dropdown"><a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Dashboard</a>
                       <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="sign-up.php">Try It Free</a><a class="dropdown-item" role="presentation" href="sign-in.php">Log In</a></div>
                    </li>
                </ul>
        </div>
        </div>
    </nav>
    <main class="page"></main>
    <div class="newsletter-subscribe" style="padding-top:0px;padding-bottom:58px;">
        <div class="container" style="padding-top:40px;padding-bottom:40px;">
            <div class="intro">
                <h2 class="text-center">Please provide some details</h2>
                <p class="text-center">Please provide your valid email address linked to your account</p>
                <p class="text-center">A reset link will be send to you shortly. Simply follow the instructions in the email</p>
            </div>
            <form class="form-inline" method="post">
                <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Your Email"></div>
                <div class="form-group"><button class="btn btn-primary" type="submit" name="resetPassword">Send reset link</button></div>
                <?php  
                 
                    if(isset($_POST['resetPassword'])){
                        echo '<div><strong><a href="change-password.php?token='.$token.'">localhost/preboWebsite/change-password.php?token="'.$token.'"</a></strong></div>';
                    }
                
                ?>
            </form>
        </div>
    </div>
    <footer class="page-footer dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="home.html">Home</a></li>
                        <li><a href="sign-up.php">Sign up</a></li>
                        <li><a href="#">Downloads</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2018 Copyright Prebo Digital 2018. All rights reserved</p>
            <p>Terms &amp; Conditions</p>
            <div class="clean-block add-on social-icons">
                <div class="icons"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-instagram"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-google-plus"></i></a><a href="#"><i class="fa fa-linkedin"></i></a></div>
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>