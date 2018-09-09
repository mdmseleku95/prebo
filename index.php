<?php

session_start();

include('classes/DB.php');
include('classes/Login.php');
include('classes/Post.php');

$tokenIsValid = False;
$username="";
$id = 0;
$dashname = '';
$descriptions = '';
$title ='';
$body = '';
$tags = '';
$mDesc = '';
$followingposts;

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

if(DB::query('SELECT * FROM dashboards WHERE user_id=:user_id', array(':user_id' => $userid))){
    $dashname = DB::query('SELECT name FROM dashboards WHERE user_id=:user_id', array(':user_id' => $userid))[0]['name'];
}

else {
    $dashname = '';
}

if(DB::query('SELECT dashboards.description FROM dashboards WHERE dashboards.user_id = :userID', array(':userID'=>$userid))){
    $descriptions = DB::query('SELECT dashboards.description FROM dashboards WHERE dashboards.user_id = :userID', array(':userID'=>$userid))[0]['description'];
}

else {
    $descriptions = '';
}

if(isset($_POST['save'])){
    
    $title = $_POST['title'];
    $mbody = $_POST['mbody'];
    $tags = $_POST['tags'];
    $mDesc = $_POST['mDescription'];

    
    DB::query('INSERT INTO notes VALUES (:id, :title, :body, :metaTags, :metaDescription, :user_id)', array(':id'=> $id, ':title' => $title,':body' => $mbody ,':metaTags' => $tags,':metaDescription' => $mDesc , ':user_id' => $userid)); 
    
    $followingposts = DB::query('SELECT notes.id, notes.title, notes.body FROM notes
            WHERE notes.user_id = :userID ORDER BY notes.id DESC;', array(':userID'=>$userid));
}

?>

<!-------------------------------------------------->

<?php

//Everything under this php tag is for the Instagram API callback values 

	if( isset($_SESSION['user_info']) ){ // if user is logged in
	$user_info = $_SESSION['user_info']; // get user info array
	$full_name = $_SESSION['user_info']['data']['full_name']; // get full name
	$usernameInsta = $_SESSION['user_info']['data']['username']; // get username
	$bio = $_SESSION['user_info']['data']['bio']; // get bio
	$ID = $_SESSION['user_info']['data']['id']; // get bio
	$website = $_SESSION['user_info']['data']['website']; // get bio
	$media_count = $_SESSION['user_info']['data']['counts']['media']; // get media count
	$followers_count = $_SESSION['user_info']['data']['counts']['followed_by']; // get followers
	$following_count = $_SESSION['user_info']['data']['counts']['follows']; // get following
	$profile_picture = $_SESSION['user_info']['data']['profile_picture']; // get profile picture
            }            
?>

<!-------------------------------------------------->

<?php

//Everything under this php tag is for the LinkedIn API callback values
require "init.php";
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

?>
<!-------------------------------------------------->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
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
            <h1><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard <small>Manage Your Information</small></h1>
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
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </section>
      
       <section id="breadcrumb">
      <div class="container">
          <ol class="breadcrumb">
              <?php echo' <p><strong>Dashboard name: </strong></p>'.$dashname. '<p><strong> Description: </strong></p>' .$descriptions ?>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
                <a href="index.php" class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard
              </a>
              <a href="integrations.php" class="list-group-item"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Integrations <span class="badge"></span></a>
              <a href="csv.php" class="list-group-item"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> CSV File Manager <span class="badge"></span></a>
              <a href="logoManager.php" class="list-group-item"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> Logo Manager <span class="badge"></span></a>
            </div>
          </div>
           
          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Website Overview</h3>
              </div>
              <div class="grid">
                <div class="item" id="followersCard">
                  <div class="well dash-box">
                    <h2><span class="" aria-hidden="true"></span><?php if( isset($_SESSION['user_info']) ){echo $followers_count;} else{echo'';}  ?></h2>
                    <h4>Followers</h4>
                  </div>
                </div>
                <div class="item">
                  <div class="well dash-box" id="followingCard">
                    <h2><span class="" aria-hidden="true"></span><?php if( isset($_SESSION['user_info']) ){echo $following_count;} else{echo'';}  ?></h2>
                    <h4>Following</h4>
                  </div>
                </div>
                <div class="item">
                  <div class="well dash-box" id="postsCard">
                    <h2><span class="" aria-hidden="true"></span><?php if( isset($_SESSION['user_info']) ){echo $media_count;} else{echo'';}  ?></h2>
                    <h4>Posts</h4>
                  </div>
                </div>
                <div class="item">
                  <div class="well dash-box" id="userCard">
                    <h3><span class="" aria-hidden="true"></span><?php if( isset($_SESSION['user_info']) ){echo $ID;} else{echo'';}  ?></h3>
                    <h4>User ID</h4>
                  </div>
                </div>
                  
<!--<div class="grid">

  <div class="item">
    <div class="item-content">
      <?php //if( isset($_SESSION['user_info']) ){echo $followers_count;} else{echo'';} ?>    
    </div>
  </div>

  <div class="item">
    <div class="item-content">
      Second
    </div>
  </div>


  <div class="item">
    <div class="item-content">
      Third
    </div>
  </div>


  <div class="item">
    <div class="item-content">
      Fourth
    </div>
  </div>

  <div class="item">
    <div class="item-content">
      Fifth
    </div>
  </div>

  <div class="item">
    <div class="item-content">
      Sixth
    </div>
  </div>

  <div class="item">
    <div class="item-content">
      Seventh
    </div>
  </div>

  <div class="item">
    <div class="item-content">
      Eight
    </div>
  </div>

  <div class="item">
    <div class="item-content">
      Ninth
    </div>
  </div>

  <div class="item">
    <div class="item-content">
      Tenth
    </div>
  </div>

  <!-- <div class="item">
    <div class="item-content">
      <img src="http://lorempixel.com/200/200/cats/10/">
    </div>
  </div>

  <div class="item">
    <div class="item-content">
      <img src="http://lorempixel.com/200/200/cats/8/">
    </div>
  </div>  
  
</div>-->
                  
              </div>
              </div>
              
              <!------------------------------------------->
              
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Widgets</h3>
                </div>
                <div class="panel-body">
                    
                    <div id="accordion">

<?php if( isset($_SESSION['user_info']) ){ echo '                        
<div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Instagram API
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
       <table class="table table-striped table-hover">
                      <tr>
                        <th>Metric Name</th>
                        <th></th>
                      </tr>
                      <tr>
                        <td>Followers</td>
                        <td><button class="btn btn-default" name="viewFollowers" id="viewFollowers" type="submit">Add</button> <button class="btn btn-danger" name="hideFollowers" id="hideFollowers" type="submit">Remove</button></td>
                      </tr>
                       <tr>
                        <td>Following</td>
                        <td><button class="btn btn-default" name="viewFollowing" id="viewFollowing" type="submit">Add</button> <button class="btn btn-danger" name="hideFollowing" id="hideFollowing" type="submit">Remove</button></td>
                      </tr>
                      <tr>
                        <td>Posts</td>
                        <td><button class="btn btn-default" name="viewPosts" id="viewPosts" type="submit">Add</button> <button class="btn btn-danger" name="hidePosts" id="hidePosts" type="submit">Remove</button></td>
                      </tr>
                        <tr>
                        <td>User Info</td>
                        <td><button class="btn btn-default" name="viewUser" id="viewUser" type="submit">Add</button> <button class="btn btn-danger" name="hideUser" id="hideUser" type="submit">Remove</button></td>
                      </tr>
                    </table>
      </div>
    </div>
  </div>';} else { echo ''; }?> 
    
<?php if (isset($_SESSION['user'])) { echo '                       
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          LinkedIn API
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
      
      </div>
    </div>
  </div>';} else {echo '';}?>
  <!--<div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>-->
</div>
                    
                </div>
              </div>
              
              
              <!------------------------------------------->

              <!-- Latest Users -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Integrations</h3>
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                      
        <?php
                      //Everything under this php tag is to display the callback values for the instagram api if the user is logged in
        
                      if( isset($_SESSION['user_info']) ){ 
                      
                          echo '<strong>Instagram Account Info</strong>';
                          echo'<h2>Welcome'.$full_name.'</h2>
                            <p>Your username: '.$usernameInsta.'</p>
                            <p>Your bio: '.$bio.'</p>
                            <p>Your website: <a href="'.$website.'">'.$website.'</a></p>
                            <p>Media count: '.$media_count.'</p>
                            <p>Followers count: '.$followers_count.'</p>
                            <p>Following count: '.$following_count.'</p>
                            <p>Your ID: '.$ID.'</p>
                            <p><img src="'.$profile_picture.'"></p>
                            <p><a href="logoutInsta.php">Logout?</a></p><hr><br>';
                      
                      
                      };
                      
                      if (isset($_SESSION['user'])) {
                          
                    echo '<strong>LinkedIn Account Info</strong>';     
                    echo '<div>
                        <label style="font-weight: 600">First Name</label><br>
                        <label>'.$user->firstName.'</label><br><br>
                        <label style="font-weight: 600">Last Name</label><br>
                        <label>'.$user->lastName.'</label><br><br>
                        <label style="font-weight: 600">Email Address</label><br>
                        <label>'.$user->emailAddress.'</label><br><br>
                        <label style="font-weight: 600">Headline</label><br>
                        <label>'.$user->headline.'</label><br><br>
                        <label style="font-weight: 600">Industry</label><br>
                        <label>'.$user->industry.'</label><br><br>
                        <button><a href="logoutLinkedIn.php">Log out</a></button>
                    </div>';
                      };
                      
        ?>
		
        </table>
                </div>
              </div>
              
              <!--------------------------------------------------------------------->
              
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Notes</h3>
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                <?php
                      
            $followingposts = DB::query('SELECT notes.id, notes.title, notes.body FROM notes
            WHERE notes.user_id = :userID ORDER BY notes.id DESC;', array(':userID'=>$userid));

       foreach($followingposts as $post) {

        echo $post['title']." ~ ".$post['body']."<br>"; }?>
                      
                </table>
                </div>
              </div>
              
          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
      <p>Prebo Digital Copyright, &copy; 2018</p>
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
          <textarea name="mbody" id="mbody" class="form-control" placeholder="Page Body"></textarea>
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
   
  <script>
     CKEDITOR.replace( 'editor1' );
 </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web-animations/2.3.1/web-animations.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/muuri/0.5.3/muuri.min.js"></script>

    <script type="text/javascript">
    const grid = new Muuri('.grid',{
    dragEnabled: true,
    dragAxis: 'xy'
    });
    </script>
      
      
    <script>
        
        $(document).ready (function(){
            $("#followersCard").hide();
            $("#followingCard").hide();
            $("#postsCard").hide();
            $("#userCard").hide();
        });
        
        $(function() {
        $( "#viewFollowers" ).click(function() {
        $( "#followersCard" ).show();
            });
        });
        
        $(function() {
        $( "#hideFollowers" ).click(function() {
        $( "#followersCard" ).hide();
            });
        });
        
        $(function() {
        $( "#viewFollowing" ).click(function() {
        $( "#followingCard" ).show();
            });
        });
        
        $(function() {
        $( "#hideFollowing" ).click(function() {
        $( "#followingCard" ).hide();
            });
        });
        
        $(function() {
        $( "#viewPosts" ).click(function() {
        $( "#postsCard" ).show();
            });
        });
        
        $(function() {
        $( "#hidePosts" ).click(function() {
        $( "#postsCard" ).hide();
            });
        });
        
        $(function() {
        $( "#viewUser" ).click(function() {
        $( "#userCard" ).show();
            });
        });
        
        $(function() {
        $( "#hideUser" ).click(function() {
        $( "#userCard" ).hide();
            });
        });
</script>
      
  </body>
</html>
