<?php
ob_start();
session_start();
include "init.php";

?>


<div class="container">
    <h1 class="text-center">show category Items </h1>
    <?php
    $catid = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']): 0 ;  
    $items=getRecord("*","items","Item_ID","WHERE Cat_ID = ".$catid. " AND Approve = 1 ");
    $items2=getRecord("*","items","Item_ID","inner join categories 
    on items.Cat_ID = categories.ID
    WHERE  Parent = ".$catid);
    
    $subcat = getRecord("*","categories","ID","WHERE Visibility =0 AND Parent = ".$catid);
    if(!empty($items)){

        if(!empty($items2)){
    ?>

    
    <div class="row ">
       
        <div  class="col-sm-4 ">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <?php foreach( $subcat as $cat){?>
                                <a class="nav-link" href="categories.php?pageid=<?php echo $cat['ID'] ?>">
                                    <?php echo $cat['Name']; ?>
                                </a> 
                            <?php }?> 
                        </li>
                    </ul>
                </div>
            </nav>
        </div>    
    </div>
    
<?php }?>

    <div class="row">
        <?php
        foreach($items as $item)
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
        foreach($items2 as $item)
        {
            ?>
         <div class="card col-sm-6 col-md-3 m-2 mt-4" style="width: 16rem;">
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

    ?>
</div>
    

<?php include $tpl.'footer.php';
ob_end_flush();
?> 