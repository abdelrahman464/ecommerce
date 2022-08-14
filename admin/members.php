<?php
/*
======================================================
==  manage members page
==  you can Add | Delete | Edit Members from here 
======================================================
*/ 


session_start();

$pageTitle  = 'Members';

if(isset($_SESSION['Username']))
{
    include "init.php"; 
     
    $do =isset($_GET['do'])?$_GET['do']:'Manage' ;

    // start manage page
    if($do == 'Manage')
    {
       
         //manage members page
         $query='';
         if(isset($_GET['page'])&& $_GET['page']=='pending')
         {
            $query=' AND RegStatus = 0 ';
         }
         if(isset($_GET['page'])&& $_GET['page']=='activated')
         {
            $query=' AND RegStatus = 1';
         }

         // select all users except admin who has id =1
        $stmt = $con->prepare(" SELECT * from users WHERE GroupID !=1 ".$query);
        $stmt->execute();

        // assign to variable 
        $rows = $stmt->fetchAll();

         if(!empty($rows)){
        ?>



<h1 class="text-center ">Manage Members </h1>
<div class="container">
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr>
                <td>#ID</td>
                <td>Avatar</td>
                <td>Username</td>
                <td>Fullname</td>
                <td>Email</td>
                <td>Registered Date</td>
                <td>Control</td>
            </tr>
            <?php

            foreach($rows as $row){

             


             ?>
            <tr>
                <td><?php echo $row['UserID']?></td>
                <td><img class="rounded-circle" src='uploads\images\avatar\<?php if(!empty($row['Avatar'])){echo $row['Avatar'];}else{echo 'defalt.jpg';} ?>' width="50" height="50"  alt=""></td>
                <td><?php echo $row['Username']?></td>
                <td><?php echo $row['FullName']?></td>
                <td><?php echo $row['Email']?></td>
                <td><?php echo $row['Date']?></td>
                <td>
                    <a href="members.php?do=Edit&UserID=<?php echo $row['UserID'];?>" class="btn btn-success"><i
                            class="fa fa-edit"></i> Edit</a>
                    <a href="members.php?do=Delete&UserID=<?php echo $row['UserID'];?>"
                        class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                    <?php if($row['RegStatus']==0)
                   {  ?>
                    <a href="members.php?do=Activate&UserID=<?php echo $row['UserID'];?>" class="btn btn-info"><i
                            class="fa fa-check"></i> Activate</a>
                    <?php
                   }
                   ?>
                </td>
            </tr>


            <?php 
            }

            ?>

        </table>
    </div>


    <a href="members.php?do=Add " class="botoon btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
    
</div>
            
        <?php }else{ echo ' <div class="container">
             <div class="alert alert-info mt-4"> There\' Is No Uusers To Show </div>';
           ?> <a href="members.php?do=Add " class="botoon btn btn-primary"><i class="fa fa-plus"></i> New Member</a><?php
        }
                    echo '</div> ';
        ?>

<?php
         
       
    }
    elseif($do == 'Add'){
        // add new member
        ?>
<h1 class="text-center ">Add New Member</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">

        <!-- start usernmae field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10 col-md-6">
                <div class="input-content">
                    <input required type="text" class="form-control form-control-lg" name="username" autocomplete="off"
                        placeholder="Username to Login Into Shop">
                </div>

            </div>
        </div>
        <!-- end usernmae field -->
        <!-- start Password field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10 col-md-6">
                <div class="input-content">
                    <input required type="Password" class="password form-control form-control-lg" name="password"
                        autocomplete="new-password" placeholder="Password must be Hard & Complex">
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
                    <input required type="Email" class="form-control form-control-lg" name="email" autocomplete="off"
                        placeholder="Email must be valid">
                </div>
            </div>
        </div>
        <!-- end email field -->
        <!-- start Full Name field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-10 col-md-6">
                <div class="input-content">
                    <input required type="text" class="form-control form-control-lg" name="full" autocomplete="off"
                        placeholder="Full Name apper in your Profile Page">
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
                            placeholder="Avatar apper in your Profile Page">
                </div>
            </div>
        </div>
        <!-- end Avatar field -->
        <!-- start submit btn field -->
        <div class="form-group row ">
            <div class="col-sm-offset-6 col-sm-6">
                <input type="submit" class="botoon btn btn-success " value="Add Member">
            </div>
        </div>
        <!-- end submit btn field -->
    </form>


</div>



<?php

    }elseif($do == 'Insert')
    {   
        // insert member page
       

        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            echo '<h1 class="text-center">Insert New Member</h1>';
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
            $exploded=explode('.', $avatarName );
            $endofarray=end($exploded );
            $avatarExtentions = strtolower($endofarray);
            
            
            
            //get variables from the form
            
            
                    $email  = $_POST['email'];
                    $user   = $_POST['username'];
                    $name   = $_POST['full'];
                    $pass   = $_POST['password'];
                    $hashpass = sha1($_POST['password']);
                    
                    // validate the form

                    $fromErrors = array();

                    if(strlen($user)<4 )
                    {
                        $fromErrors[]= ' Username can not be less than <strong> 4 chararcters </strong> </div>';
                    }
                    if(empty($user))
                    {
                        $fromErrors[]= 'Username can not be <strong>Empty</strong> </div>';
                    }
                    if(empty($pass))
                    {
                        $fromErrors[]= 'Password can not be <strong>Empty</strong> </div>';
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
                        if(!empty($avatarName)){
                            $avatar = rand(0,10000000).$user.'_'.$avatarName;
                            move_uploaded_file($avatarTmp_Name,"uploads\images\avatar\\".$avatar);
                        }else
                        {
                            $avatar = 'defalt.jpg';
                            move_uploaded_file($avatarTmp_Name,"uploads\images\avatar\\".$avatar);
                        }
                        // check if user exist in database
                        $check=checkItem("Username","users",$user);
                        if($check ==1)
                        {
                            $theMsg= '<div class="alert alert-danger">this Username =  <strong>'.$user.'</strong> Already exist' . '</div>';
                            redirectHome($theMsg,'back');
                        }else
                            {   
                                    //Insert user info into database  this info

                                $stmt = $con->prepare(" INSERT INTO
                                users(Username,Password,Email,FullName,RegStatus,Date,Avatar)
                            VALUES  
                                (:zuser,:zpass,:zmail,:zname,1,now(),:zavatar)
                                ");
                                            $stmt->execute(array(
                                            'zuser'      =>$user,
                                            'zpass'      =>$hashpass,
                                            'zmail'      =>$email,
                                            'zname'      =>$name,
                                            'zavatar'    =>$avatar

                            ));
                            // echo successful msg and redirect to previos page

                            $theMsg= '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Inserted' . '</div>';
                            redirectHome($theMsg,'back');
                            
                        }


                        }


                    

                }
                else
                {
                    echo '<div class="container">';
                    $theMsg = '<div class= "alert alert-danger mt-5">  Sorry You Can Not Browes This Page Directly </div>';
                    redirectHome($theMsg);
                    echo '</div>';
                }

        echo '</div>';
    }

    elseif($do == 'Edit')
    {
        // check if get requestis numeric & get the intger value of it
        $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID'])? intval($_GET['UserID']): 0 ;
        // select all data depent on this iD
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? Limit 1 ");
        // execute query
        $stmt->execute(array($userid));
        // fetch the data from the database
        $row = $stmt->fetch();
        // row count 
        // if there is this iD or no
        $count = $stmt->rowCount();
        // if there is id show the from 
        if($stmt->rowCount() > 0)
        {
        // Edite page
        ?>
<h1 class="text-center ">Edit Member</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="userid" value="<?php echo $userid ?>">
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
                <div class="input-content"
                >
                   
                            <input  type="file"
                            class="form-control form-control-lg"
                            name="avatar"
                            value="<?php echo $row['Avatar']; ?>"
                            >
                </div>
            </div>
        </div>
        <!-- end Avatar field -->
        <!-- start submit btn field -->
        <div class="form-group row ">
            <div class="col-sm-offset-6 col-sm-6">
                <input type="submit" class="botoon btn btn-success  " value="Save">
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
    }
    elseif($do == 'Update')// update page
    {   
       

        if($_SERVER['REQUEST_METHOD']=='POST')
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
                $us=$stmt2->fetch();
                $count= $stmt2->rowCount();


                if($count==1)
                {
                    $theMsg= '<div class="alert alert-danger">this Username =  <strong>'.$user.'</strong> Already exist' . '</div>';
                    redirectHome($theMsg,'back');
                }else
                {       

                    
                        $avatar = rand(0,10000000).$user.'_'.$avatarName;
                        move_uploaded_file($avatarTmp_Name,"uploads\images\avatar\\".$avatar);
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
        else
        {
              echo '<div class="container">';
                    $theMsg =' <div class="alert alert-danger mt-5">Sorry You Can Not Browes This Page Directly </div>';
                    redirectHome($theMsg);
              echo '</div>';

        }

        echo '</div>';
    }elseif($do =='Activate'){
        // Activate memeber page
        echo '<h1 class="text-center">Activate Member</h1>';
        echo '<div class="container">';
         // check if get requestis numeric & get the intger value of it
         $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID'])? intval($_GET['UserID']): 0 ;
         // select all data depent on this iD
         $check=checkItem("UserID","users", $userid);
        
        
         // if there is id show the from 
         if($check > 0)
         {  
            $stmt =$con->prepare('UPDATE users SET RegStatus =1 WHERE UserID = ?');
            $stmt->execute(array($userid));
            $theMsg=  '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Activated' . '</div>';
            redirectHome($theMsg,'back');
         }else{
            $theMsg= '<p class="alert alert-danger"> this iD is not exist</p>';
            redirectHome($theMsg);
         }
         echo '</div>';
    }
    elseif($do == 'Delete')
    {
        // Delete memeber page
        echo '<h1 class="text-center">Delete Member</h1>';
        echo '<div class="container">';
         // check if get requestis numeric & get the intger value of it
         $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID'])? intval($_GET['UserID']): 0 ;
         // select all data depent on this iD
         $check=checkItem("UserID","users", $userid);
        
        
         // if there is id show the from 
         if($check > 0)
         {  
            $stmt =$con->prepare('DELETE FROM users WHERE UserID = :zuser');
            $stmt->bindParam(':zuser',$userid);
            $stmt->execute();
            $theMsg=  '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Deleted' . '</div>';
            redirectHome($theMsg,'back');
         }else{
            $theMsg= '<p class="alert alert-danger"> this iD is not exist</p>';
            redirectHome($theMsg);
         }
         echo '</div>';
    }

    
    include $tpl."footer.php";
}else
{
  header('location: index.php');
  exit();
}