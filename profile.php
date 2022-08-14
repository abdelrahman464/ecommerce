<?php
session_start();
$pageTitle='Profile';
include "init.php";

if(isset($_SESSION['user']))
{
    $getstmt=$con->prepare("SELECT * FROM users WHERE Username = ?");
    $getstmt->execute(array($sessionUser));
    $rows = $getstmt->fetch();
    
?>


<h1 class="text-center"> Welcom <?php echo $_SESSION['user']; ?></h1>

<div class="container text-center">
    
        <img class="rounded-circle " src='Admin\uploads\images\avatar\<?php if(!empty($rows['Avatar'])){echo $rows['Avatar'];}else{echo 'defalt.jpg';} ?>' width="200" height="200"  alt="">
   
</div>                   

<div class=" mt-4">
    <div class="container">
    <div class="row ">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i>
                       My information
                    </div>
                    <div class="card-body information">
                        <ul class="list-group" >
                                    <li class="list-group-item">
                                        <i class="fa fa-unlock-alt fa-fw"></i>
                                         <span>Name</span> : <?php echo $rows['Username']; ?>
                                    </li>
                                    <li class="list-group-item"> 
                                         <i class="fa fa-envelope-o fa-fw"></i>
                                        <span>Email</span> : <?php echo $rows['Email']; ?>
                                    </li>
                                    <li class="list-group-item"> 
                                        <i class="fa fa-user fa-fw"></i>
                                        <span>Full Name</span> : <?php echo $rows['FullName']; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-calendar fa-fw"></i>
                                         <span>Date</span> : <?php echo $rows['Date']; ?>
                                    </li>
                        </ul> 
                        <?php
                            $status = checkUserStatus($sessionUser);
                            if($status ==1)
                            {
                            }else
                            {
                                ?>
                                <a href="editProfile.php" class="btn btn-primary editbtn botoon">Edit Profile</a> 
                                <?php
                            }
                        ?>
                         

                    </div>
                 </div>
            </div>


    
        <?php
        // if the user not approved
            $status = checkUserStatus($sessionUser);
            if($status ==1)
            {

            }else
            {

           

        ?>

    <div class="container">
        <div class="row mt-3" id="myads" >    
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i>
                       My items
                    </div>
                    <div class="card-body information" >
                        <?php
                           // $items= getitems("*","items","Member_ID",$rows['UserID']);
                            $getstmt=$con->prepare('SELECT * FROM items WHERE Member_ID = ? ' );
                            $getstmt->execute(array($rows['UserID']));
                            $items = $getstmt->fetchAll();


                            
                            if(!empty($items)){
                        ?>
                        <div class="row">
                         <?php
                        
                        foreach($items as $item)
                        {
                            ?>

                        <div  class="card col-sm-6 col-md-4 m-2 " style="width: 18rem;">
                            
                                <img height="80%" class="card-img-top" src="Admin\uploads\images\items\<?php if(!empty($item['Image'])){echo $item['Image'];}else{echo 'defalt.jpg';} ?>" alt="Card image cap">
                                <?php if($item['Approve']==0){
                                    ?>
                                        <div class=" notapproved">waiting Approval</div>
                                <?php
                                } ?>
                                
                                <div class="card-body itemCard">
                                    <h5 class="card-title"> <a href="items.php?itemid=<?php echo $item['Item_ID']; ?>"> <?php echo $item['Name'] ?></a></h5>
                                    <span class="Price-tag"><?php echo $item['Price'] ?> EGP</span>
                                    <p class="card-text "><?php echo $item['Description'] ?></p>
                                    <p class="itemDate"><?php echo $item['Add_Date'] ?></p>
                                   
                                </div>
                                
                        </div>
                            <?php
                        }
                        ?>

                        
                    </div>
                    </div>
                    <?php
                            }else
                            {
                                echo '<div class="alert alert-info" style="width:35%;">There\'s No ad to show 
                                
                                 </div>
                                 <a class="btn btn-primary creattbtn botoon"href="newad.php">Create New </a>';
                            }
                    ?>
                 </div>
              </div>
            </div>
        </div>
        </div>



    <div class="container">                 
        <div class="row mt-3">    
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i>
                       My Comments
                    </div>
                    <div class="card-body">
                        <?php
                            $coms= getitems("*","comments","user_id",$rows['UserID']);
                            if(!empty($coms)){
                        ?>
                        
                         
                            
                                <tr>
                                    <?php
                                    foreach($coms as $com){
                                        ?>
                                   <div class="bg-light p-2">
                                        <div class="d-flex flex-row align-items-start">
                                            <img class="rounded-circle" src='Admin\uploads\images\avatar\<?php if(!empty($rows['Avatar'])){echo $rows['Avatar'];}else{echo 'defalt.jpg';} ?>' width="40" alt="">
                                            <textarea class="form-control ml-1 shadow-none textarea"><?php echo $com['Comment']; ?></textarea></div>
                                    </div>
                                        <?php } ?>
                                </tr>
                               

                     

                        
                    </div>
                    <?php
                            }else
                            {
                                echo '<div class="alert alert-info" style="width:35%;">There\'s No comments </div>';
                            }
                    ?>
                 </div>
              </div>
            </div>
        </div>
    </div>
</div>

</div>       


<?php
}
}else
{
    header("Location: Login.php");
    exit();
}


include $tpl.'footer.php'; 