<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo getTitle() ?></title>

    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>Front.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&family=Roboto:wght@100;300;500&display=swap"
        rel="stylesheet">


</head>
<div class="upper-bar">
    <div class="container">
        <?php
            if(isset($_SESSION['user'])){
                ?>
                    
                <div class="nav-item dropdown d-flex flex-row ">
                    <?php 
                        $stmt = $con->prepare("SELECT Avatar FROM users WHERE UserID = ?");
                        $stmt->execute(array($_SESSION['uid']));
                        $Avatar = $stmt->fetch();
                        
                    ?>          
                    <img class="rounded-circle" src='Admin\uploads\images\avatar\<?php if(!empty($Avatar['Avatar'])){echo $Avatar['Avatar'];}else{echo 'defalt.jpg';} ?>' width="50" height="50"  alt="">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <?php echo $sessionUser ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profile.php"> Profile </a></li>
                        <?php
                        $status = checkUserStatus($sessionUser);
                        if($status ==1)
                        {
                            $msgg = "wating for approval";
                         }else{// user is not active
                        ?>
                        <li><a class="dropdown-item" href="profile.php#myads">My Items </a></li>
                        <li><a class="dropdown-item" href="newad.php"> New Item </a></li>
                        <?php
                        }
                        ?>
                        
                        <li><a class="dropdown-item" href="Logout.php"> Logout </a></li>
                    </ul>
                    <?php
                    if(isset($msgg)){
                        echo '<div class="wating-aprvomsg alert alert-info m-0">'.$msgg.'</div>';
                    }
                ?>
                </div>
                
               

    <?php

                $status = checkUserStatus($sessionUser);
                if($status ==1)
                {
                  // user is not active
                }
            }else{
        ?>

        <a class="btn btn-primary" href="Login.php"> Login</a>
        <a class="btn btn-success" href="Login.php"> Signup</a>

        <?php } ?>
    </div>

</div>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">Home Page</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav"
            aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fa-solid fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse " id="app-nav">
            <ul class="nav navbar-nav  navbar-right">
                <?php
                    foreach(getRecord('*','categories','ID','WHERE Visibility = 0 AND Parent = 0','ASC') as $cat){
                        
                ?>      
                        <li class="nav-item ">
                            <a class="nav-link " aria-current="page" 
                            href="categories.php?pageid=<?php echo $cat['ID'] ?>" >
                            <?php echo $cat['Name']; ?></a>
                        <?php
                        }
                            ?>
                <?php   ?>
                

            </ul>
        </div>
    </div>
</nav>