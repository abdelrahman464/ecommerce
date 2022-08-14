<?php
ob_start();
session_start();
include "init.php";

?>


<div class="container">
    
    <?php
    $tagname = $_GET['name'];
    if(isset($tagname)) {
        
        $getstmt=$con->prepare("SELECT * From items WHERE Tags LIKE '%$tagname%' AND Approve = 1");
        $getstmt->execute();
        $tagitems = $getstmt->fetchAll(); ?>
        <h1 class="text-center"><?php echo $_GET['name'] ?> </h1>
        <?php
        if(!empty($tagitems)){
        ?>
        <div class="row">
            <?php
            foreach($tagitems as $item)
            {
                ?>
            <div class="card col-sm-6 col-md-2 m-1 mt-4" style="width: 16rem;">
                <img class="card-img-top " height="80%" src="Admin\uploads\images\items\<?php if(!empty($item['Image'])){echo $item['Image'];}else{echo 'defalt.jpg';} ?>" alt="Card image cap">
                <div class="card-body itemCard">
                    <h5 class="card-title"> <a href="items.php?itemid=<?php echo $item['Item_ID']; ?>"> <?php echo $item['Name'] ?> </a></h5>
                    <span class="Price-tag"> <?php echo $item['Price'] ?> EGP</span>
                    <p class="card-text"><?php echo $item['Description'] ?></p>
                    <p class="itemDate"><?php echo $item['Add_Date'] ?></p>
                
                </div>
            </div>
                <?php
            }
            ?>
        </div>
        <?php
        }
        else
        {
            echo  '<div class="alert alert-info" >  There\' No Items To Show</div>';
        }
    }else
    {
        echo  '<div class="alert alert-info" > You Did Not Enter Tag name </div>';
    }
    ?>
</div>
    

<?php include $tpl.'footer.php';
ob_end_flush();
?> 