<?php

ob_start(); // output buffering start

session_start();

if(isset($_SESSION['Username']))
{
  $pageTitle  = 'Dashboard';
  include "init.php";
  /*start dashboard page*/ 
      // variable have the number of latest users i will show in dashboar
        $LatesetUsercount=6;
        // function to get the latest users and assign it to variabl
        $theLatestUsers = getLatest("*","users","UserID",$LatesetUsercount,"WHERE GroupID !=1");
         // variable have the number of latest items i will show in dashboar
         $LatesetItemcount=6;
         // function to get the latest items and assign it to variabl
         $theLatestItems = getLatest("items.Item_ID,
                                    items.Add_Date,
                                    items.Approve,
                                    items.Name AS itemname,
                                    categories.Name AS catname,
                                    users.Username AS username",
                                    "items",
                                    "Item_ID",$LatesetItemcount,
         "inner join categories ON categories.ID = items.Cat_ID
         inner join users ON users.UserID = items.Member_ID");
         
         // variable have the number of latest comments i will show in dashboar
         $LatesetComcount=6;
         // function to get the latest comments and assign it to variabl
         $theLatestComments = getLatest(" users.Username AS username,users.Avatar AS Avatar ,comments.*",
                                    "comments",
                                    "C_ID",$LatesetComcount,
         "inner join users ON users.UserID = comments.user_id
            ");?>
         
         
         
         
       







<div class="home-stats">
    <div class="container text-center">
        <h1><?php echo lang('DASHBOARD'); ?></h1>
        
        <div class="row">
            <div class="col-md-2">
                <div class="stat st-members">
                    <i class="fa fa-users fa-2x" ></i>
                         Total Members
                 
                         <a
                        href="members.php?do=Manage&page=activated">
                                <span><?php echo countItems("UserID","users",'WHERE RegStatus = 1'); ?></span></a>
                   
              </div>
            </div>
            <div class="col-md-2">
                <div class="stat st-pendings">
                <i class="fa fa-user-plus fa-2x" ></i>
                    Pending Members
                    <a href="members.php?do=Manage&page=pending">
                             <span><?php echo countItems("UserID","users",'WHERE RegStatus = 0'); ?> </span></a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat st-items">
                <i class="fa fa-tag fa-2x" ></i>
                    Total Items
                   <a href="items.php?do=Manage&page=Approved">
                             <span><?php echo countItems("Item_ID","items",'WHERE Approve = 1'); ?></span></a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat st-items">
                <i class="fa fa-tag fa-2x" ></i>
                    Pending Items
                   <a href="items.php?do=Manage&page=Pending">
                             <span><?php echo countItems("Item_ID","items",'WHERE Approve = 0'); ?></span></a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat st-comments">
                <i class="fa fa-comment fa-2x" ></i>
                    Total Comments
                    <a href="comments.php?do=Manage">
                             <span><?php echo countItems("C_ID","comments"); ?></span></a>
               
                    
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat st-comments">
                <i class="fa fa-comment fa-2x" ></i>
                    Total Comments
                    <span>0 </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="latest">
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i>
                        Latest <?php echo $LatesetUsercount;?> Registered Users
                    </div>
                    <div class="card-body">

                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Registered Date</th>
                                    <th scope="col">Control</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                    // loop to show the latest users
                                    
                                    foreach($theLatestUsers as $user)
                                    {?>
                                <tr>
                                    <td><?php echo $user['Username'];?> </td>
                                    <td><?php echo $user['Email'];?> </td>
                                    <td><?php echo $user['Date'];?> </td>
                                    <td>
                                        <a href="members.php?do=Edit&UserID=<?php echo $user['UserID'];?>"
                                            class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="members.php?do=Delete&UserID=<?php echo $user['UserID'];?>"
                                            class="btn btn-danger confirm"><i class="fa fa-close"></i></a>
                                        <?php if($user['RegStatus']==0)
                   {  ?>
                                        <a href="members.php?do=Activate&UserID=<?php echo $user['UserID'];?>"
                                            class="btn btn-info"><i class="fa fa-check"></i></a>
                                        <?php
                   }

                   
                   ?>
                                    </td>

                                </tr>
                                <?php
                                    }   
                                     ?>



                            </tbody>
                        </table>

                        <?php 
                           
                        


                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i>
                        Latest <?php echo $LatesetItemcount;?> Items Add By Users
                    </div>
                    <div class="card-body">
               <?php     if(!empty($theLatestItems)){?>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Control</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                    // loop to show the latest users
                                    foreach($theLatestItems as $item)
                                    {?>
                                <tr>
                                    <td><?php echo $item['itemname'];?> </td>
                                    <td><?php echo $item['catname'];?> </td>
                                    <td><?php echo $item['username'];?> </td>
                                    <td><?php echo $item['Add_Date'];?> </td>
                                    <td>
                                        <a href="items.php?do=Edit&itemid=<?php echo $item['Item_ID'];?>"
                                            class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="items.php?do=Delete&itemid=<?php echo $item['Item_ID'];?>"
                                            class="btn btn-danger confirm"><i class="fa fa-close"></i></a>
                                        <?php if($item['Approve']==0)
                   {  ?>
                                        <a href="items.php?do=Approve&itemid=<?php echo $item['Item_ID'];?>"
                                            class="btn btn-info"><i class="fa fa-check"></i></a>
                                        <?php
                   }

                   
                   ?>
                                    </td>

                                </tr>
                                <?php
                                    }   
                                     ?>



                            </tbody>
                        </table>

                        <?php 
                           
                        


                        ?>
                    </div>
                    <?php }else{echo ' <div class="alert alert-info "> There\' Is No Items To Show </div>';}?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i>
                        Latest <?php echo $LatesetComcount;?> Comments by Users
                    </div>
                   
                <div class="card-body">
                <?php     if(!empty($theLatestComments)){?>
                        <table class="table">                           
                            <tbody>
                                <?php
                                    // loop to show the latest users
                                    foreach($theLatestComments as $com)
                                    {?>
                                <tr>
                                    <td>
                                    <div class="comment-box">
                                            <div class=" p-2 mb-3 ">
                                        <div class="info-box">
                                            <div class="d-flex flex-row user-info "><img class="rounded-circle" src="uploads\images\avatar\<?php if(!empty($com['Avatar'])){echo $com['Avatar'];}else{echo 'defalt.jpg';} ?>" width="50" height="50" alt="">
                                                <div class="d-flex flex-column justify-content-start ml-2">
                                                    <span class="d-block font-weight-bold name"><?php echo $com['username']?></span>
                                                    <span class="data text-black-50"><?php echo $com['Comment_Date']?></span>
                                            </div>
                                            </div>
                                            <div class="description">
                                                <textarea disabled class="form-control ml-1 shadow-none textarea comment-text">
                                                    <?php echo $com['Comment']?>
                                                </textarea>
                                            </div>
                                    </div>
                                    </div>
                                     </td>
                                    
                                   
                                    <td>
                                        <a href="comments.php?do=Edit&comid=<?php echo $com['C_ID'];?>"
                                            class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="comments.php?do=Delete&comid=<?php echo $com['C_ID'];?>"
                                            class="btn btn-danger confirm"><i class="fa fa-close"></i></a>
                                        <?php if($com['Status']==0)
                                        {  ?>
                                        <a href="comments.php?do=Approve&comid=<?php echo $com['C_ID'];?>"
                                            class="btn btn-info"><i class="fa fa-check"></i></a>
                                        <?php
                                            }

                   
                   ?>
                                    </td>

                                </tr>
                                <?php
                                    }   
                                     ?>



                            </tbody>
                        </table>

                        <?php 
                           
                        


                        ?>
                    </div>
                </div>
            </div>
            <?php }else{echo ' <div class="alert alert-info "> There\' Is No Items To Show </div>';}?>
              
        </div>
        
    </div>
</div>


<?php
  /*end dashboard page*/ 
  include $tpl."footer.php";
}else
{
  header('location: index.php');
  exit();
}



ob_end_flush();
?>