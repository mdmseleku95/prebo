<?php

include('classes/DB.php');
include('classes/Login.php');
$tokenIsValid = False;
$username="";
$dashname = "";


$errors = array();

if(Login::isLoggedIn()){
    $tokenIsValid = True;
}

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id = 0;
    
    if(DB::query('SELECT email FROM accounts WHERE email=:email', array(':email'=>$email))){
        
        if(password_verify($password,DB::query('SELECT password FROM accounts WHERE email=:email', array(':email'=>$email))[0]['password'])){
            
            $cstrong = true;
            
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            
            $user_id = DB::query('SELECT id FROM accounts WHERE email=:email', array(':email' => $email))[0]['id'];
            
            $username = DB::query('SELECT username FROM accounts WHERE email=:email', array(':email'=>$email))[0]['username'];
                
            DB::query('INSERT INTO login_tokens VALUES (:id, :token, :user_id)', array(':id'=> $id, ':token' => sha1($token), ':user_id' => $user_id));  
            
            setcookie("onPointID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, true);
            setcookie("onPointID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, true);
        
           if(DB::query('SELECT * FROM dashboards WHERE user_id=:user_id', array(':user_id' => $user_id))){
                $dashname = DB::query('SELECT name FROM dashboards WHERE user_id=:user_id', array(':user_id' => $userid))[0]['name'];
               
               header('Location: index.php');
            }

            else {
                $dashname = '';
                header('Location: integrations.php');
            }
            
        }
        
        else {
            $err = "Incorrect password";
            array_push($errors, $err);
        }
        
    }
    
    else{
        $err = "No such user exists in our records";
        array_push($errors, $err);
    }
    
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-In</title>
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
                         <?php if ($tokenIsValid) { echo '<div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="index.php">Back To Dashboard</a><a class="dropdown-item" role="presentation" href="#">Help</a><a class="dropdown-item" role="presentation" href="logout.php">Logout</a></div>';}
                        
                        else{ echo'
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="sign-up.php">Register</a><a class="dropdown-item" role="presentation" href="#">Help</a></div>';} ?>
                    </li>
                </ul>
        </div>
        </div>
    </nav>
    <main class="page">
        <section class="clean-block about-us" style="padding-bottom:25px;background-color:#e7e5e5;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Sign In Here</h2>
                </div>
            </div>
        </section>
    </main>
    <div>
        <div class="container-fluid">
            <div class="row mh-100vh">
                <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0" id="login-block" style="padding-bottom:40px;">
                    <div class="m-auto w-lg-75 w-xl-50">
                        <h2 class="text-info font-weight-light mb-5"><i class="fa fa-diamond"></i>&nbsp;Prebo Digital</h2>
                        <form method="post" action="sign-in.php">
                            
                            <?php if(count($errors) > 0){
                                foreach($errors as $error){
                                    echo "<div><p>".$error."</p></div>";
                                }
                                }
                            ?>
                            
                            <div class="form-group"><label class="text-secondary">Email</label><input class="form-control" type="text" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,15}$" inputmode="email" name="email"></div>
                            <div class="form-group"><label class="text-secondary">Password</label><input class="form-control" type="password" required name="password"></div><button class="btn btn-info mt-2" type="submit" name="login">Log In</button></form>
                        <p class="mt-3 mb-0"><a href="forgot-login.php" class="text-info small">Forgot your password?</a></p>
                        <p class="mt-3 mb-0"><a href="sign-up.php" class="text-info small">Register here</a></p>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-end" id="bg-block" style="background-image:url(&quot;assets/img/aldain-austria-316143-unsplash.jpg&quot;);background-size:cover;background-position:center center;">
                    <p class="ml-auto small text-dark mb-2"><em>Photo by JoeSimz</em><br></p>
                </div>
            </div>
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