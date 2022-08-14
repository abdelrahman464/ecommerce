<?php
ob_start();
session_start();
$pageTitle='Show Items';
include "init.php";

$itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval(($_GET['itemid'])):0;

$stmt = $con->prepare("SELECT items.*,categories.Name AS catname,users.Username AS username,users.Avatar AS Avatar FROM items 
                       INNER JOIN categories 
                             ON categories.ID = items.Cat_ID
                       INNER JOIN users 
                             ON items.Member_ID  = users.UserID
                                
                                WHERE
                                     Item_ID = ?
                                AND 
                                    Approve = 1
                                    ");

$stmt->execute(array($itemid));

$items = $stmt->fetch();

$count = $stmt->rowCount();

if($count >0)
{

?>


<h1 class="text-center"> <?php echo $items['Name']; ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card ">
            <img class="card-img-top" src="Admin\uploads\images\items\<?php if(!empty($items['Image'])){echo $items['Image'];}else{echo 'defalt.jpg';} ?>" alt="Card image cap">
            </div>
        </div>
        <div class="col-md-9 itemshow">
            <ul class="list-group" > 
                <h2 class="mb-4 "><?php echo $items['Name'] ?></h2>
                <li class="list-group-item">
                    <div> <span>Description </span>: <?php echo $items['Description'] ?></div>
                </li>
                <li class="list-group-item">
                    <div><span>Add_Date </span>: <?php echo $items['Add_Date'] ?></div>
                </li>
                <li class="list-group-item">
                    <div><span>Price </span>: <?php echo $items['Price'] ?> EGP</div>
                </li>
                <li class="list-group-item">
                    <div><span>Made In </span>:  <?php echo $items['Country_Made'] ?></div>
                </li>
                <li class="list-group-item">
                    <div><span>Category </span>:  <?php echo $items['catname'] ?></div>
                </li>
                <li class="list-group-item">
                    <div> <span>Added by </span>: <?php echo $items['username'] ?></div>
                </li>
                <li class="list-group-item">
                    <div> <span>Tags </span>: 
                    <?php
                        $alltags = explode(",",$items['Tags']);
                        foreach($alltags as $tag)
                        {
                            $tag = str_replace(" ", "",$tag);
                            $lowertag = strtolower($tag);
                            if(!empty($tag)){
                            ?>
                            <a class="btn btn-secondary btn-sm m-1" href="tags.php?name=<?php echo $lowertag ?>"><?php echo $tag ?></a>
                            <?php
                            }
                        }
                    
                    
                    ?>
                </div>
                </li>
            </ul>    
        </div>
    </div>
    <hr class="mt-4">
</div>

    
<div class="container mt-5 comment-box">
    <div class="d-flex justify-content-center row ">
        <div class="col-md-12">
            <div class="d-flex-column-center comment-section">
                <div class=" p-2 mb-3 ">
                    <div class="info-box">
                        <div class="d-flex flex-row user-info "><img  class="rounded-circle" src='Admin\uploads\images\avatar\<?php if(!empty($items['Avatar'])){echo $items['Avatar'];}else{echo 'defalt.jpg';} ?>' width="60" alt="">
                            <div class="d-flex flex-column justify-content-start ml-2">
                                <span class="d-block font-weight-bold name"><?php echo $items['username']?></span>
                                <span class="data text-black-50">shared publicly - <?php echo $items['Add_Date']?></span>
                            
                    
                        </div>
                        </div>
                        <div class="description">
                            <div class="mt-3">
                                <p class="comment-text"> [ <?php echo $items['Name']?> ] </p>
                                <p class="comment-text"> <?php echo $items['Description']?> </p>
                            </div>
                            </div>
                        </div>
                </div>
            <?php 
                $stmt = $con->prepare("SELECT  comments.* ,users.UserID,users.Username AS member ,users.Avatar AS Avatar 
                                       FROM comments
                                       INNER JOIN users
                                       ON comments.user_id = users.UserID
                                       WHERE item_id  = ?
                                       AND Status = 1
                                       ORDER BY C_ID DESC
                                        ");
                           
                $stmt->execute(array($items['Item_ID']));
                $comments = $stmt->fetchAll();
                if(!empty($comments)){

                foreach($comments as $com){
            ?>
                <div class=" p-2 mb-3 ">
                    <div class="info-box">
                        <div class="d-flex flex-row user-info "><img class="rounded-circle" src='Admin\uploads\images\avatar\<?php if(!empty($com['Avatar'])){echo $com['Avatar'];}else{echo 'defalt.jpg';} ?>' width="60" alt="">
                            <div class="d-flex flex-column justify-content-start ml-2">
                                <span class="d-block font-weight-bold name"><?php echo $com['member']?></span>
                                <span class="data text-black-50"><?php echo $com['Comment_Date']?></span>
                        </div>
                        </div>
                        <div class="description">
                            <textarea disabled class="form-control ml-1 shadow-none textarea comment-text">
                                <?php echo $com['Comment']?>
                            </textarea>
                        </div>
                </div>
            <?php }}else{
                echo '<div class="alert alert-info"> No Comment In '. $items['Name'].' </div>'; 
            }
            ?>



            <?php 
                                            //add comment
                                            $status = checkUserStatus($sessionUser);
                                            if($status ==1)
                                            {}else{                         
            if(isset($_SESSION['user'])) {?>
                <div class=" p-2">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>?itemid=<?php echo $items['Item_ID'] ?>" method="POSt">
                    <div class=" p-2 mb-3 ">
                        <div class="info-box">
                            <div class="d-flex flex-row user-info ">
                                <img class="rounded-circle" 
        src='Admin\uploads\images\avatar\<?php if(!empty($items['Avatar'])){echo $items['Avatar'];}else{echo 'defalt.jpg';} ?>' width="60" alt="">
                                <div class="d-flex flex-column justify-content-start ml-2">
                                    <span class="d-block font-weight-bold name"><?php echo $_SESSION['user']?></span>
                                    
                            </div>
                            </div>
                            <div class="d-flex flex-row align-items-start description ">
                                <textarea required name="comment" class="form-control ml-1 shadow-none textarea comment-text"></textarea>
                                
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-primary btn-sm shadow-none" type="submit">Post Comment</button>
                            </div>
                            
                                
                        </div>
                    </div>

                </form>
                    <?php
                        if($_SERVER['REQUEST_METHOD']=='POST'){
                            $comment = $_POST['comment'] ;
                            $userid  = $_SESSION['uid'];
                            $itemid  = $items['Item_ID'];

                            if(!empty($comment))
                            {
                                $stmt =$con->prepare(" INSERT INTO
                                                             comments ( Comment,Status,Comment_Date,item_id, user_id)
                                                        VAlUES (:zcom,0,now(),:zitemid,:zuserid)
                                                    ");
                                $stmt->execute(array(
                                    'zcom'    => $comment,
                                    'zitemid' => $itemid,
                                    'zuserid' => $userid
                                   
                                ));

                                if($stmt){
                                    echo '<div class="alert alert-success"> Comment Added </div>';
                                  
                                }

                            }else
                            {
                                echo '<div class="alert alert-danger"> Comment Is Empty </div>';
                            }

                        }
                    ?>
            <?php }else{
                echo '<div class="alert alert-info">  <a class="btn btn-primary btn-sm" href="Login.php">Login</a> Or <a class="btn btn-success btn-sm" href="Login.php">Register</a> To Add Comment </div>';
            }}
                     ?>
            </div>
        </div>
    </div>
</div>





<?php
}else
{
    echo '<div class="container">
    <div class="alert alert-danger mt-3">There\'s No Such ID or This Item Wating For Approval</div>
    </div>';
}


include $tpl.'footer.php'; 
ob_end_flush();
?>