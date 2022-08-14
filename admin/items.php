<?php
ob_start();
/*
======================================================
==  Items  page
==  you can Add | Delete | Edit items from here 
======================================================
*/ 


session_start();

$pageTitle  = 'Items';

if(isset($_SESSION['Username']))
{
            include "init.php"; 
            
            $do =isset($_GET['do'])?$_GET['do']:'Manage' ;

            // start manage page
            if($do == 'Manage')
            {
                $query='';
                if(isset($_GET['page'])&& $_GET['page']=='Approved')
                {
                    $query='WHERE Approve = 1';
                }
                if(isset($_GET['page'])&& $_GET['page']=='Pending')
                {
                    $query='WHERE Approve = 0';
                }
            
            $stmt2 = $con->prepare("SELECT items.* ,categories.Name AS category_Name ,users.Username As Username From items
                                    inner join categories on categories.ID = items.Cat_ID
                                    inner join users ON users.UserID = items.Member_ID ".$query);
            $stmt2->execute();
            $items = $stmt2->fetchAll();
            if(!empty($items)){
            
            ?>


        <h1 class="text-center ">Manage items </h1>
        <div class="container">
            
            <div class=" table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>

                        <td>#ID</td>
                        <td>Image</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Country</td>
                        <td>Adding Date</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Control</td>
                    </tr>
                    <?php

                                foreach($items as $item){
                                ?>
                    <tr>
                        <td><?php echo $item['Item_ID'];?></td>
                        <td><img class="rounded-circle" src='uploads\images\items\<?php if(!empty($item['Image'])){echo $item['Image'];}else{echo 'defalt.jpg';} ?>' width="50" height="50"  alt=""></td>
                        <td><?php echo $item['Name'];?></td>
                        <td><?php echo $item['Description'];?></td>
                        <td><?php echo $item['Price'];?></td>
                        <td><?php echo $item['Country_Made'];?></td>
                        <td><?php echo $item['Add_Date'];?></td>
                        <td><?php echo $item['category_Name'];?></td>
                        <td><?php echo $item['Username'];?></td>
                        <?php
                        
                        ?>
                        <td>
                            <a href="items.php?do=Edit&itemid= <?php echo $item['Item_ID'] ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            <a href="items.php?do=Delete&itemid= <?php echo $item['Item_ID'] ?>" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                            <?php
                                if($item['Approve']==0)
                                {?>
                                    <a href="items.php?do=Approve&itemid= <?php echo $item['Item_ID'] ?>" class="btn btn-info confirm"><i class="fa fa-check"></i> Approve</a>
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


            <a href="items.php?do=Add" class="botoon btn btn-primary"><i class="fa fa-plus"></i> New Item</a>

        </div>
       
        <?php }else{ echo ' <div class="container">';
           echo ' <div class="alert alert-info mt-4"> There\' Is No Items To Show </div>';
            ?><a href="items.php?do=Add" class="botoon btn btn-primary"><i class="fa fa-plus"></i> New Item</a> <?php     
        }
                    echo '</div> ';?>
        <?php
            }
            elseif($do =='Add')
            {   
                // add new Category
                ?>
        <h1 class="text-center ">Add New Item</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">

                <!-- start Name field -->
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <input  required 
                                    type="text"
                                    class="form-control form-control-lg" 
                                    name="name"
                                    placeholder="Name Of The Item">
                        </div>
                    </div>
                </div>
                <!-- end Name field -->
                <!-- start Description field -->
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <input  required
                                    type="text"
                                    class="form-control form-control-lg" 
                                    name="description"
                                    placeholder="Describe The Item">
                        </div>

                    </div>
                </div>
                <!-- end Description field -->
                <!-- start Price field -->
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <input  required
                                    type="text"
                                    class="form-control form-control-lg" 
                                    name="price"
                                    placeholder="Price  Of The Item">
                        </div>
                    </div>
                </div>
                <!-- end Price field -->
                <!-- start Country_Made field -->
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Country</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <input  required
                                    type="text"
                                    class="form-control form-control-lg" 
                                    name="country_made"
                                    placeholder="Country Of Made ">
                        </div>
                    </div>
                </div>
                <!-- end Country_Made field -->
                <!-- start Status field -->
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <select required
                                    name="status" class="form-select form-select-lg" aria-label="Default select example">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                                <option value="5">Very Old</option>

                            </select>
                        </div>
                    </div>
                </div>
                <!-- end Status field -->
                <!-- start Member field -->
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Member</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <select required
                                    name="member"
                                    class="form-select form-select-lg" aria-label="Default select example">
                                <option value="0">...</option>
                                <?php
                                    $users = getRecord("*","users","UserID","WHERE RegStatus = 1","ASC");
                                    

                                    foreach($users as $user){
                                        ?>
                                    
                                    <option value="<?php echo $user['UserID']; ?>"> <?php echo $user['Username'];?></option>
                                    <?php
                                    }
                                    
                                
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <!-- end Member field -->
                <!-- start Categories field -->
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <select required
                                    name="category"
                                    class="form-select form-select-lg" aria-label="Default select example">
                                <option value="0">...</option>
                                <?php
                                    $categories =getRecord("*","categories","ID","WHERE Visibility = 0 AND Parent = 0","ASC");
                                   

                                    foreach($categories as $category){
                                        ?>
                                    
                                    <option value="<?php echo $category['ID']; ?>"> <?php echo $category['Name'];?></option>
                                    <?php

                                    $childcategories =getRecord("*","categories","ID","WHERE Visibility = 0 AND Parent = ".$category['ID'],"ASC");
                                        foreach($childcategories as $childcat){
                                            ?>
                                                <option value="<?php echo $childcat['ID']; ?>"> ---<?php echo $childcat['Name'];?> [ <?php echo $category['Name'];?> ] </option>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                    }
                                    
                                
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <!-- end Categories field -->
                <!-- start Avatar field -->
                    <div class="form-group row ">
                        <label class="col-sm-2 col-form-label">Item Image</label>
                        <div class="col-sm-10 col-md-6">
                            <div class="input-content">
                                <input  
                                        type="file"
                                        class="form-control form-control-lg" 
                                        name="image">
                            </div>
                        </div>
                    </div>
                 <!-- end Avatar field -->
                <!-- start Tags field -->
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Tags</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <input  
                                    type="text"
                                    class="form-control form-control-lg" 
                                    name="tags"
                                    placeholder="Separet Tags With comma (,) ">
                        </div>
                    </div>
                </div>
                <!-- end Tags field -->
                <!-- start submit btn field -->
                <div class="form-group row ">
                    <div class="col-sm-offset-6 col-sm-6">
                        <input type="submit" class="botoon btn btn-success " value="Add Category">
                    </div>
                </div>
                <!-- end submit btn field -->
            </form>


        </div>

        <?php

            }
            elseif($do =='Insert')
            {
                
                // insert item page
            

                if($_SERVER['REQUEST_METHOD']=='POST')
                {
                    echo '<h1 class="text-center">Insert New Item</h1>';
                    echo '<div class="container">';


                     //uploded files
                        $imageName     = $_FILES['image']['name'] ;
                        $imagePath     = $_FILES['image']['full_path'] ;
                        $imageType     = $_FILES['image']['type'] ;
                        $imageTmp_Name = $_FILES['image']['tmp_name'] ;
                        $imageEror     = $_FILES['image']['error'] ;
                        $imageSize     = $_FILES['image']['size'] ;
                        // list of allowed file type of upload
                        $imageAllowedExtentions = array("jpeg","jpg","gif","png");
                        //get image extention
                        $exploded=explode('.', $imageName );
                        $endofarray=end($exploded );
                        $imageExtentions = strtolower($endofarray);
                        //get variables from the form


                            $name        = $_POST['name'];
                            $desc        = $_POST['description'];
                            $price       = $_POST['price'];
                            $country     = $_POST['country_made'];
                            $status      = $_POST['status'];   
                            $member      = $_POST['member'];   
                            $category    = $_POST['category'];   
                            $tags        = $_POST['tags'];   
                            // validate the form
                            $fromErrors = array();
                            if(empty($name))
                            {
                                $fromErrors[]= 'name can\'t be <strong>Empty</strong> </div>';
                            }
                            if(empty($desc))
                            {
                                $fromErrors[]= 'Description can\'t be <strong>Empty</strong> </div>';
                            }
                            if(empty($price))
                            {
                                $fromErrors[]= 'Price can\'t be <strong>Empty</strong> </div>';
                            }
                            if(empty($country))
                            {
                                $fromErrors[]= 'Country can\'t be <strong>Empty</strong> </div>';
                            }
                            if($status==='0')
                            {
                                $fromErrors[]= ' you must choose <strong>Status</strong> </div>';
                            }
                            if($member==='0')
                            {
                                $fromErrors[]= ' you must choose <strong>Member</strong> </div>';
                            }
                            if($category==='0')
                            {
                                $fromErrors[]= ' you must choose <strong>Category</strong> </div>';
                            }
                            
                            if(!empty($imageName)){
                                if(!in_array($imageExtentions,$imageAllowedExtentions)){
                                    $fromErrors[]= 'This Extention is Not  <strong>Allowed</strong> </div>';
                                }
                                if($imageSize > 4194304 ){ 
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
                                if(!empty($imageName)){
                                    $image = rand(0,10000000).$user.'_'.$imageName;
                                    move_uploaded_file($imageTmp_Name,"uploads\images\items\\".$image);
                                }else
                                {
                                    $image = 'defalt.jpg';
                                    move_uploaded_file($imageTmp_Name,"uploads\images\items\\".$image);
                                }
                                //Insert user info into database  this info
                                        $stmt = $con->prepare(" INSERT INTO
                                        items(Name, Description, Price, Country_Made,Image, Status,Approve, Add_Date,Cat_ID,Member_ID,Tags)
                                                                VALUES  
                                        (:zname, :zdesc, :zprice, :zcountry_made,:zimage ,:zstatus,1, now(),:zcatid,:zmemberid,:ztags )");
                                                    $stmt->execute(array(
                                                    'zname'           => $name,
                                                    'zdesc'           => $desc,
                                                    'zprice'          => $price,
                                                    'zcountry_made'   => $country,
                                                    'zimage'          => $image,
                                                    'zstatus'         => $status, 
                                                    'zcatid'          => $category, 
                                                    'zmemberid'       => $member,
                                                    'ztags'           => $tags 
                                    ));
                                    // echo successful msg and redirect to previos page
                                    $theMsg= '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Inserted' . '</div>';
                                    redirectHome($theMsg,'back');
                                    
                                
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
            elseif($do =='Edit')
            {
                 // check if get requestis catid is numeric & get the intger value of it
        $itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']): 0 ;
        // select all data depent on this iD
        $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
        // execute query
        $stmt->execute(array($itemid));
        // fetch the data from the database
        $item = $stmt->fetch();  
        // row count 
        // if there is this iD or no
        $count = $stmt->rowCount();
        // if there is id show the from 
        if($stmt->rowCount() > 0)
        {
            
        // Edite page
        ?>
<h1 class="text-center ">Edit item</h1>
<div class="container">
    
<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data" >
            <input type="hidden" name="itemId" value="<?php echo $itemid ?>">
<!-- start Name field -->
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10 col-md-6">
        <div class="input-content">
            <input  required 
                    type="text"
                    class="form-control form-control-lg" 
                    name="name"
                    placeholder="Name Of The Item"
                    value="<?php echo $item['Name'] ?>">
                    
        </div>
    </div>
</div>
<!-- end Name field -->
<!-- start Description field -->
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10 col-md-6">
        <div class="input-content">
            <input  required
                    type="text"
                    class="form-control form-control-lg" 
                    name="description"
                    placeholder="Describe The Item"
                    value="<?php echo $item['Description'] ?>">
        </div>

    </div>
</div>
<!-- end Description field -->
<!-- start Price field -->
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Price</label>
    <div class="col-sm-10 col-md-6">
        <div class="input-content">
            <input  required
                    type="text"
                    class="form-control form-control-lg" 
                    name="price"
                    placeholder="Price  Of The Item"
                    value="<?php echo $item['Price'] ?>">
        </div>
    </div>
</div>
<!-- end Price field -->
<!-- start Country_Made field -->
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Item Image</label>
    <div class="col-sm-10 col-md-6">
        <div class="input-content">
            <input  
                    type="file"
                    class="form-control form-control-lg" 
                    name="image">
        </div>
    </div>
</div>
<!-- end Country_Made field -->
<!-- start Country_Made field -->
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Country</label>
    <div class="col-sm-10 col-md-6">
        <div class="input-content">
            <input  required
                    type="text"
                    class="form-control form-control-lg" 
                    name="country_made"
                    placeholder="Country Of Made "
                    value="<?php echo $item['Country_Made'] ?>">
        </div>
    </div>
</div>
<!-- end Country_Made field -->
<!-- start Status field -->
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Status</label>
    <div class="col-sm-10 col-md-6">
        <div class="input-content">
            <select required
                    name="status" class="form-select form-select-lg" 
                    aria-label="Default select example">
                
                <option value="1" <?php if($item['Status']==1  ){echo 'selected';}?>>New</option>
                <option value="2" <?php if($item['Status']==2  ){echo 'selected';}?>>Like New</option>
                <option value="3" <?php if($item['Status']==3  ){echo 'selected';}?>>Used</option>
                <option value="4" <?php if($item['Status']==4  ){echo 'selected';}?>>Old</option>
                <option value="5" <?php if($item['Status']==5  ){echo 'selected';}?>>Very Old</option>

            </select>
        </div>
    </div>
</div>
<!-- end Status field -->
<!-- start Member field -->
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Member</label>
    <div class="col-sm-10 col-md-6">
        <div class="input-content">
            <select required
                    name="member"
                    class="form-select form-select-lg" 
                    aria-label="Default select example"
                   >
                
                <?php
                     $users=getRecord("*","users","UserID","WHERE RegStatus = 1","ASC");
                   
                    

                    foreach($users as $user){
                        ?>
                    
                    <option value="<?php echo $user['UserID']; ?>" <?php if($item['Member_ID']==$user['UserID']  ){echo 'selected';}?>
                    > <?php echo $user['Username'];?></option>
                    <?php
                    }
                    
                
                ?>

            </select>
        </div>
    </div>
</div>
<!-- end Member field -->
<!-- start Categories field -->
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Category</label>
    <div class="col-sm-10 col-md-6">
        <div class="input-content">
            <select required
                    name="category"
                    class="form-select form-select-lg" 
                    aria-label="Default select example"
                   >
                
                <?php
                    $categories =getRecord("*","categories","ID","WHERE Visibility = 0","ASC");
                    
                    foreach($categories as $category){
                        ?>
                    
                    <option value="<?php echo $category['ID']; ?>" <?php if($item['Cat_ID']==$category['ID']  ){echo 'selected';}?>> <?php echo $category['Name'];?></option>
                    <?php
                    }
                    
                
                ?>

            </select>
        </div>
    </div>
</div>
<!-- end Categories field -->
<!-- start Tags field -->
<div class="form-group row ">
                    <label class="col-sm-2 col-form-label">Tags</label>
                    <div class="col-sm-10 col-md-6">
                        <div class="input-content">
                            <input  
                                    type="text"
                                    class="form-control form-control-lg" 
                                    name="tags"
                                    placeholder="Separet Tags With comma (,) "
                                    value="<?php echo $item['Tags'] ?>">
                        </div>
                    </div>
                </div>
<!-- end Tags field -->
<!-- start submit btn field -->
<div class="form-group row ">
    <div class="col-sm-offset-6 col-sm-6">
        <input type="submit" class="botoon btn btn-success " value="Save Item">
    </div>
</div>
<!-- end submit btn field -->
</form>
             <?php       
         //manage comment page
        
        $stmt = $con->prepare(" SELECT
                                     comments.*,users.Username AS username
                                FROM comments
                                
                                INNER JOIN users
                                ON comments.user_id = users.UserID
                                WHERE item_id = ?");
        $stmt->execute(array($itemid));

        // assign to variable 
        $rows = $stmt->fetchAll();
                    
                    

        ?>



<h1 class="text-center ">Manage [<?php echo $item['Name'] ?>] Comments </h1>

    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr>
                 
                <td>Comment</td>
                <td>Username</td>
                <td>Added Date</td>
                <td>Control</td>
            </tr>
            <?php
            foreach($rows as $row){
             ?>
            <tr>
                    
                    <td><?php echo $row['Comment']?></td>
                    <td><?php echo $row['username']?></td>
                    
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
            elseif($do =='Update')
            {
                
        // update page
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            echo '<h1 class="text-center">Update Item</h1>';
            echo '<div class="container">';


            //uploded files
            $imageName     = $_FILES['image']['name'] ;
            $imagePath     = $_FILES['image']['full_path'] ;
            $imageType     = $_FILES['image']['type'] ;
            $imageTmp_Name = $_FILES['image']['tmp_name'] ;
            $imageEror     = $_FILES['image']['error'] ;
            $imageSize     = $_FILES['image']['size'] ;
            // list of allowed file type of upload
            $imageAllowedExtentions = array("jpeg","jpg","gif","png");
            //get image extention
            $exploded=explode('.', $imageName );
            $endofarray=end($exploded );
            $imageExtentions = strtolower($endofarray);
            //get variables from the form
            //get variables from the form
            $id          = $_POST['itemId'];
            $name        = $_POST['name'];
            $desc        = $_POST['description'];
            $price       = $_POST['price'];
            $country     = $_POST['country_made'];
            $status      = $_POST['status'];
            $member      = $_POST['member'];
            $cat         = $_POST['category'];
            $tags        = $_POST['tags'];

            // validate the form

            $fromErrors = array();

           
            if(empty($name))
            {
                $fromErrors[]= ' Name can not be <strong>Empty</strong> </div>';
            }
            
            if(empty($desc))
            {
                $fromErrors[]= ' Description can not be <strong>Empty</strong> </div>';
            }
            
            if(empty($price))
            {
                $fromErrors[]= ' Price can not be <strong>Empty</strong> </div>';
            }
            if(empty($status))
            {
                $fromErrors[]= ' Status can not be <strong>Empty</strong> </div>';
            }
            if(empty($member))
            {
                $fromErrors[]= ' Member can not be <strong>Empty</strong> </div>';
            }
            if(empty($cat))
            {
                $fromErrors[]= ' Category can not be <strong>Empty</strong> </div>';
            }
            if(!empty($imageName)){
                if(!in_array($imageExtentions,$imageAllowedExtentions)){
                    $fromErrors[]= 'This Extention is Not  <strong>Allowed</strong> </div>';
                }
                if($imageSize > 4194304 ){ 
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
                //update the database with this info
                $image = rand(0,10000000).$name.'_'.$imageName;
                        move_uploaded_file($imageTmp_Name,"uploads\images\items\\".$image);
                        if($imageName >0 ){
                           
                                        
                            $stmt = $con->prepare(' UPDATE 
                            items
                     SET 
                             Name               =? ,
                             Description        =? ,
                             Price              =? ,
                             Country_Made       =? ,
                             Image              =? ,
                             Status             =? ,
                             tags               =? ,
                             Member_ID          =? ,
                             CAT_ID             =? ,
                             Last_Modify_Date   =now()
                     WHERE 
                            Item_ID             =? ');
                    $stmt->execute(array($name,$desc,$price,$country,$image,$status,$tags,$member,$cat,$id));

                        }else
                        {
                            $stmt = $con->prepare(' UPDATE 
                            items
                     SET 
                             Name               =? ,
                             Description        =? ,
                             Price              =? ,
                             Country_Made       =? ,
                             Status             =? ,
                             tags               =? ,
                             Member_ID          =? ,
                             CAT_ID             =? ,
                             Last_Modify_Date   =now()
                     WHERE 
                            Item_ID             =? ');
                    $stmt->execute(array($name,$desc,$price,$country,$status,$tags,$member,$cat,$id));
                        }



                
                // echo successful msg and redirect to previos page

                $theMsg = '<div class="alert alert-success"> <strong>'.$stmt->rowcount().'</strong> Record Updated' . '</div>';
                redirectHome($theMsg,'back');
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
            }
            elseif($do =='Delete')
            {
                // DELETE  ITEM PAGE
                echo '<h1 class="text-center"> Delete Item</h1>';
                echo '<div class="container">';

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0 ;

                $check= checkItem('Item_ID','items',$itemid);

                if($check >0)
                {
                    $stmt = $con->prepare("DELETE from items Where Item_ID = :zitemid");
                    $stmt->bindParam(':zitemid',$itemid);
                    $stmt->execute();

                    $theMsg= '<div class="alert alert-success">'.$stmt->rowcount(). ' Record Deleted </div>';
                    redirectHome($theMsg,'back');
                }else
                {
                    $theMsg= '<div class="alert alert-danger"> There id No Such Id </div>';
                    redirectHome($theMsg);
                }

                echo '</div>';
            }
            elseif($do =='Approve')
            {
                // Approve Page
                echo '<h1 class="text-center"> Approve Item</h1>';
                echo '<div class="container">';

                $itemid = isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
                
                $check = checkItem("Item_ID","items",$itemid);

                if($check>0)
                {   
                    $stmt=$con->prepare("UPDATE items SET Approve= 1 WHERE Item_ID = :zitemid ") ; 
                    $stmt->bindParam(':zitemid',$itemid);
                    $stmt->execute();

                    
                    $theMsg= '<div class="alert alert-success">'.$stmt->rowcount(). ' Record Approved </div>';
                    redirectHome($theMsg,'back');
                }else
                {
                    $theMsg= '<div class="alert alert-danger"> There Is NO Such ID </div>';
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