<?php

include('classes/DB.php');
include('classes/Login.php');
include('classes/Post.php');

require_once "init.php";

$tokenIsValid = False;
$username="";
$id = 0;
$showModal = 0;

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

 if(!DB::query('SELECT id FROM dashboards WHERE user_id=:user_id', array(':user_id'=>$userid))){
     $showModal = 1;
 }

if(isset($_POST['save'])){
    
    $title = $_POST['title'];
    $body = $_POST['body'];
    $tags = $_POST['tags'];
    $mDesc = $_POST['mDescription'];

    
    DB::query('INSERT INTO notes VALUES (:id, :title, :body, :metaTags, :metaDescription, :user_id)', array(':id'=> $id, ':title' => $title,':body' => $body ,':metaTags' => $tags,':metaDescription' => $mDesc , ':user_id' => $user_id)); 
    
}
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Integrations</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
      
    <script type="text/javascript">
        var showModal = <?php echo $showModal?>
        
            if(showModal === 1){
            $(document).ready(function(){
                $("#myModal").modal('show');
            });
        }
        
    </script>
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
            <h1><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Integrations <small>Manage Your Integrations</small></h1>
          </div>
          <div class="col-md-2">
            <div class="dropdown create">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Create Content
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a type="button" data-toggle="modal" data-target="#addPage">Add Page</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li><a href="index.html">Dashboard</a></li>
          <li class="active">Integrations</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="index.php" class="list-group-item">
                <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard
              </a>
              <a href="integrations.php" class="list-group-item active main-color-bg"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Integrations <span class="badge"></span></a>
              <a href="csv.php" class="list-group-item"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> CSV File Manager <span class="badge"></span></a>
              <a href="logoManager.php" class="list-group-item"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> Logo Manager <span class="badge"></span></a>
            </div>

             <div class="well">
              <h4>Disk Space Used</h4>
              <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
              </div>
            </div>
            <h4>Bandwidth Used </h4>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
            </div>
          </div>
              </div>
          </div>
          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Integrations</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" placeholder="Search Integrations">
                      </div>
                </div>
                <br>
                <table class="table table-striped table-hover">
                      <tr>
                        <th>Integration Name</th>
                        <th></th>
                      </tr>
                      <tr>
                        <td>Instagram</td>
                        <td><a class="btn btn-default" href="login.php">Login</a> <a class="btn btn-danger" href="logoutInsta.php">Logout</a></td>
                      </tr>
                      <tr>
                        <td>LinkedIn</td>
                        <td><a class="btn btn-default" href="<?php  echo "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id={$client_id}&redirect_uri={$redirect_uri}&state={$csrf_token}&scope={$scopes}"; ?>">Login</a> <a class="btn btn-danger" href="#">Logout</a></td>
                      </tr>
                      <tr>
                        <td>Facebook</td>
                        <td><a class="btn btn-default" href="edit.html">Login</a> <a class="btn btn-danger" href="#">Logout</a></td>
                      </tr>
                    <tr>
                        <td>Bing Ads</td>
                        <td><a class="btn btn-default" href="edit.html">Login</a> <a class="btn btn-danger" href="#">Logout</a></td>
                      </tr>
                    <tr>
                        <td>Twitter</td>
                        <td><a class="btn btn-default" href="edit.html">Login</a> <a class="btn btn-danger" href="#">Logout</a></td>
                      </tr>
                    <tr>
                        <td>Google AdWords</td>
                        <td><a class="btn btn-default" href="edit.html">Login</a> <a class="btn btn-danger" href="#">Logout</a></td>
                      </tr>
                    </table>
              </div>
              </div>

          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
      <p>Copyright, &copy; 2018</p>
    </footer>

    <!-- Modals -->

    <!-- Add Page -->
    <div class="modal fade" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Page</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Page Title</label>
          <input type="text" name="title" id="title" class="form-control" placeholder="Page Title">
        </div>
        <div class="form-group">
          <label>Page Body</label>
          <textarea name="editor1" name="body" id="body" class="form-control" placeholder="Page Body"></textarea>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox"> Published
          </label>
        </div>
        <div class="form-group">
          <label>Meta Tags</label>
          <input type="text" name="tags" id="tags" class="form-control" placeholder="Add Some Tags...">
        </div>
        <div class="form-group">
          <label>Meta Description</label>
          <input type="text" name="mDescription" id="mDescription" class="form-control" placeholder="Add Meta Description...">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="save" id="save" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
      
      <div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">Let's get you all set up</h4>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Welcome to your first Dashboard</h3>
				<p>You're only a couple of steps away from creating your first Dashboard. The first thing you have to do is connect an integration</p>
                <form>
                    <button class="btn btn-dark" data-dismiss="modal" aria-hidden="true">Next Step</button>
                </form>
            </div>
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
