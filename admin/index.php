<?php
session_start();
$noNavbar = '';
$pageTitle  = 'Login';
if(isset($_SESSION['Username']))
{
    header('location: dashboard.php');
    
}

include "init.php";


// cheack if user coming from POSt
if($_SERVER['REQUEST_METHOD']=="POST")
{   
    $Username = $_POST['user'];
    $Password = $_POST['pass'];
    $hashedPass = sha1($Password);
    
// check if the user exist in database

    $stmt = $con->prepare("SELECT
                             UserID,Username,Password
                              FROM 
                                     users
                              WHERE
                                    Username = ? 
                               AND
                                    Password = ?
                               AND 
                                     GroupID = 1
                               Limit 1 ");
    $stmt->execute(array($Username,$hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

// if count > 0 this mean there is a record about this user
    if($count>0)
    {
       $_SESSION['Username'] = $Username ;//register session name
       $_SESSION['ID'] = $row['UserID'] ;//register session iD
       header('location: dashboard.php');//redirect to dashboard page
       exit();
    }
}

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password">
    <input class="w-100 btn btn-primary  btn-block" type="submit" value="Login">

</form>






<?php include $tpl.'footer.php'; ?>