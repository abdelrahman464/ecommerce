<?php 
session_start();
$pageTitle='Login';
if(isset($_SESSION['user'])){
    header('Location: index.php');
}


include "init.php";

if($_SERVER['REQUEST_METHOD']=='POST')
{

    if(isset($_POST['login'])){
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashedpass = sha1($pass);

          $stmt = $con->prepare("SELECT UserID,Username,Password FROM users WHERE Username=? AND Password = ?");
          $stmt->execute(array($user,$hashedpass));
          $get = $stmt->fetch();
          $count = $stmt->rowCount();

            if($count >0)
            {
                
                $_SESSION['user'] = $user; // regitser session name
                $_SESSION['uid'] = $get['UserID']; // regitser user id in session

                 header("Location: index.php");
                exit();
            }
    }else
    {
      $fromErrors=array();

      $username     = $_POST['username'];
      $mail         = filter_var( $_POST['email'],FILTER_SANITIZE_EMAIL);
      $pass         = $_POST['password'];
      $hashedpass   = sha1($pass);
      $fullname     = $_POST['fullname'];





      // valid the username 
      if(isset($username))
      {
        $filteredusername = filter_var($username, FILTER_SANITIZE_EMAIL);
    
        if(strlen($filteredusername)<4){
          $fromErrors[]="Username = ".$filteredusername." must be larger than 4 characters";
        }

      }

      // valid the password must match confirm passowrd field
      if(isset($pass)&& isset($pass))
      {
        if(empty($pass))
        {
          $fromErrors[]=" Password cant be empty";
        }


        $pass1 = sha1($pass);
        $pass2 = sha1($_POST['password-again']);
        if($pass1 !== $pass2){
          $fromErrors[]=" Password Is Not Match";
        }

      } 

      // valid the email
      if(isset($mail))
      {
       
        $filteredemail = filter_var($mail, FILTER_SANITIZE_EMAIL);
    
        if( filter_var($filteredemail,FILTER_VALIDATE_EMAIL )!= true ){
          $fromErrors[]="This Email Is Not Valid";
        }


      } 



      // if $fromErrors empty i will put the data into data base
      if(empty($fromErrors)){

        // check if username exist in database if $check=1 this mean this user exist if $check = 0 i will insert in database
        $check = checkItem("Username","users",$username);
        if($check == 1 )
        {
          $fromErrors[]="This Username Is Exist";
        }else
        {
          $stat = $con->prepare(" INSERT INTO 
                                      users (Username , FullName ,Email, Password, RegStatus, Date )
                                  VALUES
                                            (:zuser,:zfulo,:zmail,:zpass,0,now() )");
          $stat->execute(array(
              "zuser"    => $username,
              "zfulo"    => $fullname,
              "zmail"    => $mail,
              "zpass"    => $hashedpass 
              
          ));
          // echo successMsg

          $successMsg = "Congrats You Are One Of Us Now";


        }



      }





    }

}






?>

<div class="contaienr login-page">
    <h1 class="text-center ">
        <span class="selectted" data-class="login">Login</span> | <span data-class="signup">Signup</span>
    </h1>
<!-- start login page -->

<section class="login text-center text-lg-start mt-5" >
  <style>
    .rounded-t-5 {
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }

    @media (min-width: 992px) {
      .rounded-tr-lg-0 {
        border-top-right-radius: 0;
      }

      .rounded-bl-lg-5 {
        border-bottom-left-radius: 0.5rem;
      }
    }
  </style>
  <div class="card mb-3">
    <div class="row g-0 d-flex align-items-center">
      <div class="col-lg-4 d-none d-lg-flex">
        <img src="test.jpg" alt="Trendy Pants and Shoes"
          class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
      </div>
      <div class="col-lg-8">
        <div class="card-body py-5 px-md-5">

          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <!-- Email input -->
            <h2 class="fw-bold  mb-5 ">Login</h2>
            <div class="form-outline mb-4">
              <input type="text" id="form2Example1" class="form-control" name="username" autocomplete="off" />
              <label class="form-label" for="form2Example1">Username</label>
            </div>
            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="form2Example2" class="form-control" name="password" autocomplete="new-password" />
              <label class="form-label" for="form2Example2">Password</label>
            </div>

            

            <!-- Submit button -->
            <button name="login" type="submit" class="btn btn-primary btn-block mb-4 botoon btn-lg">Sign in</button>

          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- end login page -->





<!-- start sign up page -->
<section class="text-center text-lg-start signup" >
  <style>
    .cascading-right {
      margin-right: -50px;
    }

    @media (max-width: 991.98px) {
      .cascading-right {
        margin-right: 0;
      }
    }
  </style>

  <!-- Jumbotron -->
  <div class="container py-4">
    <div class="row g-0 align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <div class="card cascading-right" style="
            background: hsla(0, 0%, 100%, 0.55);
            backdrop-filter: blur(30px);
            ">
          <div class="card-body p-5 shadow-5 text-center">
            <h2 class="fw-bold mb-5">Sign up now</h2>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
              <!-- 2 column grid layout with text inputs for the first and last names -->
              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <div class="input-content">
                    <input 
                            pattern=".{4,12}"
                            title="Username Must be between 4 And 12 Chars"
                            required  
                            type="text"
                            id="form3Example1"
                            class="form-control"
                            autocomplete="off"
                            name="username"
                            placeholder="Usernaem to Login"
                            />
                    </div>
                    <label class="form-label" for="form3Example1"> Username</label>
                  </div>
                </div>
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" id="form3Example2" class="form-control" name="fullname" placeholder="triple name" />
                    <label class="form-label" for="form3Example2">Full name</label>
                  </div>
                </div>
              </div>

              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="email" id="form3Example3" class="form-control" name="email" placeholder="valid email"/>
                <label class="form-label" for="form3Example3">Email address</label>
              </div>

              <!-- Password input -->
              <div class="form-outline mb-4">
              <div class="input-content">
                <input 
                      minlength="8"
                      type="password"
                      autocomplete="new-password" 
                      id="form3Example4"
                      class="form-control password" 
                      name="password" 
                      placeholder=" Complex Password" 
                      required/>
                <i class="show-pass fa fa-eye"></i>
              </div>  
                <label class="form-label" for="form3Example4">Password</label>
              </div>
               <!-- Password again -->
               <div class="form-outline mb-4">
               <div class="input-content">
                <input    minlength="8"
                          required 
                          type="password" 
                          id="form3Example4"
                          autocomplete="new-password"
                          class="form-control" 
                          name="password-again" 
                          placeholder=" Your Password Again" />
                
               </div>
                <label class="form-label" for="form3Example4">confirm Password</label>
              </div>

              <!-- Checkbox -->
              <div class="form-check d-flex justify-content-center mb-4">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                <label class="form-check-label" for="form2Example33">
                  Subscribe to our newsletter
                </label>
              </div>

              <!-- Submit button -->
              <button type="submit" name="signup" class="btn btn-primary btn-block mb-4 botoon">
                Sign up
              </button>

            
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0">
        <img src="test.jpg" class="w-100 rounded-4 shadow-4"
          alt="" />
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</section>
<!-- end sign up page -->
</div>


<div class="container">
  <div class="text-center">
    <?php
      if(!empty($fromErrors))
      {
        foreach($fromErrors as $error){
          echo '<div class="alert alert-danger">'.$error.'</div>';
        }
      }
      
      if(isset($successMsg)){
        echo '<div class="alert alert-success">'.$successMsg.'</div>';
      }
    ?>
  </div>
</div>


<?php include $tpl.'footer.php';?>