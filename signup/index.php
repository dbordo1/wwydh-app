<?php
include("../helpers/conn.php");
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
 {
// username and password received from loginform
$name=mysqli_real_escape_string($conn,$_POST['name']);
$username=mysqli_real_escape_string($conn,$_POST['username']);
$password=mysqli_real_escape_string($conn,$_POST['password']);
$password = md5($password);
$email=mysqli_real_escape_string($conn,$_POST['email']);
$address=mysqli_real_escape_string($conn,$_POST['address']);
$sID = "";
$zipCode=mysqli_real_escape_string($conn,$_POST['zipCode']);



$sql_query="INSERT INTO users(id,name,username,email,password,address,zipCode) VALUES('sID','$name','$username','$email','$password','$address','$zipCode')";
$result=mysqli_query($conn,$sql_query)or die(mysqli_error($conn));
//$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//$count=mysqli_num_rows($result);


// If result matched $username and $password, table row must be 1 row
if($result)
{
$_SESSION['login_user']=$username;

header("location: login.php");
}
else
{
$error="Registration Failed!";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="../helpers/header_footer.css" type="text/css" rel="stylesheet" />
<link href="styles.css" type="text/css" rel="stylesheet" />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<title>WWYDH Registration</title>
</head>

<body>
  <div class="width">
    <div id="nav">
            <div class="nav-inner width clearfix <?php if (isset($_SESSION['user'])) echo 'loggedin' ?>">
                <a href="../home">
                    <div id="logo"></div>
                    <div id="logo_name">What Would You Do Here?</div>
                    <div class="spacer"></div>
                </a>
                <div id="user_nav" class="nav">
                    <?php if (!isset($_SESSION["user"])) { ?>
                        <ul>
                            <a href="../login"><li>Log in</li></a>
                            <a href="../signup"><li>Sign up<class="active" </li></a>
                            <a href="../contact"><li>Contact</li></a>
                        </ul>
                    <?php } else { ?>
                        <div class="loggedin">
                            <span class="click-space">
                                <span class="chevron"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                <div class="image" style="background-image: url(../helpers/user_images/<?php echo $_SESSION["user"]["image"] ?>);"></div>
                                <span class="greet">Hi <?php echo $_SESSION["user"]["first"] ?>!</span>
                            </span>

                            <div id="nav_submenu">
                                <ul>
                                    <a href="../dashboard"><li>Dashboard</li></a>
                                    <a href="../profile"><li>My Profile</li></a>
                                    <a href="../helpers/logout.php?go=home"><li>Log out</li></a>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div id="main_nav" class="nav">
                    <ul>
                        <a href="../locations"><li>Locations</li></a>
                        <a href="../ideas"><li>Ideas</li></a>
                        <a href="../plans"><li>Plans</li></a>
                        <a href="../projects"><li>Projects</li></a>
                    </ul>
                </div>
            </div>
        </div>
  </div>
<div id="signup">
  <div class="width">
    <div id="signup_name">Sign Up for WWYDH</div>
    <div id="form">
      <form method="post" action="#" name="loginform">
        <input type="text" value="" placeholder="First Name"  name="fname" class="form-size"><br>
        <input type="text" value="" placeholder="Last Name"  name="lname" class="form-size"><br>
        <input type="text" value="" placeholder="Username"  name="username" class="form-size"><br>
        <input type="password" value="" placeholder="Password"  name="password" class="form-size"><br>
        <input type="password" value="" placeholder="Confirm Password"  name="confirmpassword" class="form-size"><br>
        <input type="text" value="" placeholder="Email"  name="email" class="form-size"><br>
        <input type="text" value="" placeholder="Address"  name="address" class="form-size"><br>
        <input type="text" value="" placeholder="Zip Code" name="zipCode" class="form-size"><br>
        <input type="submit" id="submit" class="form-size" value="Sign Up">
      </form>
    </div>
  </div>
</div>
 <div id="footer">
            <div class="grid-inner">
                &copy; Copyright WWYDH <?php echo date("Y") ?>
            </div>
    </div>
</body>

</html>
