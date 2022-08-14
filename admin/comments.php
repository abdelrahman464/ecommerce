<?php
/*
======================================================
==  manage comments page
==  you can Approve | Delete | Edit comment from here 
======================================================
*/ 

ob_start(); // output buffering start
session_start();

$pageTitle  = 'Comments';

if(isset($_SESSION['Username']))
{
    include "init.php"; 
     
    $do =isset($_GET['do'])?$_GET['do']:'Manage' ;

    // start manage page
    if($do == 'Manage')
    {
       
         //manage comment page
        
        $stmt = $con->prepare(" SELECT
                                     comments.* ,items.Name AS itemname,users.Username AS username
                                FROM comments
                                INNER JOIN items
                                ON comments.item_id = items.Item_ID
                                INNER JOIN users
                                ON comments.user_id = users.UserID");
        $stmt->execute();

        // assign to variable 
        $rows = $stmt->fetchAll();
        
        if(!empty($rows)){

        ?>



<h1 class="text-center ">Manage Comments </h1>
<div class="container">
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr>
                <td>ID</td>
                <td>Comment</td>
                <td>Username</td>
                <td>Item</td>
                <td>Added Date</td>
                <td>Control</td>
            </tr>
            <?php
            foreach($rows as $row){
             ?>
            <tr>
                    <td><?php echo $row['C_ID']?></td>
                    <td><?php echo $row['Comment']?></td>
                    <td><?php echo $row['username']?></td>
                    <td><?php echo $row['itemname']?></td>
                    <td><?php echo $row['Comment_Date']?></td>
                    <td>
                        <a href="comments.php?do=Edit&comid=<?php echo $row['C_ID'];?>" class="btn btn-success"><i
                                class="fa fa-edit"></i> Edit</a>
                        <a href="comments.php?do=Delete&comid=<?php echo $row['C_ID'];?>"
                            class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                        <?php if($row['Status']==0)
                                      {  ?>
                                           <a href="comments.php?do=Approve&comid=<?php echo $row['C_ID'];?>" class="btn btn-info"><i
                                                 class="fa fa-check"></i> Approve</a>
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
</div>  
   
        <?php }else{ echo ' <div class="container">';
            $theMsg= ' <div class="alert alert-info mt-4"> There\' Is No Comments To Show </div>';
                    redirectHome($theMsg);}
                    echo '</div> ';?>
    

<?php
   
    }
    elseif($do == 'Edit')
    {
        // check if get requestis numeric & get the intger value of it
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']): 0 ;
        // select all data depent on this iD
        $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ? ");
        // execute query
        $stmt->execute(array($comid));
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
<h1 class="text-center ">Edit Comment</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="comid" value="<?php echo $comid ?>">
        <!-- start comment field -->
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Comments</label>
            <div class="col-sm-10 col-md-6">
                <div class="input-content">
                    <textarea name="comment" class="form-control"><?php echo $row['Comment'] ?></textarea>
                </div>
            </div>
        </div>
        <!-- end comment field -->
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
            echo '<h1 class="text-center">Update Comment</h1>';
            echo '<div class="container">';
            //get variables from the form
            $comId     = $_POST['comid'];
            $comment   = $_POST['comment'];
           
            
           
 
          
                //update the database with this info

                $stmt = $con->prepare(' UPDATE comments SET Comment=?  WHERE C_ID=?');
                $stmt->execute(array($comment,$comId));

                // echo successful msg and redirect to previos page

                $theMsg = '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Updated' . '</div>';
                redirectHome($theMsg,'back');
          
        }
        else
        {
              echo '<div class="container">';
                    $theMsg =' <div class="alert alert-danger mt-5">Sorry You Can Not Browes This Page Directly </div>';
                    redirectHome($theMsg);
              echo '</div>';

        }

        echo '</div>';
    }elseif($do =='Approve'){
        // Activate memeber page
        echo '<h1 class="text-center">Approve Comment</h1>';
        echo '<div class="container">';
         // check if get requestis numeric & get the intger value of it
         $comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']): 0 ;
         // select all data depent on this iD
         $check=checkItem("C_ID","comments", $comid);
        
        
         // if there is id show the from 
         if($check > 0)
         {  
            $stmt =$con->prepare('UPDATE comments SET Status =1 WHERE C_ID = ?');
            $stmt->execute(array($comid));
            $theMsg=  '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Approved' . '</div>';
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
        echo '<h1 class="text-center">Delete Comment</h1>';
        echo '<div class="container">';
         // check if get requestis numeric & get the intger value of it
         $comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']): 0 ;
         // select all data depent on this iD
         $check=checkItem("C_ID","comments", $comid);
        
        
         // if there is id show the from 
         if($check > 0)
         {  
            $stmt =$con->prepare('DELETE FROM comments WHERE C_ID = :zcid');
            $stmt->bindParam(':zcid',$comid);
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
ob_end_flush();
?>