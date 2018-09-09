<?php
include('classes/DB.php');
include('classes/Login.php');
$tokenIsValid = False;
if (Login::isLoggedIn()) {

        if (isset($_POST['changePassword'])) {

                $oldPassword = $_POST['oldPassword'];
                $newPassword = $_POST['password'];
                $newPasswordRepeat = $_POST['password-repeat'];
                $userID = Login::isLoggedIn();

                if (password_verify($oldPassword, DB::query('SELECT password FROM accounts WHERE id=:userID', array(':userID'=>$userID))[0]['password'])) {

                        if ($newPassword == $newPasswordRepeat) {

                                if (strlen($newPassword) >= 6 && strlen($newPassword) <= 60) {

                                        DB::query('UPDATE password SET password=:newPassword WHERE id=:userID', array(':newPassword'=>password_hash($newPassword, PASSWORD_BCRYPT), ':userID'=>$userID));
                                        echo 'Password changed successfully!';
                                    
                                    header('Location: sign-in.php');
                                }

                        } else {
                                echo 'Passwords don\'t match!';
                        }

                } else {
                        echo 'Incorrect old password!';
                }

        }

} else {
        if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if (DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))) {
                $userID = DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $tokenIsValid = True;
                if (isset($_POST['changePassword'])) {

                        $newPassword = $_POST['password'];
                        $newPasswordRepeat = $_POST['password-repeat'];

                                if ($newPassword == $newPasswordRepeat) {

                                        if (strlen($newPassword) >= 6 && strlen($newPassword) <= 60) {

                                                DB::query('UPDATE accounts SET password=:newPassword WHERE id=:userID', array(':newPassword'=>password_hash($newPassword, PASSWORD_BCRYPT), ':userID'=>$userID));
                                                echo 'Password changed successfully!';
                                                DB::query('DELETE FROM password_tokens WHERE user_id=:userID', array(':userID'=>$userID));
                                            
                                            header('Location: sign-in.php');
                                        }

                                } else {
                                        echo 'Passwords don\'t match!';
                                }

                        }


        } else {
                die('Token invalid');
        }
} else {
        die('Not logged in');
}
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar" style="padding-bottom:10px;">
        <div class="container"><a class="navbar-brand logo" href="#"><img src="assets/img/PreboDigitalLogo.png" style="width:300px;"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="home.php" style="padding:8px;">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="features.html">Features</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="pricing.html">Pricing</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="about-us.html">About Us</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="contact-us.html">Contact Us</a></li>
                    <li class="dropdown"><a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Dashboard</a>
                        <?php if (!$tokenIsValid) { echo '<div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="index.php">Back To Dashboard</a><a class="dropdown-item" role="presentation" href="#">Help</a><a class="dropdown-item" role="presentation" href="logout.php">Logout</a></div>';}
                        
                        else{ echo'
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="sign-in.php">Login</a><a class="dropdown-item" role="presentation" href="sign-up.php">Register</a></div>';} ?>
                    </li>
                </ul>
        </div>
        </div>
    </nav>
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Reset Password</h2>
                    <p>Please enter your new password and click the reset button when you're done</p>
                </div>
                <form action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } ?>" method="post">
        <?php if (!$tokenIsValid) { echo '<div class="form-group><label for="oldPassword>Old Password</label>"<input class="form-control item" type="password" name="oldPassword" value="" placeholder="Current Password ..."><p /></div>'; } ?>
                    <div class="form-group"><label for="password">New Password</label><input class="form-control item" type="password" id="password" name="password" placeholder="New Password ..."></div>
                    <div class="form-group"><label for="password-repeat">Repeat Password</label><input class="form-control" type="password" id="password-repeat" name="password-repeat" placeholder="Repeat New Password ..."></div><button class="btn btn-primary btn-block" type="submit" name="changePassword">Reset Password</button></form>
            </div>
        </section>
    </main>
    <footer class="page-footer dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="home.php">Home</a></li>
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
            <p>© 2018 Copyright Text</p>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>