<?php
session_start();

$pageTitle  = 'Members';

if(isset($_SESSION['user'])){
    include "init.php"; 

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            echo '<h1 class="text-center">Update Member</h1>';
            echo '<div class="container">';

             //uploded files

            
             $avatarName     = $_FILES['avatar']['name'] ;
             $avatarPath     = $_FILES['avatar']['full_path'] ;
             $avatarType     = $_FILES['avatar']['type'] ;
             $avatarTmp_Name = $_FILES['avatar']['tmp_name'] ;
             $avatarEror     = $_FILES['avatar']['error'] ;
             $avatarSize     = $_FILES['avatar']['size'] ;  

            // list of allowed file type of upload
             $avatarAllowedExtentions = array("jpeg","jpg","gif","png");
             //get avatar extention
             $exploded=explode('.', $avatarName);
             $endofarray=end($exploded );
             $avatarExtentions = strtolower($endofarray);

            //get variables from the form
            $id     = $_POST['userid'];
            $email  = $_POST['email'];
            $user   = $_POST['username'];
            $name   = $_POST['full'];

            // password tick
            $pass = empty($_POST['newpassword'])?   $_POST['oldpassword']:  sha1($_POST['newpassword']);
            
            // validate the form

            $fromErrors = array();

            if(strlen($user)<4 )
            {
                $fromErrors[]= '  Username can not be less than <strong> 4 chararcters </strong> </div>';
            }
            if(empty($user))
            {
                $fromErrors[]= 'Username can not be <strong>Empty</strong> </div>';
            }
            if(empty($email))
            {
                $fromErrors[]= 'Email can not be <strong>Empty</strong> </div>';
            }
            if(empty($name))
            {
                $fromErrors[]= 'Full Name can not be <strong>Empty</strong> </div>';
            }
            if(!empty($avatarName)){
                if(!in_array($avatarExtentions,$avatarAllowedExtentions)){
                    $fromErrors[]= 'This Extention is Not  <strong>Allowed</strong> </div>';
                }
                if($avatarSize > 4194304 ){ 
                    $fromErrors[]= 'Avatar Can\'t be More Than <strong>4MB</strong> </div>';
                }
            }

            // loop into error array and echo it
            foreach( $fromErrors as $error)
            {
                echo '<div class="alert alert-danger">'.$error ;
            }
           

            // check if there is no errors proceed the update operation

            if(empty( $fromErrors))
            {
                


                $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
                $stmt2->execute(array($user,$id));

                $count= $stmt2->rowCount();

                if($count==1)
                {
                    $theMsg= '<div class="alert alert-danger">this Username =  <strong>'.$user.'</strong> Already exist' . '</div>';
                    redirectHome($theMsg,'back');
                }else
                {
                    
                    $avatar = rand(0,10000000).$user.'_'.$avatarName;
                    move_uploaded_file($avatarTmp_Name,"Admin\uploads\images\avatar\\".$avatar);
                    if($avatarName >0 ){
                       
                                    
                        $stmt = $con->prepare(' UPDATE users SET Username=? ,Password=?, Email=? ,FullName=? , Avatar =?
                        WHERE UserID=?');
                        $stmt->execute(array($user,$pass,$email,$name,$avatar,$id));

                    }else
                    {
                                
                    $stmt = $con->prepare(' UPDATE users SET Username=? ,Password=?, Email=? ,FullName=? 
                    WHERE UserID=?');
                    $stmt->execute(array($user,$pass,$email,$name,$id));
                    }
                 // echo successful msg and redirect to previos page
                 if($stmt){
                        
                    $theMsg = '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Updated' . '</div>';
                    redirectHome($theMsg,'back');
                 }
                }
                
               
            }
        }
        

        echo '</div>';








    // check if get requestis numeric & get the intger value of it
    //$userid = isset($_GET['UserID']) && is_numeric($_GET['UserID'])? intval($_GET['UserID']): 0 ;
    // select all data depent on this iD
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? Limit 1 ");
    // execute query
    $stmt->execute(array($_SESSION['uid']));
    // fetch the data from the database
    $row = $stmt->fetch();
    // row count 
    // if there is this iD or no
    $count = $stmt->rowCount();
    // if there is id show the from 
    if($count > 0)
    {
    // Edite page
    ?>
<h1 class="text-center ">Edit Member</h1>
<div class="container">
<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="userid" value="<?php echo $_SESSION['uid'] ?>">
    <!-- start usernmae field -->
    <div class="form-group row ">
        <label class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10 col-md-6">
            <div class="input-content">
                <input type="text" class="form-control form-control-lg" name="username" autocomplete="off"
                    value="<?php echo $row['Username'] ?>" required="required">
            </div>
        </div>
    </div>
    <!-- end usernmae field -->
    <!-- start Password field -->
    <div class="form-group row ">
        <label class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10 col-md-6">
            <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
            <div class="input-content">
                <input type="Password" class="password form-control  form-control-lg" name="newpassword"
                    autocomplete="new-password" placeholder=" leave blank if you dont want to change">
                <i class="show-pass fa fa-eye fa-2x"></i>
            </div>
        </div>
    </div>
    <!-- end Password field -->
    <!-- start email field -->
    <div class="form-group row ">
        <label class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10 col-md-6 ">
            <div class="input-content">
                <input type="Email" class="form-control form-control-lg" name="email" autocomplete="off"
                    value="<?php echo $row['Email'] ?>" required='requiered'>
            </div>
        </div>
    </div>
    <!-- end email field -->
    <!-- start Full Name field -->
    <div class="form-group row ">
        <label class="col-sm-2 col-form-label">Full Name</label>
        <div class="col-sm-10 col-md-6">
            <div class="input-content">
                <input type="text" class="form-control form-control-lg" name="full" autocomplete="off"
                    value="<?php echo $row['FullName'] ?>"
                     required='requiered'>
            </div>
        </div>
    </div>
    <!-- end Full Name field -->
    <!-- start Avatar field -->
    <div class="form-group row ">
        <label class="col-sm-2 col-form-label">User Avatar</label>
        <div class="col-sm-10 col-md-6">
            <div class="input-content">
                <input  type="file"
                        class="form-control form-control-lg"
                        name="avatar"
                        autocomplete="off"
                        placeholder="Avatar apper in your Profile Page"
                        value="<?php echo $row['Avatar'] ?>" >
            </div>
        </div>
    </div>
    <!-- end Avatar field -->
    <!-- start submit btn field -->
    <div class="form-group row ">
        <div class="col-sm-offset-6 col-sm-6">
            <input type="submit" class="botoon btn btn-success" value="Save">
        </div>
    </div>
    <!-- end submit btn field -->
</form>


</div>



<?php

   }
   //if there is no such iD show error msg
   else
   {
    echo '<div class="container">';
    $theMsg= '<div class="alert alert-danger mt-5"> there is no such iD </div>';
    redirectHome($theMsg);
    echo '</div>';
   }



   






















 include $tpl."footer.php";
}else
{
  header('location: index.php');
  exit();
}     








