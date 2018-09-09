<?php

include('classes/DB.php');
include('classes/Login.php');
$tokenIsValid = False;

$errors = array();

if(Login::isLoggedIn()){
    $tokenIsValid = True;
}

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $id = 0;
    
    if(!DB::query('SELECT username FROM accounts WHERE username=:username', array(':username'=>$username))){
        if(!DB::query('SELECT email FROM accounts WHERE email=:email', array(':email'=>$email))){
        
        if(strlen($username) >= 3 && strlen($username) <= 32 ){
            
            if(preg_match('/[a-zA-Z0-9_]+/', $username)){
                
                if(strlen($password) >= 6 && strlen($password) <= 60){
                
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    
                    if($password == $password-repeat){
                    
    
        DB::query('INSERT INTO accounts VALUES(:id, :username, :password, :email, \'0\')', array(':id'=>$id, ':username'=> $username, ':password'=>password_hash($password,PASSWORD_BCRYPT), ':email'=>$email));
        echo "Success";
                        
        header('Location: sign-in.php');
        }
                    
                    else{
                        $err = "Password don't match";
                        array_push($errors, $err);
                    }
                }
                    
                    else{
                    $err = "Invalid email address";
                    array_push($errors, $err);
                }
                }
                
                 else{
                    $err = "Invalid password. Doesn't match minimum character length of 6 or exceeds maximum character length of 60";
                     array_push($errors, $err);
                }
                    
                }
            
            else {
                $err = "Invalid username. Doesn't match allowed format";
                array_push($errors, $err);
            }
                
            }
            
            else {
           $err = "Invalid username. Doesn't meet minimum character length of 3 or exceeds maximum length of 32.";
                array_push($errors, $err);
        }
            
            
        }
        
        else {
            $err = "This email address is already in use";
            array_push($errors, $err);
        }
        
    }
    
    else{
        $err =  "This username is already in use";
        array_push($errors, $err);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
                    <li class="nav-item" role="presentation"><a class="nav-link" href="home.php" style="padding:8px;">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="features.html">Features</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="pricing.html">Pricing</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="about-us.html">About Us</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="contact-us.html">Contact Us</a></li>
                    <li class="dropdown"><a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Dashboard</a>
                        
                        <?php if ($tokenIsValid) { echo '<div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">Back To Dashboard</a><a class="dropdown-item" role="presentation" href="#">Help</a><a class="dropdown-item" role="presentation" href="logout.php">Logout</a></div>';}
                        
                        else{ echo'
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="sign-in.php">Login</a><a class="dropdown-item" role="presentation" href="#">Help</a></div>';} ?>
                    </li>
                </ul>
        </div>
        </div>
    </nav>
    <main class="page"></main>
    <div></div>
    <div class="highlight-blue" style="background-color:#e7e5e5;color:rgb(84,97,111);">
        <div class="container" style="padding-top:20px;">
            <div class="intro">
                <h2 class="text-center" style="color:rgb(62,140,228);">Don't have an account?</h2>
            </div>
            <div class="buttons"></div>
        </div>
    </div>
    <div class="register-photo">
        <div class="form-container">
            <div class="image-holder"></div>
            <?php 
            
                if($tokenIsValid){
                    echo ' <form method="post" action="sign-up.php">
                <h2 class="text-center"><strong>Create</strong> an account.</h2>
                <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username" disabled></div>
                <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email" disabled></div>
                <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" disabled></div>
                <div class="form-group"><input class="form-control" type="password" name="password-repeat" placeholder="Password (repeat)" disabled></div>
                <div class="form-group">
                    <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" disabled>I agree to the license terms.</label></div>
                </div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="register" disabled>Sign Up</button></div></form>';
                }
            
            else{
                echo' 
            <form method="post" action="sign-up.php">';?>
                <?php if(count($errors) > 0){
                    foreach($errors as $error){
                        echo "<div><p>".$error."</p></div>";
                    }
                    }?>
                <?php echo'
                <h2 class="text-center"><strong>Create</strong> an account.</h2>
                <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username" required></div>
                <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div required>
                <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
                <div class="form-group"><input class="form-control" type="password" name="password-repeat" placeholder="Password (repeat)" required></div>
                <div class="form-group">
                    <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" required>I agree to the license terms.</label></div>
                </div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="register">Sign Up</button></div><a href="sign-in.php" class="already">You already have an account? Login here.</a></form>';
            }?>
            
        </div>
    </div>
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