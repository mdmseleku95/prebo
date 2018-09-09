<?php

//session_start();

include('classes/DB.php');
include('classes/Login.php');
include('classes/Post.php');

$tokenIsValid = False;
$username="";
$id = 0;

if (Login::isLoggedIn()) {
    $userid = Login::isLoggedIn();
    
    $username = DB::query('SELECT username FROM accounts WHERE id=:userid', array(':userid'=>$userid))[0]['username'];
}

/*if(Login::isLoggedIn()){
    $username = DB::query('SELECT username FROM accounts WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
}*/

else {
    header('Location: sign-in.php');
}

        if(isset($_POST['create'])){
                    $id = 0;
                    $dname = $_POST['dname'];
                    $description = $_POST['description'];
                    $dashContents = $_POST['dashBody'];
                    $createdOn = date("y/m/d");
                    
                    DB::query('INSERT INTO dashboards VALUES (:id, :name, :description, :contents, :createdOn, :user_id)', array(':id'=> $id, ':name' => $dname, ':description' => $description, ':contents' => $dashContents, ':createdOn' => $createdOn , ':user_id' => $userid));
                    
                    header('Location: index.php');
                }
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Settings</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
  </head>
  <body>

          <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Prebo Digital</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
            <li><a href="pages.html">Notifications</a></li>
            <li><a href="posts.html">Blog</a></li>
            <li><a href="users.html">Help</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Welcome, <?php echo $username?></a></li>
              <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Account
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a type="button" data-toggle="modal" data-target="#addPage">Manage Account</a></li>
                <li><a href="#">Billing Info</a></li>
                <li><a href="change-password.php">Change Password</a></li>
                <li><a href="#">Sharing Settings</a></li>
                <div class="dropdown-divider"></div>
                <li><a href="logout.php">Logout</a></li>  
              </ul>
          </ul>
            
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Settings<small> Save your dashboard settings</small></h1>
          </div>
        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
            
            <?php echo'<form method="post" action="dashboardsettings.php">';?>
                <!--<?php// if(count($errors) > 0){
                    //foreach($errors as $error){
                        //echo "<div><p>".$error."</p></div>";
                    }
                    }?>-->
                <?php echo'
                <h2 class="text-center"><strong>Create</strong> a new dashboard.</h2>
                <div class="form-group"><input class="form-control" type="text" name="dname" placeholder="Dashboard Name" required></div>
                <div class="form-group"><input class="form-control" type="text" name="description" placeholder="Description" required></div>
                <div class="form-group"><input type="hidden" name="dashBody" class="form-control" placeholder="Dash Body"></div>
                <div class="form-group"><button class="btn btn-dark btn-block" type="submit" name="create" id="create">Create Dashboard</button><a class="btn btn-danger btn-block" name="cancel" href="logoutInsta.php">Cancel</a></div></form>';
                
                ?>
                
                <script src="makePage.js">
                </script>
            
            </div>
        </div>
      </div>
    </section>

    <footer id="footer">
      <p>Copyright, &copy; 2018</p>
    </footer>
    <!-- Modals -->

      <input type="hidden" name="dashBody" class="form-control" placeholder="Dash Body">
      
    <!-- Add Page -->
    <div class="modal fade" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Page</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Post Title</label>
          <input type="text" class="form-control" placeholder="Post Title" name="postTitle"> 
        </div>
        <div class="form-group">
          <label>Post Body</label>
          <textarea name="postBody" class="form-control" placeholder="Post Body"></textarea>
        </div>
        <div class="form-group">
          <label>Meta Tags</label>
          <input type="text" class="form-control" placeholder="Add Some Tags...">
        </div>
        <div class="form-group">
          <label>Meta Description</label>
          <input type="text" class="form-control" placeholder="Add Meta Description...">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="post" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

  <script>
     CKEDITOR.replace( 'editor1' );
 </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
