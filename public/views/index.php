
<?php

require_once 'tracking.php';

if($_POST['submit'] == 'Login') {
	var_dump($_POST);
    if($_POST['login'] && $_POST['password']) {
        $_POST['login'] = safe_var($_POST['login']);
        $_POST['password'] = safe_var($_POST['password']);
        $_POST['rememberMe'] = (int)$_POST['rememberMe'];
        doLogin($dbh, $_POST['login'], $_POST['password'], $_POST['rememberMe']);
    }
}
else if($_POST['submit'] == 'Create Account') {
    if($_POST['username'] && $_POST['name'] && $_POST['email']
    && $_POST['pwd'] && $_POST['cpwd']) {
        $_POST['username'] = safe_var($_POST['username']);
        $_POST['name'] = safe_var($_POST['name']);
        $_POST['email'] = safe_var($_POST['email']);
        $_POST['pwd'] = safe_var($_POST['pwd']);

        doRegister($dbh, $_POST['username'], $_POST['name'], $_POST['pwd'], $_POST['email']);
    }
}

?>

<!DOCTYPE html>

<head>
<title>Rockhopper login page</title>
<meta name="description" content="a project management system for Scrum">
<meta name="keywords" content="Rockhopper, Scrum, project management">
<meta http-equiv="author" content="estel">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/validationEngine.jquery.css" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<script type="text/javascript" src="assets/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="assets/js/jquery.validationEngine-en.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $("#tab").validationEngine();
    $("#loginForm").validationEngine();
});

function showErrMessage(message) {
	$("#errMessage").append("<div  class=\"errmessage\">" + message + "</div>");
}

function check_username(value) {
	$("#user_message").html(" checking...").css("color","red");
	if (value == "") return false;

	$.ajax({
		type:"get",
		url:"check_available.php",
		data:{checkuser:value, nametype:"isname"},
		success:function(data){
			if(data==0){
				$("#user_message").html(" Username available.").css("color","green");
			}
			else if(data==1) {
				$("#user_message").html(" Username already taken.").css("color","red");
			}
		}
	});
}

function check_email(value) {
	$("#email_message").html(" checking...").css("color","red");
	if (value == "") return false;

	$.ajax({
		type:"get",
		url:"check_available.php",
		data:{checkuser:value, nametype:"isemail"},
		success:function(data){
			if(data==2){
				$("#email_message").html(" Email available.").css("color","green");
			}
			else if(data==3){
				$("#email_message").html(" Email has been used.").css("color","red");
			}
		}
	});
}

</script>
</head>

<body>
<header id="index_header">
  <div class="container">
    <div class="row">
      <div class="span12">
        <div class="header_block clearfix">
          <div class="logo_block clearfix" align="right">
            <a href="index.php" target="_blank"><img src="../assets/img/facebook.png" alt="Join using your Facebook account" border="0" height="32" width="32"></a>
            <a href="index.php" target="_blank"><img src="../assets/img/google.png" alt="Join using your Google account" border="0" height="32" width="32"></a>
            <a href="index.php" target="_blank"><img src="../assets/img/linkedin.png" alt="Join using your LinkedIn account" border="0" height="32" width="32"></a>
            <a href="index.php" target="_blank"><img src="../assets/img/microsoft.png" alt="Join using Microsoft account" border="0" height="32" width="32"></a>
            <a href="index.php" target="_blank"><img src="../assets/img/twitter.png" alt="Join using your Twitter account" border="0" height="32" width="32"></a>
            <a href="index.php" target="_blank"><img src="../assets/img/yahoo.png" alt="Join using your Yahoo account" border="0" height="32" width="32"></a>
          </div>
        </div>
      </div>
    </div>
  </div> 
</header>

<section id="index_content">
  <div class="container">
  
    <div class="row">
    
      <div class="span6">
        <div class="discription">
          <h2>Rockhopper</h2>
          <p>&sdot; Agile Project Management<br>&sdot; Distributed development<br>&sdot; Scrum</p>   
        </div>
      </div>
      
  
      
      <div class="span6">
        <div class="modal-body modal-body_compact">
        
            <ul class="nav nav-tabs nav-tabs_compact">
              <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
              <li><a href="#create_account" data-toggle="tab">Create Account</a></li>
            </ul>
        
            <!-- user login form start -->
            <div class="tab-content tab-content_compact">
              <div class="tab-pane tab-pane_compact active in" id="login">
                <form action="index.php" method="post" id="loginForm">
                
                  <p><input type="text" name="login" placeholder="Username or Email" class="validate[required] input-xlarge" maxlength="20"></p>
                  <p><input type="password" name="password" placeholder="Password" class="validate[required] input-xlarge" maxlength="20"></p>
                  <label class="checkbox"><input type="checkbox" name="rememberMe">Remember me</label>
                  <button type="submit" name="submit" value="Login" class="btn pull-right">Login</button>
                  
                </form>
              </div>
              <!-- user login form end -->
          
              <!--  create account form  start -->
              <div class="tab-pane tab-pane_compact fade" id="create_account">
                <form class="form-horizontal" id="tab" method="post" action="index.php">
                
                  <div class="control-group">
                    <label class="control-label">Username</label>
                    <div class="controls">
                      <input type="text" name="username" class="validate[required,custom[onlyLetterNumber]] text-input" maxlength="20" onchange="check_username(this.value)">
                    <div id="user_message"></div>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label">Real Name</label>
                    <div class="controls">
                      <input type="text" name="name" class="validate[required,custom[onlyLetterSp]] text-input" maxlength="40">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                      <input type="text" name="email" class="validate[required,custom[email]] text-input" maxlength="40" onchange="check_email(this.value)">
                    <div id="email_message"></div>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label">Password</label>
                    <div class="controls">
                      <input type="password" name="pwd" class="validate[required] text-input"  id="password" maxlength="20">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label">Confirm Password</label>
                    <div class="controls">
                      <input type="password" name="cpwd" class="validate[required,equals[password]] text-input" maxlength="20">
                    </div>
                  </div>
                  
                  <button type="submit" name="submit" value="Create Account" class="btn pull-right">Create Account</button>
                </form>
              </div>  
              <!--  create account form end -->
              
            </div>
            
            <div class="errmessage">
              <?php
              
                if($_SESSION['msg']['login-err']) {
                    echo $_SESSION['msg']['login-err'];
                    unset($_SESSION['msg']['login-err']);
                }
                 
                if($_SESSION['msg']['reg-err']) {
                    echo $_SESSION['msg']['reg-err'];
                    unset($_SESSION['msg']['reg-err']);
                }
                 
                if($_SESSION['msg']['reg-success']) {
                    echo '<p style="color: green;">'.$_SESSION['msg']['reg-success'].'</p>';
                    unset($_SESSION['msg']['reg-success']);
                }
                
              ?>
            </div>
          
        </div>
      </div>
      
      
    </div>
  </div>
</section>
  
<footer> 
  <div class="container">
    <div class="row">
      <div class="span12">
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</footer>
</body>
</html>