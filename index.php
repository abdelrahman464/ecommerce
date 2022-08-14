<?php
session_start();
$pageTitle='Home Page';
include "init.php";

?>

<div class="container">
    <h1 class="text-center">All Items</h1>
    <?php
    
    $items=getRecord("*","items","Item_ID","WHERE Approve = 1");
    if(!empty($items)){
    ?>
    <div class="row">
        <?php
        foreach($items as $item)
        {
            ?>
         <div class="card col-sm-6 col-md-2 m-1 mt-4" style="width:16rem;">
            <img class="card-img-top "height="80%" src="Admin\uploads\images\items\<?php if(!empty($item['Image'])){echo $item['Image'];}else{echo 'defalt.jpg';} ?>" alt="Card image cap">
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
    
    ?>
</div>






<?php
include $tpl.'footer.php'; 
?>